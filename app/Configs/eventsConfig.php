<?php

namespace App\Configs;

use App\Models\Dto\Action\ActionParamsDto;
use App\Models\Dto\Action\AmoActionDto;
use App\Models\Dto\Action\SalebotActionDto;
use App\Models\Dto\Bizon\UserMetaDto;

class eventsConfig
{

    /**
     * Проверяем смотрел ли пользователь
     * интересующие нас участки веба
     * и даем имя событию
     * @param UserMetaDto $user
     * @return string|null
     */
    public static function getEventNameByUserMetaDto(UserMetaDto $user): ?string
    {

        //TODO CHANGE ME
        if ($user->getIsViewSalesPart()) {
            return 'view_sales_part';
        } elseif ($user->getIsViewContentPart()) {
            return 'view_content_part';
        } elseif ($user->getIsVisitWebinar()) {
            return 'visit_webinar';
        }

        return 'visit_webinar';
    }

    public static function getActionParamsDtoByEventName(string $event_name): ActionParamsDto
    {
        $action_model = new ActionParamsDto();
        $action_model->setName($event_name);

        switch ($event_name) {

            //TODO CHANGE ME
            /* case 'send_link_to_webinar':
                 $amo_action = new AmoActionDto();
                 $amo_action->setPipelineId(amocrmConfig::PIPELINE_WORKED);
                 $amo_action->setStatusId(amocrmConfig::STATUS_SEND_WEBINAR_LINK);
                 $action_model->setAmocrmAction($amo_action);
                 break;*/
            /* case 'click_link_webinar':
                 $amo_action = new AmoActionDto();
                 $amo_action->setPipelineId(amocrmConfig::PIPELINE_WORKED);
                 $amo_action->setStatusId(amocrmConfig::STATUS_START_WEBINAR);
                 $action_model->setAmocrmAction($amo_action);
                 break;*/
            /*case 'visit_webinar':
                $amo_action = new AmoActionDto();
                $amo_action->setPipelineId(amocrmConfig::PIPELINE_WORKED);
                $amo_action->setStatusId(amocrmConfig::STATUS_START_WEBINAR);
                $amo_action->setTags(['вебинар']);
                $action_model->setAmocrmAction($amo_action);
                break;*/
            /*case 'click_link_record_webinar':
                $amo_action = new AmoActionDto();
                $amo_action->setPipelineId(amocrmConfig::PIPELINE_WORKED);
                $amo_action->setStatusId(amocrmConfig::STATUS_OPENED_RECORD_WEBINAR);
                $amo_action->setTags(['запись']);
                $action_model->setAmocrmAction($amo_action);
                break;*/
            case 'view_content_part':
                $amo_action = new AmoActionDto();
                $amo_action->setPipelineId(amocrmConfig::PIPELINE_WORKED);
                $amo_action->setStatusId(amocrmConfig::STATUS_OPENING_WEB);
                $action_model->setAmocrmAction($amo_action);
                break;
            case 'view_sales_part':
                $amo_action = new AmoActionDto();
                $amo_action->setPipelineId(amocrmConfig::PIPELINE_PAID);
                $amo_action->setStatusId(amocrmConfig::STATUS_OPENING_WEB);
                $amo_action->setTags(['2кат']);
                $action_model->setAmocrmAction($amo_action);
                break;
            case 'visit_sales_page':
                $amo_action = new AmoActionDto();
                $amo_action->setTags(['ленд-продажник']);
                $amo_action->setServiceMessage('Посещение продающей страницы');
                $action_model->setAmocrmAction($amo_action);
                break;
            /*case 'written_key_lesson_course':
                $amo_action = new AmoActionDto();
                $amo_action->setPipelineId(amocrmConfig::PIPELINE_PAID);
                $amo_action->setStatusId(amocrmConfig::STATUS_ALL_LEADS);
                $amo_action->setTags(['курс']);
                $action_model->setAmocrmAction($amo_action);

                break;*/
            case 'deal_create':
                $amo_action = new AmoActionDto();
                $amo_action->setPipelineId(amocrmConfig::PIPELINE_PAID);
                $amo_action->setStatusId(amocrmConfig::LEGACY_STATUS_BUILD_SENT);
                $amo_action->setTags(['GC']);
                $action_model->setAmocrmAction($amo_action);
//                $salebot_action = new SalebotActionDto();
//                $salebot_action->message = 'deal_create';
//                $action_model->setSalebotAction($salebot_action);
                break;
            /*case 'form_submit':
                $amo_action = new AmoActionDto();
                $amo_action->setPipelineId(amocrmConfig::PIPELINE_PAID);
                $amo_action->setStatusId(amocrmConfig::STATUS_ALL_LEADS);
                $amo_action->setTags(['заявка']);
                $action_model->setAmocrmAction($amo_action);
                $salebot_action = new SalebotActionDto();
                $salebot_action->message = 'form_submit';
                $action_model->setSalebotAction($salebot_action);
                break;*/
            case 'Новый':
            case 'В работе':
            case 'Ожидаем оплаты':
                $amo_action = new AmoActionDto();
                $amo_action->setPipelineId(amocrmConfig::PIPELINE_PAID);
                $amo_action->setStatusId(amocrmConfig::LEGACY_STATUS_BUILD_SENT);
                $amo_action->setTags(['GC']);
                $action_model->setAmocrmAction($amo_action);
                break;
            case 'partial_payment_success':
            case 'Частично оплачен':
                $amo_action = new AmoActionDto();
                $amo_action->setPipelineId(amocrmConfig::PIPELINE_PAID);
                $amo_action->setStatusId(amocrmConfig::LEGACY_STATUS_PARTIAL_PAYMENT_SUCCESS);
                $amo_action->setTags(['GC']);
                $action_model->setAmocrmAction($amo_action);
                break;
            case 'payment_success':
            case 'Завершен':
                $amo_action = new AmoActionDto();
                $amo_action->setPipelineId(amocrmConfig::PIPELINE_PAID);
                $amo_action->setStatusId(amocrmConfig::STATUS_PAID_SUCCESS);
                $amo_action->setTags(['GC']);
                $action_model->setAmocrmAction($amo_action);
                break;
            case 'bounce':
            case 'Не подтвержден':
            case 'Отменен':
            case 'Ложный':
            case 'Отложен':
                $amo_action = new AmoActionDto();
                $amo_action->setPipelineId(amocrmConfig::PIPELINE_PAID);
                $amo_action->setStatusId(amocrmConfig::STATUS_BOUNCE);
                $amo_action->setTags(['GC']);
                $action_model->setAmocrmAction($amo_action);
                break;
            default:
                $amo_action = new AmoActionDto();
                $amo_action->setPipelineId(amocrmConfig::PIPELINE_WORKED);
                $amo_action->setStatusId(amocrmConfig::STATUS_ALL_LEADS);
                break;
        }

        return $action_model;
    }
}
