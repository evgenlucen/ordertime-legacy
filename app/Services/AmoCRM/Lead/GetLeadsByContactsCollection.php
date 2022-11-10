<?php


namespace App\Services\AmoCRM\Lead;


use AmoCRM\Collections\ContactsCollection;
use AmoCRM\Collections\Leads\LeadsCollection;

class GetLeadsByContactsCollection
{
    public static function run(ContactsCollection $contacts_collection)
    {
        $result_lead_collection = new LeadsCollection();

        for($i = 0; $i < $contacts_collection->count();$i++){
            $contact_model = $contacts_collection->offsetGet($i);
            $leads_collection = $contact_model->getLeads();
            if(!is_null($leads_collection)){
                for($l = 0; $l < $leads_collection->count(); $l++){
                    $result_lead_collection->add($leads_collection->offsetGet($l));
                }
            }
        }

        return $result_lead_collection;
    }

}