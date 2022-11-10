<?php


namespace App\Services\AmoCRM\Contact;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\Models\ContactModel;
use App\Services\Logger\Logger;

class UpdateContactByContactModel
{
    /**
     * @param AmoCRMApiClient $api_client
     * @param ContactModel $contact
     * @return ContactModel|bool
     */
    public static function run(AmoCRMApiClient $api_client, ContactModel $contact)
    {
        try {
            $contact = $api_client->contacts()->updateOne($contact);
        } catch (AmoCRMMissedTokenException $e) {
        } catch (AmoCRMoAuthApiException $e) {
        } catch (AmoCRMApiException $e) {
            Logger::writeToLog(["Создание контакта - " . $e->getMessage() . "Описание - " . $e->getDescription()],config('logging.dir_error'));
            return false;
        }

        return $contact;

    }

}