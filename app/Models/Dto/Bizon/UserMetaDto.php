<?php


namespace App\Models\Dto\Bizon;

use App\Configs\bizonConfig;

class UserMetaDto
{
    /** @var string */
    private string $id= '';
    /** @var  bool */
    private bool $playVideo= false;
    /** @var  null|string */
    private ?string $username= '';
    /** @var  null|string */
    private ?string $phone= '';
    /** @var null|string */
    private ?string $email= '';
    /** @var  string|null */
    private ?string $url= '';
    /** @var  string|null */
    private ?string $ip= '';
    /** @var  string|null */
    private ?string $useragent= '';
    /** @var  string */
    private string $referer= '';
    /** @var  null|string JSON  {"c": "Изумрудный"} — настраиваемые в комнате дополнительные поля */
    private ?string $cv= '';
    /** @var null|string Настраиваемый в комнате свой URL-параметр */
    private ?string $cu1= '';
    /** @var null|string param1 из url */
    private ?string $p1= '';
    /** @var null|string param2 из url */
    private ?string $p2= '';
    /** @var null|string param3 из url */
    private ?string $p3= '';
    /** @var  string|null 11046:dnt_lesson5 */
    private ?string $roomid= '';
    /** @var  string|null SsiQ-Vv8_*/
    private ?string $chatUserId= '';
    /** @var  string|null */
    private ?string $city= '';
    /** @var  string|null */
    private ?string $country= '';
    /** @var  string|null */
    private ?string $region= '';

    /** @var  string|null вероятно дата создания клиента в бизоне 2021-04-16T15:45:42.614Z */
    private ?string $created= '';
    /** @var  int|null 1618588822288 метка unix (в мс) в GMT, с которого зритель присутствовал на вебинаре */
    private ?int $view= null;
    /** @var  int|null 1618598722350 метка unix (в мс) в GTM до которого зритель присутствовал на вебинаре*/
    private ?int $viewTill= null;
    /** @var  string|null 11046:dnt_lesson5*2021-04-16T19:00:00 */
    private ?string $webinarId= '';
    /** @var int|null кол-во сообщений */
    private ?int $messages_num= null;
    /** @var null|array [секунда сообщения => текст] */
    private ?array $messages_data= null;

    private ?int $duration_in_webinar = 0;
    private ?bool $is_view_content_part = false;
    private ?bool $is_view_sales_part = false;
    private ?bool $is_visit_webinar = false;
    /** рассчитываемая активность от 1 до 4 */
    private ?int $web_activity;


    public static function fromArray($user_meta): UserMetaDto
    {
        $user_model = new self();

        if(!empty($user_meta['_id'])) { $user_model->setId($user_meta['_id']); }
        $user_model->setPlayVideo($user_meta['playVideo']);
        if(!empty($user_meta['phone'])) { $user_model->setPhone($user_meta['phone']); }
        if(!empty($user_meta['username'])){ $user_model->setUsername($user_meta['username']); }

        if(!empty($user_meta['url']))  { $user_model->setUrl($user_meta['url']); }
        if(!empty($user_meta['ip']))  {  $user_model->setIp($user_meta['ip']); }
        if(!empty($user_meta['useragent'])) { $user_model->setUseragent($user_meta['useragent']); }
        if(!empty($user_meta['referer']))  { $user_model->setReferer($user_meta['referer']); }
        if(!empty($user_meta['tz']))  { $user_model->setCv($user_meta['cv']); }
        if(!empty($user_meta['cu1']))  {$user_model->setCu1($user_meta['cu1']); }
        if(!empty($user_meta['p1']))  {$user_model->setP1($user_meta['p1']); }
        if(!empty($user_meta['p2']))  {$user_model->setP2($user_meta['p2']); }
        if(!empty($user_meta['p3']))  {$user_model->setP3($user_meta['p3']); }
        if(!empty($user_meta['roomid']))  {$user_model->setRoomid($user_meta['roomid']); }


        $user_model->setChatUserId($user_meta['chatUserId']);
        if(!empty($user_meta['city'])) { $user_model->setCity($user_meta['city']); }
        if(!empty($user_meta['region'])) { $user_model->setRegion($user_meta['region']); }
        if(!empty($user_meta['country'])) {  $user_model->setCountry($user_meta['country']); }
        $user_model->setCreated($user_meta['created']);
        $user_model->setWebinarId($user_meta['webinarId']);
        /** добавляем мс до часового пояса приложения */
        if(!empty($user_meta['view'])) { $user_model->setView($user_meta['view'] + bizonConfig::UTC * 3600000); }
        if(!empty($user_meta['viewTill'])) { $user_model->setViewTill($user_meta['viewTill']  + bizonConfig::UTC * 3600000); }
        if(!empty($user_meta['messages_num'])) { $user_model->setMessagesNum($user_meta['messages_num']); }
        if(!empty($user_meta['messages_data'])) { $user_model->setMessagesData($user_meta['messages_data']); }

        return $user_model;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return bool
     */
    public function isPlayVideo(): bool
    {
        return $this->playVideo;
    }

    /**
     * @param bool $playVideo
     */
    public function setPlayVideo(bool $playVideo): void
    {
        $this->playVideo = $playVideo;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     */
    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     */
    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     */
    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string|null
     */
    public function getIp(): ?string
    {
        return $this->ip;
    }

    /**
     * @param string|null $ip
     */
    public function setIp(?string $ip): void
    {
        $this->ip = $ip;
    }

    /**
     * @return string|null
     */
    public function getUseragent(): ?string
    {
        return $this->useragent;
    }

    /**
     * @param string|null $useragent
     */
    public function setUseragent(?string $useragent): void
    {
        $this->useragent = $useragent;
    }

    /**
     * @return string
     */
    public function getReferer(): string
    {
        return $this->referer;
    }

    /**
     * @param string $referer
     */
    public function setReferer(string $referer): void
    {
        $this->referer = $referer;
    }

    /**
     * @return string|null
     */
    public function getCv(): ?string
    {
        return $this->cv;
    }

    /**
     * @param string|null $cv
     */
    public function setCv(?string $cv): void
    {
        $this->cv = $cv;
    }

    /**
     * @return string|null
     */
    public function getCu1(): ?string
    {
        return $this->cu1;
    }

    /**
     * @param string|null $cu1
     */
    public function setCu1(?string $cu1): void
    {
        $this->cu1 = $cu1;
    }

    /**
     * @return string|null
     */
    public function getP1(): ?string
    {
        return $this->p1;
    }

    /**
     * @param string|null $p1
     */
    public function setP1(?string $p1): void
    {
        $this->p1 = $p1;
    }

    /**
     * @return string|null
     */
    public function getP2(): ?string
    {
        return $this->p2;
    }

    /**
     * @param string|null $p2
     */
    public function setP2(?string $p2): void
    {
        $this->p2 = $p2;
    }

    /**
     * @return string|null
     */
    public function getP3(): ?string
    {
        return $this->p3;
    }

    /**
     * @param string|null $p3
     */
    public function setP3(?string $p3): void
    {
        $this->p3 = $p3;
    }

    /**
     * @return string|null
     */
    public function getRoomid(): ?string
    {
        return $this->roomid;
    }

    /**
     * @param string|null $roomid
     */
    public function setRoomid(?string $roomid): void
    {
        $this->roomid = $roomid;
    }

    /**
     * @return string|null
     */
    public function getChatUserId(): ?string
    {
        return $this->chatUserId;
    }

    /**
     * @param string|null $chatUserId
     */
    public function setChatUserId(?string $chatUserId): void
    {
        $this->chatUserId = $chatUserId;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     */
    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string|null $country
     */
    public function setCountry(?string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return string|null
     */
    public function getRegion(): ?string
    {
        return $this->region;
    }

    /**
     * @param string|null $region
     */
    public function setRegion(?string $region): void
    {
        $this->region = $region;
    }

    /**
     * @return string|null
     */
    public function getCreated(): ?string
    {
        return $this->created;
    }

    /**
     * @param string|null $created
     */
    public function setCreated(?string $created): void
    {
        $this->created = $created;
    }

    /**
     * @return int|null
     */
    public function getView(): ?int
    {
        return $this->view;
    }

    /**
     * @param int|null $view
     */
    public function setView(?int $view): void
    {
        $this->view = $view;
    }

    /**
     * @return int|null
     */
    public function getViewTill(): ?int
    {
        return $this->viewTill;
    }

    /**
     * @param int|null $viewTill
     */
    public function setViewTill(?int $viewTill): void
    {
        $this->viewTill = $viewTill;
    }

    /**
     * @return string|null
     */
    public function getWebinarId(): ?string
    {
        return $this->webinarId;
    }

    /**
     * @param string|null $webinarId
     */
    public function setWebinarId(?string $webinarId): void
    {
        $this->webinarId = $webinarId;
    }

    /**
     * @return int|null
     */
    public function getMessagesNum(): ?int
    {
        return $this->messages_num;
    }

    /**
     * @param int|null $messages_num
     */
    public function setMessagesNum(?int $messages_num): void
    {
        $this->messages_num = $messages_num;
    }

    /**
     * @return array|null
     */
    public function getMessagesData(): ?array
    {
        return $this->messages_data;
    }

    /**
     * @param array|null $messages_data
     */
    public function setMessagesData(?array $messages_data): void
    {
        $this->messages_data = $messages_data;
    }

    /**
     * @return bool|null
     */
    public function getIsViewContentPart(): ?bool
    {
        return $this->is_view_content_part;
    }

    /**
     * @param bool|null $is_view_content_part
     */
    public function setIsViewContentPart(?bool $is_view_content_part): void
    {
        $this->is_view_content_part = $is_view_content_part;
    }


    /**
     * @return bool|null
     */
    public function getIsViewSalesPart(): ?bool
    {
        return $this->is_view_sales_part;
    }

    /**
     * @param bool|null $is_view_sales_part
     */
    public function setIsViewSalesPart(?bool $is_view_sales_part): void
    {
        $this->is_view_sales_part = $is_view_sales_part;
    }

    /**
     * @return bool|null
     */
    public function getIsVisitWebinar(): ?bool
    {
        return $this->is_visit_webinar;
    }

    /**
     * @param bool|null $is_visit_webinar
     */
    public function setIsVisitWebinar(?bool $is_visit_webinar): void
    {
        $this->is_visit_webinar = $is_visit_webinar;
    }

    /**
     * @return int|null
     */
    public function getDurationInWebinar(): ?int
    {
        return $this->duration_in_webinar;
    }

    /**
     * @param int|null $duration_in_webinar
     */
    public function setDurationInWebinar(?int $duration_in_webinar): void
    {
        $this->duration_in_webinar = $duration_in_webinar;
    }

    /**
     * @return int|null
     */
    public function getWebActivity(): ?int
    {
        return $this->web_activity;
    }

    /**
     * @param int|null $web_activity
     */
    public function setWebActivity(?int $web_activity): void
    {
        $this->web_activity = $web_activity;
    }


}
