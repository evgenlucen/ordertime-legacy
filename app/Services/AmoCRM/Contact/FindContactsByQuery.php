<?php


namespace App\Services\AmoCRM\Contact;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Collections\ContactsCollection;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\Filters\ContactsFilter;
use AmoCRM\Models\ContactModel;

class FindContactsByQuery
{

    /**
     * @param AmoCRMApiClient $api_client
     * @param string $query
     * @return ContactsCollection|null
     */
    public static function run(AmoCRMApiClient $api_client, string $query)
    {
        // на слишком короткий запрос отдаем пустую коллекцию
        if(strlen($query) < 2) {
            return new ContactsCollection();
        }

        $filter = new ContactsFilter();
        $filter->setQuery($query);

        try {
            $contacts_collection = $api_client->contacts()->get($filter, [ContactModel::LEADS]);
        } catch (AmoCRMMissedTokenException $e) {
        } catch (AmoCRMoAuthApiException $e) {
        } catch (AmoCRMApiException $e) {
            return new ContactsCollection();
        }

        if(empty($contacts_collection)){
            return new ContactsCollection();
        } else {
            return $contacts_collection;
        }
    }

}