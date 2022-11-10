<?php


namespace App\Services\AmoCRM\CustomFields;


use AmoCRM\Collections\CustomFieldsValuesCollection;

class GetValueCustomFieldByCode
{

    /**
     * @param CustomFieldsValuesCollection $custom_fields
     * @param $code
     * @return array|bool|int|mixed|object|string
     */
    public static function run(CustomFieldsValuesCollection $custom_fields,$code)
    {
        $custom_field = $custom_fields->getBy('field_code',$code);
        if (!is_null($custom_field)) {
            $values = $custom_field->getValues();
            if (!empty($values)) {
                $value = $values->first()->toArray()['value'];
                if(!empty($value)){
                    return $value;
                }
            }
        }

        return false;

    }
}