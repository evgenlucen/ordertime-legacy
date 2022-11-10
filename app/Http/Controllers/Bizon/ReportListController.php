<?php

namespace App\Http\Controllers\Bizon;



use App\Configs\bizonConfig;
use App\Models\Bizon\Webinar;
use App\Services\Bizon\Report\Tasks\GetTimestampEndByWebinarArray;
use App\Services\Bizon\Report\Tasks\GetTimestampStartByWebinarArray;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use slavkluev\Bizon365\Client;

class ReportListController extends Controller
{

    public function reports()
    {
        return Webinar::orderByDesc('time_start')->get();
    }

    public function run(){
        return view('bizon.report');
    }

    public function addToDb()
    {
        # header('Content-Type: text/html; charset=utf-8');
        $bizon_client = new Client(bizonConfig::getApiKey());
        $webinar_api = $bizon_client->getWebinarApi();
        $webinars = $webinar_api->getList(0,50);

        foreach ($webinars['list'] as $webinar){
            $webinar['created'] = Str::substr($webinar['created'],0,-4);
            $webinar['time_start'] = GetTimestampStartByWebinarArray::run($webinar);
            $webinar['time_end'] = GetTimestampEndByWebinarArray::run($webinar);
            $result[] = Webinar::updateOrCreate($webinar);
        }

        return $result;
    }
}
