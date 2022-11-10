<?php

namespace App\Http\Controllers\Test\Bizon;


use App\Models\AmoCRM\Status;
use App\Models\Dto\Action\ActionParamsDto;
use App\Models\Dto\Action\AmoActionDto;
use App\Services\Bizon\Report\Tasks\GetPriorityStatusByAmoActionDto;
use App\Services\Debug\Debuger;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AnyMiniTest extends Controller
{
    public static function getStatus(Request $request)
    {
        $action_dto = new AmoActionDto();
        $action_dto->setStatusId($request->status_id);
        $action_dto->setPipelineId($request->pipeline_id);

        $result = Status::select('id')
            ->where('status_id','=',$action_dto->getStatusId())
            ->where('pipeline_id', '=', $action_dto->getPipelineId())
            ->get();

        Debuger::debug($result->first()->id);
        die();

    }
}
