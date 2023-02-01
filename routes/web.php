<?php

use App\Http\Controllers\AmoCRM\AmoAntiDouble;
use App\Http\Controllers\AmoCRM\AmoAuthController;
use App\Http\Controllers\AmoCRM\AmoSetPipelinesDataToDbController;
use App\Http\Controllers\AmoCRM\AnalyticsController;
use App\Http\Controllers\AmoCRM\AnalyticsControllerTest;
use App\Http\Controllers\AmoCRM\Helpers\AddTagsController;
use App\Http\Controllers\AmoCRM\Helpers\AddTaskController;
use App\Http\Controllers\AmoCRM\Helpers\ChangeLeadStatus;
use App\Http\Controllers\AmoCRM\Helpers\ChangeResponsibleUserController;
use App\Http\Controllers\AmoCRM\Info\AmoInfo;
use App\Http\Controllers\Events\EventGetcourseDealController;
use App\Http\Controllers\Events\EventGetcourseUserController;
use Illuminate\Support\Facades\Route;

Route::prefix('amocrm')->group(function(){
    Route::post('analytics',[AnalyticsController::class,'run']);
    Route::post('antidouble',[AmoAntiDouble::class,'run']);
    Route::post('analytics/test',[AnalyticsControllerTest::class,'run']);
    Route::get('info',[AmoInfo::class, 'run']);
    Route::get('auth',[AmoAuthController::class, 'run']);
    Route::post('statuses-create',[AmoSetPipelinesDataToDbController::class,'create']);
    Route::get('statuses-get',[AmoSetPipelinesDataToDbController::class,'get']);
    Route::get('statuses',[AmoSetPipelinesDataToDbController::class,'index']);
    Route::prefix('helper')->group(function(){
        Route::post('add-tags',[AddTagsController::class,'run']);
        Route::post('change-responsible',[ChangeResponsibleUserController::class,'run']);
        Route::post('change-lead-status',[ChangeLeadStatus::class,'run']);
        Route::post('add-task',[AddTaskController::class,'run']);
    });
});


Route::prefix('events')->group(function(){
    Route::prefix('getcourse')->group(function(){
        Route::post('deal_events',[EventGetcourseDealController::class,'run']);
        Route::post('user_events',[EventGetcourseUserController::class,'run']);
    });
});
