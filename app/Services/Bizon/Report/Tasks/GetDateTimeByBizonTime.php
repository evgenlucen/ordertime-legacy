<?php


namespace App\Services\Bizon\Report\Tasks;


class GetDateTimeByBizonTime
{
    public static function run($view_timestamp_bizon)
    {
        $bizon_time = GetRealUnixByBizonTime::run($view_timestamp_bizon); //substr($bizon_time,0,-3);
        return date("H:i d.m l", $bizon_time);
    }

}