<?php

namespace App\Services\Leadcollect;


class LcFormater
{
    /**
     * @var array
     */
    private $post;

    /**
     * LcFormater constructor.
     * @param $post array
     */
    public function __construct($post)
    {
        $this->post = $post;
    }

    /**
     * @return string
     */
    public function getTypeLead()
    {
        if (!empty($this->post['caller_id'])) {
            $type_lead = 'CALL';
        } elseif (!empty($this->post['ot_kogo'])) {
            $type_lead = 'CALL';
        } else {
            $type_lead = 'FORM';
        }
        return $type_lead;
    }

    /**
     * @return mixed
     */
    public function getClearPhone()
    {
        if (!empty($this->post['caller_id'])) {
            $phone = $this->post['caller_id'];
        } elseif (!empty($this->post['ot_kogo'])) {
            $phone = $this->post['ot_kogo'];
        } elseif (!empty($this->post['phone'])) {
            $phone = $this->post['phone'];
        } elseif (!empty($this->post['Phone'])) {
            $phone = $this->post['Phone'];
        } elseif (isset($this->post['contacts']['phone'])) {
            $phone = $this->post['contacts']['phone'];
        } elseif (isset($this->post['contacts']['whatsapp'])) {
            $phone = $this->post['contacts']['whatsapp'];
        } elseif (isset($this->post['contacts']['viber'])) {
            $phone = $this->post['contacts']['viber'];
        } elseif (isset($this->post['contacts']['telegram'])) {
            $phone = $this->post['contacts']['telegram'];
        } elseif (isset($this->post['contacts']['vk'])) {
            $phone = $this->post['contacts']['vk'];
        } elseif (isset($this->post['form_text_6'])) {
            $phone = $this->post['form_text_6'];
        } elseif (isset($this->post['__submission']['user_inputs']['phone'])) {
            $phone = $this->post['__submission']['user_inputs']['phone'];
        } else {
            return $phone = false;
        }

        $phone = $this->phoneClear($phone);
        return $phone;
    }

    /**
     * @return bool|string
     */
    public function getEmail()
    {

        if (isset($this->post['email'])) {
            $email = htmlspecialchars($this->post['email']);
        } elseif (isset($this->post['Email'])) {
            $email = htmlspecialchars($this->post['Email']);
        } elseif (isset($this->post['contacts']['email'])) {
            $email = $this->post['contacts']['email'];
        } elseif (isset($this->post['form_text_4'])) {
            $email = $this->post['form_text_4'];
        } elseif (isset($this->post['user_email'])) {
            $email = $this->post['user_email'];
        } elseif(isset($this->post['user_inputs']['email'])){
            $email = $this->post['user_inputs']['email'];
        }
        else {
            $email = false;
        }
        return $email;
    }

    /**
     * @return bool|string
     */
    public function getName()
    {
        if (isset($this->post['name'])) {
            $name = htmlspecialchars($this->post['name']);
        } elseif (isset($this->post['Name'])) {
            $name = htmlspecialchars($this->post['Name']);
        } elseif (isset($this->post['contacts']['name'])) {
            $name = $this->post['contacts']['name'];
        } elseif (isset($this->post['form_text_1'])) {
            $name = $this->post['form_text_1'];
        } elseif (isset($this->post['user_name'])) {
            $name = $this->post['user_name'];
        } elseif(isset($this->post['__submission']['user_inputs']['names'])){
            $name = $this->post['__submission']['user_inputs']['names'];
        }
        else {
            $name = false;
        }
        return $name;
    }

    /**
     * @return bool|mixed
     */
    public function getPage()
    {
        $page = false;

        if (!empty($this->post['page'])) {
            $page = $this->post['page'];
        } elseif (!empty($this->post['url'])) {
            $page = $this->post['url'];
        } elseif (!empty($this->post['pagehost'])) {
            $page = $this->post['pagehost'];
        } elseif (!empty($this->post['quiz']['name'])) {
            $page = $this->post['quiz']['name'];
        } elseif (!empty($this->post['quiz']['name'])) {
            $page = $this->post['quiz']['name'];
        } elseif (!empty($this->getCookie())) {
            $arrCookies = $this->getCookie();
            $page = $arrCookies['previousUrl'] ?? false;
        } elseif (!empty($this->post['__submission']['source_url'])) {
            $page = $this->post['__submission']['source_url'];
        }

        return $page;
    }

    /**
     * @return mixed|string
     */
    public function getLtype()
    {
        if (isset($this->post['title'])) {
            $ltype = $this->post['title'];
        } elseif (isset($this->post['ltype'])) {
            $ltype = $this->post['ltype'];
        } elseif (isset($this->post['formname'])) {
            $ltype = $this->post['formname'];
        } elseif (isset($this->post['quiz']['name'])) {
            $ltype = $this->post['quiz']['name'];
        } elseif (isset($this->post['submit'])) {
            $ltype = $this->post['submit'];
        } else {
            $ltype = 'Новый лид';
        }
        return $ltype;
    }

    /**
     * @return bool|array
     */
    public function getCookie()
    {
        if (isset($this->post['COOKIES'])) {
            $cookies = str_replace('; ', '&', $this->post['COOKIES']);
            parse_str($cookies, $arrCookies);
        } else {
            $arrCookies = false;
        }

        return $arrCookies;
    }

    /**
     * @return bool|mixed
     */
    public function getUtmSource()
    {
        if (isset($this->post['utm']['utm_source'])) {
            $utm_source = $this->post['utm']['utm_source'];
        } elseif (isset($this->post['utm_source'])) {
            $utm_source = $this->post['utm_source'];
        } else {
            $utm_source = false;
        }
        return $utm_source;
    }

    /**
     * @return bool|mixed
     */
    public function getUtmMedium()
    {
        if (!empty($this->post['utm']['utm_medium'])) {
            $utm_medium = $this->post['utm']['utm_medium'];
        } elseif (!empty($this->post['utm_medium'])) {
            $utm_medium = $this->post['utm_medium'];
        }
        {
            $utm_medium = false;
        }
        return $utm_medium;
    }

    /**
     * @return bool|mixed
     */
    public function getUtmCampaign()
    {

        if (!empty($this->post['utm']['utm_campaign'])) {
            $utm_campaign = $this->post['utm']['utm_campaign'];
        } elseif (!empty($this->post['utm_campaign'])) {
            $utm_campaign = $this->post['utm_campaign'];
        } else {
            $utm_campaign = false;
        }

        return $utm_campaign;
    }

    public function getUtmTerm()
    {
        if (!empty($this->post['utm']['utm_term'])) {
            $utm_term = $this->post['utm']['utm_term'];
        } elseif (!empty($this->post['utm_term'])) {
            $utm_term = $this->post['utm_term'];
        } else {
            $utm_term = false;
        }

        return $utm_term;
    }

    public function getUtmContent()
    {
        if (!empty($this->post['utm']['utm_content'])) {
            $utm_content = $this->post['utm']['utm_content'];
        } elseif (!empty($this->post['utm_content'])) {
            $utm_content = $this->post['utm_content'];
        } else {
            $utm_content = false;
        }

        return $utm_content;
    }

    public function getGoogleClientId()
    {
        if (!empty($this->post['cid'])) {
            $ga_cid = $this->post['cid'];
        } elseif (!empty($this->post['ga_client_id'])) {
            $ga_cid = $this->post['ga_client_id'];
        } elseif ($this->getCookie() != false) { //Tilda
            $arrCookies = $this->getCookie();
            $ga_cid = substr($arrCookies['_ga'], 6, 21);
        } elseif (!empty($post['extra']['cookies']['_ga'])) { //marquiz
            $ga_cid = substr($this->post['extra']['cookies']['_ga'], 6, 21);
        } else {
            $ga_cid = false;
        }
        return $ga_cid;
    }

    /**
     * @return bool|string
     */
    public function getRoistatVisit()
    {
        if (!empty($this->post['roistat_visit'])) {
            $result = $this->post['roistat_visit'];
        } elseif (!empty($this->getCookie())) {
            $arrCookies = $this->getCookie();
            $result = $arrCookies['roistat_visit'] ?? false;
        } else {
            $result = false;
        }

        return $result;
    }

    /**
     * @return bool|string
     */
    public function getFacebookClick()
    {
        if (!empty($this->post['fbc'])) {
            $result = $this->post['fbc'];
        } elseif (!empty($this->getCookie())) {
            $arrCookies = $this->getCookie();
            $result = $arrCookies['_fbc'] ?? false;
        } else {
            $result = false;
        }

        return $result;
    }

    /**
     * @return bool|string
     */
    public function getFacebookId()
    {
        if (!empty($this->post['fbp'])) {
            $result = $this->post['fbp'];
        } elseif (!empty($this->getCookie())) {
            $arrCookies = $this->getCookie();
            $result = $arrCookies['_fbp'] ?? false;
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * @return bool|string
     */
    public function getYmUid()
    {
        if (!empty($this->post['ym_uid'])) {
            $result = $this->post['ym_uid'];
        } elseif (!empty($this->getCookie())) {
            $arrCookies = $this->getCookie();
            $result = $arrCookies['ym_uid'] ?? false;
        } else {
            $result = false;
        }

        return $result;
    }

    public function getSalebotId()
    {
        if(!empty($this->post['sb_id'])){
            $result = $this->post['sb_id'];
        }
        elseif(!empty($this->getCookie())){
            $arrCookies = $this->getCookie();
            $result = $arrCookies['sb_id'] ?? false;
        } else {
            $result = false;
        }

        return $result;
    }

    public function getAmoLeadId()
    {
        $result = false;

        if(!empty($this->post['amo_lead_id'])){
            $result = $this->post['amo_lead_id'];
        }
        elseif(!empty($this->getCookie())){
            $arrCookies = $this->getCookie();
            if(!empty($arrCookies['amo_lead_id']) && strlen($arrCookies['amo_lead_id'] > 4)){
                $result = $arrCookies['amo_lead_id'];
            }
        }

        return $result;
    }

    public function getRec()
    {
        if (!empty($this->post['rec'])) {
            $rec = $this->post['rec'];
        } else {
            $rec = false;
        }

        return $rec;
    }

    public function getDuration()
    {
        if (!empty($this->post['duration'])) {
            $duration = $this->post['duration'];
        } else {
            $duration = false;
        }

        return $duration;
    }

    public function getCallId()
    {
        if (!empty($this->post['call_id'])) {
            $call_id = $this->post['call_id'];
        } else {
            $call_id = false;
        }

        return $call_id;
    }

    public function getCallStatus()
    {
        if (!empty($this->post['call_status'])) {
            $call_status = $this->post['call_status'];
        } else {
            $call_status = false;
        }

        return $call_status;
    }

    /**
     * @return bool|mixed
     */
    public function getOrderId()
    {
        if (!empty($this->post['payment']['orderid'])) {
            $order_id = $this->post['payment']['orderid'];
        } else {
            $order_id = false;
        }
        return $order_id;
    }

    /**
     * @return array
     */
    public function getProducts()
    {
        if (!empty($this->post['payment']['products'])) {
            $products = $this->post['payment']['products'];
        } else {
            $products = false;
        }
        return $products;
    }


    /**
     * @return bool|mixed
     */
    public function getPromocode()
    {
        if (!empty($this->post['Промокод'])) {
            $result = $this->post['Промокод'];
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * @return bool|mixed
     */
    public function getComment()
    {
        if (!empty($this->post['comment'])) {
            $result = $this->post['comment'];
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * @return bool|mixed
     */
    public function getAmount()
    {
        if (!empty($this->post['payment']['amount'])) {
            $result = $this->post['payment']['amount'];
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * @return bool|mixed
     */
    public function getProductDate()
    {
        if (!empty($this->post['payment']['products'][0]['options'][0]['variant'])) {
            $result = $this->post['payment']['products'][0]['options'][0]['variant'];
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * @return int|null
     */
    public function getProductQuantity()
    {
        if (!empty($this->post['payment']['products'][0]['quantity'])) {
            $result = $this->post['payment']['products'][0]['quantity'];
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * @return bool|string
     */
    public function getUrl()
    {
        if (!empty($this->post['url'])) {
            $result = $this->post['url'];
        } elseif (!empty($this->getCookie())) {
            $arrCookies = $this->getCookie();
            $result = $arrCookies['previousUrl'];
        } else {
            $result = false;
        }
        return $result;
    }


    /**
     * @param $phone
     * @return string|string[]|null
     */
    public function phoneClear($phone)
    {
        if (empty($phone)) {
            return false;
        }
        // плюс оставляем, чтобы 8 заменить дальше
        $resPhone = preg_replace("/[^0-9\+]/", "", $phone);
        $phone = trim($phone);
        // с 8 всего циферок будет 11 и не будет + в начале
        if (strlen($resPhone) === 11) {
            $resPhone = preg_replace("/^8/", "7", $resPhone);
        }
        if (substr($phone, 0, 1) == '8' or substr($phone, 0, 1) == '+') {
            //echo $phone . "<br>";
            $phone = preg_replace('/^\+?(8|7)/', '7', $phone);
        }
        // теперь уберём все плюсы
        $phone = preg_replace("/[^0-9]/", "", $phone);
        return $phone;
    }

}