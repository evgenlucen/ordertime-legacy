<?php

use App\Http\Controllers\Events\EventSalebotController;
use App\Http\Controllers\LeadCollect\LeadCollectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('events')->group(function(){
    Route::post('salebot',[EventSalebotController::class,'run']);
});

Route::prefix('tilda')->group(function(){
    Route::post('form_submit',[LeadCollectController::class,'run']);
});

Route::prefix('bizon')->group(function(){
    Route::post('report-handler',[\App\Http\Controllers\Bizon\ReportHandlerController::class,'run']);
    Route::resource('reports',\App\Http\Controllers\Bizon\WebinarController::class);
});

Route::prefix('amocrm')->group(function(){
    Route::resource('pipelines', \App\Http\Controllers\AmoCRM\Info\PipelinesController::class);
    Route::resource('statuses', \App\Http\Controllers\AmoCRM\Info\StatusesController::class);
    Route::resource('leads',\App\Http\Controllers\AmoCRM\LeadController::class);
});

