<?php


namespace App\Services\Bizon\Report;



use App\Models\Dto\Bizon\WebinarReportDto;
use App\Services\Bizon\Report\Tasks\AddMessageDataToUserArray;
use App\Services\Debug\Debuger;

class GetUserMetaCollectionByWebinarReportDto
{
    public static function run(WebinarReportDto $webinar_dto)
    {

        $usersMeta = json_decode($webinar_dto->getReport(),1)['usersMeta'];
        if(empty($usersMeta)){
            return false;
        }
        $text_messages = json_decode($webinar_dto->getMessages(), 1);
        $time_messages = json_decode($webinar_dto->getMessagesTS(), 1);

        /** получаем массив вида chat_id = [time => message] */
        $message_data = AddMessageDataToUserArray::run($text_messages, $time_messages);

        /** Клеим чаты к юзерам */
        return CreateUserMetaCollectionByUserMetaAndMessageData::run($usersMeta, $message_data);

    }

}