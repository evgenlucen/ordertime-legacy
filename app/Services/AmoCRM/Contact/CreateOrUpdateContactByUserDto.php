<?php


namespace App\Services\AmoCRM\Contact;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Models\ContactModel;
use App\Models\Dto\Getcourse\UserDto;
use App\Services\AmoCRM\CustomFields\CreateCustomFieldsCollectionByUserDto;

class CreateOrUpdateContactByUserDto
{
    /**
     * @param AmoCRMApiClient $api_client
     * @param UserDto $user
     * @return ContactModel|bool|null
     */
    public static function run(AmoCRMApiClient $api_client, UserDto $user)
    {
        # найти контакты (или пустоту)
        $contacts = FindContactsByUserDto::run($api_client, $user);

        # update model
        if (null !== $contacts && !$contacts->isEmpty()) {
            $contact = $contacts->first();
            // обновляем поля контакта, если
            //if (null !== $contact->getCustomFieldsValues()) {
                $custom_fields = CreateCustomFieldsCollectionByUserDto::run($user);
                $contact->setCustomFieldsValues($custom_fields);
                $contact = UpdateContactByContactModel::run($api_client, $contact);
            //}
        } else {
            $contact = CreateContactByUserDto::run($api_client, $user);
        }

        return $contact;

    }

}
