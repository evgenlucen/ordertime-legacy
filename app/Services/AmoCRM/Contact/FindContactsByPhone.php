<?php

namespace App\Services\AmoCRM\Contact;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Collections\ContactsCollection;
use App\Configs\amocrmConfig;
use App\Services\AmoCRM\CustomFields\GetValueCustomFieldByCfId;
use App\Services\AmoCRM\Helper\PhoneClear;

class FindContactsByPhone
{

    public static function run(AmoCRMApiClient $apiClient, string $phone): ?ContactsCollection
    {
        $phone = PhoneClear::withOutCountryCode($phone);

        $contacts = FindContactsByQuery::run($apiClient,$phone);

        $result = new ContactsCollection();

        if (null === $contacts or $contacts->isEmpty()){
            return null;
        }

        for ($i = 0; $i < $contacts->count(); $i++){
            $contact = $contacts->offsetGet($i);
            $contactPhone = GetValueCustomFieldByCfId::run($contact->getCustomFieldsValues(),amocrmConfig::PHONE_CF_ID);
            if (null === $contactPhone) { continue; }
            $contactPhone =  PhoneClear::withOutCountryCode($contactPhone);

            if ($phone == $contactPhone) {
                $result = $result->add($contact);
            }
        }

        return $result;
    }

}
