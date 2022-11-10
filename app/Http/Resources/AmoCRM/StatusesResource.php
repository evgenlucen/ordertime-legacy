<?php

namespace App\Http\Resources\AmoCRM;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StatusesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
           'priority' => $this->resource->id,
           'status_id' => $this->resource->status_id,
           'name' => $this->resource->name,
           'pipeline_id' => $this->resource->pipeline_id,
           'pipeline_name' => $this->resource->pipeline->name,
           'color' => $this->resource->color
        ];
    }
}
