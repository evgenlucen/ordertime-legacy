<?php


namespace App\Models\Dto\Action;

class AmoActionDto implements ActionInterface
{
    public ?int $status_id = null;
    public ?int $pipeline_id = null;
    public ?array $cf_data = [];
    public ?array $tags = [];
    public ?string $service_message = '';
    public ?int $responsible_user_id = null;

    public function toArray(): array
    {
        $result = [];
        if(!empty($this->status_id)){
            $result['status_id'] = $this->status_id;
        }
        if(!empty($this->pipeline_id)){
            $result['pipeline_id'] = $this->pipeline_id;
        }
        if(!empty($this->status_id)){
            $result['status_id'] = $this->status_id;
        }
        if(!empty($this->cf_id)){
            $result['cf_id'] = $this->cf_id;
        }
        if(!empty($this->tags)){
            $result['tags'] = $this->tags;
        }
        if(!empty($this->service_message)){
            $result['service_message'] = $this->service_message;
        }
        if(!empty($this->responsible_user_id)){
            $result['responsible_user_id'] = $this->responsible_user_id;
        }


        return $result;
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
     * @return array|null
     */
    public function getTags(): ?array
    {
        return $this->tags;
    }

    /**
     * @param array|null $tags
     */
    public function setTags(?array $tags): void
    {
        $this->tags = $tags;
    }

    public function appendTag(string $tag): void
    {
        $this->tags[] = $tag;
    }

    /**
     * @return string|null
     */
    public function getServiceMessage(): ?string
    {
        return $this->service_message;
    }

    /**
     * @param string|null $service_message
     */
    public function setServiceMessage(?string $service_message): void
    {
        $this->service_message = $service_message;
    }

    /**
     * @return int|null
     */
    public function getResponsibleUserId(): ?int
    {
        return $this->responsible_user_id;
    }

    /**
     * @param int|null $responsible_user_id
     */
    public function setResponsibleUserId(?int $responsible_user_id): void
    {
        $this->responsible_user_id = $responsible_user_id;
    }

    /**
     * @return array|null
     */
    public function getCfData(): ?array
    {
        return $this->cf_data;
    }

    /**
     * @param array|null $cf_data
     */
    public function setCfData(?array $cf_data): void
    {
        $this->cf_data = $cf_data;
    }


}
