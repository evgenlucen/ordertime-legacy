<?php


namespace App\Services\Bizon\Report\Tasks;


use App\Configs\bizonConfig;

class GetTimestampStartByWebinarArray
{
    /**
     *
     * @param array $webinar
     * @return false|string
     */
    public static function run(array $webinar)
    {
        /** {"minutes":116,"roomid":"11046:dnt_1_V2_15","group":11046,"start":1640174400000,"stat":0}  */
        $data = json_decode($webinar['data'],1);
        return substr($data['start'],0,-3)+ 60*bizonConfig::UTC;
    }
}