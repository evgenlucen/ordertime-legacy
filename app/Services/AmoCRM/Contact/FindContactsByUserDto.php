<?php


namespace App\Services\AmoCRM\Contact;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Collections\ContactsCollection;
use App\Models\Dto\Getcourse\UserDto;

class FindContactsByUserDto
{
    /**
     * @param AmoCRMApiClient $api_client
     * @param UserDto $user
     * @return ContactsCollection|null
     */
    public static function run(AmoCRMApiClient $api_client,UserDto $user)
    {
        if(!empty($user->getEmail())){
            $contacts_collection = FindContactsByQuery::run($api_client,$user->getEmail());
            if(!$contacts_collection->isEmpty()){
                return $contacts_collection;
            }
        }

        if(!empty($user->getPhone())){
            $contacts_collection = FindContactsByQuery::run($api_client,$user->getPhone());
            if(!$contacts_collection->isEmpty()){
                return $contacts_collection;
            }
        }

        return new ContactsCollection();
    }

}