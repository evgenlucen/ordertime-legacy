<?php

namespace App\Services\AmoCRM\Webhook;

use AmoCRM\Helpers\EntityTypesInterface;
use Illuminate\Http\Request;
use Webmozart\Assert\Assert;

class GetModelIdByWebhook
{
    public static function run(Request $request, string $modelType = null)
    {
        if ($modelType == null){
            $modelType = GetModelTypeByWebhook::run($request);
        }

        if ($modelType == EntityTypesInterface::LEAD) {
            $id = $request->input(EntityTypesInterface::LEADS)['add'][0]['id'];
        } elseif ($modelType == EntityTypesInterface::CONTACT){
            $id = $request->input(EntityTypesInterface::CONTACTS)['add'][0]['id'];
        } else {
            $id = null;
        }

        Assert::notEmpty($id, "Undefined model id");

        return $id;

    }

}
