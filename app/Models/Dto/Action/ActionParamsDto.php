<?php


namespace App\Models\Dto\Action;

class ActionParamsDto
{
    public string $name = '';
    public ?AmoActionDto $amocrm_action = null;
    public ?SalebotActionDto $salebot_action = null;

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'amo_action' => $this->getAmocrmAction()->toArray(),
            'salebot_action' => $this->getSalebotAction()->toArray()
        ];
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
     * @return AmoActionDto|null
     */
    public function getAmocrmAction(): ?AmoActionDto
    {
        return $this->amocrm_action;
    }

    /**
     * @param AmoActionDto|null $amocrm_action
     */
    public function setAmocrmAction(?AmoActionDto $amocrm_action): void
    {
        $this->amocrm_action = $amocrm_action;
    }

    /**
     * @return SalebotActionDto|null
     */
    public function getSalebotAction(): ?SalebotActionDto
    {
        return $this->salebot_action;
    }

    /**
     * @param SalebotActionDto|null $salebot_action
     */
    public function setSalebotAction(?SalebotActionDto $salebot_action): void
    {
        $this->salebot_action = $salebot_action;
    }




}
