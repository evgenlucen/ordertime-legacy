<?php

namespace App\Configs;

use App\Models\Dto\Action\ActionParamsDto;
use App\Models\Dto\Action\AmoActionDto;
use App\Models\Dto\Action\SalebotActionDto;
use App\Models\Dto\Bizon\UserMetaDto;
use App\Models\Dto\GetCourse\DealDto;

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

        if ($user->getIsViewSalesPart()) {
            return 'view_sales_part';
        } elseif ($user->getIsViewContentPart()) {
            return 'view_content_part';
        } elseif ($user->getIsVisitWebinar()) {
            return 'visit_webinar';
        }

        return 'visit_webinar';
    }

    public static function getActionParamsDtoByWebActivity(int $webActivityLevel): ?ActionParamsDto
    {
        $actionModel = new ActionParamsDto();
        $actionModel->setName('visit_webinar');

        switch ($webActivityLevel){
            case 0:
            case 1:
            case 2:
            case 3:
            case 4:
                $amoAction = new AmoActionDto();
                $amoAction->setPipelineId(amocrmConfig::PIPELINE_TG_COURSE);
                $amoAction->setStatusId(amocrmConfig::STATUS_OPENING_WEB);
                $amoAction->setTags(['web_activity_'.$webActivityLevel]);
                $actionModel->setAmocrmAction($amoAction);

                $salebotAction = new SalebotActionDto();
                $salebotAction->message = 'web_activity_' . $webActivityLevel;
                $salebotAction->vars = ['web_activity' => $webActivityLevel];

                $actionModel->setSalebotAction($salebotAction);
                break;

        }

        return $actionModel;


    }

    public static function getActionParamsDtoByEventName(string $event_name): ?ActionParamsDto
    {
        $action_model = new ActionParamsDto();
        $action_model->setName($event_name);

        switch ($event_name) {

            case 'view_lesson_1':
                 $amo_action = new AmoActionDto();
                 $amo_action->setPipelineId(amocrmConfig::PIPELINE_TG_COURSE);
                 $amo_action->setStatusId(amocrmConfig::STATUS_OPEN_1_LESSON);
                 $amo_action->setTags(['Открыл 1 урок']);
                 $action_model->setAmocrmAction($amo_action);
                 $salebot_action = new SalebotActionDto();

                 $salebot_action->message = $event_name;
                 $salebot_action->vars = [
                     'is_'.$event_name => 'true',
                     'ip' => $_SERVER['REDIRECT_GEOIP_ADDR'],
                     'city' => $_SERVER['REDIRECT_GEOIP_CITY'],
                     'country' => $_SERVER['REDIRECT_GEOIP_COUNTRY_NAME'],
                     'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                     ];
                 $action_model->setSalebotAction($salebot_action);
                 break;
            case 'view_lesson_2':
                $amo_action = new AmoActionDto();
                $amo_action->setPipelineId(amocrmConfig::PIPELINE_TG_COURSE);
                $amo_action->setStatusId(amocrmConfig::STATUS_OPEN_2_LESSON);
                $amo_action->setTags(['Открыл 2 урок']);
                $action_model->setAmocrmAction($amo_action);

                $salebot_action = new SalebotActionDto();
                $salebot_action->message = $event_name;
                $salebot_action->vars = [
                    'is_'.$event_name => 'true',
                    'ip' => $_SERVER['REDIRECT_GEOIP_ADDR'],
                    'city' => $_SERVER['REDIRECT_GEOIP_CITY'],
                    'country' => $_SERVER['REDIRECT_GEOIP_COUNTRY_NAME'],
                    'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                ];
                $action_model->setSalebotAction($salebot_action);
                break;
            case 'view_lesson_3':
                $amo_action = new AmoActionDto();
                $amo_action->setPipelineId(amocrmConfig::PIPELINE_TG_COURSE);
                $amo_action->setStatusId(amocrmConfig::STATUS_OPEN_3_LESSON);
                $amo_action->setTags(['Открыл 3 урок']);
                $action_model->setAmocrmAction($amo_action);

                $salebot_action = new SalebotActionDto();
                $salebot_action->message = $event_name;
                $salebot_action->vars = [
                    'is_'.$event_name => 'true',
                    'ip' => $_SERVER['REDIRECT_GEOIP_ADDR'],
                    'city' => $_SERVER['REDIRECT_GEOIP_CITY'],
                    'country' => $_SERVER['REDIRECT_GEOIP_COUNTRY_NAME'],
                    'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                ];
                $action_model->setSalebotAction($salebot_action);
                break;
            case 'view_lesson_4':
                $amo_action = new AmoActionDto();
                $amo_action->setPipelineId(amocrmConfig::PIPELINE_TG_COURSE);
                $amo_action->setStatusId(amocrmConfig::STATUS_OPENING_WEB);
                $amo_action->setTags(['Открыл 4 урок']);
                $amo_action->setServiceMessage('Открыл 4 урок');
                $action_model->setAmocrmAction($amo_action);


                $salebot_action = new SalebotActionDto();
                $salebot_action->message = $event_name;
                $salebot_action->vars = [
                    'is_'.$event_name => 'true',
                    'ip' => $_SERVER['REDIRECT_GEOIP_ADDR'],
                    'city' => $_SERVER['REDIRECT_GEOIP_CITY'],
                    'country' => $_SERVER['REDIRECT_GEOIP_COUNTRY_NAME'],
                    'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                ];
                $action_model->setSalebotAction($salebot_action);
                break;
            case 'view_content_part':
                $amo_action = new AmoActionDto();
                $amo_action->setPipelineId(amocrmConfig::PIPELINE_TG_COURSE);
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
            case 'deal_create':
                $amo_action = new AmoActionDto();
                $amo_action->setPipelineId(amocrmConfig::PIPELINE_PAID);
                $amo_action->setStatusId(amocrmConfig::LEGACY_STATUS_BUILD_SENT);
                $amo_action->setTags(['GC']);
                $action_model->setAmocrmAction($amo_action);
                $salebot_action = new SalebotActionDto();
                $salebot_action->message = 'deal_create';
                $action_model->setSalebotAction($salebot_action);
                break;
            case 'deal_create_telegram':
                $amo_action = new AmoActionDto();
                $amo_action->setPipelineId(amocrmConfig::PIPELINE_TG_COURSE);
                $amo_action->setStatusId(amocrmConfig::STATUS_CREATED_ORDER);
                $amo_action->setTags(['GC']);
                $action_model->setAmocrmAction($amo_action);
                $salebot_action = new SalebotActionDto();
                $salebot_action->message = 'deal_create';
                $action_model->setSalebotAction($salebot_action);
                break;
            case 'partial_payment_success':
                $amo_action = new AmoActionDto();
                $amo_action->setPipelineId(amocrmConfig::PIPELINE_PAID);
                $amo_action->setStatusId(amocrmConfig::LEGACY_STATUS_PARTIAL_PAYMENT_SUCCESS);
                $amo_action->setTags(['GC']);
                $action_model->setAmocrmAction($amo_action);
                break;
            case 'partial_payment_success_telegram':
                $amo_action = new AmoActionDto();
                $amo_action->setPipelineId(amocrmConfig::PIPELINE_TG_COURSE);
                $amo_action->setStatusId(amocrmConfig::STATUS_PREPAYMENT_SUCCESS);
                $amo_action->setTags(['GC']);
                $action_model->setAmocrmAction($amo_action);
                break;
            case 'payment_success':
                $amo_action = new AmoActionDto();
                $amo_action->setPipelineId(amocrmConfig::PIPELINE_PAID);
                $amo_action->setStatusId(amocrmConfig::STATUS_PAYMENT_SUCCESS);
                $amo_action->setTags(['GC']);
                $action_model->setAmocrmAction($amo_action);
                break;
            case 'payment_success_telegram':
                $amo_action = new AmoActionDto();
                $amo_action->setPipelineId(amocrmConfig::PIPELINE_TG_COURSE);
                $amo_action->setStatusId(amocrmConfig::STATUS_PAYMENT_SUCCESS);
                $amo_action->setTags(['GC']);
                $action_model->setAmocrmAction($amo_action);
                break;
            case 'bounce':
                $amo_action = new AmoActionDto();
                $amo_action->setPipelineId(amocrmConfig::PIPELINE_PAID);
                $amo_action->setStatusId(amocrmConfig::STATUS_BOUNCE);
                $amo_action->setTags(['GC']);
                $action_model->setAmocrmAction($amo_action);
                break;
            default:
                $action_model = null;
                break;
        }

        return $action_model;
    }

    public static function getActionParamByDeal(DealDto $deal, $eventName)
    {
        # получить воронку по позиции
        $pipelineId = self::getPipelineIdByPosition($deal->getPositions());
        # получить статус сделки по статусу заказа
        $statusId = self::getStatusIdByDealStatus($deal->getStatus(),$pipelineId,$eventName);

        $action_model = new ActionParamsDto();
        $action_model->setName($eventName);
        $amo_action = new AmoActionDto();
        $amo_action->setPipelineId($pipelineId);
        $amo_action->setStatusId($statusId);
        $amo_action->setTags(['GC']);
        $action_model->setAmocrmAction($amo_action);

        $salebot_action = new SalebotActionDto();
        $salebot_action->message = $eventName;
        $salebot_action->vars = [
            'gc_deal_id' => $deal->getId(),
            'gc_deal_positions' => $deal->getPositions(),
            'gc_cost_money' => $deal->getCostMoney(),
            'gc_payment_link' => $deal->getPaymentLink()
        ];
        $action_model->setSalebotAction($salebot_action);

        return $action_model;

    }

    private static function getPipelineIdByPosition(?string $positions): int
    {
        switch ($positions){
            case 'Гайд по финансовому плану':
            case 'Гайд по выплатам и льготам':
            case 'Экспресс-метод наведения порядка в бюджете':
                $pipelineId = amocrmConfig::PIPELINE_FINPLAN;
                break;
            case 'Разработчик чат-ботов 0%':
            case 'Разработчик чат-ботов 5%':
            case 'Разработчик чат-ботов 10%':
            case 'Разработчик чат-ботов 15%':
            case 'Разработчик чат-ботов 20%':
                $pipelineId = amocrmConfig::PIPELINE_CHAT_BOTS;
                break;
            default:
                $pipelineId = amocrmConfig::PIPELINE_PAID;
        }

        return $pipelineId;
    }

    private static function getStatusIdByDealStatus(string $statusDeal,int $pipelineId, string $eventName): int
    {
//        if($pipelineId == amocrmConfig::PIPELINE_FINPLAN){
//
//            if ($statusDeal == 'Новый' || $statusDeal == 'В Работе') {
//                $statusId = amocrmConfig::STATUS_TIPWARE_DEAL_CREATE;
//            } elseif($eventName == strpos($eventName,'partial_payment_success')){
//                $statusId = amocrmConfig::STATUS_PREPAYMENT_SUCCESS;
//            } elseif($eventName == strpos($eventName, 'payment_success')){
//                $statusId = amocrmConfig::STATUS_PAYMENT_SUCCESS;
//            }
//            else {
//                $statusId = amocrmConfig::STATUS_CREATED_ORDER;
//            }
//
//        } else
        if($pipelineId == amocrmConfig::PIPELINE_CHAT_BOTS){
            if ($statusDeal == 'Новый' || $statusDeal == 'В Работе') {
                $statusId = amocrmConfig::STATUS_CREATED_ORDER_CB;
            } elseif($eventName == strpos($eventName,'partial_payment_success')){
                $statusId = amocrmConfig::STATUS_PREPAYMENT_SUCCESS_CB;
            } elseif($eventName == strpos($eventName, 'payment_success')){
                $statusId = amocrmConfig::STATUS_PAYMENT_SUCCESS;
            }
            else {
                $statusId = amocrmConfig::STATUS_CREATED_ORDER;
            }
        } else {
            $statusId = amocrmConfig::STATUS_CREATED_ORDER;
        }

        return $statusId;

    }

}
