<?php


namespace App\Services\AmoCRM\Lead;


use AmoCRM\Collections\Leads\LeadsCollection;
use AmoCRM\Models\LeadModel;
use App\Services\AmoCRM\CustomFields\GetValueCustomFieldByCfId;

class GetLeadWithoutDealId
{

    /**
     * @param LeadsCollection $leads_collection
     * @return LeadModel|bool|null
     */
    public static function run(LeadsCollection $leads_collection)
    {
        for ($i = 0; $i < $leads_collection->count(); $i++) {

            $lead = $leads_collection->offsetGet($i);
            if(empty($lead->getCustomFieldsValues())){
                return $lead;
            }
            if(!empty($lead->getCustomFieldsValues())){
                $deal_id = GetValueCustomFieldByCfId::run(
                    $lead->getCustomFieldsValues(),
                    config('amocrm.cf_gc_deal_id')
                );
            }
            if(!empty($deal_id)){
                return $lead;
            }
        }

        return false;
    }

}