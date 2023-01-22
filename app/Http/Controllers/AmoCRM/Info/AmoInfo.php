<?php

namespace App\Http\Controllers\AmoCRM\Info;


use App\Services\AmoCRM\ApiClient\GetApiClient;
use App\Services\AmoCRM\Info\AmoInfoGetAccount;
use App\Services\AmoCRM\Info\AmoInfoGetCustomFieldsCompany;
use App\Services\AmoCRM\Info\AmoInfoGetCustomFieldsContact;
use App\Services\AmoCRM\Info\AmoInfoGetCustomFieldsLead;
use App\Services\AmoCRM\Info\AmoInfoGetStatuses;
use App\Services\AmoCRM\Info\AmoInfoGetUsers;
use App\Services\Debug\Debuger;
use Illuminate\Routing\Controller;

class AmoInfo extends Controller
{
    public function run()
    {
        header('Content-Type: text/html; charset=utf-8');
        $api_client = GetApiClient::getApiClient();
        $account = AmoInfoGetAccount::run($api_client);
        $users = AmoInfoGetUsers::run($api_client);
        $statuses = AmoInfoGetStatuses::run($api_client);
        $lead_custom_fields = AmoInfoGetCustomFieldsLead::run($api_client);
        $contact_custom_fields = AmoInfoGetCustomFieldsContact::run($api_client);
       # $company_custom_fields = AmoInfoGetCustomFieldsCompany::run($api_client);

        Debuger::debug(array_merge($account,$users,$statuses,$lead_custom_fields,$contact_custom_fields));


    }
}
