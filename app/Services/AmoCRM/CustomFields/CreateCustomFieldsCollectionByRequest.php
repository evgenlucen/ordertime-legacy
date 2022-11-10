<?php


namespace App\Services\AmoCRM\CustomFields;


use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Exceptions\InvalidArgumentException;
use AmoCRM\Helpers\EntityTypesInterface;
use Illuminate\Http\Request;

class CreateCustomFieldsCollectionByRequest
{
    /**
     * @param Request $request
     * @param string $entity_type
     * @return CustomFieldsValuesCollection
     * @throws InvalidArgumentException
     */
    public static function run(Request $request,string $entity_type)
    {
        $cf_collection = new CustomFieldsValuesCollection();

        if($entity_type == EntityTypesInterface::LEAD){
            $cf_name_id_type_map = config('amocrm.cf_lead_name_id_type_map');
        } elseif($entity_type == EntityTypesInterface::CONTACT){
            $cf_name_id_type_map = config('amocrm.cf_contact_name_id_type_map');
        }
        foreach ($request->all() as $key => $value) {

            if (!empty($cf_name_id_type_map[$key])) {

                $cf_id = $cf_name_id_type_map[$key]['id']; //берем id из var map
                $cf_type = $cf_name_id_type_map[$key]['type'];

                if($cf_type == 'text'){
                    $cf = CreateTextCfModel::run($cf_id,$value);
                }
                if($cf_type == 'date'){
                    $cf = CreateDateCfModel::run($cf_id,$value);
                }

                $cf_collection->add($cf); //добавить в коллекцию
            }
        }

        return $cf_collection;
    }

}