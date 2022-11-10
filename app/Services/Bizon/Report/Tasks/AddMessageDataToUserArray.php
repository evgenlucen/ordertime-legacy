<?php


namespace App\Services\Bizon\Report\Tasks;

/**
 *
 * Class AddMessageDataToUserArray
 * @package App\Services\Bizon\Report\Tasks
 */
class AddMessageDataToUserArray
{
    /**
     * @param $text_messages
     * @param $time_messages
     * @return array
     */
    public static function run($text_messages,$time_messages)
    {
        $message_data =[];
        foreach ($text_messages as $chat_id => $messages){
            $timing = $time_messages[$chat_id];
            $message_data[$chat_id] = array_combine($timing,$messages);
        }
        return $message_data;

    }
}