<?php

use App\Http\Controllers\AmoCRM\AmoAuthController;
use App\Http\Controllers\AmoCRM\AmoSetPipelinesDataToDbController;
use App\Http\Controllers\AmoCRM\AnalyticsController;
use App\Http\Controllers\AmoCRM\AnalyticsControllerTest;
use App\Http\Controllers\AmoCRM\Helpers\AddTagsController;
use App\Http\Controllers\AmoCRM\Info\AmoInfo;
use App\Http\Controllers\Bizon\ReportHandlerController;
use App\Http\Controllers\Events\EventGetcourseDealController;
use App\Http\Controllers\Events\EventGetcourseUserController;
use App\Http\Controllers\Events\EventSalebotController;
use App\Services\Analytics\GoogleAnalytics\GetStatusNameByStatusIdAndPipelineId;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



#Route::get('/{any}',[\App\Http\Controllers\SpaController::class,'index'])->where('any',".*");


Route::prefix('amocrm')->group(function(){
    Route::post('analytics',[AnalyticsController::class,'run']);
    Route::post('analytics/test',[AnalyticsControllerTest::class,'run']);
    Route::get('info',[AmoInfo::class, 'run']);
    Route::get('auth',[AmoAuthController::class, 'run']);
    Route::post('statuses-create',[AmoSetPipelinesDataToDbController::class,'create']);
    Route::get('statuses-get',[AmoSetPipelinesDataToDbController::class,'get']);
    Route::get('statuses',[AmoSetPipelinesDataToDbController::class,'index'])->name('statuses');
    Route::prefix('helper')->group(function(){
        Route::post('add_tags',[AddTagsController::class,'run']);
    });

    Route::get('test',function (){
        return GetStatusNameByStatusIdAndPipelineId::run(44821654,4963063);
    });
});

/*Route::prefix('bizon')->group(function(){
    Route::post('report',[ReportHandlerController::class,'run']);
    Route::resource('reports',\App\Http\Controllers\Bizon\WebinarController::class);
});*/

Route::prefix('events')->group(function(){
    Route::prefix('getcourse')->group(function(){
        Route::post('deal_events',[EventGetcourseDealController::class,'run']);
        Route::post('user_events',[EventGetcourseUserController::class,'run']);
    });
    Route::post('salebot',[EventSalebotController::class,'run']);
});

Route::prefix('test')->group(function(){
    Route::post('/bizon/get_user',[\App\Http\Controllers\Test\Bizon\FindLeadByUserModel::class,'run']);
    #Route::post('/bizon/webinar_status',[\App\Services\Bizon\Report\Actions\UpdateReportHandlerStatusAction::class,'__construct']);
    Route::post('/bizon/get_webinars',[\App\Http\Controllers\Test\Bizon\AnyMiniTest::class,'getAllWebinars']);

    Route::prefix('events')->group(function() {
        Route::prefix('getcourse')->group(function () {
            Route::post('deal_events', [\App\Http\Controllers\Test\GetCourse\EventGetcourseDealTestController::class, 'run']);

        });
    });
});
