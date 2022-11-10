<?php


namespace App\Services\AmoCRM\Contact;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Collections\ContactsCollection;
use App\Models\Dto\LeadCollect\LcModel;

class FindContactsByLeadCollectModel
{
    /**
     * @param AmoCRMApiClient $api_client
     * @param LcModel $lc_model
     * @return ContactsCollection
     */
    public static function run(AmoCRMApiClient $api_client, LcModel $lc_model)
    {
        # найти контакты (или пустоту)
        if(!empty($lc_model->getPhone())){
            $contacts = FindContactsByQuery::run($api_client,$lc_model->getPhone());
        }
        if(empty($contacts) && !empty($lc_model->getEmail())){
            $contacts = FindContactsByQuery::run($api_client,$lc_model->getEmail());
        }
        if(empty($contacts)){
            $contacts = new ContactsCollection();
        }

        return $contacts;
    }
}