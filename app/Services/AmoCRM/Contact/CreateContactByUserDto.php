<?php


namespace App\Services\AmoCRM\Contact;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Models\ContactModel;
use App\Configs\amocrmConfig;
use App\Models\Dto\Getcourse\UserDto;
use App\Services\AmoCRM\CustomFields\CreateCustomFieldsCollectionByUserDto;
use App\Services\Logger\Logger;

class CreateContactByUserDto
{

    public static function run(AmoCRMApiClient $api_client,UserDto $user)
    {
        $contact = new ContactModel();
        $contact->setName($user->getName());
        $custom_fields = CreateCustomFieldsCollectionByUserDto::run($user);
        $contact->setCustomFieldsValues($custom_fields);
        $contact->setResponsibleUserId(amocrmConfig::RESPONSIBLE_USER_ID);
        try {
            $contact = $api_client->contacts()->addOne($contact);
        } catch (AmoCRMApiException $e) {
            Logger::writeToLog(["Создание контакта" . $e->getMessage() . " - " . $e->getDescription()],config('logging.dir_error'));
            return false;
        }

        return $contact;
    }
}
