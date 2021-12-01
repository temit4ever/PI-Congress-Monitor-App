<?php


namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
      'title' => $this->title,
      'firstname' => $this->firstname,
      'lastname' => $this->lastname,
      'email' => $this->email,
      'status' => $this->status,
      'role_id' => $this->role_id,
      'roles'=> $this->roles,
      'profile_photo_path' => $this->profile_photo_path,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ];

    return parent::toArray($request);

  }
}
