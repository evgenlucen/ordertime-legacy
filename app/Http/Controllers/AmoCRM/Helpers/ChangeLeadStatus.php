<?php

namespace App\Http\Controllers\AmoCRM\Helpers;


use AmoCRM\Models\LeadModel;
use App\Services\AmoCRM\ApiClient\GetApiClient;
use App\Services\AmoCRM\Lead\FindLeadBySalebotEventRequest;
use App\Services\AmoCRM\Tag\AddTagsToLeadByLeadModel;
use App\Services\Logger\Logger;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Webmozart\Assert\Assert;

class ChangeLeadStatus extends Controller
{
    /**
     * @throws \Exception
     */
    public static function run(Request $request): JsonResponse
    {

        $status_id = $request->input('status_id');

        if(empty($status_id)){
            return new JsonResponse(['success' => false, 'error' => 'status_id undefined']);
        }

        Assert::integer($status_id,"status_id must be int");
        Assert::minLength($status_id,6,"status_id must be int");



        $api_client = GetApiClient::getApiClient();

        # Получить сделку
        $lead = new LeadModel();
        $lead->setStatusId($status_id);

        $lead = $api_client->leads()->updateOne($lead);

        $data_log['request'] = $request->json()->all();
        $data_log['lead'] = $lead->toArray();

        Logger::writeToLog($data_log,config('logging.dir_amo_helper_add_tags'));

        return new JsonResponse(['success' => true, 'data' => ['lead_id' => $lead->getId()]]);

    }
}
