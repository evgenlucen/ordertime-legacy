<?php

namespace App\Services\AmoCRM\Webhook;

use AmoCRM\Helpers\EntityTypesInterface;
use Illuminate\Http\Request;

class GetModelIdsByWebhook
{
    public static function run(Request $request, string $modelType = null): ?array
    {
        if ($modelType == null){
            $modelType = GetModelTypeByWebhook::run($request);
        }

        if ($modelType == EntityTypesInterface::LEAD) {
            $addData = $request->input(EntityTypesInterface::LEADS)['add'];
            $ids = array_column($addData,'id');
        } elseif ($modelType == EntityTypesInterface::CONTACT){
            $addData = $request->input(EntityTypesInterface::CONTACTS)['add'];
            $ids = array_column($addData,'id');
        } else {
            $ids = null;
        }

        return $ids;

    }

}
