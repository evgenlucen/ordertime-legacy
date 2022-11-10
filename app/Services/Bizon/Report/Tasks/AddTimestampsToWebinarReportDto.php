<?php


namespace App\Services\Bizon\Report\Tasks;


use App\Models\Dto\Bizon\WebinarConfigDto;
use App\Models\Dto\Bizon\WebinarReportDto;

class AddTimestampsToWebinarReportDto
{
    /**
     * @param WebinarReportDto $webinar_report_dto
     * @param WebinarConfigDto $config_by_room
     * @return WebinarReportDto
     */
    public static function run(WebinarReportDto $webinar_report_dto, WebinarConfigDto $config_by_room)
    {
        $time_start = GetWebinarTimeStartByWebinarDto::run($webinar_report_dto);
        $time_end = GetWebinarTimeEndByWebinarDto::run($webinar_report_dto, $time_start);

        $webinar_report_dto->setTimeStart($time_start);
        $webinar_report_dto->setTimeEnd($time_end);

        # высчитываем и добавляем продающую секунду вебинара
        if(!empty($config_by_room->getSalesPartByMinutes())){
            $webinar_report_dto->setSalesPartTimestamp($time_start + $config_by_room->getSalesPartByMinutes() * 60);
        }
        if(!empty($config_by_room->getSalesPartByPercent())){
            $webinar_report_dto->setSalesPartTimestamp(
                $time_start + round(($time_end - $time_start) * $config_by_room->getSalesPartByPercent() / 100));
        }

        return $webinar_report_dto;
    }

}