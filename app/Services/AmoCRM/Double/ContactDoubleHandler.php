<?php

namespace App\Services\AmoCRM\Double;

use AmoCRM\Collections\ContactsCollection;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use App\Configs\amocrmConfig;
use App\Services\AmoCRM\ApiClient\GetApiClient;
use App\Services\AmoCRM\Contact\FindContactsByPhone;
use App\Services\AmoCRM\Contact\FindContactsListByCustomField;
use App\Services\AmoCRM\Contact\GetContactById;
use App\Services\AmoCRM\CustomFields\GetValueCustomFieldByCode;
use App\Services\AmoCRM\Helper\GetUniqModelIdsByCollection;
use App\Services\AmoCRM\Helper\MergeCollections;

class ContactDoubleHandler
{
    /**
     * @throws AmoCRMApiException
     * @throws AmoCRMoAuthApiException
     * @throws AmoCRMMissedTokenException
     * @throws \Exception
     */
    public static function run(int $contactId)
    {
        $amoApiClient = GetApiClient::getApiClient();

        # получить свежую модель контакта
        $contactModel = GetContactById::run($amoApiClient,$contactId);

        if (null === $contactModel) {
            return sprintf("Contact not found: id %s", $contactId);
        }

        # получить поля сущности
        $customFieldsValues = $contactModel->getCustomFieldsValues();

        if(null === $customFieldsValues){
            return 'contact don`t have custom fields, double not founded';
        }

        # получить значения телефона и email
        $phone = GetValueCustomFieldByCode::run($customFieldsValues,"PHONE");
        $email = GetValueCustomFieldByCode::run($customFieldsValues,"EMAIL");

        # поиск по контактным данным
        $contacts = new ContactsCollection();
        if(null !== $phone) {
            $contactsByPhone = FindContactsByPhone::run($amoApiClient,$phone);
            if (null !== $contactsByPhone) {
                $contacts = MergeCollections::run($contacts,$contactsByPhone);
            }
        }
        if(null !== $email) {
            $contactsByEmail = FindContactsListByCustomField::run($amoApiClient,$email,amocrmConfig::EMAIL_CF_ID);
            if (null !== $contactsByEmail) {
                $contacts = MergeCollections::run($contacts,$contactsByEmail);
            }
        }

        $uniqContactIds = GetUniqModelIdsByCollection::run($contacts);

        if (\count($uniqContactIds) > 1){
            # set antidouble Task.
        }
    }

}
