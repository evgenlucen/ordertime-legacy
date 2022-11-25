<?php

namespace App\Services\AmoCRM\Webhook;

use AmoCRM\Helpers\EntityTypesInterface;
use Illuminate\Http\Request;

class GetModelTypeByWebhook
{

    public static function run(Request $request): string
    {

        $webhook = $request->all();

        if (null !== $request->input('contacts')){
            return $webhook['contacts']['add'][0]['type'] ?? $webhook['contacts']['update'][0]['type'];
        }

        if (null !== $request->input('leads')){
            return EntityTypesInterface::LEADS;
        }

        return new \Exception (sprintf("Unknown webhook type %s", json_encode( $request->toArray(), true)));
    }

}
