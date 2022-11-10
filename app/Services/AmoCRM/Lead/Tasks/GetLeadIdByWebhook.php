<?php


namespace App\Services\AmoCRM\Lead\Tasks;


use Illuminate\Http\Request;

class GetLeadIdByWebhook
{
    public static function run(Request $request)
    {
        if (isset($request->leads['status'][0]['id'])) {
            $lead_id = $request->leads['status'][0]['id'];
        } elseif (isset($request->leads['add'][0]['id'])) {
            $lead_id = $request->leads['add'][0]['id'];
        } elseif (isset($request->unsorted['delete'][0]['accept_result']['leads'])) {
            $lead_id = $request->unsorted['delete'][0]['accept_result']['leads'][0];
        }

        return $lead_id;
    }

}