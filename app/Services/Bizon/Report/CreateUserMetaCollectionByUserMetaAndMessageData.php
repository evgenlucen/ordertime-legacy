<?php


namespace App\Services\Bizon\Report;





use App\Models\Dto\Bizon\UserMetaDto;

class CreateUserMetaCollectionByUserMetaAndMessageData
{
    /**
     * @param array $user_meta
     * @param array $message_data
     * @return array
     */
    public static function run(array $user_meta,array $message_data)
    {

        $user_collection = [];
        foreach ($user_meta as $chat_id => $user){
            if(!empty($message_data[$chat_id])){
                $user_meta[$chat_id]['messages_data'] = $message_data[$chat_id];
            }
            $user_collection[] = UserMetaDto::fromArray($user_meta[$chat_id]);
        }

        return $user_collection;
    }

}