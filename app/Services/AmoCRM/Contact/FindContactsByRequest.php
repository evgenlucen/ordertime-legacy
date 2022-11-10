<?php


namespace App\Services\AmoCRM\Contact;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Collections\ContactsCollection;
use Illuminate\Http\Request;


class FindContactsByRequest
{

    public static function run(AmoCRMApiClient $api_client,Request $request)
    {
        if(!empty($request->email)){
            $contacts_collection = FindContactsByQuery::run($api_client,$request->email);
            if(!$contacts_collection->isEmpty()){
                return $contacts_collection;
            }
        }

        if(!empty($request->phone)){
            $contacts_collection = FindContactsByQuery::run($api_client,$request->phone);
            if(!$contacts_collection->isEmpty()){
                return $contacts_collection;
            }
        }

        return new ContactsCollection();
    }
}