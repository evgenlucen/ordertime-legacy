<?php


namespace App\Services\AmoCRM\CustomFields;


use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Models\CustomFieldsValues\BaseCustomFieldValuesModel;
use App\Configs\amocrmConfig;
use App\Models\Dto\Getcourse\UserDto;

class CreateCustomFieldsCollectionByUserDto
{

    public static function run(UserDto $user)
    {
        $cf_collection = new CustomFieldsValuesCollection();

        $user_array = $user->toArray();

        $cf_name_id_type_map = amocrmConfig::getCfNameIdMapContact();

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