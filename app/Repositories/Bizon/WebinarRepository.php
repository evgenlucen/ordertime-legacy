<?php


namespace App\Repositories\Bizon;


use App\Http\Resources\WebinarResourse;
use App\Models\Bizon\Webinar;
use App\Services\Bizon\Report\Tasks\GetTimestampEndByWebinarArray;
use App\Services\Bizon\Report\Tasks\GetTimestampStartByWebinarArray;
use App\Services\Debug\Debuger;
use Carbon\Carbon;
use Illuminate\Support\Str;
use slavkluev\Bizon365\Client;

class WebinarRepository
{

    public static function getAll()
    {
         return WebinarResourse::collection(Webinar::all());
    }

    /**
     * @param Client $bizon_client
     * @param int $skip
     * @param int $limit
     * @return mixed
     */
    public static function getFromBizonApi(Client $bizon_client, $skip = 0, $limit = 50)
    {
        $webinar_api = $bizon_client->getWebinarApi();
        $webinars_data = $webinar_api->getList($skip, $limit);

        $webinars = self::transformWebinarData($webinars_data['list']);

        return $webinars;
    }

    private static function transformWebinarData(array $webinars)
    {
        $result = [];
        foreach ($webinars as $webinar) {
            #$webinar['_id'] = $webinar['_id'];
            $webinar['created'] = Str::substr($webinar['created'], 0, -4);
            $webinar['time_start'] = GetTimestampStartByWebinarArray::run($webinar);
            $webinar['time_end'] = GetTimestampEndByWebinarArray::run($webinar);
            $webinar['text'] = Str::replace($webinar['text'],',','.');
            $webinar['updated_at'] = Carbon::now();
            $webinar['created_at'] = Carbon::now();
            $result[] = $webinar;
        }

        return $result;
    }

    public static function getAllFromBizonApi(Client $bizon_client, $skip = 0, $limit = 50)
    {
        $webinar_api = $bizon_client->getWebinarApi();
        $webinars_data = $webinar_api->getList($skip, $limit);

        $count = $webinars_data['count'];
        $current_limit = $webinars_data['limit'];
        $current_skip = $webinars_data['skip'];
        $webinars = self::transformWebinarData($webinars_data['list']);

        // Уже получено вебинаров в webinars
        $already_received_webinars = $current_skip + $current_limit;

        // осталось получить
        $left_to_get = $count - $already_received_webinars;

        while ($left_to_get > 0) {
            usleep(500000);
            $webinars_data = $webinar_api->getList($already_received_webinars, 50);
            $count = $webinars_data['count'];
            $current_limit = $webinars_data['limit'];
            $current_skip = $webinars_data['skip'];
            $webinars = array_merge(self::transformWebinarData($webinars_data['list']),$webinars);

            $already_received_webinars = $current_skip + $current_limit;
            $left_to_get = $count - $already_received_webinars;
        }

        return $webinars;

    }

    /**
     * Это получение отчета конкретного вебинара, а не данных о вебинаре как в List!
     * @param Client $bizon_client
     * @param string $webinarId
     * @return mixed
     */
    public static function getFromBizonById(Client $bizon_client, string $webinarId)
    {
        $webinar_api = $bizon_client->getWebinarApi();
        $webinar = $webinar_api->getWebinar($webinarId);

        return $webinar;
    }
}