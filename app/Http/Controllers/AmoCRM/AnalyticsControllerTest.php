<?php

namespace App\Http\Controllers\AmoCRM;


use App\Services\AmoCRM\ApiClient\GetApiClient;
use App\Services\AmoCRM\Interfaces\WebhookTypeInterface;
use App\Services\AmoCRM\Lead\CreateLeadForAnalyticsDtoFromWebhook;
use App\Services\AmoCRM\Lead\Tasks\GetLeadArrayByWebhook;
use App\Services\AmoCRM\Lead\Tasks\GetTypeEventByWebhook;
use App\Services\AmoCRM\Pipelines\AddPipelineDataToDataBase;
use App\Services\AmoCRM\Pipelines\Statuses\AddStatusesDataToDataBase;
use App\Services\AmoCRM\Pipelines\Tasks\CheckPipelineAccessForAnalytics;
use App\Services\Analytics\GoogleAnalytics\CheckEventForDoubleByLeadForAnalyticsDto;
use App\Services\Analytics\GoogleAnalytics\CreateGoogleAnalyticsDtoByLeadForAnalyticsDto;
use App\Services\Analytics\GoogleAnalytics\GetStatusNameByStatusIdAndPipelineId;
use App\Services\Analytics\GoogleAnalytics\Tasks\AddEventLeadToDB;
use App\Services\Analytics\GoogleAnalytics\Tasks\CreateGeneratedGaCid;
use App\Services\Debug\Debuger;
use App\Services\Logger\Logger;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AnalyticsControllerTest extends Controller
{

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

        # Проверить наличие кастомного источника в полях ( убрать в CreateLeadForAnalyticsDto )

        # Генерация  cid ( убрать в CreateLeadForAnalyticsDto )
        if(empty($lead_for_analytics_dto->getGoogleClientId())){
            $lead_for_analytics_dto->setGoogleClientId(CreateGeneratedGaCid::run());
            $lead_for_analytics_dto->setIsGaCidGenerated(true);
        }

        $data_log['lead_dto'] = $lead_for_analytics_dto;

        # Проверить, отправляли ли мы ранее это события для этой сделки
        # $check_on_double_event = CheckEventForDoubleByLeadForAnalyticsDto::run($lead_for_analytics_dto);
//       /* if($check_on_double_event->isNotEmpty()){
//            throw new \Exception('Событие уже было отправлено ранее');
//        }*/


        # Создать объект для отправки в GA
        $google_analytics_dto = CreateGoogleAnalyticsDtoByLeadForAnalyticsDto::run($lead_for_analytics_dto);

        $data_log['google_dto'] = $google_analytics_dto;
        Debuger::debug($data_log);

        # Отправить событие в GA
        # $response_ga = $google_analytics_dto->sendEvent();
        # $data_log['final_url_arr'] = explode('&', $response_ga->getRequestUrl());

        # Записать в базу статус отправки события для этой сделки
        # AddEventLeadToDB::run($lead_for_analytics_dto);

        # Logger::writeToLog($data_log,config('logging.dir_amo_analytics'));

        # Создать объект для отправки в Facebook

        /*
        $api = Api::init(null, null, $data['token']);
        $api->setLogger(new CurlLogger());

        $facebook_events_dto = CreateFacebookEventsLeadForAnalyticsDto::run($lead_for_analytics_dto);

        # Отправить событие в пиксели Facebook
        try {
            $request = (new EventRequest($fb_dto->getPixelId()))
                ->setEvents($events);
        } catch (\Exception $exception) {
            $data_log['exception_set_event'] = $exception->getMessage();
        }

        try {
            $data_log['request_fb'] = $request->execute();
        } catch (\Exception $exception) {
            $data_log['exception_set_request'] = $exception->getMessage();
        }

        */
        # Записать в базу статус отправки события для этой сделки
    }
}
