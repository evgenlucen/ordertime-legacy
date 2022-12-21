<?php

namespace App\Http\Controllers\AmoCRM\Helpers;


use AmoCRM\Models\LeadModel;
use App\Models\Dto\Action\ActionParamsDto;
use App\Models\Dto\Action\AmoActionDto;
use App\Services\AmoCRM\ApiClient\GetApiClient;
use App\Services\AmoCRM\Lead\GetLeadById;
use App\Services\AmoCRM\Pipelines\Statuses\AddStatusesDataToDataBase;
use App\Services\AmoCRM\Pipelines\Statuses\GetPriorityStatusByLeadModel;
use App\Services\Bizon\Report\Tasks\GetPriorityStatusByAmoActionDto;
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
        $pipeline_id = (int) $request->input('pipeline_id');

        Assert::notEmpty($pipeline_id, "pipeline_id undefined");
        Assert::minLength($pipeline_id,5,"pipeline_id must min 5 simbols");

        Assert::notEmpty($status_id, "status_id undefined");
        Assert::minLength($status_id,6,"status_id must min 6 simbols");

        Assert::notEmpty($lead_id, "lead_id undefined");
        Assert::minLength($lead_id,6,"lead_id must be min 6 simbols");

        $api_client = GetApiClient::getApiClient();

        $lead = GetLeadById::run($api_client,$lead_id);

        # влияет обновим ли мы статус и воронку
        $priority_status_lead = GetPriorityStatusByLeadModel::run($lead);

        $amo_action = new AmoActionDto();
        $amo_action->setStatusId($status_id);
        $amo_action->setPipelineId($pipeline_id);

        $priority_status_request = GetPriorityStatusByAmoActionDto::run($amo_action);
        if(null === $priority_status_request) {
            $update_statuses_result = AddStatusesDataToDataBase::run($api_client);
            $priority_status_request = GetPriorityStatusByAmoActionDto::run($amo_action);
            if(null === $priority_status_request) {
                return new JsonResponse(['success' => false, 'error' => 'status_id not found in our database']);
            }
        }
        $data_log['priority_statuses'][] = ['lead' => $priority_status_lead, 'user' => $priority_status_request];

        /** Если приоритет нового статуса выше - обновляем в модели */
        if ($priority_status_request > $priority_status_lead) {
            $lead->setStatusId($amo_action->getStatusId());
            $lead->setPipelineId($amo_action->getPipelineId());
        } else {
            return new JsonResponse(
                [
                    'success' => false,
                    'error' => sprintf(
                        'Priority status lead %s, your status priority %s',
                        $priority_status_lead,
                        $priority_status_request)
                ]);
        }

        $lead = $api_client->leads()->updateOne($lead);

        $data_log['request'] = $request->json()->all();
        $data_log['lead'] = $lead->toArray();

        Logger::writeToLog($data_log,config('logging.dir_amo_helper_add_tags'));

        return new JsonResponse(['success' => true, 'data' => ['lead_id' => $lead->getId()]]);

    }
}
