<?php

namespace App\Http\Controllers\Events;


use App\Configs\amocrmConfig;
use App\Configs\eventsConfig;
use App\Services\AmoCRM\ApiClient\GetApiClient;
use App\Services\AmoCRM\Lead\FindLeadsByCustomFieldValue;
use App\Services\AmoCRM\Lead\GetLeadById;
use App\Services\AmoCRM\Lead\GetOpenLeadsByLeadsCollection;
use App\Services\AmoCRM\Lead\UpdateLeadByLeadModel;
use App\Services\AmoCRM\Lead\UpdateLeadModelByAmoActionDto;
use App\Services\AmoCRM\Note\SendServiceMessageToLead;
use App\Services\AmoCRM\Pipelines\Statuses\GetPriorityStatusByLeadModel;
use App\Services\Bizon\Report\Tasks\GetPriorityStatusByAmoActionDto;
use App\Services\Debug\Debuger;
use App\Services\Logger\Logger;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EventSalebotController extends Controller
{
    public static function run(Request $request)
    {
        if(empty($request->json()->get('salebot_id')) && empty($request->json()->get('amo_lead_id'))){
            die('no salebot and amo id');
            throw new \Exception('Нет Salebot_id && Amo lead id');
        }
        if(empty($request->json()->get('event_name'))){
            die('no event name');
            throw new \Exception('не указано имя события');
        }

        # Получить параметры действий по имени события
        $action_params = eventsConfig::getActionParamsDtoByEventName($request->json()->get('event_name'));

        $api_client = GetApiClient::getApiClient();

        if(!empty($request->json()->get('amo_lead_id'))){
            $lead = GetLeadById::run($api_client,$request->json()->get('amo_lead_id'));
        }
        if(empty($lead) && !empty($request->json()->get('salebot_id'))){
            $leads_collection = FindLeadsByCustomFieldValue::run($api_client,amocrmConfig::SB_CF_ID,$request->json()->get('salebot_id'));
            if(!$leads_collection->isEmpty()){
                $leads_collection = GetOpenLeadsByLeadsCollection::run($leads_collection);
                if(!$leads_collection->isEmpty()){
                    $lead = $leads_collection->first();
                }
            }
        }

        if(!empty($lead)){
            if($action_params->getAmocrmAction()->getStatusId()){
                $priority_status_lead = GetPriorityStatusByLeadModel::run($lead);
                try{
                    $priority_status_action = GetPriorityStatusByAmoActionDto::run($action_params->getAmocrmAction());
                } catch (\Exception $exception ){
                    throw new \Exception("Error get PriorityStatusByAmoAction");
                }
                $data_log['priority_status_lead'] = $priority_status_lead;
                $data_log['priority_status_action'] = $priority_status_action;
                # Если текущий статус лида приоритетнее статуса события
                # Обнуляем статус и воронку события,чтобы при обновлении они не применились
                if($priority_status_lead > $priority_status_action){
                    $action_params->getAmocrmAction()->setStatusId(null);
                    $action_params->getAmocrmAction()->setPipelineId(null);
                    $data_log['events'][] = 'Обновление статусов запрещено';
                }
            }



            $lead = UpdateLeadModelByAmoActionDto::run($lead,$action_params->getAmocrmAction());
            $lead = UpdateLeadByLeadModel::run($api_client,$lead);
        }

        if($action_params->getAmocrmAction()->getServiceMessage()){
            SendServiceMessageToLead::run($api_client,$action_params->getAmocrmAction()->getServiceMessage(),$lead->getId());
        }

        $data_log['request'] = $request->all();
        $data_log['lead'] = $lead->toArray() ?? 'lead not found';
        $data_log['action'] = $action_params->getAmocrmAction()->toArray();

        Logger::writeToLog($data_log,config('logging.dir_salebot_event'));

        return true;
    }
}
