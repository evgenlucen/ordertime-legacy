<?php


namespace App\Services\Leadcollect;

use App\Configs\leadcollectConfig;
use App\Services\Leadcollect\Helpers\JsonHelper;


class LcDoubleCheck extends JsonHelper
{
    public function checkDoubleByPhone($phone){
        if($phone == false) { return false; }
        $res = $this->searchPhoneInFile(leadcollectConfig::FILE_PHONES,$phone);
        return $res;
    }

    public function checkDoubleByEmail($email){
        if($email == false) { return false; }
        $res = $this->searchEmailInFile(leadcollectConfig::FILE_EMAIL,$email);
        return $res;
    }
}