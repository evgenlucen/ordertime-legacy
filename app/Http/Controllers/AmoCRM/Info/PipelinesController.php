<?php

namespace App\Http\Controllers\AmoCRM\Info;

use App\Http\Resources\AmoCRM\PipelinesResource;
use App\Models\AmoCRM\Pipeline;
use App\Models\AmoCRM\Status;
use App\Repositories\AmoCRM\PipelinesRepository;
use App\Services\AmoCRM\ApiClient\GetApiClient;
use App\Services\Debug\Debuger;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class PipelinesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return PipelinesResource::collection(Pipeline::with('statuses')->get());
    }



    public function store(Request $request)
    {
        $api_client = GetApiClient::getApiClient();
        $pipelines = PipelinesRepository::getModelsFromAmoCRM($api_client);
        DB::table('pipelines')->truncate();
        DB::table('statuses')->truncate();
        foreach ($pipelines as $pipeline){
            $statuses = [];
            foreach ($pipeline->getStatuses() as $status){

                $status_model = new Status();
                $status_model->status_id = $status->getId();
                $status_model->pipeline_id = $pipeline->getId();
                $status_model->name = $status->getName();
                $status_model->color = $status->getColor();
                $status_model->type = $status->getType();
               # Status::create($status_model->toArray());
                $statuses[] = $status_model->toArray();
            }
            $pipeline_model = new Pipeline();
            $pipeline_model->id = $pipeline->getId();
            $pipeline_model->name = $pipeline->getName();
            $pipeline_model->is_main = $pipeline->getIsMain();
            DB::table('statuses')->upsert($statuses,['status_id','pipeline_id']);
            DB::table('pipelines')->upsert($pipeline_model->toArray(),'id');

        }
        return 'ok';

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AmoCRM\Pipeline  $pipeline
     * @return \Illuminate\Http\Response
     */
    public function show(Pipeline $pipeline)
    {
        //
    }



    public function update(Request $request, Pipeline $pipeline)
    {
        //
    }


}
