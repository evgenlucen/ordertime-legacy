<?php

namespace App\Services\Logger;

class Logger
{
    /**
     * @param $data
     * @param $log_file
     * @param string $title
     * @return bool
     */
    public static function writeToLog($data, $log_file,$title = '') {
        $log = "\n------------------------\n";
        $log .= date("Y.m.d G:i:s") . "\n";
        $log .= time() . "\n";
        $log .= (strlen($title) > 0 ? $title : 'DEBUG') . "\n";
        $log .= print_r($data, 1);
        $log .= "\n------------------------\n";
        file_put_contents($log_file, $log, FILE_APPEND);
        return true;
    }

}