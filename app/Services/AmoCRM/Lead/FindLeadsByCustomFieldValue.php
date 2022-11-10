<?php


namespace App\Services\AmoCRM\Lead;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Collections\Leads\LeadsCollection;

final class FindLeadsByCustomFieldValue
{
    /**
     * @param AmoCRMApiClient $api_client
     * @param $cf_id
     * @param $cf_value
     * @return LeadsCollection
     * @throws \Exception
     */
    public static function run(AmoCRMApiClient $api_client, $cf_id, $cf_value)
    {
        $lead_collection = FindLeadsByQuery::run($api_client, $cf_value);

        $result_lead_collection = new LeadsCollection();

        if (!$lead_collection->isEmpty()) {
            for ($i = 0; $i < $lead_collection->count(); $i++) {
                $lead_model = $lead_collection->offsetGet($i);
                $cf = $lead_model->getCustomFieldsValues();
                if(!empty($cf)){
                    $cf_values_collection = $cf->getBy('fieldId', $cf_id);

                    if (!empty($cf_values_collection)) {
                        $cf_values_collection = $cf_values_collection->getValues();
                        $lead_cf_value = $cf_values_collection->first()->toArray()['value'];
                    } else {
                        continue;
                    }
                    if ($lead_cf_value == $cf_value) {
                        $result_lead_collection->add($lead_model);
                    } else {
                        continue;
                    }
                } else {
                    continue;
                }

            }
        }

        return $result_lead_collection;

    }

}