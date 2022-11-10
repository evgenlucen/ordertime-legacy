<?php


namespace App\Services\Bizon\Report\Tasks;


class GetRealUnixByBizonTime
{
    /**
     * Bizon отдает unix в милисекундах. обрезаем до секунд
     * @param int $view_timestamp_bizon
     * @return false|string
     */
    public static function run(int $view_timestamp_bizon)
    {
        return substr($view_timestamp_bizon,0,-3);
    }

}