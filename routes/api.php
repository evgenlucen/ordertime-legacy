<?php

use App\Http\Controllers\AmoCRM\Info\PipelinesController;
use App\Http\Controllers\AmoCRM\Info\StatusesController;
use App\Http\Controllers\AmoCRM\LeadController;
use App\Http\Controllers\Analytics\GA4Controller;
use App\Http\Controllers\Bizon\ReportHandlerController;
use App\Http\Controllers\Bizon\WebinarController;
use App\Http\Controllers\Events\EventController;
use App\Http\Controllers\LeadCollect\LeadCollectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('events')->group(function(){
    Route::post('salebot',[EventController::class,'run']);
});

Route::prefix('tilda')->group(function(){
    Route::post('form_submit',[LeadCollectController::class,'run']);
});

Route::prefix('bizon')->group(function(){
    Route::post('report-handler',[ReportHandlerController::class,'run']);
    Route::resource('reports', WebinarController::class);
});

Route::prefix('amocrm')->group(function(){
    Route::resource('pipelines', PipelinesController::class);
    Route::resource('statuses', StatusesController::class);
    Route::resource('leads', LeadController::class);
});

Route::prefix('ga')->group(function(){
    Route::post('event',[GA4Controller::class,'run']);
});

