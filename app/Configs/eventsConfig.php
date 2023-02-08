<?php

namespace App\Configs;

use App\Models\Dto\Action\ActionParamsDto;
use App\Models\Dto\Action\AmoActionDto;

class eventsConfig
{


    public static function getActionParamsDtoByEventName(string $event_name): ?ActionParamsDto
    {
        $action_model = new ActionParamsDto();
        $action_model->setName($event_name);

        switch ($event_name) {
            case 'deal_create':
                $amo_action = new AmoActionDto();
                $amo_action->setPipelineId(amocrmConfig::PIPELINE_PAID);
                $amo_action->setStatusId(amocrmConfig::STATUS_CREATED_ORDER);
                $amo_action->setTags(['GC']);
                $action_model->setAmocrmAction($amo_action);
                break;
            case 'partial_payment_success':
                $amo_action = new AmoActionDto();
                $amo_action->setPipelineId(amocrmConfig::PIPELINE_PAID);
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
}
