<?php


namespace App\Services\AmoCRM\Lead;


use AmoCRM\Models\LeadModel;
use App\Models\Dto\Getcourse\DealDto;
use App\Services\AmoCRM\CustomFields\CreateCustomFieldsCollectionByDealDto;

class CreateLeadModelByDealDto
{
    /**
     * @param DealDto $deal
     * @return LeadModel
     */
    public static function run(DealDto $deal)
    {
        $lead = new LeadModel();
        $custom_fields = CreateCustomFieldsCollectionByDealDto::run($deal);
        $lead->setCustomFieldsValues($custom_fields);
        if($deal->getCostMoney()){
            $lead->setPrice($deal->getCostMoney());
        }
        $lead->setResponsibleUserId(config('amocrm.responsible_user_id'));

        return $lead;
    }

}