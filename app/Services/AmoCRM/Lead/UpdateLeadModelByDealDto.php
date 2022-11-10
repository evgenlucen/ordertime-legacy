<?php


namespace App\Services\AmoCRM\Lead;


use AmoCRM\Models\LeadModel;
use App\Models\Dto\Getcourse\DealDto;
use App\Services\AmoCRM\CustomFields\CreateCustomFieldsCollectionByDealDto;

class UpdateLeadModelByDealDto
{
    /**
     * @param LeadModel $lead
     * @param DealDto $deal
     * @return LeadModel
     */
    public static function run(LeadModel $lead, DealDto $deal)
    {
        $custom_fields = CreateCustomFieldsCollectionByDealDto::run($deal);
        $lead->setCustomFieldsValues($custom_fields);
        if($deal->getCostMoney()){
            $lead->setPrice($deal->getCostMoney());
        }
        if($deal->getName()){
            $lead->setName($deal->getName());
        }

        return $lead;
    }

}