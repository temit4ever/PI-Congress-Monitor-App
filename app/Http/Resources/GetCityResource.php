<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GetCityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      return [
        'id' => (int) $this->id,
        'country_id' => (int) $this->country_id,
        'name' => $this->name,
        ];
        return parent::toArray($request);
    }
}
