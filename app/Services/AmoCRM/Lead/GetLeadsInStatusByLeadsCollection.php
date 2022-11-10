<?php


namespace App\Services\AmoCRM\Lead;


use AmoCRM\Collections\Leads\LeadsCollection;

class GetLeadsInStatusByLeadsCollection
{
    /**
     * @param array $status_ids
     * @param LeadsCollection $leads_collection
     * @return LeadsCollection
     */
    public static function run(array $status_ids, LeadsCollection $leads_collection)
    {
        $result_collection = new LeadsCollection();

        for ($i = 0; $i < $leads_collection->count(); $i++) {
            $lead = $leads_collection->offsetGet($i);

            if (array_search($lead->getStatusId(), $status_ids) !== FALSE) {
                $result_collection->add($lead);
            }
        }

        return $result_collection;
    }

}