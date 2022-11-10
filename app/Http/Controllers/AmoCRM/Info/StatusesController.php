<?php

namespace App\Http\Controllers\AmoCRM\Info;


use App\Http\Resources\AmoCRM\StatusesResource;
use App\Models\AmoCRM\Status;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class StatusesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return StatusesResource::collection(Status::with('pipeline')->get());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }



}
