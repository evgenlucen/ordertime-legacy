<?php


namespace App\Services\Leadcollect;


use GuzzleHttp\Client;

class LcTelegram extends LcRequest
{
    const URL_TG = 'https://api.telegram.org/bot';

    /**
     * @var string
     */
    private $token;

    /**
     * @var array
     */
    private $chats_id;

    /**
     * @var array|null
     */
    public $body = [];


    public function __construct($token)
    {
        $this->token=$token;
    }

    /**
     * @param $value
     * @return bool
     */
    public function addParamToBody($value){
        $body = $this->body;
        array_push($body,$value);
        $this->body = $body;
        return true;
    }


    /**
     * @param $chat_ids
     * @return array
     * @throws \Exception
     */
    public function sendMessage($chat_ids)
    {

        if($this->body == []){
            throw new \Exception('body is []');
        }

        $log = [];
        foreach ($chat_ids as $chat_id){
            $url_telegram = self::URL_TG . $this->token . '/sendMessage?';
            $url_telegram.= '&chat_id=' . $chat_id . "&text=" . implode("%0A",$this->body);
            $log[] = json_decode ($this->postRequest(null,$url_telegram));
        }

        return $log;

    }

    /**
     * @return array
     */
    public function getChatsId()
    {
        return $this->chats_id;
    }

    /**
     * @param array $chats_id
     */
    public function setChatsId($chats_id)
    {
        $this->chats_id = $chats_id;
    }

    private function getHttpClient(){
        $client = new Client(
            ['base_uri' => self::URL_TG . $this->token]
        );
        return $client;
    }

    /**
     * @return array|null
     */
    public function getBody()
    {
        return $this->body;
    }



}