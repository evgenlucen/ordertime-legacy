<?php

namespace App\Services\AmoCRM\Contact;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\Models\ContactModel;

class GetContactById
{
    /**
     * @throws AmoCRMApiException
     * @throws AmoCRMoAuthApiException
     * @throws AmoCRMMissedTokenException
     */
    public static function run(AmoCRMApiClient $amoApiClient, int $contactId): ?ContactModel
    {
        return $amoApiClient->contacts()->getOne($contactId);
    }

}
