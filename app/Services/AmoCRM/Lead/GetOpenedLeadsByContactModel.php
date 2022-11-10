<?php


namespace App\Services\AmoCRM\Lead;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Collections\Leads\LeadsCollection;
use AmoCRM\Models\ContactModel;

class GetOpenedLeadsByContactModel
{

    /**
     * @param AmoCRMApiClient $api_client
     * @param ContactModel $contact
     * @return LeadsCollection
     */
    public static function run(AmoCRMApiClient $api_client,ContactModel $contact)
    {
        $leads_collection = $contact->getLeads();

        # если лидов нет - вернем пустую коллекцию
        if(is_null($leads_collection)){
            return new LeadsCollection();
        }

        $leads_collection = GetLeadsBodyByLeadsCollection::run($api_client,$leads_collection);
        $leads_collection = GetOpenLeadsByLeadsCollection::run($leads_collection);

        return $leads_collection;
    }
}