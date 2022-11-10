<?php


namespace App\Services\Leadcollect\Helpers;


use Exception;

class JsonHelper
{
    /**
     * @param $dir_file
     * @param $phone string
     * @return false|int|string
     */
    public function searchPhoneInFile($dir_file, $phone)
    {
        if (file_exists($dir_file)) {
            $file = file_get_contents($dir_file);  // Открыть файл
            try {
                $data = json_decode($file, TRUE);
            } catch (Exception $e) {
                return false;
            }
            if (isset($data['phones'])) {
                $result = array_search($phone, $data['phones']);
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * @param $dir_file
     * @param $email string
     * @return false|int|string
     */
    public function searchEmailInFile($dir_file, $email)
    {
        if (file_exists($dir_file)) {
            $file = file_get_contents($dir_file);  // Открыть файл
            try {
                $data = json_decode($file, TRUE);
            } catch (Exception $e) {
                return false;
            }
            if (isset($data['emails'])) {
                $result = array_search($email, $data['emails']);
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * @param $dir_file
     * @param $lead_id
     * @return bool|array
     */
    public function searchLeadIdInFile($dir_file, $lead_id)
    {
        if (file_exists($dir_file)) {
            $file = file_get_contents($dir_file);  // Открыть файл
            try {
                $data = json_decode($file, TRUE);
            } catch (Exception $e) {
                return false;
            }
            if (isset($data[$lead_id])) {
                return $data[$lead_id];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * @param $events array
     * @param $event_name string
     * @return bool
     */
    public function checkEventDouble($events,$event_name){
        if($events === FALSE) { return FALSE; }
        $result =  array_search($event_name,$events);
        if($result === FALSE){
            return FALSE;
        } else {
            return TRUE;
        }
    }


    public function writeLeadEventToFile($dir_file, $lead_id, $event_name)
    {
        if (file_exists($dir_file)) {
            $file = file_get_contents($dir_file);  // Открыть файл
            try {
                $data = json_decode($file, TRUE);
            } catch (Exception $e) {
                return $e; //??
            }
            if (isset($data[$lead_id]['events'])) {
                array_push($data[$lead_id]['events'], $event_name);
                file_put_contents($dir_file, json_encode($data,JSON_UNESCAPED_UNICODE));  // Перекодировать в формат и записать в файл.
            } else {
                $data[$lead_id] = ['events' => [$event_name]];
                $data = json_encode($data,JSON_UNESCAPED_UNICODE);
                file_put_contents($dir_file, $data);
                /*
                $data = json_encode([$data[$lead_id]['events'] => [$event_name]],JSON_UNESCAPED_UNICODE);
                file_put_contents($dir_file, $data);
                */
            }

        } else {
            $data[$lead_id] = ['events' => [$event_name]];
            $data = json_encode($data,JSON_UNESCAPED_UNICODE);
            //$data = json_encode([[$lead_id] =>['events'=> [$event_name]]]);
            file_put_contents($dir_file, $data);
        }

        return $data;
    }


    /**
     * @param $dir_file string
     * @param $phone int|string
     * @return bool
     */
    public function writePhoneToFile($dir_file, $phone)
    {
        if (file_exists($dir_file)) {
            $file = file_get_contents($dir_file);  // Открыть файл
            try {
                $data = json_decode($file, TRUE);
            } catch (Exception $e) {
                $data = ['phones' => [$phone]];
                file_put_contents($dir_file, json_encode($data));
                return true;
            }
            if (isset($data['phones'])) {
                array_push($data['phones'], $phone); // добавим в конец массива id ещё один.
                file_put_contents($dir_file, json_encode($data));  // Перекодировать в формат и записать в файл.
            } else {
                $data = json_encode(['phones' => [$phone]]);
                file_put_contents($dir_file, $data);
            }

        } else {
            $data = json_encode(['phones' => [$phone]]);
            file_put_contents($dir_file, $data);
        }

        return $data;
    }


    /**
     * @param $dir_file string
     * @param $email int|string
     * @return bool
     */
    public function writeEmailToFile($dir_file, $email)
    {
        if (file_exists($dir_file)) {
            $file = file_get_contents($dir_file);  // Открыть файл
            try {
                $data = json_decode($file, TRUE);
            } catch (Exception $e) {
                $data = ['emails' => [$email]];
                file_put_contents($dir_file, json_encode($data));
                return true;
            }
            if (isset($data['emails'])) {
                array_push($data['emails'], $email); // добавим в конец массива id ещё один.
                file_put_contents($dir_file, json_encode($data));  // Перекодировать в формат и записать в файл.
            } else {
                $data = json_encode(['emails' => [$email]]);
                file_put_contents($dir_file, $data);
            }

        } else {
            $data = json_encode(['emails' => [$email]]);
            file_put_contents($dir_file, $data);
        }

        return $data;
    }
}