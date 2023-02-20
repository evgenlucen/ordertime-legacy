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
     * @return ContactModel
     * @throws AmoCRMApiException
     * @throws AmoCRMMissedTokenException
     * @throws AmoCRMoAuthApiException
     */
    public static function run(AmoCRMApiClient $api_client, ContactModel $contact): ContactModel
    {
        try {
            $contact = $api_client->contacts()->updateOne($contact);
        } catch (AmoCRMMissedTokenException|AmoCRMoAuthApiException|AmoCRMApiException $e) {
            Logger::writeToLog(
                [
                    'error' => "Обновление контакта" . $e->getMessage() . " - " . $e->getDescription() . "-" . $e->getPrevious(),
                    'description' => var_export($e->getLastRequestInfo(), true),
                    'contact' => $contact->toArray()
                ],
                config('logging.dir_error')
            );
            throw $e;
        }

        return $contact;

    }

}
