<?php

namespace App\Http\Controllers\AmoCRM\Helpers;


use AmoCRM\Models\LeadModel;
use App\Services\AmoCRM\ApiClient\GetApiClient;
use App\Services\Logger\Logger;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Webmozart\Assert\Assert;

class ChangeLeadStatus extends Controller
{
    /**
     * @throws Exception
     */
    public static function run(Request $request): JsonResponse
    {

        $status_id = (int) $request->input('status_id');
        $lead_id = (int) $request->input('amo_lead_id');

        Assert::notEmpty($status_id, "status_id undefined");
        Assert::minLength($status_id,6,"status_id must min 6 simbols");

        Assert::notEmpty($lead_id, "lead_id undefined");
        Assert::minLength($lead_id,6,"lead_id must be min 6 simbols");

        $api_client = GetApiClient::getApiClient();

        # Получить сделку
        $lead = new LeadModel();
        $lead->setId($lead_id);
        $lead->setStatusId($status_id);

        $lead = $api_client->leads()->updateOne($lead);

        $data_log['request'] = $request->json()->all();
        $data_log['lead'] = $lead->toArray();

        Logger::writeToLog($data_log,config('logging.dir_amo_helper_add_tags'));

        return new JsonResponse(['success' => true, 'data' => ['lead_id' => $lead->getId()]]);

    }
}
