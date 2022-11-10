<?php


namespace App\Services\AmoCRM\Contact;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Models\ContactModel;
use App\Models\Dto\Getcourse\UserDto;

class FindOrCreateContactByUserDto
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
        if (!$contacts->isEmpty()) {
            $contact = $contacts->first();
        } else {
            $contact = CreateContactByUserDto::run($api_client, $user);
        }

        return $contact;

    }

}