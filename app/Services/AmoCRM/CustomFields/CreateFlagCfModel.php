<?php

namespace App\Services\AmoCRM\CustomFields;

use AmoCRM\Models\CustomFieldsValues\CheckboxCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\CheckboxCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\CheckboxCustomFieldValueModel;

class CreateFlagCfModel
{
    public static function run(int $customFieldsId, bool $status): CheckboxCustomFieldValuesModel
    {

        $cfModel = new CheckboxCustomFieldValuesModel();
        $cfModel->setFieldId($customFieldsId);
        $cfModel->setValues(
            (new CheckboxCustomFieldValueCollection())
                ->add((new CheckBoxCustomFieldValueModel())->setValue($status))
        );

        return $cfModel;

    }
}
