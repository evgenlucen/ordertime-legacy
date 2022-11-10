<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class WebinarResourse extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->_id,
            'webinarId' => $this->resource->webinarId,
            'name' => $this->resource->name,
            'type' => $this->resource->type,
            'nerrors' => $this->resource->nerrors,
            'count1' => $this->resource->count1,
            'count2' => $this->resource->count2,
            'send_to_amo' => $this->resource->send_to_amo,
            'time_start' => Carbon::createFromTimestamp($this->resource->time_start)->format('d-m-Y H:i'),
            'time_end' => Carbon::createFromTimestamp($this->resource->time_end)->format('d-m-Y H:i'),
        ];
    }
}
