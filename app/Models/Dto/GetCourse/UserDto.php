<?php


namespace App\Models\Dto\GetCourse;


use App\Configs\getcourseConfig;
use Illuminate\Http\Request;

class UserDto
{
    public ?string $phone = '';
    public string $email = '';
    public ?string $salebot_id = '';
    public ?int $amo_contact_id = null;
    public string $name = "Имя неизвестно";
    public ?string $comment = null;
    public ?int $getcourse_user_id = null;


    public ?string $age = null;
    public ?string $utc = null;
    public ?string $city = null;

    /**
     * @return array
     */
    public function toArray(): array
    {
        $result = [];
        if(!empty($this->getEmail())){
            $result['email'] = $this->getEmail();
        }
        if(!empty($this->getPhone())){
            $result['phone'] = $this->getPhone();
        }
        if(!empty($this->getSalebotId())){
            $result['salebot_id'] = $this->getSalebotId();
        }
        if(!empty($this->getAmoContactId())){
            $result['amo_contact_id'] = $this->getAmoContactId();
        }
        if(!empty($this->getName())){
            $result['name'] = $this->getName();
        }
        if(!empty($this->getComment())){
            $result['comment'] = $this->getComment();
        }
        if(!empty($this->getGetcourseUserId())){
            $result['user_id'] = $this->getGetcourseUserId();
            $result['gc_user_link'] = getcourseConfig::USER_LINK . $this->getGetcourseUserId();
        }


        return $result;

    }

    /**
     * @param Request $request
     * @return UserDto
     */
    public static function fromRequest(Request $request): UserDto
    {
        $user = new self();

        if (!empty($request->phone)) {
            $user->setPhone($request->phone);
        }
        if (!empty($request->email)) {
            $user->setEmail($request->email);
        }
        if (!empty($request->salebot_id)) {
            $user->setSalebotId($request->salebot_id);
        }
        if (!empty($request->amo_contact_id)) {
            $user->setAmoContactId($request->amo_contact_id);
        }
        if (!empty($request->name)) {
            $user->setName($request->name);
        }
        if (!empty($request->comment)) {
            $user->setComment($request->comment);
        }
        if (!empty($request->user_id)) {
            $user->setGetcourseUserId($request->user_id);
        }
        if (!empty($request->age)) {
            $user->setAge($request->age);
        }
        if (!empty($request->utc)) {
            $user->setUtc($request->utc);
        }
        if (!empty($request->city)) {
            $user->setCity($request->city);
        }

        return $user;

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
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getSalebotId(): ?string
    {
        return $this->salebot_id;
    }

    /**
     * @param string|null $salebot_id
     */
    public function setSalebotId(?string $salebot_id): void
    {
        $this->salebot_id = $salebot_id;
    }

    /**
     * @return string|null
     */
    public function getAmoContactId(): ?string
    {
        return $this->amo_contact_id;
    }

    /**
     * @param string|null $amo_contact_id
     */
    public function setAmoContactId(?string $amo_contact_id): void
    {
        $this->amo_contact_id = $amo_contact_id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @param string|null $comment
     */
    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return int|null
     */
    public function getGetcourseUserId(): ?int
    {
        return $this->getcourse_user_id;
    }

    /**
     * @param int|null $getcourse_user_id
     */
    public function setGetcourseUserId(?int $getcourse_user_id): void
    {
        $this->getcourse_user_id = $getcourse_user_id;
    }


    /**
     * @return string|null
     */
    public function getAge(): ?string
    {
        return $this->age;
    }

    /**
     * @param string|null $age
     */
    public function setAge(?string $age): void
    {
        $this->age = $age;
    }

    /**
     * @return string|null
     */
    public function getUtc(): ?string
    {
        return $this->utc;
    }

    /**
     * @param string|null $utc
     */
    public function setUtc(?string $utc): void
    {
        $this->utc = $utc;
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


}
