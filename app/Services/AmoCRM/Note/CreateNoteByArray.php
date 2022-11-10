<?php


namespace App\Services\AmoCRM\Note;


class CreateNoteByArray
{
    public static function run(array $array)
    {
        return implode("\n",$array);
    }

}