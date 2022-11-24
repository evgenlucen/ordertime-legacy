<?php

namespace App\Http\Controllers\Events;


use AmoCRM\Collections\CustomFields\CustomFieldsCollection;
use AmoCRM\Collections\CustomFieldsValuesCollection;
use App\Configs\amocrmConfig;
use App\Configs\eventsConfig;
use App\Services\AmoCRM\ApiClient\GetApiClient;
use App\Services\AmoCRM\CustomFields\CreateTextCfModel;
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
use App\Services\Salebot\Actions\SalebotSendCallback;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Webmozart\Assert\Assert;

class EventLessonController extends Controller
{
    /**
     * @throws Exception
     */
    public static function run(Request $request): JsonResponse
    {

        $event_params = $request->input('event_params') ?? null;
        $event_name = $request->input('event_name');

        Assert::notEmpty($event_name, "Undefined event name");
        Assert::notEmpty($event_params, "Undefined event params");

        $salebot_id = $event_params['salebot_id'] ?? null;
        $amo_lead_id = $event_params['amo_lead_id'] ?? null;
        $utc = $event_params['utc'] ?? null;

        if (null === $salebot_id && null === $amo_lead_id) {
            return new JsonResponse(['success' => false, 'error' => 'Undefined Salebot id & Amo lead id']);
        }

        # Получить параметры действий по имени события
        $action_params = eventsConfig::getActionParamsDtoByEventName($event_name);

        if (null === $action_params) {
            return new JsonResponse(['success' => false, 'error' => 'Not found config for event_name' . (string)$event_name]);
        }

        # Действия в AmoCRM
        if (!empty($action_params->getAmocrmAction())) {

            $api_client = GetApiClient::getApiClient();

            if (!empty($amo_lead_id)) {
                $lead = GetLeadById::run($api_client, $amo_lead_id);
            }
            if (empty($lead) && !empty($salebot_id)) {
                $leads_collection = FindLeadsByCustomFieldValue::run(
                    $api_client,
                    amocrmConfig::SB_CF_ID,
                    $salebot_id
                );

                if (!$leads_collection->isEmpty()) {
                    $leads_collection = GetOpenLeadsByLeadsCollection::run($leads_collection);
                    if (!$leads_collection->isEmpty()) {
                        $lead = $leads_collection->first();
                    }
                }
            }

            if (!empty($lead)) {
                if ($action_params->getAmocrmAction()->getStatusId()) {
                    $priority_status_lead = GetPriorityStatusByLeadModel::run($lead);
                    try {
                        $priority_status_action = GetPriorityStatusByAmoActionDto::run($action_params->getAmocrmAction());
                    } catch (Exception $exception) {
                        throw new Exception("Error get PriorityStatusByAmoAction");
                    }
                    $data_log['priority_status_lead'] = $priority_status_lead;
                    $data_log['priority_status_action'] = $priority_status_action;
                    # Если текущий статус лида приоритетнее статуса события
                    # Обнуляем статус и воронку события,чтобы при обновлении они не применились
                    if ($priority_status_lead > $priority_status_action) {
                        $action_params->getAmocrmAction()->setStatusId(null);
                        $action_params->getAmocrmAction()->setPipelineId(null);
                        $data_log['events'][] = 'Обновление статусов запрещено';
                    }
                }


                $lead = UpdateLeadModelByAmoActionDto::run($lead, $action_params->getAmocrmAction());

                # update cf
                $cf_country =  CreateTextCfModel::run(amocrmConfig::CF_ID_COUNTRY,$_SERVER['REDIRECT_GEOIP_COUNTRY_NAME']);
                $cf_city =  CreateTextCfModel::run(amocrmConfig::CF_ID_CITY,$_SERVER['REDIRECT_GEOIP_CITY']);
                $cf_utc=  CreateTextCfModel::run(amocrmConfig::CF_ID_UTC, $utc);

                $cf_collection = $lead->getCustomFieldsValues() ?? new CustomFieldsValuesCollection();
                $cf_collection->add($cf_country);
                $cf_collection->add($cf_city);
                $cf_collection->add($cf_utc);

                $lead->setCustomFieldsValues($cf_collection);


                $lead = UpdateLeadByLeadModel::run($api_client, $lead);
            }

            if ($action_params->getAmocrmAction()->getServiceMessage() && !empty($lead)) {
                SendServiceMessageToLead::run($api_client, $action_params->getAmocrmAction()->getServiceMessage(), $lead->getId());
            }

            $data_log['lead'] = $lead->toArray() ?? 'lead not found';

        }

        if (!empty($action_params->getSalebotAction()) && null !== $salebot_id) {
            $salebot_result = SalebotSendCallback::run((int)$salebot_id,$action_params->getSalebotAction());
        }

        $data_log['request'] = $request->all();


        $result = [];
        if (!empty($lead)){ $result['lead_id'] = $lead->getId(); }
        $result['action'] = $action_params->toArray();

        if(!empty($salebot_result)){
            $result['salebot_response'] = $salebot_result;
        }

        Logger::writeToLog($data_log,config('logging.dir_event_lesson'));

        return new JsonResponse([
            'success' => true,
            'data' => $result
        ]);
    }
}
