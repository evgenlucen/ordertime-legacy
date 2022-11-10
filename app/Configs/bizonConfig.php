<?php

namespace App\Configs;

use App\Models\Dto\Bizon\WebinarConfigDto;

class bizonConfig {

    public const UTC = 3;

    /**
     * Если просто из env тянуть - почему-то не лезет.
     * Прокинул через конфиг.
     */
    public static function getApiKey()
    {
        return config('bizon.api_key');
    }



    /**
     * @param string $webinar_name
     * @return WebinarConfigDto
     */
    public static function getWebinarConfigDtoByWebinarName(string $webinar_name)
    {
        $webinar_config = new WebinarConfigDto();

        switch ($webinar_name) {
            //TODO CHANGE ME
            case '116808:wd12':
            case '116808:wd15':
            case '116808:wd19':
            case '116808:wd21':
                $webinar_config->setWebinarName($webinar_name);
                $webinar_config->setSalesPartByMinutes(108);
                $webinar_config->setContentPartDurationMin(30);
                $webinar_config->setSalesPartDurationMin(20);
                $webinar_config->setVisitWebinarDurationMin(1);
                break;
        }

        return $webinar_config;

    }
}
