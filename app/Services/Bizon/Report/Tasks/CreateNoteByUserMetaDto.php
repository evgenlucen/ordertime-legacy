<?php


namespace App\Services\Bizon\Report\Tasks;


use App\Models\Dto\Bizon\UserMetaDto;

class CreateNoteByUserMetaDto
{
    /**
     * @param UserMetaDto $user
     * @return string
     */
    public static function run(UserMetaDto $user)
    {
        $note = '';
        $note.= 'Вебинар: ' . $user->getWebinarId() . "\n";
        $note.= 'Имя - ' . $user->getUsername() ."\n";
        $note.= 'Длительность посещения - ' . $user->getDurationInWebinar() ."\n";
        $note.= "► Вход - ". GetDateTimeByBizonTime::run($user->getView()) . "\n";
        $note.= "◄ Выход - ". GetDateTimeByBizonTime::run($user->getViewTill()) . "\n";
        $note.= "Регион - " . $user->getRegion() . "\n";
        if(!empty($user->getMessagesData())){
            $note.= "• Сообщения в чат: " . self::messagesToString($user->getMessagesData());
        }
        return $note;
    }



    /**
     * @param $messages_data array
     * @return string
     */
    public static function messagesToString($messages_data){
        $res = '';
        foreach ($messages_data as $time=>$message){
            $res.= date("H:i:s", mktime(0, 0, $time)) . ": " . $message . "\n";
        }
        return $res;
    }


}