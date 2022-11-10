<?php


namespace App\Services\AmoCRM\Contact;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Collections\ContactsCollection;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Helpers\EntityTypesInterface;
use AmoCRM\Models\ContactModel;
use App\Services\AmoCRM\CustomFields\CreateCustomFieldsCollectionByRequest;
use Illuminate\Http\Request;

class UpdateContactByRequestAndContactsCollection
{
    /**
     * @param AmoCRMApiClient $api_client
     * @param Request $request
     * @param ContactsCollection $contacts_collection
     * @return ContactModel|bool
     */
    public static function run(AmoCRMApiClient $api_client,Request $request,ContactsCollection $contacts_collection)
    {
        $contact = $contacts_collection->first();
        $custom_fields = CreateCustomFieldsCollectionByRequest::run($request,EntityTypesInterface::CONTACT);

        $contact->setCustomFieldsValues($custom_fields);
        try {
            $contact = $api_client->contacts()->updateOne($contact);
        } catch (AmoCRMApiException $e) {
            return false;
        }

        return $contact;
    }

}