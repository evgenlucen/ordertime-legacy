<?php


namespace App\Services\Bizon\Report\Tasks;


use App\Models\Dto\Bizon\WebinarReportDto;

class GetWebinarTimeEndByWebinarDto
{

    /**
     * @param WebinarReportDto $webinar_dto
     * @param int $time_start
     * @return float|int
     */
    public static function run(WebinarReportDto $webinar_dto,int $time_start)
    {
        return $time_start + $webinar_dto->getLen() * 60;
    }
}