<?php

namespace App\Models\Dto\LeadCollect;

class LcModel
{

    /**
     * @var string|int
     */
    protected $phone;

    /**
     * @var string
     */
    protected string $email;

    /**
     * @var string
     */
    protected string $name;

    /**
     * @var string
     */
    protected string $page;

    /**
     * @var string
     */
    protected string $domain;

    /**
     * @var string
     */
    protected string $path;

    /**
     * @var string
     */
    protected $url;


    /**
     * @var string
     */
    protected $ltype;

    /**
     * @var string
     */
    protected $type_lead;

    /**
     * @var string
     */
    protected $calc;

    /**
     * @var string
     */
    protected $double_status_name;

    /**
     * @var bool
     */
    protected $double_status;

    /**
     * @var string
     */
    protected $rec;

    /**
     * @var string|int
     */
    protected $call_id;

    /**
     * @var string|int
     */
    protected $duration;

    /**
     * @var string
     */
    protected $utm_source;
    /**
     * @var string
     */
    protected $utm_campaign;
    /**
     * @var string
     */
    protected $utm_medium;
    /**
     * @var string
     */
    protected $utm_term;
    /**
     * @var string
     */
    protected $utm_content;

    /**
     * @var string
     */
    protected $ga_cid;
    /**
     * @var string|int
     */
    protected $roistat_visit;
    /**
     * @var string|int
     */
    protected $fb_fbc;
    /**
     * @var string|int
     */
    protected $fb_fbp;
    /**
     * @var string|int
     */
    protected $ym_uid;

    /**
     * @var array
     */
    protected $tags;

    /**
     * @var string
     */
    protected $company_name;

    protected string $promocode;

    /**
     * @var string|int
     */
    protected $amount;

    /**
     * @var int
     */
    protected $order_id;
    /**
     * @var array
     */
    protected $products;

    /**
     * @var string
     */
    protected $comment;

    /**
     * @var string
     */
    protected $product_date;

    /**
     * @var string|int
     */
    protected $product_quantity;

    /** @var string|null */
    private $sb_id;
    /** @var int|null */
    private $amo_lead_id;
    /** @var string|null */
    private $date_webinar;


    /**
     * @return string|null
     */
    public function getProductDate()
    {
        return $this->product_date;
    }

    /**
     * @param string $product_date
     */
    public function setProductDate( $product_date)
    {
        $this->product_date = $product_date;
    }


    /**
     * @return array|null
     */
    public function getProducts()
    {
        return $this->products;
    }



    /**
     * @param $products array
     */
    public function setProducts( $products)
    {
        $this->products = $products;
    }

    /**
     * @return int|null
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * @param int $order_id
     */
    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;
    }
    /**
     * @return string|null
     */
    public function getPromocode()
    {
        return $this->promocode;
    }

    /**
     * @param string $promocode
     */
    public function setPromocode($promocode)
    {
        $this->promocode = $promocode;
    }

    /**
     * @return string|null
     */
    public function getCompanyName()
    {
        return $this->company_name;
    }

    /**
     * @param string $company_name
     */
    public function setCompanyName($company_name)
    {
        $this->company_name = $company_name;
    }


    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return int|null
     */
    public function getAmoLeadId(): ?int
    {
        return $this->amo_lead_id;
    }

    /**
     * @param int|null $amo_lead_id
     */
    public function setAmoLeadId(?int $amo_lead_id): void
    {
        $this->amo_lead_id = $amo_lead_id;
    }

    /**
     * @return string|null
     */
    public function getDateWebinar(): ?string
    {
        return $this->date_webinar;
    }

    /**
     * @param string|null $date_webinar
     */
    public function setDateWebinar(?string $date_webinar): void
    {
        $this->date_webinar = $date_webinar;
    }

    /**
     * @return string|null
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return mixed
     */
    public function getLtype()
    {
        return $this->ltype;
    }

    /**
     * @return mixed
     */
    public function getRec()
    {
        return $this->rec;
    }

    /**
     * @return mixed
     */
    public function getCallId()
    {
        return $this->call_id;
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @return mixed
     */
    public function getUtmSource()
    {
        return $this->utm_source;
    }

    /**
     * @return mixed
     */
    public function getUtmCampaign()
    {
        return $this->utm_campaign;
    }

    /**
     * @return mixed
     */
    public function getUtmMedium()
    {
        return $this->utm_medium;
    }

    /**
     * @return mixed
     */
    public function getUtmTerm()
    {
        return $this->utm_term;
    }

    /**
     * @return mixed
     */
    public function getUtmContent()
    {
        return $this->utm_content;
    }

    /**
     * @return mixed
     */
    public function getGaCid()
    {
        return $this->ga_cid;
    }

    /**
     * @return mixed
     */
    public function getRoistatVisit()
    {
        return $this->roistat_visit;
    }

    /**
     * @return mixed
     */
    public function getFbFbc()
    {
        return $this->fb_fbc;
    }

    /**
     * @return mixed
     */
    public function getFbFbp()
    {
        return $this->fb_fbp;
    }

    /**
     * @return mixed
     */
    public function getYmUid()
    {
        return $this->ym_uid;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    /**
     * @param mixed $domain
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }



    /**
     * @param string $url
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @param mixed $ltype
     */
    public function setLtype($ltype)
    {
        $this->ltype = $ltype;
    }

    /**
     * @param mixed $rec
     */
    public function setRec($rec)
    {
        $this->rec = $rec;
    }

    /**
     * @param mixed $call_id
     */
    public function setCallId($call_id)
    {
        $this->call_id = $call_id;
    }

    /**
     * @param mixed $duration
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    /**
     * @param mixed $utm_source
     */
    public function setUtmSource($utm_source)
    {
        $this->utm_source = $utm_source;
    }

    /**
     * @param mixed $utm_campaign
     */
    public function setUtmCampaign($utm_campaign)
    {
        $this->utm_campaign = $utm_campaign;
    }

    /**
     * @param mixed $utm_medium
     */
    public function setUtmMedium($utm_medium)
    {
        $this->utm_medium = $utm_medium;
    }

    /**
     * @param mixed $utm_term
     */
    public function setUtmTerm($utm_term)
    {
        $this->utm_term = $utm_term;
    }

    /**
     * @param mixed $utm_content
     */
    public function setUtmContent($utm_content)
    {
        $this->utm_content = $utm_content;
    }

    /**
     * @param mixed $ga_cid
     */
    public function setGaCid($ga_cid)
    {
        $this->ga_cid = $ga_cid;
    }

    /**
     * @param mixed $roistat_visit
     */
    public function setRoistatVisit($roistat_visit)
    {
        $this->roistat_visit = $roistat_visit;
    }

    /**
     * @param mixed $fb_fbc
     */
    public function setFbFbc($fb_fbc)
    {
        $this->fb_fbc = $fb_fbc;
    }

    /**
     * @param mixed $fb_fbp
     */
    public function setFbFbp($fb_fbp)
    {
        $this->fb_fbp = $fb_fbp;
    }

    /**
     * @param mixed $ym_uid
     */
    public function setYmUid($ym_uid)
    {
        $this->ym_uid = $ym_uid;
    }

    /**
     * @return string|null
     */
    public function getCalc()
    {
        return $this->calc;
    }

    /**
     * @param string $calc
     */
    public function setCalc($calc)
    {
        $this->calc = $calc;
    }

    /**
     * @param $string string
     * @return string
     */
    public function appendCalc($string){
        if(empty($this->getCalc())){
            $calc = $string;
        } else {
            $calc = $this->getCalc();
            $calc .= "\n" . $string;
        }
        return $calc;
    }

    /**
     * @return mixed
     */
    public function getDoubleStatusName()
    {
        return $this->double_status_name;
    }

    /**
     * @param mixed $double_status_name
     */
    public function setDoubleStatusName($double_status_name)
    {
        $this->double_status_name = $double_status_name;
    }

    /**
     * @return bool
     */
    public function isDoubleStatus()
    {
        return $this->double_status;
    }

    /**
     * @param bool $double_status
     */
    public function setDoubleStatus( $double_status)
    {
        $this->double_status = $double_status;
    }

    /**
     * @return string
     */
    public function getTypeLead()
    {
        return $this->type_lead;
    }

    /**
     * @param string $type_lead
     */
    public function setTypeLead( $type_lead)
    {
        $this->type_lead = $type_lead;
    }

    /**
     * @return string|null
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment( $comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return int|string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int|string $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }




    public function toArray(){

        $data = [];
        if(!empty($this->getPhone())){ $data['phone'] = $this->getPhone(); }
        if(!empty($this->getEmail())){ $data['email'] = $this->getEmail(); }
        if(!empty($this->getLtype())){ $data['ltype'] = $this->getLtype(); }
        if(!empty($this->getDoubleStatusName())){ $data['double_status_name'] = $this->getDoubleStatusName(); }
        if(!empty($this->getName())){ $data['name'] = $this->getName(); }
        if(!empty($this->getTypeLead())){ $data['type_lead'] = $this->getTypeLead(); }

        if(!empty($this->getPage())){ $data['page'] = $this->getPage(); }
        if(!empty($this->getDomain())){ $data['domain'] = $this->getDomain(); }
        if(!empty($this->getPath())){ $data['path'] = $this->getPath(); }
        if(!empty($this->getUrl())){ $data['url'] = $this->getUrl(); }

        if(!empty($this->getCalc())){ $data['calc'] = $this->getCalc(); }

        if(!empty($this->getRec())){ $data['rec'] = $this->getRec(); }
        if(!empty($this->getCallId())){ $data['call_id'] = $this->getCallId(); }
        if(!empty($this->getDuration())){ $data['duration'] = $this->getDuration(); }

        if(!empty($this->getUtmSource())){ $data['utm_source'] = $this->getUtmSource(); }
        if(!empty($this->getUtmMedium())){ $data['utm_medium'] = $this->getUtmMedium(); }
        if(!empty($this->getUtmCampaign())){ $data['utm_campaign'] = $this->getUtmCampaign(); }
        if(!empty($this->getUtmTerm())){ $data['utm_term'] = $this->getUtmTerm(); }
        if(!empty($this->getUtmContent())){ $data['utm_content'] = $this->getUtmContent(); }
        if(!empty($this->getGaCid())){ $data['ga_cid'] = $this->getGaCid(); }
        if(!empty($this->getRoistatVisit())){ $data['roistat_visit'] = $this->getRoistatVisit(); }
        if(!empty($this->getFbFbc())){ $data['fbc'] = $this->getFbFbc(); }
        if(!empty($this->getFbFbp())){ $data['fbp'] = $this->getFbFbp(); }
        if(!empty($this->getYmUid())){ $data['ym_uid'] = $this->getYmUid(); }

        if(!empty($this->getTags())){ $data['tags'] = $this->getTags(); }

        if(!empty($this->getProducts())){ $data['products'] = $this->getProducts(); }
        if(!empty($this->getOrderId())){ $data['order_id'] = $this->getOrderId(); }
        if(!empty($this->getComment())){ $data['comment'] = $this->getComment(); }
        if(!empty($this->getPromocode())){ $data['promocode'] = $this->getPromocode(); }
        if(!empty($this->getAmount())){ $data['amount'] = $this->getAmount(); }
        if(!empty($this->getProductDate())){ $data['product_date'] = $this->getProductDate(); }
        if(!empty($this->getProductQuantity())){ $data['product_quantity'] = $this->getProductQuantity(); }

        return $data;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     */
    public function setTags( $tags)
    {
        $this->tags = $tags;
    }

    /**
     * @param $tags array
     */
    public function addTags($tags){
        $this->tags = array_merge($tags,$this->tags);
    }

    /**
     * @return int|string
     */
    public function getProductQuantity()
    {
        return $this->product_quantity;
    }

    /**
     * @param int|string $product_quantity
     */
    public function setProductQuantity($product_quantity)
    {
        $this->product_quantity = $product_quantity;
    }

    /**
     * @return string|null
     */
    public function getSbId(): ?string
    {
        return $this->sb_id;
    }

    /**
     * @param string|null $sb_id
     */
    public function setSbId(?string $sb_id): void
    {
        $this->sb_id = $sb_id;
    }


}
