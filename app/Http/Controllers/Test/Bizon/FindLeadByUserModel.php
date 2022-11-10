<?php

namespace App\Http\Controllers\Test\Bizon;



use App\Models\Dto\Bizon\UserMetaDto;
use App\Services\AmoCRM\ApiClient\GetApiClient;
use App\Services\AmoCRM\Lead\GetLeadByBizonUserMetaDto;
use App\Services\Debug\Debuger;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FindLeadByUserModel extends Controller
{
    public static function run(Request $request)
    {
        $user_meta = new UserMetaDto();
        $user_meta->setPhone($request->phone);

        $api_client = GetApiClient::getApiClient();

        $lead = GetLeadByBizonUserMetaDto::run($api_client, $user_meta);

        Debuger::debug($lead);
    }
}
