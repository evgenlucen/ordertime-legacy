<?php

namespace App\Services\Debug;

class Debuger
{
    /**
     * @param $data
     * @param bool $status
     * @param null $title
     * @return bool
     */
    public static function debug($data,$status = true,$title = null){
        if ($status == false) { return false; }
        echo '<pre>' . $title. print_r($data,1) . '</pre>';
    }

}