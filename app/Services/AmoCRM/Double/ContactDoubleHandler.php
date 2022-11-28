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
use App\Services\AmoCRM\Helper\PhoneClear;
use App\Services\AmoCRM\Task\CreateDoubleTask;

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
                $isFindByPhone = true;
            }
        }
        if(null !== $email) {
            $contactsByEmail = FindContactsListByCustomField::run($amoApiClient,$email,amocrmConfig::EMAIL_CF_ID);
            if (null !== $contactsByEmail) {
                $contacts = MergeCollections::run($contacts,$contactsByEmail);
                $isFindByEmail = true;
            }
        }

        $uniqContactIds = GetUniqModelIdsByCollection::run($contacts);

        if (\count($uniqContactIds) > 1) {

            # set antidouble Task.
            $result = [];
            if (!empty($isFindByPhone)) {
                $result['task_by_phone'] = CreateDoubleTask::contact(
                    $amoApiClient,
                    PhoneClear::run($phone),
                    $contactModel->getId(),
                    amocrmConfig::TASK_TYPE_DOUBLE_CONTACT
                )->getId();
            }
            if (!empty($isFindByEmail)) {
                $result['task_by_email'] = CreateDoubleTask::contact(
                    $amoApiClient,
                    trim($email),
                    $contactModel->getId(),
                    amocrmConfig::TASK_TYPE_DOUBLE_CONTACT
                )->getId();
            }

            return $result;

        } else {
            return 'Not found double contact';
        }
    }

}
