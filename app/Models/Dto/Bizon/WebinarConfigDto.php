<?php


namespace App\Models\Dto\Bizon;


class WebinarConfigDto
{

    /** @var string */
    public string $webinar_name = '';
    /** @var int|null начало продающей части в процентах*/
    public ?int $sales_part_by_percent = null;
    /** @var int|null начало продающей части в минутах*/
    public ?int $sales_part_by_minutes = null;
    /** @var int|null в минутах
     * минимальная длительность присутствия на контентной части, чтобы засчитать просмотр контентной части */
    public ?int $content_part_duration_min = null;
    /** @var int|null в минутах
     * минимальная длительность присутствия на продающей части, чтобы засчитать просмотр продающей */
    public ?int $sales_part_duration_min = null;
    /** @var int в минутах
     * минимальное длительность присутствия на вебинаре, чтобы засчитать событие "был на вебинаре" */
    public int $visit_webinar_duration_min = 20;

    /**
     * @return int|null
     */
    public function getContentPartDurationMin(): ?int
    {
        return $this->content_part_duration_min;
    }

    /**
     * @param int|null $content_part_duration_min
     */
    public function setContentPartDurationMin(?int $content_part_duration_min): void
    {
        $this->content_part_duration_min = $content_part_duration_min;
    }

    /**
     * @return int|null
     */
    public function getSalesPartDurationMin(): ?int
    {
        return $this->sales_part_duration_min;
    }

    /**
     * @param int|null $sales_part_duration_min
     */
    public function setSalesPartDurationMin(?int $sales_part_duration_min): void
    {
        $this->sales_part_duration_min = $sales_part_duration_min;
    }

    /**
     * @return int
     */
    public function getVisitWebinarDurationMin(): int
    {
        return $this->visit_webinar_duration_min;
    }

    /**
     * @param int $visit_webinar_duration_min
     */
    public function setVisitWebinarDurationMin(int $visit_webinar_duration_min): void
    {
        $this->visit_webinar_duration_min = $visit_webinar_duration_min;
    }


    /**
     * @return string
     */
    public function getWebinarName(): string
    {
        return $this->webinar_name;
    }

    /**
     * @param string $webinar_name
     */
    public function setWebinarName(string $webinar_name): void
    {
        $this->webinar_name = $webinar_name;
    }



    /**
     * @return int|null
     */
    public function getSalesPartByPercent(): ?int
    {
        return $this->sales_part_by_percent;
    }

    /**
     * @param int|null $sales_part_by_percent
     */
    public function setSalesPartByPercent(?int $sales_part_by_percent): void
    {
        $this->sales_part_by_percent = $sales_part_by_percent;
    }

    /**
     * @return int|null
     */
    public function getSalesPartByMinutes(): ?int
    {
        return $this->sales_part_by_minutes;
    }

    /**
     * @param int|null $sales_part_by_minutes
     */
    public function setSalesPartByMinutes(?int $sales_part_by_minutes): void
    {
        $this->sales_part_by_minutes = $sales_part_by_minutes;
    }


}