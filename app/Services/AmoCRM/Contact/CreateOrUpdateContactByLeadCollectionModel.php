<?php


namespace App\Services\AmoCRM\Contact;


use AmoCRM\Client\AmoCRMApiClient;
use App\Configs\amocrmConfig;
use App\Models\Dto\LeadCollect\LcModel;
use App\Services\AmoCRM\CustomFields\CreateCustomFieldsCollectionByLeadCollectModel;

class CreateOrUpdateContactByLeadCollectionModel
{
    /**
     * @param AmoCRMApiClient $api_client
     * @param LcModel $lc_model
     * @return \AmoCRM\Models\ContactModel|bool|null
     */
    public static function run(AmoCRMApiClient $api_client,LcModel $lc_model)
    {

        $contacts = FindContactsByLeadCollectModel::run($api_client,$lc_model);

        # update model
        if (!empty($contacts) && !$contacts->isEmpty()) {
            $contact = $contacts->first();
            if (!$contact->getCustomFieldsValues()->isEmpty()) {
                $cf_name_id_type_map = amocrmConfig::getCfNameIdMapContact();
                $custom_fields = CreateCustomFieldsCollectionByLeadCollectModel::run($lc_model,$cf_name_id_type_map);
                $contact->setCustomFieldsValues($custom_fields);

                $contact = UpdateContactByContactModel::run($api_client, $contact);

            }
        } else {
            $contact = CreateContactByLeadCollectModel::run($api_client, $lc_model);
        }

        return $contact;
    }

}