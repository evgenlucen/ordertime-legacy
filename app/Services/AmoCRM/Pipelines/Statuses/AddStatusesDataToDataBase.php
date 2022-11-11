<?php


namespace App\Services\AmoCRM\Pipelines\Statuses;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\Models\Customers\Statuses\StatusModel;
use AmoCRM\Models\Leads\Pipelines\PipelineModel;
use App\Models\AmoCRM\Pipeline;
use App\Models\AmoCRM\Status;
use Illuminate\Support\Facades\DB;

class AddStatusesDataToDataBase
{
    /**
     * @throws AmoCRMApiException
     * @throws AmoCRMoAuthApiException
     * @throws AmoCRMMissedTokenException
     */
    public static function run(AmoCRMApiClient $api_client): array
    {
        $pipelines = $api_client->pipelines()->get();
        $result = [];
        /** @var PipelineModel $pipeline */
        foreach ($pipelines as $pipeline) {
            $pipeline_model = new Pipeline();
            $pipeline_model->id = $pipeline->getId();
            $pipeline_model->name = $pipeline->getName();
            $pipeline_model->is_main = $pipeline->getIsMain();

            $pipeline_model->update();

            $statuses = $pipeline->getStatuses();

            /** @var StatusModel $status */
            foreach ($statuses as $status) {
                $status_model = new Status();
                $status_model->status_id = $status->getId();
                $status_model->pipeline_id = $pipeline->getId();
                $status_model->name = $status->getName();
                $status_model->color = $status->getColor();
                $status_model->type = $status->getType();
                #$result[] = DB::table('statuses')->update($status_model->toArray());
                #$result[] = $status_model['name'] . " - " . (string)$status_model->updateOrCreate(['status_id' => $status->getId()], $status_model->toArray());
                $result[] = $status_model['name'] . " - " . (string)$status_model->save();
            }
        }
        return $result;
    }

}
