<?php


namespace App\Services\AmoCRM\Contact;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Helpers\EntityTypesInterface;
use AmoCRM\Models\ContactModel;
use App\Services\AmoCRM\CustomFields\CreateCustomFieldsCollectionByArray;

class CreateContactByArray
{
    /**
     * @param AmoCRMApiClient $api_client
     * @param array $request
     * @return ContactModel|bool
     */
    public static function run(AmoCRMApiClient $api_client, $request)
    {
        $contact = new ContactModel();
        $contact->setName($request['name']);
        $custom_fields = CreateCustomFieldsCollectionByArray::run($request,EntityTypesInterface::CONTACT);
        $contact->setCustomFieldsValues($custom_fields);
        try {
            $contact = $api_client->contacts()->addOne($contact);
        } catch (AmoCRMApiException $e) {
            return false;
        }

        return $contact;
    }

}