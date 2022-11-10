<?php


namespace App\Services\AmoCRM\Lead\Tasks;


use App\Services\AmoCRM\Interfaces\WebhookTypeInterface;
use Illuminate\Http\Request;

class GetTypeEventByWebhook
{
    public static function run(Request $request)
    {
        if (isset($request->leads['status'])) {
            return WebhookTypeInterface::LEAD_CHANGE_STATUS;
        } elseif (isset($request->leads['add'])) {
            return WebhookTypeInterface::LEAD_ADD;
        } elseif (isset($request->unsorted['delete'][0]['accept_result'])) {
           return WebhookTypeInterface::DELETE_UNSORTED;
        } else {
            throw new \Exception('Не удалось определить тип вебхука');
        }


    }

}