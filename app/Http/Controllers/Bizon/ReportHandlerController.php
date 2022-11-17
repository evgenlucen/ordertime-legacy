<?php

namespace App\Http\Controllers\Bizon;

use AmoCRM\Collections\Leads\LeadsCollection;
use AmoCRM\Collections\NotesCollection;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\Exceptions\InvalidArgumentException;
use AmoCRM\Helpers\EntityTypesInterface;
use AmoCRM\Models\NoteType\CommonNote;
use App\Configs\bizonConfig;
use App\Configs\eventsConfig;
use App\Models\Dto\Bizon\WebinarReportDto;
use App\Services\AmoCRM\ApiClient\GetApiClient;
use App\Services\AmoCRM\Lead\GetLeadByBizonUserMetaDto;
use App\Services\AmoCRM\Pipelines\Statuses\GetPriorityStatusByLeadModel;
use App\Services\AmoCRM\Tag\AppendTagsToTagsCollection;
use App\Services\Bizon\Report\GetUserMetaCollectionByWebinarReportDto;
use App\Services\Bizon\Report\Tasks\AddTimestampsToWebinarReportDto;
use App\Services\Bizon\Report\Tasks\CreateNoteByUserMetaDto;
use App\Services\Bizon\Report\Tasks\GetPriorityStatusByAmoActionDto;
use App\Services\Bizon\Report\Tasks\GetRealUnixByBizonTime;
use App\Services\Debug\Debuger;
use App\Services\Logger\Logger;
use App\Services\Salebot\Actions\SalebotSendCallbackBySalebotByUserModel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use slavkluev\Bizon365\Client;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Class ReportHandlerController
 * @package App\Http\Controllers\Bizon
 * @todo Рапилить на Actions
 */
class ReportHandlerController extends Controller
{
    /**
     * @throws InvalidArgumentException
     * @throws AmoCRMApiException
     * @throws AmoCRMMissedTokenException
     * @throws AmoCRMoAuthApiException
     */
    public function run(Request $request)
    {
        $bizon_client = new Client(bizonConfig::getApiKey());
        $webinar_api = $bizon_client->getWebinarApi();

        # Получить отчет из бизона
        $report_data = $webinar_api->getWebinar($request->webinarId)['report'] ?? null; //['report'];
        if(empty($report_data)) {
            return 'report not found';
        }

        # Сформировать из него DTO
        $webinar_report_dto = WebinarReportDto::fromArray($report_data);
        $webinar_report_dto->setLen($request->len);

        # получить конфигурацию для веб-комнаты
        $config_by_room = bizonConfig::getWebinarConfigDtoByWebinarName($webinar_report_dto->getRoomid());
        $data_log['config_by_room'] = $config_by_room;

        # Добавить в webinar report dto обработанные время старта и конца, время продающей и контентной части
        $webinar_report_dto = AddTimestampsToWebinarReportDto::run($webinar_report_dto, $config_by_room);
        $data_log['webinar_report_dto'] = $webinar_report_dto;

        # создать коллекцию пользователей с чатами
        $users_meta_collection = GetUserMetaCollectionByWebinarReportDto::run($webinar_report_dto);
        if(empty($users_meta_collection)){
            return 'no users';
        }

        # amoCRM client
        $api_client = GetApiClient::getApiClient();

        /** Сформировать коллекции примечаний и лидов для обновления */
        $leads_colleciton = new LeadsCollection();
        $notes_collection = new NotesCollection();

        $i = 0;
        foreach ($users_meta_collection as $user_model) {

            $lead = GetLeadByBizonUserMetaDto::run($api_client, $user_model);

            /** LEAD FALSE */
            if (empty($lead)) {
                continue;
            }

            # если модель пользователя не содержит времени старта (ошибка отчета бизон) -
            # счатаем, что он зашел в начале
            if (empty($user_model->getView())) {
                $user_model->setView($webinar_report_dto->getTimeStart());
            }

            /** Высчитываем пользовательское время входа и выхода из веб-комнаты */
            if (empty($user_model->getView())) {
                $user_model->setView($webinar_report_dto->getTimeStart());
            }
            if (empty($user_model->getViewTill())) {
                $user_model->setViewTill($webinar_report_dto->getTimeStart());
            }
            $view_start_ux = GetRealUnixByBizonTime::run($user_model->getView());
            $view_end_ux = GetRealUnixByBizonTime::run($user_model->getViewTill());

            /** Длительность пребывания на вебе в минутах */
            $user_model->setDurationInWebinar((string)round(($view_end_ux - $view_start_ux) / 60, 1));

            /** Получить событие по параметрам просмотра */
            # был ли на вебинаре минимальное кол-во времени
            if ($user_model->getDurationInWebinar() >= $config_by_room->getVisitWebinarDurationMin()) {
                $user_model->setIsVisitWebinar(TRUE);

                # Смотрел ли контентную
                if ($user_model->getDurationInWebinar() >= $config_by_room->getContentPartDurationMin()) {
                    $user_model->setIsViewContentPart(TRUE);
                }
                # Смотрел ли продающую часть

                $diff = ($view_end_ux - $webinar_report_dto->getSalesPartTimestamp()) / 60 - $config_by_room->getSalesPartDurationMin();
                if (!empty($diff) && $diff > 0) {
                    $user_model->setIsViewSalesPart(TRUE);
                }

            }


            # Получить имя события по user_model
            $event_name = eventsConfig::getEventNameByUserMetaDto($user_model);

            if (empty($event_name)) {
                return new JsonResponse(['success' =>false, 'error' => 'Event name not found' ]);
            }

            # Получить параметры действия по событию
            $action_params = eventsConfig::getActionParamsDtoByEventName($event_name);

            /** добавить в модель лида теги */
            if (!empty($action_params->getAmocrmAction())) {
                if (!empty($action_params->getAmocrmAction()->getTags())) {
                    $tags = AppendTagsToTagsCollection::run($lead, $action_params->getAmocrmAction()->getTags());
                    $lead->setTags($tags);
                }
                if ($action_params->getAmocrmAction()->getStatusId()) {
                    /** приоритет статуса сделки */
                    # влияет обновим ли мы статус и воронку
                    $priority_status_lead = GetPriorityStatusByLeadModel::run($lead);
                    $priority_status_user_model = GetPriorityStatusByAmoActionDto::run($action_params->getAmocrmAction());
                    $data_log['priority_statuses'][] = ['lead' => $priority_status_lead, 'user' => $priority_status_user_model];

                    /** Если приоритет нового статуса выше - обновляем в модели */
                    if ($priority_status_user_model > $priority_status_lead) {
                        $lead->setStatusId($action_params->getAmocrmAction()->getStatusId());
                        $lead->setPipelineId($action_params->getAmocrmAction()->getPipelineId());
                    }
                }

            }

            $leads_colleciton->add($lead);

            /** примечание в коллекцию */
            $note = CreateNoteByUserMetaDto::run($user_model);
            $note_model = new CommonNote();
            $note_model->setText($note);
            $note_model->setEntityId($lead->getId());
            $notes_collection->add($note_model);

            /** Отправить в salebot со статусом посещения вебинара */
            $salebot_callback_res = SalebotSendCallbackBySalebotByUserModel::run($user_model);
            $data_log['salebot_message'][] = $salebot_callback_res;

            /** Sleep ибо нет очередей */
            usleep(200000);

            $data_log['users_data'][] = [
                'user_model' => $user_model,
                'user_duration' => $user_model->getDurationInWebinar(),
                'diff (view_end - SalesPartTimestamp) / 60 - SalesPartDurationMin' => $diff ?? 'none',
                'view_start_ux' => $view_start_ux,
                'view_end_ux' => $view_end_ux,
                'event_name' => $event_name,
                'action_params' => $action_params,
                'priority_status_lead' => $priority_status_lead ?? 'null',
                'priority_status_user' => $priority_status_user_model ?? 'null',
                'salebot_callback' => $salebot_callback_res,
                'lead_array' => $lead->toArray() ?? 'null',
                'note' => $note_model->toArray() ?? 'null'

            ];

//            $i += 1;
//            if ($i > 5) {
//                break;
//            }
        }

        $api_client->leads()->update($leads_colleciton);
        $api_client->notes(EntityTypesInterface::LEADS)->add($notes_collection);

        Logger::writeToLog($data_log, config('logging.dir_bizon_reports'));

        return new JsonResponse(['success' => true, 'data' => []]);

        //$data_log['leads_collection'] = $leads_colleciton->toArray();
        //$data_log['notes_collection'] = $notes_collection->toArray();
        # Debuger::debug($data_log);
        #die();

    }


}
