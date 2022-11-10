<?php

namespace App\Http\Controllers\Test\GetCourse;


use App\Configs\amocrmConfig;
use App\Configs\eventsConfig;
use App\Models\Dto\GetCourse\DealDto;
use App\Services\AmoCRM\ApiClient\GetApiClient;
use App\Services\AmoCRM\Contact\CreateOrUpdateContactByUserDto;
use App\Services\AmoCRM\Lead\CreateOrUpdateLeadByDealDtoAndContact;
use App\Services\AmoCRM\Lead\FindLeadsByCustomFieldValue;
use App\Services\AmoCRM\Lead\UpdateLeadByLeadModel;
use App\Services\AmoCRM\Lead\UpdateLeadModelByAmoActionDto;
use App\Services\AmoCRM\Lead\UpdateLeadModelByDealDto;
use App\Services\Debug\Debuger;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EventGetcourseDealTestController extends Controller
{
    public static function run(Request $request)
    {
        if (empty($request->event_name)) {
            throw new \Exception('no event_name');
        }

        $api_client = GetApiClient::getApiClient();

        $deal = DealDto::fromRequest($request);
        $user = $deal->getUser();

        if($request->event_name == "change_status_deal") {
            $action_param = eventsConfig::getActionParamsDtoByEventName($request->status_deal);
        } else {
            $action_param = eventsConfig::getActionParamsDtoByEventName($request->event_name);
        }



        # ищем по deal_id
        $leads_collection = FindLeadsByCustomFieldValue::run($api_client,amocrmConfig::CF_GC_DEAL_ID,$deal->getId());


        # если не нашли
        if($leads_collection->isEmpty()){
            # ищем или создаем контакт
            $contact = CreateOrUpdateContactByUserDto::run($api_client,$user);
            # обновляем существующую сделку или создаем новую
            $lead = CreateOrUpdateLeadByDealDtoAndContact::run($api_client,$deal,$contact, $action_param->getAmocrmAction());
            $data_log['contact'] = $contact->toArray();
        } else {
            # если нашли
            $lead = $leads_collection->first();
            $lead = UpdateLeadModelByAmoActionDto::run($lead,$action_param->getAmocrmAction());
            $lead = UpdateLeadModelByDealDto::run($lead,$deal);
            $lead = UpdateLeadByLeadModel::run($api_client,$lead);
        }

        $data_log['action_param'] = $action_param;
        $data_log['request'] = $request->all();
        $data_log['deal'] = $deal->toArray();
        $data_log['user'] = $user->toArray();
        $data_log['lead'] = $lead->toArray();


        /*Debuger::debug($data_log);
        die();*/
        #Logger::writeToLog($data_log,config('logging.dir_getcourse_deal_events'));
        Debuger::debug($data_log);
    }
}
