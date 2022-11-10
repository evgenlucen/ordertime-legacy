<?php


namespace App\Services\AmoCRM\CustomFields;


use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Models\CustomFieldsValues\BaseCustomFieldValuesModel;
use App\Models\Dto\LeadCollect\LcModel;

class CreateCustomFieldsCollectionByLeadCollectModel
{
    public static function run(LcModel $lc_model,array $cf_name_id_type_map)
    {
        $cf_collection = new CustomFieldsValuesCollection();

        $user_array = $lc_model->toArray();

        foreach ($user_array as $key => $value) {

            if (!empty($cf_name_id_type_map[$key])) {

                $cf_id = $cf_name_id_type_map[$key]['id']; //берем id из var map
                $cf_type = $cf_name_id_type_map[$key]['type'];

                if($cf_type == 'text'){
                    $cf = CreateTextCfModel::run($cf_id,$value);
                }
                if($cf_type == 'date'){
                    $cf = CreateDateCfModel::run($cf_id,$value);
                }
                if($cf instanceof BaseCustomFieldValuesModel){
                    $cf_collection->add($cf);  //добавить в коллекцию
                }
            }
        }

        return $cf_collection;
    }

}