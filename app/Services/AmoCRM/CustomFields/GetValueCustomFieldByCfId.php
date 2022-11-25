<?php


namespace App\Services\AmoCRM\CustomFields;


use AmoCRM\Collections\CustomFieldsValuesCollection;

class GetValueCustomFieldByCfId
{
    /**
     * @param CustomFieldsValuesCollection $custom_fields
     * @param $cf_id
     * @return array|bool|int|object|string
     */
    public static function run(CustomFieldsValuesCollection $custom_fields,$cf_id)
    {
        $custom_field = $custom_fields->getBy('field_id',$cf_id);
        if (!is_null($custom_field)) {
            $values = $custom_field->getValues();
            if (!empty($values)) {
                $value = $values->first()->toArray()['value'];
                if(!empty($value)){
                    return $value;
                }
            }
        }

        return null;

    }

}
