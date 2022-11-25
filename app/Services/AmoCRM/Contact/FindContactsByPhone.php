<?php

namespace App\Services\AmoCRM\Contact;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Collections\ContactsCollection;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use App\Configs\amocrmConfig;
use App\Services\AmoCRM\CustomFields\GetValueCustomFieldByCfId;

class FindContactsByPhone
{

    public static function run(AmoCRMApiClient $apiClient, string $phone): ?ContactsCollection
    {
        $phone = self::phoneClear($phone);

        $contacts = FindContactsByQuery::run($apiClient,$phone);

        $result = new ContactsCollection();

        if (null === $contacts or $contacts->isEmpty()){
            return null;
        }

        for ($i = 0; $i < $contacts->count(); $i++){
            $contact = $contacts->offsetGet($i);
            $contactPhone = GetValueCustomFieldByCfId::run($contact->getCustomFieldsValues(),amocrmConfig::PHONE_CF_ID);
            if (null === $contactPhone) { continue; }
            $contactPhone =  self::phoneClear($contactPhone);

            if ($phone == $contactPhone) {
                $result = $result->add($contact);
            }
        }

        return $result;
    }



    /*
     * преобразует номер телефона к единому формату
     *
     * 89051234578 -> 79051234567
     * +7 905 123-45-78 -> 79051234567
     * +33 (123) 213 23 3 -> 33123213233
     * 123 4567 -> 1234567
     */
    private static function phoneClear($phone)
    {
        // плюс оставляем, чтобы 8 заменить дальше
        $resPhone = preg_replace("/[^0-9\+]/", "", $phone);
        $phone = trim($phone);
        // с 8 всего циферок будет 11 и не будет + в начале
        if (strlen($resPhone) === 11) {
            $resPhone = preg_replace("/^8/", "7", $resPhone);
        }

        if (substr($phone, 0,1) == '8' or substr($phone, 0,1) == '+') {
            //echo $phone . "<br>";
            $phone = preg_replace('/^\+?(8|7)/', '7', $phone);
        }
        // теперь уберём все плюсы
        $phone = preg_replace("/[^0-9]/", "", $phone);
        return $phone;
    }
}
