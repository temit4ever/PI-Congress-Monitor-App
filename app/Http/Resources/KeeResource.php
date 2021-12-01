<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

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
      //dd($this);
      return [
        'id' => (int) $this->id,
        'user_id' => (int) $this->user_id,
        'specialism' => $this->specialism,
        'title' => $this->title,
        'firstname' => $this->firstname,
        'lastname' => $this->lastname,
        'email' => $this->email,
        'affiliate' => $this->affiliate,
        'city' => $this->city,
        'country_id' => $this->country_id,
        'country' => $this->country,
        'avatar' => $this->kee_photo_path,
        'created_at' => $this->created_at,
        'updated_at' => $this->updated_at,
        'h1_link' => $this->hi_link,
        'kee_photo_path' => $this->avatar,
        'current_page'=> $this->current_page,
      ];
        return parent::toArray($request);
    }
}
