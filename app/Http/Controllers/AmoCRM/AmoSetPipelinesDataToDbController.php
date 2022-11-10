<?php

namespace App\Http\Controllers\AmoCRM;


use App\Models\AmoCRM\Status;
use App\Services\AmoCRM\ApiClient\GetApiClient;
use App\Services\AmoCRM\Pipelines\Statuses\AddStatusesDataToDataBase;
use Illuminate\Routing\Controller;

class AmoSetPipelinesDataToDbController extends Controller
{

    public function create()
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
