<?php

namespace App\Services\AmoCRM\Filter;


use AmoCRM\Collections\ContactsCollection;

class FilterContactsByCustomFieldValue
{
    public static function run(ContactsCollection $contacts, string $customFieldValue, int $customFieldId): ContactsCollection
    {
        $result = new ContactsCollection();

        if ($contacts->isEmpty()) {
            return $contacts;
        }

        for ($i = 0; $i < $contacts->count(); $i++) {
            $contact = $contacts->offsetGet($i);

            $cfCollection = $contact->getCustomFieldsValues();

            if ($cfCollection->isEmpty()) { continue; }

            $cf = $cfCollection->getBy('fieldId',$customFieldId);

            if(empty($cf)) { continue; }

            $cfValues = $cf->getValues();
            if ($cfValues->isEmpty()) { continue; }


            for ($y = 0; $y < $cfValues->count(); $y++){
                $cfValue = $cfValues->offsetGet($y);

                if(empty($cfValue)) { continue; }

                if ($cfValue->toArray()['value'] == $customFieldValue){
                    $result = $result->add($contact);
                    break;
                }
            }
        }

        return $result;
    }
}
