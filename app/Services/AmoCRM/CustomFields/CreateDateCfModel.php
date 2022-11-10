<?php


namespace App\Services\AmoCRM\CustomFields;


use AmoCRM\Exceptions\InvalidArgumentException;
use AmoCRM\Models\CustomFieldsValues\DateCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\DateCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\DateCustomFieldValueModel;
use Carbon\Carbon;

class CreateDateCfModel
{
    /**
     * @param $cf_id
     * @param $cf_value
     * @return DateCustomFieldValuesModel
     * @throws InvalidArgumentException
     */
    public static function run($cf_id, $cf_value)
    {
        $cf_model = new DateCustomFieldValuesModel();
        $cf_value = str_replace("\"","",$cf_value);
        $date = Carbon::createFromFormat("i.m.Y",$cf_value)->getTimestamp();
        $cf_model->setFieldId($cf_id);
        $cf_model->setValues(
            (new DateCustomFieldValueCollection())
                ->add((new DateCustomFieldValueModel())->setValue($cf_value))
        );

        return $cf_model;
    }
}