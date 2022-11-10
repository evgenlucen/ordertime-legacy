<?php


namespace App\Services\AmoCRM\Contact;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Models\ContactModel;
use App\Configs\amocrmConfig;
use App\Models\Dto\LeadCollect\LcModel;
use App\Services\AmoCRM\CustomFields\CreateCustomFieldsCollectionByLeadCollectModel;
use App\Services\Logger\Logger;

class CreateContactByLeadCollectModel
{
    public static function run(AmoCRMApiClient $api_client,LcModel $lc_model)
    {
        $contact = new ContactModel();
        $contact->setName($lc_model->getName());
        $cf_id_name_map = amocrmConfig::getCfNameIdMapContact();
        $custom_fields = CreateCustomFieldsCollectionByLeadCollectModel::run($lc_model,$cf_id_name_map);
        $contact->setCustomFieldsValues($custom_fields);
        try {
            $contact = $api_client->contacts()->addOne($contact);
        } catch (AmoCRMApiException $e) {
            Logger::writeToLog(["Создание контакта" . $e->getMessage() . " - " . $e->getDescription()],config('logging.dir_error'));
            return false;
        }

        return $contact;
    }

}