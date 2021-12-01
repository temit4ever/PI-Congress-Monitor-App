<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KeeResource extends JsonResource
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
        'user_id' => (int) $this->user_id,
        'specialism' => $this->specialism,
        'title' => $this->title,
        'firstname' => $this->firstname,
        'lastname' => $this->lastname,
        'email' => $this->email,
        'place_of_work' => $this->place_of_work,
        'city' => $this->city,
        'country_id' => $this->country,
        'avatar' => $this->kee_photo_path,
        'created_at' => $this->created_at,
        'updated_at' => $this->updated_at,
        'h1_link' => $this->hi_link,
      ];
        return parent::toArray($request);
    }
}
