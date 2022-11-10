<?php


namespace App\Services\AmoCRM\Lead;


use AmoCRM\Collections\Leads\LeadsCollection;

class GetLeadsIdByLeadsCollection
{
    /**
     * @param LeadsCollection $lead_collection
     * @return array
     */
    public static function run(LeadsCollection $lead_collection)
    {

        $ids = [];
        for($i = 0;$i < $lead_collection->count();$i++){
            $lead = $lead_collection->offsetGet($i);
            $ids[] = $lead->getId();
        }

        return $ids;
    }

}