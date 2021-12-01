<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CalendarResource extends JsonResource
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
        'data_set' => $this->data_set,
        'name' => $this->name,
        'city' => $this->city,
        'country' => $this->country,
        'calendar_date' => $this->calendar_date,
        'start_time' => $this->start_time,
        'end_time' => $this->end_time,
        'created_at' => $this->created_at, //->timestamp,
        'updated_at' => $this->updated_at,
      ];


    }
}
