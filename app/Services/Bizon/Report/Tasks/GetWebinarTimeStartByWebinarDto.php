<?php


namespace App\Services\Bizon\Report\Tasks;


use App\Models\Dto\Bizon\WebinarReportDto;
use DateTime;

class GetWebinarTimeStartByWebinarDto
{
    /**
     * @param WebinarReportDto $webinar_dto
     * @return int
     */
    public static function run(WebinarReportDto $webinar_dto)
    {
        $webinarId = $webinar_dto->getWebinarId(); //116808:wd19*2021-12-27T18:53:00
        $time = explode('*',$webinarId)[1]; //2019-01-28T20:00:00
        return (int)DateTime::createFromFormat('Y-m-d H:i:s',preg_replace('%T%',' ',$time))->format('U');
    }

}