<?php

namespace App\Http\Controllers\AmoCRM\Helpers;

use AmoCRM\Helpers\EntityTypesInterface;
use AmoCRM\Models\TaskModel;
use App\Configs\amocrmConfig;
use App\Http\Controllers\Controller;
use App\Services\AmoCRM\ApiClient\GetApiClient;
use App\Services\AmoCRM\Lead\FindLeadsByCustomFieldValue;
use App\Services\AmoCRM\Lead\GetLeadById;
use DateTimeImmutable;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Webmozart\Assert\Assert;

class AddTaskController extends Controller
{
    /**
     * @throws Exception
     */
    public function run(Request $request): JsonResponse
    {
        $amo_lead_id = $request->input('amo_lead_id') ?? null;
        Assert::notEmpty($amo_lead_id, "undefined amo_lead_id");

        $text_task = $request->input('task_text') ?? null;
        Assert::string($text_task, "Text task must be string");

        $salebot_id = $request->input('salebot_id') ?? null;
        $task_type = $request->input('task_type') ?? 1;

        $execution_time_in_hour = $request->input('execution_time_in_hour') ?? 1;

        $api_client = GetApiClient::getApiClient();
        $lead = GetLeadById::run($api_client, $amo_lead_id);
        if(null === $lead && null !== $salebot_id) {
            $leads = FindLeadsByCustomFieldValue::run($api_client,amocrmConfig::SB_CF_ID,$salebot_id);
            if(!$leads->isEmpty()){
                $lead = $leads->first();
            } else {
                new JsonResponse([
                    'success' => false,
                    'error' => sprintf("Lead with id %s and salebot_id %s not found", $amo_lead_id, $salebot_id)
                ]);
            }
        }

        $taskModel = new TaskModel();
        $taskModel->setText($text_task);
        $taskModel->setEntityId($lead->getId());
        $taskModel->setEntityType(EntityTypesInterface::LEADS);
        $taskModel->setCompleteTill((new DateTimeImmutable())->getTimestamp() + $execution_time_in_hour*60*60);
        $taskModel->setTaskTypeId($task_type);
        $taskModel->setResponsibleUserId($lead->getResponsibleUserId());

        $result = $api_client->tasks()->addOne($taskModel);

        return new JsonResponse(['success' => true, 'data' => ['task_id' => $result->getId()]]);
    }

}
