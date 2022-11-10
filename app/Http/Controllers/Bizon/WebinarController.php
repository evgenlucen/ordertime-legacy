<?php

namespace App\Http\Controllers\Bizon;


use App\Configs\bizonConfig;
use App\Models\Bizon\Webinar;
use App\Repositories\Bizon\WebinarRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use slavkluev\Bizon365\Client;

class WebinarController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index()
    {
       return WebinarRepository::getAll();
    }


    public function store(Request $request): array
    {
        $bizon_client = new Client(bizonConfig::getApiKey());
        $webinars = WebinarRepository::getAllFromBizonApi($bizon_client);

        DB::table('webinars')->upsert($webinars,'_id',['count1','count2','data','text','nerrors','updated_at']);

        return $webinars;
    }


    public function show(Webinar $webinar)
    {

    }


    /**
     * @param Request $request
     * @param Webinar $webinar
     * @todo Релаизовать
     */
    public function update(Request $request, Webinar $webinar)
    {
        //
    }

    /**
     * Delete all rows
     * @return mixed
     */
        public static function destroy(Request $request)
    {
        $webinar = Webinar::find($request->webinarId);
        return $webinar->delete();
    }

}
