<?php


namespace App\Services\AmoCRM\Lead;


use AmoCRM\Models\LeadModel;
use App\Models\DTO\Action\AmoActionDto;
use App\Services\AmoCRM\Tag\AppendTagsToTagsCollection;

class UpdateLeadModelByAmoActionDto
{

    /**
     * @param LeadModel $lead_model
     * @param AmoActionDto $amo_action
     * @return LeadModel
     */
    public static function run(LeadModel $lead_model, AmoActionDto $amo_action): LeadModel
    {

        if (!empty($amo_action->getStatusId())) {
            $lead_model->setStatusId($amo_action->getStatusId());
        }
        if (!empty($amo_action->getPipelineId())) {
            $lead_model->setPipelineId($amo_action->getPipelineId());
        }
        if (!empty($amo_action->getTags())) {
            $tags_collection = AppendTagsToTagsCollection::run($lead_model, $amo_action->getTags());
            $lead_model->setTags($tags_collection);
        }

        if(!empty($amo_action->getResponsibleUserId())){
            $lead_model->setResponsibleUserId($amo_action->getResponsibleUserId());
        }

        return $lead_model;

    }
}
