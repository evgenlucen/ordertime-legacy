<?php


namespace App\Services\Bizon\Report\Tasks;


use App\Configs\bizonConfig;

class GetTimestampEndByWebinarArray
{
    /**
     * @param array $webinar
     * @return int
     */
    public static function run(array $webinar)
    {
        $time_start = GetTimestampStartByWebinarArray::run($webinar);
        $duration_in_min = $webinar['count2']; # 120
        return $time_start + $duration_in_min*60 + 60*bizonConfig::UTC;
    }
}