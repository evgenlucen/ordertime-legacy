<?php

namespace App\Http\Controllers\AmoCRM\Helpers;


use App\Services\AmoCRM\ApiClient\GetApiClient;
use App\Services\AmoCRM\Lead\FindLeadBySalebotEventRequest;
use App\Services\AmoCRM\Tag\AddTagsToLeadByLeadModel;
use App\Services\Logger\Logger;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class AddTagsController extends Controller
{
    /**
     * @throws \Exception
     */
    public static function run(Request $request): JsonResponse
    {


        if(empty($request->input('tags'))){
            return new JsonResponse(['success' => false, 'error' => 'Tags undefined']);
        }

        if(empty($request->input('amo_lead_id'))){
            return new JsonResponse(['success' => false, 'error' => 'amo_lead_id undefined']);
        }

        $tags = explode(',',$request->input('tags'));

        $api_client = GetApiClient::getApiClient();

        # Получить сделку
        try{
            $lead = FindLeadBySalebotEventRequest::run($api_client,$request);
        } catch (\Exception $exception){
            return new JsonResponse(['success' => false, 'error' => $exception->getMessage()]);
        }
        if(empty($lead)){
            return new JsonResponse(['success' => false, 'error' => "Lead with id: {$request->input('amo_lead_id')} undefined"]);
        }

        $lead = AddTagsToLeadByLeadModel::run($api_client,$lead,$tags);

        $data_log['request'] = $request->json()->all();
        $data_log['lead'] = $lead->toArray();

        Logger::writeToLog($data_log,config('logging.dir_amo_helper_add_tags'));

        return new JsonResponse(['success' => true, 'data' => ['lead_id' => $lead->getId()]]);


    }
}
