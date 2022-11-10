<?php


namespace App\Services\AmoCRM\Lead\Tasks;




use Illuminate\Http\Request;

class GetLeadArrayByWebhook
{

    /**
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public static function run(Request $request)
    {
        if (isset($request->leads['status'][0])) {
            return $request->leads['status'][0];
        } elseif (isset($request->leads['add'][0])) {
            return  $request->leads['add'][0];
        } else {
            throw new \Exception("Не удалось получить массив сделки из вебхука");
        }
    }
}