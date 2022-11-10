<?php

namespace App\Services\Salebot\src;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Salebot
 * @package Salebot
 */
class Salebot
{


    private $url = 'https://chatter.Salebot.pro/api/';
    const REQUEST_TIMEOUT_SECONDS = 20;

    /**
     * @var string
     */
    private $token;

    /**
     * @var Client
     */
    public $client;

    public function __construct($token)
    {
        $this->token = $token;
        $this->setClient();
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    private function setClient()
    {

        $uri = $this->url . $this->token;

        $client = new Client([
            'base_uri' => $uri,
            'timeout' => self::REQUEST_TIMEOUT_SECONDS
        ]);
        $this->client = $client;
        return $this;
    }

    /**
     * @param $client_id int|string
     * @param $message string|int
     * @param null|array $variables
     * @return \Exception|GuzzleException|string
     */
    public function callback($client_id, $message, $variables = null)
    {


        $params = [
            'form_params' => [
                'client_id' => (string)$client_id,
                'message' => (string)$message
            ]
        ];

        if (!empty($variables)) {
            if (is_array($variables)) {
                $params['form_params'] = array_merge($params['form_params'], $variables);
            }
        }

        try {
            return $this->client->post($this->token . '/callback', $params)->getReasonPhrase();
        } catch (GuzzleException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Метод можно использовать для запуска воронки у клиента или подтверждения действия на стороннем ресурсе.
     * Данное сообщение не увидит клиент.
     * Дополнительно переданные параметры сохранятся в переменные.
     * @param $vk_id int|string
     * @param $group_id int|string
     * @param $message string|int
     * @return ResponseInterface|string
     */
    public function vk_callback($vk_id, $group_id, $message = '')
    {

        $params = [
            'user_id' => (string)$vk_id,
            'group_id' => (string)$group_id
        ];
        if (!empty($message)) {
            $params['message'] = (string)$message;
        }

        try {
            $response = $this->client->post($this->token . '/vk_callback', $params);
        } catch (GuzzleException $e) {
            return $e->getMessage();
        }

        return $response;
    }

    /**
     * Этот метод может запустить вотсап бота, после регистрации клиента на сайте или после того,
     * как он оставит заявку с номером телефона.
     * Дополнительно переданные параметры сохранятся в переменные.
     * @param $phone int|string
     * @param string $name
     * @param string $message
     * @param string $bot_id
     * @return ResponseInterface|string
     */
    public function whatsapp_callback($phone, $name = '', $message = '', $bot_id = '')
    {

        $params = [
            'phone' => (string)$phone
        ];

        if (!empty($message)) {
            $params['message'] = (string)$message;
        }
        if (!empty($name)) {
            $params['name'] = (string)$name;
        }
        if (!empty($bot_id)) {
            $params['bot_id'] = (string)$bot_id;
        }

        try {
            $response = $this->client->post($this->token . '/whatsapp_callback', $params);
        } catch (GuzzleException $e) {
            return $e->getMessage();
        }

        return $response;
    }

    /**
     * Этот метод можно использовать для отправки сообщений с уведомлениями.
     * Параметр message обязателен, если вы не отправляете файл. Если вы отправляете файл, текст необязателен.
     * @param $message string
     * @param $client_id
     * @param string $attachment_type Тип отображения фала
     * @param string $attachment_url url файла
     * @param array $buttons
     * @return ResponseInterface|string
     */
    public function message($client_id, $message = '', $attachment_type = '', $attachment_url = '', $buttons = [])
    {

        $params = [
            'client_id' => (string)$client_id
        ];

        if (empty($message) and empty($attachment_url)) {
            return 'no file, no messge. Entry anything';
        }

        if (!empty($message)) {
            $params['message'] = (string)$message;
        }
        if (!empty($attachment_type)) {
            $params['attachment_type'] = (string)$attachment_type;
        }
        if (!empty($attachment_url)) {
            $params['attachment_url'] = (string)$attachment_url;
        }
        if (!empty($buttons)) {
            $params['buttons'] = json_encode($buttons);
        }

        try {
            $response = $this->client->post($this->token . '/message', $params);
        } catch (GuzzleException $e) {
            return $e->getMessage();
        }

        return $response;
    }

    /**
     * Метод позволяет запустить рассылку.
     * Если параметр clients не указан, рассылка будет произведена по всем пользователям.
     * Необходимо отправлять либо файл, либо текст.
     * @param $client_id
     * @param string $message
     * @param string $attachment_type
     * @param string $attachment_url
     * @param array $buttons
     * @param string $shift
     * @return ResponseInterface|string
     */
    public function broadcast($client_id = '', $message = '', $attachment_type = '', $attachment_url = '', $buttons = [], $shift = '')
    {

        if (empty($message) and empty($attachment_url)) {
            return 'no file, no messge. Entry anything';
        }

        if (!empty($client_id)) {
            $params['client_id'] = (string)$client_id;
        }
        if (!empty($message)) {
            $params['message'] = (string)$message;
        }
        if (!empty($attachment_type)) {
            $params['attachment_type'] = (string)$attachment_type;
        }
        if (!empty($attachment_url)) {
            $params['attachment_url'] = (string)$attachment_url;
        }
        if (!empty($buttons)) {
            $params['buttons'] = json_encode($buttons);
        }
        if (!empty($shift)) {
            $params['shift'] = (string)$shift;
        }

        try {
            $response = $this->client->post($this->token . '/broadcast', $params);
        } catch (GuzzleException $e) {
            return $e->getMessage();
        }

        return $response;
    }

    /**
     * Позволяет отправить сообщение от имени подключенного бота на указанный номер
     * whatsapp_bot_id необходимо взять из раздела мессенджеры и чаты.
     * Каждому подключенному вотсапу конструктор присваивает уникальный идентификатор.
     * @param $phone
     * @param string $message
     * @param string $attachment_type
     * @param string $attachment_url
     * @param string $whatsapp_bot_id
     * @return ResponseInterface|string
     */
    public function whatsapp_message($phone, $message = '', $attachment_type = '', $attachment_url = '', $whatsapp_bot_id = '')
    {

        if (empty($phone)) {
            return 'no phone';
        }

        $params = [
            'phone' => trim($phone)
        ];

        if (!empty($message)) {
            $params['message'] = (string)$message;
        }
        if (!empty($attachment_type)) {
            $params['attachment_type'] = (string)$attachment_type;
        }
        if (!empty($attachment_url)) {
            $params['attachment_url'] = (string)$attachment_url;
        }
        if (!empty($whatsapp_bot_id)) {
            $params['whatsapp_bot_id'] = (string)$whatsapp_bot_id;
        }

        try {
            $response = $this->client->post($this->token . '/whatsapp_message', $params);
        } catch (GuzzleException $e) {
            return $e->getMessage();
        }

        return $response;
    }


    /**
     * Позволяет сохранить переменные в заявку и в клиента.
     * Для сохранения переменной клиенту, переменная должна начинаться с префикса client.
     * Update: Параметр clients позволяет массово присваивать переменные.
     * @param $variables array
     * @param string $client_id
     * @param array $clients
     * @return ResponseInterface|string
     */
    public function save_variables($variables, $client_id = '', $clients = [])
    {

        if (empty($variables)) {
            return 'no variables';
        }

        $params = [
            'variables' => $variables
        ];

        if (!empty($client_id)) {
            $params['client_id'] = (string)$client_id;
        }
        if (!empty($clients)) {
            $params['clients'] = $client_id;
        }


        try {
            $response = $this->client->post($this->token . '/save_variables', $params);
        } catch (GuzzleException $e) {
            return $e->getMessage();
        }

        return $response;
    }

    /**
     * @param $client_id string|int
     * @return string
     */
    public function get_variables($client_id)
    {

        $params = [
            'query' => [
                'client_id' => $client_id
            ]
        ];

        try {
            $response = $this->client->get($this->token . '/get_variables', $params);
        } catch (GuzzleException $e) {
            return $e->getMessage();
        }

        return $response->getReasonPhrase();

    }


    /**
     * @param string $offset
     * @param string $limit
     * @return ResponseInterface|string
     */
    public function get_clients($offset = '', $limit = '')
    {

        $params = [
            'query' => []
        ];

        if (!empty($offset)) {
            $params['query']['offset'] = $offset;
        }
        if (!empty($limit)) {
            $params['query']['limit'] = $limit;
        }

        try {
            $response = $this->client->get("{$this->token}/get_clients", $params);
        } catch (GuzzleException $e) {
            return $e->getMessage();
        }

        return $response;

    }
}