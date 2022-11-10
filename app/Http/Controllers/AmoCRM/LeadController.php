<?php

namespace App\Http\Controllers\AmoCRM;

use AmoCRM\Filters\LeadsFilter;
use App\Http\Resources\LeadCollection;
use App\Models\AmoCRM\Lead;
use App\Services\AmoCRM\ApiClient\GetApiClient;
use App\Services\Debug\Debuger;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        LeadCollection::collection(Lead::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        $need_leads_count = $request->count;
        $count_pages = round($need_leads_count / 250,0);
        $count_pages = $count_pages == 0 ? 1 : $count_pages;

        $api_client = GetApiClient::getApiClient();
        $filter = new LeadsFilter();
        $filter->setLimit(250);

        $filter->setPage($count_pages);
        $leads_collection = $api_client->leads()->get($filter);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return void
     */
    public function show($id)
    {
        $api_client = GetApiClient::getApiClient();
        $lead = $api_client->leads()->getOne($id);
        Debuger::debug($lead);
        die();
        return $lead->toArray();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

}
