<?php


namespace App\Services\GetCourse\ApiClient;


use App\Configs\getcourseConfig;
use App\Services\GetCourse\Vendor\GetcourseClient;
use App\Services\GetCourse\Vendor\GetcourseManager;

class GetApiClient
{
    /**
     * @var GetcourseManager
     */
    private $api_client;

    public function __construct()
    {
        $client = new GetcourseClient(env('GETCOURSE_DOMAIN'), env('GETCOURSE_API_KEY'));
        $this->api_client = new GetcourseManager($client);
    }

    /**
     * @return GetcourseManager
     */
    public static function getApiClient(): GetcourseManager
    {
        $api_client = new self();
        return $api_client->api_client;
    }


}