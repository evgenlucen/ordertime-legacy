<?php

namespace App\Services\AmoCRM\Helper;

class PhoneClear
{
    /*
     * преобразует номер телефона к единому формату
     *
     * 89051234578 -> 79051234567
     * +7 905 123-45-78 -> 79051234567
     * +33 (123) 213 23 3 -> 33123213233
     * 123 4567 -> 1234567
     */
    public static function run(string $phone)
    {
        // плюс оставляем, чтобы 8 заменить дальше
        $resPhone = preg_replace("/[^0-9\+]/", "", $phone);
        $phone = trim($phone);
        // с 8 всего циферок будет 11 и не будет + в начале
        if (strlen($resPhone) === 11) {
            $resPhone = preg_replace("/^8/", "7", $resPhone);
        }

        if (substr($phone, 0,1) == '8' or substr($phone, 0,1) == '+') {
            //echo $phone . "<br>";
            $phone = preg_replace('/^\+?(8|7)/', '7', $phone);
        }
        // теперь уберём все плюсы
        return preg_replace("/[^0-9]/", "", $phone);
    }

}
