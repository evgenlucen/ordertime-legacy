<?php

namespace App\Services\AmoCRM\Double;

use AmoCRM\Collections\ContactsCollection;
use App\Services\AmoCRM\ApiClient\GetApiClient;
use App\Services\AmoCRM\Helper\GetUniqModelIdsByCollection;
use App\Services\AmoCRM\Lead\GetLeadById;
use App\Services\AmoCRM\Lead\GetOpenedLeadsByContactsCollection;

class LeadDoubleHandler
{
    public static function run(int $leadId)
    {
        $amoApiClient = GetApiClient::getApiClient();

        # получить свежую модель контакта
        $leadModel = GetLeadById::run($amoApiClient,$leadId);

        if (null === $leadModel) {
            return sprintf("Lead not found: id %s", $leadId);
        }

        $contacts = $leadModel->getContacts();
        $contacts = GetContactsBodyByEmptyContactsCollection::run($amoApiClient,$contacts);

        $leads = GetOpenedLeadsByContactsCollection::run($amoApiClient,$contacts);

        #Todo get opened leads.
        $uniqContactIds = GetUniqModelIdsByCollection::run($leads);

        if (\count($uniqContactIds) > 1) {
        # получить все сделки контакта, к которому привязана сделка

        # получить из коллекции сделок только открытые

        # поставить задачу о дубле, если у контакта несколько открытых сделок

        } else {
            return 'Not found double contact';
        }
    }
}
