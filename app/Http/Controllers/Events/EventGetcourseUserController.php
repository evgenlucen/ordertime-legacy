<?php

namespace App\Http\Controllers\Events;

use App\Configs\eventsConfig;
use App\Models\Dto\GetCourse\UserDto;
use App\Services\AmoCRM\ApiClient\GetApiClient;
use App\Services\AmoCRM\Contact\CreateOrUpdateContactByUserDto;
use App\Services\AmoCRM\Lead\CreateOrUpdateLeadByUserDtoAndContact;

use App\Services\Logger\Logger;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EventGetcourseUserController extends Controller
{
    public static function run(Request $request)
    {
        $api_client = GetApiClient::getApiClient();
        $userDto = UserDto::fromRequest($request);

        # получить конфиг по имени события
        $action_params = eventsConfig::getActionParamsDtoByEventName($request->event_name);

        #EventUserJob::dispatch($userDto,$action_params);

        # создать или обновить контакт
        $contact = CreateOrUpdateContactByUserDto::run($api_client,$userDto);

        # создать или обновить сделку
        $lead = CreateOrUpdateLeadByUserDtoAndContact::run($api_client, $userDto, $contact, $action_params->getAmocrmAction());


        $data_log['request'] = $request->all();
        $data_log['lead'] = $lead->toArray();
        $data_log['contact'] = $contact->toArray();


        //Debuger::debug($data_log);
        Logger::writeToLog($data_log,config('logging.dir_getcourse_user_events'));

    }
}
