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
    public static function getWebinarConfigDtoByWebinarName(string $webinar_name): WebinarConfigDto
    {
        $webinar_config = new WebinarConfigDto();

        switch ($webinar_name) {
            case '138703:la9tu69l2r':
                $webinar_config->setWebinarName($webinar_name);
                $webinar_config->setVisitWebinarDurationMin();
                break;
        }

        return $webinar_config;

    }
}
