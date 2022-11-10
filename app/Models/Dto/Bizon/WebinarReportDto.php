<?php


namespace App\Models\Dto\Bizon;


use App\Services\Debug\Debuger;

class WebinarReportDto
{
    /** @var string|null */
    private ?string $id = '';

    /** @var int|null */
    private ?int $group = null;

    /** @var string|null идентификатор комнаты */
    private ?string $roomid;

    /** @var string|null идентификатор вебинара */
    private ?string $webinarId;

    /** @var string|null JSON тело отчета*/
    private ?string $report;

    /** @var string|null JSON id чатов и текст сообщений */
    private ?string $messages;

    /** @var string|null JSON id чатов и время сообщений (сек с начала) */
    private ?string $messagesTS;

    /** @var string|null 2021-04-16T19:10:00.700Z */
    private ?string $created;

    /** @var string|null Название комнаты */
    private ?string $room_title;

    /** @var int|null Длина вебинара в минутах */
    private ?int $len;

    /** @var string|null */
    private ?string $user_meta;
    /** @var int|null timestamp */
    private ?int $time_start;
    /** @var int|null timestamp */
    private ?int $time_end;

    /** @var int|null timestamp */
    private ?int $sales_part_timestamp = null;



    /**
     * @param $report array
     * @return self
     */
    public static function fromArray($report){

        $report_model = new self();

        $report_model->setId($report['_id']);
        $report_model->setGroup($report['group']);
        $report_model->setRoomid($report['roomid']);
        $report_model->setWebinarId($report['webinarId']);
        $report_model->setReport($report['report']);
        $report_model->setMessages($report['messages']);
        $report_model->setMessagesTs($report['messagesTS']);

        $report_model->setCreated($report['created']);

        return $report_model;


    }

    /**
     * @return string|null
     */
    public function getUserMeta(): ?string
    {
        return $this->user_meta;
    }

    /**
     * @param string|null $user_meta
     */
    public function setUserMeta(?string $user_meta): void
    {
        $this->user_meta = $user_meta;
    }

    /**
     * @return int|null
     */
    public function getTimeStart(): ?int
    {
        return $this->time_start;
    }

    /**
     * @param int|null $time_start
     */
    public function setTimeStart(?int $time_start): void
    {
        $this->time_start = $time_start;
    }

    /**
     * @return int|null
     */
    public function getTimeEnd(): ?int
    {
        return $this->time_end;
    }

    /**
     * @param int|null $time_end
     */
    public function setTimeEnd(?int $time_end): void
    {
        $this->time_end = $time_end;
    }


    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int|null
     */
    public function getGroup(): ?int
    {
        return $this->group;
    }

    /**
     * @param int|null $group
     */
    public function setGroup(?int $group): void
    {
        $this->group = $group;
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
     * @return string|null
     */
    public function getReport(): ?string
    {
        return $this->report;
    }

    /**
     * @param string|null $report
     */
    public function setReport(?string $report): void
    {
        $this->report = $report;
    }

    /**
     * @return string|null
     */
    public function getMessages(): ?string
    {
        return $this->messages;
    }

    /**
     * @param string|null $messages
     */
    public function setMessages(?string $messages): void
    {
        $this->messages = $messages;
    }

    /**
     * @return string|null
     */
    public function getMessagesTS(): ?string
    {
        return $this->messagesTS;
    }

    /**
     * @param string|null $messagesTS
     */
    public function setMessagesTS(?string $messagesTS): void
    {
        $this->messagesTS = $messagesTS;
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
     * @return string|null
     */
    public function getRoomTitle(): ?string
    {
        return $this->room_title;
    }

    /**
     * @param string|null $room_title
     */
    public function setRoomTitle(?string $room_title): void
    {
        $this->room_title = $room_title;
    }



    /**
     * @return int|null
     */
    public function getLen(): ?int
    {
        return $this->len;
    }

    /**
     * @param int|null $len
     */
    public function setLen(?int $len): void
    {
        $this->len = $len;
    }

    /**
     * @return int|null
     */
    public function getSalesPartTimestamp(): ?int
    {
        return $this->sales_part_timestamp;
    }

    /**
     * @param int|null $sales_part_timestamp
     */
    public function setSalesPartTimestamp(?int $sales_part_timestamp): void
    {
        $this->sales_part_timestamp = $sales_part_timestamp;
    }


}