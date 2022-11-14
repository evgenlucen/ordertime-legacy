<?php


namespace App\Models\Dto\AmoCRM;


use AmoCRM\Models\LeadModel;
use App\Services\AmoCRM\CustomFields\GetValueCustomFieldByCfId;
use App\Services\AmoCRM\Lead\Tasks\GetCustomFieldValueFromArrayByCfId;
use App\Configs\amocrmConfig;

class LeadForAnalyticsDto
{

    public const CRM_NAME = 'amoCRM';

    public ?int $lead_id = null;
    public ?string $google_client_id = '';
    public bool $is_ga_cid_generated = false;
    public ?string $facebook_client_id = '';
    public ?int $revenue = 0;
    public ?string $status_name = '';
    public ?int $status_id = null;
    public ?int $pipeline_id = null;
    public ?string $product_name = '';
    public ?string $product_category_name = '';

    public ?string $utm_source = '';
    public ?string $utm_medium = '';
    public ?string $utm_campaign = '';
    public ?string $utm_term = '';
    public ?string $utm_content = '';


    public function toArray(): array
    {
        $lead = [];
        if(!empty($this->getLeadId())){
            $lead['lead_id'] = $this->getLeadId();
        }
        if(!empty($this->google_client_id)){
            $lead['google_client_id'] = $this->google_client_id;
        }
        if(!empty($this->is_ga_cid_generated)){
            $lead['is_ga_cid_generated'] = $this->is_ga_cid_generated;
        }
        if(!empty($this->facebook_client_id)){
            $lead['facebook_client_id'] = $this->facebook_client_id;
        }
        if(!empty($this->revenue)){
            $lead['revenue'] = $this->revenue;
        }
        if(!empty($this->status_name)){
            $lead['status_name'] = $this->status_name;
        }
        if(!empty($this->status_id)){
            $lead['status_id'] = $this->status_id;
        }
        if(!empty($this->pipeline_id)){
            $lead['pipeline_id'] = $this->pipeline_id;
        }
        if(!empty($this->product_name)){
            $lead['product_name'] = $this->product_name;
        }
        if(!empty($this->product_category_name)){
            $lead['product_category_name'] = $this->product_category_name;
        }
        if(!empty($this->utm_source)){
            $lead['utm_source'] = $this->utm_source;
        }
        if(!empty($this->utm_medium)){
            $lead['utm_medium'] = $this->utm_medium;
        }
        if(!empty($this->utm_campaign)){
            $lead['utm_campaign'] = $this->utm_campaign;
        }
        if(!empty($this->utm_term)){
            $lead['utm_term'] = $this->utm_term;
        }
        if(!empty($this->utm_content)){
            $lead['utm_content'] = $this->utm_content;
        }

        return $lead;


    }

    public static function fromLeadArrayFromWebhook(array $lead): LeadForAnalyticsDto
    {

        $dto = new self();
        $dto->setLeadId($lead['id']);
        $dto->setPipelineId($lead['pipeline_id']);
        $dto->setStatusId($lead['status_id']);

        $custom_fields = $lead['custom_fields'] ?? null;
        if(!empty($custom_fields)){
            $dto->setGoogleClientId( GetCustomFieldValueFromArrayByCfId::run($custom_fields,amocrmConfig::GOOGLE_CID_CF_ID));
            $dto->setFacebookClientId( GetCustomFieldValueFromArrayByCfId::run($custom_fields,amocrmConfig::FBP_CF_ID));
            $dto->setUtmSource( GetCustomFieldValueFromArrayByCfId::run($custom_fields,amocrmConfig::UTM_SOURCE_CF_ID));
            $dto->setUtmMedium( GetCustomFieldValueFromArrayByCfId::run($custom_fields,amocrmConfig::UTM_MEDIUM_CF_ID));
            $dto->setUtmCampaign( GetCustomFieldValueFromArrayByCfId::run($custom_fields,amocrmConfig::UTM_CAMPAIGN_CF_ID));
            $dto-> setUtmTerm( GetCustomFieldValueFromArrayByCfId::run($custom_fields,amocrmConfig::UTM_TERM_CF_ID));
            $dto->setUtmContent( GetCustomFieldValueFromArrayByCfId::run($custom_fields,amocrmConfig::UTM_CONTENT_CF_ID));
            $dto->setProductName( GetCustomFieldValueFromArrayByCfId::run($custom_fields,amocrmConfig::CF_ID_PRODUCT_NAME));
        }

        return $dto;
    }

    public static function fromLeadModel(LeadModel $lead): LeadForAnalyticsDto
    {
        $dto = new self();

        if($lead->getPrice()){
            $dto->setRevenue($lead->getPrice());
        }
        $dto->setLeadId($lead->getId());
        $dto->setPipelineId($lead->getPipelineId());
        $dto->setStatusId($lead->getStatusId());
        $custom_fields = $lead->getCustomFieldsValues();
        if(!empty($custom_fields)){
            $dto->setGoogleClientId(GetValueCustomFieldByCfId::run($custom_fields,amocrmConfig::GOOGLE_CID_CF_ID));
            $dto->setFacebookClientId(GetValueCustomFieldByCfId::run($custom_fields,amocrmConfig::FBP_CF_ID));
            $dto->setUtmSource( GetValueCustomFieldByCfId::run($custom_fields,amocrmConfig::UTM_SOURCE_CF_ID));
            $dto->setUtmMedium( GetValueCustomFieldByCfId::run($custom_fields,amocrmConfig::UTM_MEDIUM_CF_ID));
            $dto->setUtmCampaign( GetValueCustomFieldByCfId::run($custom_fields,amocrmConfig::UTM_CAMPAIGN_CF_ID));
            $dto->setUtmTerm( GetValueCustomFieldByCfId::run($custom_fields,amocrmConfig::UTM_TERM_CF_ID));
            $dto->setUtmContent( GetValueCustomFieldByCfId::run($custom_fields,amocrmConfig::UTM_CONTENT_CF_ID));
            $dto->setProductName( GetValueCustomFieldByCfId::run($custom_fields,amocrmConfig::CF_ID_PRODUCT_NAME));
        }

        return $dto;

    }



    /**
     * @return int|null
     */
    public function getRevenue(): ?int
    {
        return $this->revenue;
    }

    /**
     * @param int|null $revenue
     */
    public function setRevenue(?int $revenue): void
    {
        $this->revenue = $revenue;
    }

    /**
     * @return string|null
     */
    public function getStatusName(): ?string
    {
        return $this->status_name;
    }

    /**
     * @param string|null $status_name
     */
    public function setStatusName(?string $status_name): void
    {
        $this->status_name = $status_name;
    }

    /**
     * @return int|null
     */
    public function getStatusId(): ?int
    {
        return $this->status_id;
    }

    /**
     * @param int|null $status_id
     */
    public function setStatusId(?int $status_id): void
    {
        $this->status_id = $status_id;
    }

    /**
     * @return string|null
     */
    public function getProductName(): ?string
    {
        return $this->product_name;
    }

    /**
     * @param string|null $product_name
     */
    public function setProductName(?string $product_name): void
    {
        $this->product_name = $product_name;
    }

    /**
     * @return string|null
     */
    public function getProductCategoryName(): ?string
    {
        return $this->product_category_name;
    }

    /**
     * @param string|null $product_category_name
     */
    public function setProductCategoryName(?string $product_category_name): void
    {
        $this->product_category_name = $product_category_name;
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
     * @return int|null
     */
    public function getPipelineId(): ?int
    {
        return $this->pipeline_id;
    }

    /**
     * @param int|null $pipeline_id
     */
    public function setPipelineId(?int $pipeline_id): void
    {
        $this->pipeline_id = $pipeline_id;
    }

    /**
     * @return string|null
     */
    public function getGoogleClientId(): ?string
    {
        return $this->google_client_id;
    }

    /**
     * @param string|null $google_client_id
     */
    public function setGoogleClientId(?string $google_client_id): void
    {
        $this->google_client_id = $google_client_id;
    }

    /**
     * @return string|null
     */
    public function getFacebookClientId(): ?string
    {
        return $this->facebook_client_id;
    }

    /**
     * @param string|null $facebook_client_id
     */
    public function setFacebookClientId(?string $facebook_client_id): void
    {
        $this->facebook_client_id = $facebook_client_id;
    }

    /**
     * @return bool
     */
    public function isIsGaCidGenerated(): bool
    {
        return $this->is_ga_cid_generated;
    }

    /**
     * @param bool $is_ga_cid_generated
     */
    public function setIsGaCidGenerated(bool $is_ga_cid_generated): void
    {
        $this->is_ga_cid_generated = $is_ga_cid_generated;
    }

    /**
     * @return int|null
     */
    public function getLeadId(): ?int
    {
        return $this->lead_id;
    }

    /**
     * @param int|null $lead_id
     */
    public function setLeadId(?int $lead_id): void
    {
        $this->lead_id = $lead_id;
    }



}
