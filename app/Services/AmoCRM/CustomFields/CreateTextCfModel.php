<?php


namespace App\Services\AmoCRM\CustomFields;


use AmoCRM\Models\CustomFieldsValues\TextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\TextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\TextCustomFieldValueModel;

class CreateTextCfModel
{
    public static function run($cf_id, $cf_value): TextCustomFieldValuesModel
    {
        $cf_model = new TextCustomFieldValuesModel();
        $cf_model->setFieldId($cf_id);
        $cf_model->setValues(
            (new TextCustomFieldValueCollection())
                ->add((new TextCustomFieldValueModel())->setValue((string)$cf_value))
        );

        return $cf_model;
    }

}
