<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EngagementResource extends JsonResource
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
        'kee_id' => $this->kee_id,
        'data_set' => $this->data_set,
        'platform' => $this->platform,
        'name' => $this->name,
        'type' => $this->type,
        'house_number' => $this->house_number,
        'address_1' => $this->address_1,
        'address_2' => $this->address_2,
        'city' => $this->city,
        'post_code' => $this->post_code,
        'county_state' => $this->country_state,
        'country' => $this->country,
        'congress_link' => $this->congress_link,
        'description' => $this->description,
        'calendar_date' => $this->calendar_date,
        'start_time' => $this->start_time,
        'end_time' => $this->end_time,
        'created_at' => $this->created_at, //->timestamp,
        'updated_at' => $this->updated_at,
        'kee' => $this->kees,
        //'h1_link' => $this->hi_link,

      ];
        return parent::toArray($request);
    }
}
