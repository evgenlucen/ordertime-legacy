<?php


namespace App\Models\Dto\GetCourse;


use App\Configs\getcourseConfig;
use Illuminate\Http\Request;

class DealDto
{
    public ?UserDto $user = null;
    public int $id = 0;
    public int $number = 0;
    public string $status = '';
    public ?string $positions = '';
    public ?int $cost_money = 0;
    public ?string $payed_money = '';
    public ?string $payment_link = '';
    public ?string $utm_source = '';
    public ?string $utm_medium = '';
    public ?string $utm_campaign = '';
    public ?string $utm_term = '';
    public ?string $utm_content = '';
    public ?string $promocode = '';
    public ?int $amo_lead_id = null;
    public ?string $left_cost_money = '';
    public ?string $name = '';


    /**
     * @return array
     */
    public function toArray()
    {
        $deal = [];

        if(!empty($this->user)){
            $deal['user'] = $this->getUser()->toArray();
        }
        if(!empty($this->id)){
            $deal['deal_id'] = $this->id;
            $deal['gc_deal_link'] = getcourseConfig::DEAL_LINK . $this->id;
        }
        if(!empty($this->number)){
            $deal['number'] = $this->number;
        }
        if(!empty($this->status_deal)){
            $deal['status'] = $this->status_deal;
        }
        if(!empty($this->positions)){
            $deal['positions'] = $this->positions;
        }
        if(!empty($this->cost_money)){
            $deal['cost_money'] = $this->cost_money;
        }
        if(!empty($this->payed_money)){
            $deal['payed_money'] = $this->payed_money;
        }
        if(!empty($this->payment_link)){
            $deal['payment_link'] = $this->payment_link;
        }
        if(!empty($this->utm_source)){
            $deal['utm_source'] = $this->utm_source;
        }
        if(!empty($this->utm_medium)){
            $deal['utm_medium'] = $this->utm_medium;
        }
        if(!empty($this->utm_campaign)){
            $deal['utm_campaign'] = $this->utm_campaign;
        }
        if(!empty($this->utm_term)){
            $deal['utm_term'] = $this->utm_term;
        }
        if(!empty($this->utm_content)){
            $deal['utm_content'] = $this->utm_content;
        }
        if(!empty($this->promocode)){
            $deal['promocode'] = $this->promocode;
        }
        if(!empty($this->amo_lead_id)){
            $deal['amo_lead_id'] = $this->amo_lead_id;
        }
        if(!empty($this->left_cost_money)){
            $deal['left_cost_money'] = $this->left_cost_money;
        }
        if(!empty($this->name)){
            $deal['name'] = $this->name;
        }

        return $deal;
    }

    /**
     * @param Request $request
     * @return DealDto
     */
    public static function fromRequest(Request $request)
    {
        $deal = new self();

        $deal->setUser(UserDto::fromRequest($request));

        if(!empty($request->deal_id)){
            $deal->id = $request->deal_id;
        }
        if(!empty($request->number)){
            $deal->number = $request->number;
        }
        if(!empty($request->status_deal)){
            $deal->status = $request->status_deal;
        }
        if(!empty($request->positions)){
            $deal->positions = $request->positions;
        }
        if(!empty($request->cost_money)){
            $deal->cost_money = $request->cost_money;
        }
        if(!empty($request->payed_money)){
            $deal->payed_money = $request->payed_money;
        }
        if(!empty($request->payment_link)){
            $deal->payment_link = $request->payment_link;
        }
        if(!empty($request->utm_source)){
            $deal->utm_source = $request->utm_source;
        }
        if(!empty($request->utm_medium)){
            $deal->utm_medium = $request->utm_medium;
        }
        if(!empty($request->utm_campaign)){
            $deal->utm_campaign = $request->utm_campaign;
        }
        if(!empty($request->utm_term)){
            $deal->utm_term = $request->utm_term;
        }
        if(!empty($request->utm_content)){
            $deal->utm_content = $request->utm_content;
        }
        if(!empty($request->promocode)){
            $deal->promocode = $request->promocode;
        }
        if(!empty($request->amo_lead_id)){
            $deal->amo_lead_id = $request->amo_lead_id;
        }
        if(!empty($request->left_cost_money)){
            $deal->left_cost_money = $request->left_cost_money;
        }
        if(!empty($request->name)){
            $deal->name = $request->name;
        }

        return $deal;
    }

    /**
     * @return UserDto
     */
    public function getUser(): UserDto
    {
        return $this->user;
    }

    /**
     * @param UserDto $user
     */
    public function setUser(UserDto $user): void
    {
        $this->user = $user;
    }


    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
    }

    /**
     * @param int $number
     */
    public function setNumber(int $number): void
    {
        $this->number = $number;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string|null
     */
    public function getPositions(): ?string
    {
        return $this->positions;
    }

    /**
     * @param string|null $positions
     */
    public function setPositions(?string $positions): void
    {
        $this->positions = $positions;
    }

    /**
     * @return int
     */
    public function getCostMoney(): int
    {
        return $this->cost_money;
    }

    /**
     * @param int $cost_money
     */
    public function setCostMoney(int $cost_money): void
    {
        $this->cost_money = $cost_money;
    }

    /**
     * @return string
     */
    public function getPayedMoney(): string
    {
        return $this->payed_money;
    }

    /**
     * @param string $payed_money
     */
    public function setPayedMoney(string $payed_money): void
    {
        $this->payed_money = $payed_money;
    }

    /**
     * @return string|null
     */
    public function getPaymentLink(): ?string
    {
        return $this->payment_link;
    }

    /**
     * @param string|null $payment_link
     */
    public function setPaymentLink(?string $payment_link): void
    {
        $this->payment_link = $payment_link;
    }

    /**
     * @return string|null
     */
    public function getUtmSource(): ?string
    {
        return $this->utm_source;
    }

    /**
     * @param string|null $utm_source
     */
    public function setUtmSource(?string $utm_source): void
    {
        $this->utm_source = $utm_source;
    }

    /**
     * @return string|null
     */
    public function getUtmMedium(): ?string
    {
        return $this->utm_medium;
    }

    /**
     * @param string|null $utm_medium
     */
    public function setUtmMedium(?string $utm_medium): void
    {
        $this->utm_medium = $utm_medium;
    }

    /**
     * @return string|null
     */
    public function getUtmCampaign(): ?string
    {
        return $this->utm_campaign;
    }

    /**
     * @param string|null $utm_campaign
     */
    public function setUtmCampaign(?string $utm_campaign): void
    {
        $this->utm_campaign = $utm_campaign;
    }

    /**
     * @return string|null
     */
    public function getUtmTerm(): ?string
    {
        return $this->utm_term;
    }

    /**
     * @param string|null $utm_term
     */
    public function setUtmTerm(?string $utm_term): void
    {
        $this->utm_term = $utm_term;
    }

    /**
     * @return string|null
     */
    public function getUtmContent(): ?string
    {
        return $this->utm_content;
    }

    /**
     * @param string|null $utm_content
     */
    public function setUtmContent(?string $utm_content): void
    {
        $this->utm_content = $utm_content;
    }

    /**
     * @return string|null
     */
    public function getPromocode(): ?string
    {
        return $this->promocode;
    }

    /**
     * @param string|null $promocode
     */
    public function setPromocode(?string $promocode): void
    {
        $this->promocode = $promocode;
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
    public function getLeftCostMoney(): ?string
    {
        return $this->left_cost_money;
    }

    /**
     * @param string|null $left_cost_money
     */
    public function setLeftCostMoney(?string $left_cost_money): void
    {
        $this->left_cost_money = $left_cost_money;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }


}