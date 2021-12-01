<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PublicationResource extends JsonResource
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
        'kee_id' => (int) $this->kee_id,
        'name' => $this->name,
        'status' => $this->status,
        'description' => $this->description,
        'url_link' => $this->url_link,
      ];

        return parent::toArray($request);
    }
}
