<?php


namespace App\Services\AmoCRM\Info;


use AmoCRM\Client\AmoCRMApiClient;

class AmoInfoGetCustomFieldsAll
{
    public static function run(AmoCRMApiClient $api_client)
    {
        $lead_custom_fields = AmoInfoGetCustomFieldsLead::run($api_client);
        $contact_custom_fields = AmoInfoGetCustomFieldsContact::run($api_client);
        $company_custom_fields = AmoInfoGetCustomFieldsCompany::run($api_client);

        return array_merge($lead_custom_fields,$contact_custom_fields,$company_custom_fields);
    }

}