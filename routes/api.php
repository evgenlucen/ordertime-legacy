<?php

use App\Http\Controllers\AmoCRM\Info\PipelinesController;
use App\Http\Controllers\AmoCRM\Info\StatusesController;
use App\Http\Controllers\AmoCRM\LeadController;
use App\Http\Controllers\Events\EventController;
use App\Http\Controllers\Events\EventLessonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('events')->group(function(){
    Route::post('event',[EventController::class,'run']);
    Route::post('lesson-page',[EventLessonController::class,'run']);
});

Route::prefix('amocrm')->group(function(){
    Route::resource('pipelines', PipelinesController::class);
    Route::resource('statuses', StatusesController::class);
    Route::resource('leads', LeadController::class);
});



