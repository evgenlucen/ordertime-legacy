<?php


namespace App\Services\AmoCRM\Lead;


use AmoCRM\Collections\Leads\LeadsCollection;
use App\Configs\amocrmConfig;

final class GetOpenLeadsByLeadsCollection
{
    /**
     * На вход должна поступать коллекция
     * с полным телом сделки
     * @param LeadsCollection $lead_collection
     * @return LeadsCollection
     */
    public static function run(LeadsCollection $lead_collection)
    {
        $result_lead_collection = new LeadsCollection();

        if($lead_collection->isEmpty()){
            return $result_lead_collection;
        }

        for ($i = 0; $i < $lead_collection->count(); $i++) {
            $lead_model = $lead_collection->offsetGet($i);
            if (array_search($lead_model->getStatusId(), amocrmConfig::STATUSES_NON_WORKED) === FALSE) {
                $result_lead_collection->add($lead_model);
            }
        }
        return $result_lead_collection;
    }
}