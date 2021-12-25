<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AskAvailableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'            => $this->id,
            'user_id'       => $this->user_id,
            'property_id'   => $this->property_id,
            'is_available'  => $this->is_available,
            'start_period'  => $this->start_period,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
        ];
    }
}
