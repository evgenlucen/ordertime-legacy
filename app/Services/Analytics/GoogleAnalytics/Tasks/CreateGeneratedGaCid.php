<?php


namespace App\Services\Analytics\GoogleAnalytics\Tasks;


class CreateGeneratedGaCid
{
    /**
     * @return string
     */
    public static function run()
    {
        $symbols = '0123456789';
        // Количество символов
        $amount = 10;
        $id = 9;
        // Определяем размер будущего числа
        $size = StrLen($symbols) - 1;
        // Генерируем число
        $random_number = '';
        $random_id = '';
        while ($amount--)
            $random_number .= $symbols[rand(0, $size)];
        while ($id--)
            $random_id .= $symbols[rand(0, $size)];
        $clientId = $random_id . "." . $random_number;
        return $clientId;
    }
}