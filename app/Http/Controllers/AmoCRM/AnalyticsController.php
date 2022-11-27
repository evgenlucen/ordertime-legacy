<?php

namespace App\Http\Controllers\AmoCRM;


use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use App\Configs\googleAnalyticsConfig;
use App\Services\AmoCRM\ApiClient\GetApiClient;
use App\Services\AmoCRM\Interfaces\WebhookTypeInterface;
use App\Services\AmoCRM\Lead\CreateLeadForAnalyticsDtoFromWebhook;
use App\Services\AmoCRM\Lead\Tasks\GetLeadArrayByWebhook;
use App\Services\AmoCRM\Lead\Tasks\GetTypeEventByWebhook;
use App\Services\AmoCRM\Pipelines\AddPipelineDataToDataBase;
use App\Services\AmoCRM\Pipelines\Statuses\AddStatusesDataToDataBase;
use App\Services\AmoCRM\Pipelines\Tasks\CheckPipelineAccessForAnalytics;
use App\Services\Analytics\GA4\CreateGA4EventByLeadForAnalyticsDto;
use App\Services\Analytics\GoogleAnalytics\CheckEventForDoubleByLeadForAnalyticsDto;
use App\Services\Analytics\GoogleAnalytics\GetStatusNameByStatusIdAndPipelineId;
use App\Services\Analytics\GoogleAnalytics\Tasks\AddEventLeadToDB;
use App\Services\Analytics\GoogleAnalytics\Tasks\CreateGeneratedGaCid;
use App\Services\Logger\Logger;
use Br33f\Ga4\MeasurementProtocol\Exception\HydrationException;
use Br33f\Ga4\MeasurementProtocol\Exception\ValidationException;
use Br33f\Ga4\MeasurementProtocol\Service;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class AnalyticsController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse|void
     * @throws AmoCRMApiException
     * @throws AmoCRMMissedTokenException
     * @throws AmoCRMoAuthApiException
     * @throws HydrationException
     * @throws ValidationException
     * @throws \Exception
     */
    public static function run(Request $request)
    {
        # узнать тип вебхука
        $webhook_type = GetTypeEventByWebhook::run($request);

        # если в теле запроса есть воронка - нужно её достать
        if($webhook_type != WebhookTypeInterface::DELETE_UNSORTED){
            $lead_array = GetLeadArrayByWebhook::run($request);
            $pipeline_id = $lead_array['pipeline_id'];
            if(!empty($pipeline_id)){
                # Проверить воронку по id в списке разрешенных для импорта в аналитику
                $check_pipeline = CheckPipelineAccessForAnalytics::run($pipeline_id);
                if($check_pipeline === FALSE){
                    die();
                }
                # Проверить не тестовая ли это сделка
                if($lead_array['name'] == "TEST"){
                    die("TEST");
                }
            }
        }

        $data_log['json'] = json_encode($request->all());
        $data_log['request'] = $request->all();
        $data_log['webhook_type'] = $webhook_type;

        $api_client = GetApiClient::getApiClient();

        # Получить Lead Dto
        $lead_for_analytics_dto = CreateLeadForAnalyticsDtoFromWebhook::run($request,$api_client);

        $data_log['lead_dto'] = $lead_for_analytics_dto->toArray() ?? 'error to array';


        # Получить имя статуса воронки ( убрать в CreateLeadForAnalyticsDto )
        $status_name = GetStatusNameByStatusIdAndPipelineId::run($lead_for_analytics_dto->getStatusId(),$lead_for_analytics_dto->getPipelineId());

        # если status_name пустой - вызвать заполнение базы данных из API и повторить запрос к своей базе
        if(empty($status_name)){
            AddPipelineDataToDataBase::run($api_client);
            AddStatusesDataToDataBase::run($api_client);
            $data_log['event'][] = "update_data_base_pipeline_status_id";
            $status_name = GetStatusNameByStatusIdAndPipelineId::run($lead_for_analytics_dto->getStatusId(),$lead_for_analytics_dto->getPipelineId());
        }

        $data_log['status_name'] = $status_name;
        $lead_for_analytics_dto->setStatusName($status_name);


        # Проверить, отправляли ли мы ранее это события для этой сделки
        $check_on_double_event = CheckEventForDoubleByLeadForAnalyticsDto::run($lead_for_analytics_dto);
        if($check_on_double_event->isNotEmpty()){
            return new JsonResponse(['success' => true, 'data' => ['status' => 'Event was not send because it was sent earlier']]);
        }

        # Проверить наличие кастомного источника в полях ( убрать в CreateLeadForAnalyticsDto )

        # Генерация  cid ( убрать в CreateLeadForAnalyticsDto )
        if(empty($lead_for_analytics_dto->getGoogleClientId())){
            $lead_for_analytics_dto->setGoogleClientId(CreateGeneratedGaCid::run());
            $lead_for_analytics_dto->setIsGaCidGenerated(true);
        }




        # Создать запрос для отправки
        $google_analytics_request = CreateGA4EventByLeadForAnalyticsDto::run($lead_for_analytics_dto);

/*        echo "<pre>" . print_r($google_analytics_request,1) . "</pre>";
        die();*/

        # Отправить событие в GA
        $sendService = new Service(googleAnalyticsConfig::getApiKey(), googleAnalyticsConfig::getStreamId());
        $result_send_request = $sendService->send($google_analytics_request);
        $data_log['google_analytics_request'] = $google_analytics_request;
        $data_log['result_ga_request'] = $result_send_request;

        # Записать в базу статус отправки события для этой сделки
        AddEventLeadToDB::run($lead_for_analytics_dto);

        Logger::writeToLog($data_log,config('logging.dir_amo_analytics'));

        return new JsonResponse([
            'success' => true,
            'data' => [
                'code' => $result_send_request->getStatusCode(),
                'body' => $result_send_request->getBody(),
                'data' => $result_send_request->getData(),
                'ga_cid' => $lead_for_analytics_dto->getGoogleClientId()
            ]
        ]);
    }
}
