<?php


namespace App\Services\AmoCRM\Lead;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Collections\ContactsCollection;
use AmoCRM\Collections\Leads\LeadsCollection;

class GetOpenedLeadsByContactsCollection
{

    /**
     * @param AmoCRMApiClient $api_client
     * @param ContactsCollection $contacts_collection
     * @return LeadsCollection
     */
    public static function run(AmoCRMApiClient $api_client, ContactsCollection $contacts_collection): LeadsCollection
    {
        $lead_collection = GetLeadsByContactsCollection::run($contacts_collection);
        $result_lead_collection = GetLeadsBodyByLeadsCollection::run($api_client,$lead_collection);
        return GetOpenLeadsByLeadsCollection::run($result_lead_collection);

    }

}
