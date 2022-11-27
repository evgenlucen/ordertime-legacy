<?php


namespace App\Services\AmoCRM\Contact;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Collections\ContactsCollection;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\Filters\ContactsFilter;
use AmoCRM\Models\ContactModel;
use App\Services\AmoCRM\Filter\FilterContactsByCustomFieldValue;
use Exception;
use Webmozart\Assert\Assert;

class FindContactsListByCustomField
{

    /**
     * @param AmoCRMApiClient $amoCRMApiClient
     * @param string $customFieldValue
     * @param int $customFieldId
     * @return ContactsCollection|null
     *
     * @throws AmoCRMApiException
     * @throws AmoCRMoAuthApiException
     * @throws Exception
     */
    public static function run(AmoCRMApiClient $amoCRMApiClient, string $customFieldValue, int $customFieldId): ?ContactsCollection
    {
        Assert::minLength($customFieldValue,3, "Really small request");

        $filter = new ContactsFilter();
        $filter->setQuery($customFieldValue);


        $contacts =  $amoCRMApiClient->contacts()->get($filter,[ContactModel::LEADS]);

        if ($contacts->isEmpty()) {
            return null;
        }

        return FilterContactsByCustomFieldValue::run($contacts, $customFieldValue, $customFieldId);


    }


}
