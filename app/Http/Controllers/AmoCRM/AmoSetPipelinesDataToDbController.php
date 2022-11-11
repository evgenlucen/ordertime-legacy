<?php

namespace App\Http\Controllers\AmoCRM;


use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use App\Models\AmoCRM\Status;
use App\Services\AmoCRM\ApiClient\GetApiClient;
use App\Services\AmoCRM\Pipelines\Statuses\AddStatusesDataToDataBase;
use Illuminate\Routing\Controller;

class AmoSetPipelinesDataToDbController extends Controller
{

    /**
     * @throws AmoCRMApiException
     * @throws AmoCRMoAuthApiException
     * @throws AmoCRMMissedTokenException
     */
    public function create(): array
    {
        $api_client = GetApiClient::getApiClient();
        return AddStatusesDataToDataBase::run($api_client);
    }

    public function get()
    {
        return Status::all();
    }

    public function index()
    {
        return view('statuses');
    }
}
