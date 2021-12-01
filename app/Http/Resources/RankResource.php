<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RankResource extends JsonResource
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
        'id' => $this->id,
        'kee_id' => (int) $this->kee_id,
        'understanding_data' => $this->understanding_data,
        'commitment' => $this->commitment,
        'performance_delivery' => $this->performance_delivery,
        'attendance' => $this->attendance,
        'rank' => $this->rank,
        'fluara' => $this->fluara,
        'fluara_2' => $this->fluara_2,
        'mykonos' => $this->mykonos,
        'elios' => $this->elios,
        'savannah' => $this->savannah,
        'orchard' => $this->orchard,
        'compel' => $this->compel,
        'adaura' => $this->adaura,
        'neo_adaura' => $this->neo_adaura,
        'st1_adaura' => $this->st1_adaura,
        'target' => $this->target,
        'laura' => $this->laura,
        'created_at' => $this->created_at, //->timestamp,
        'updated_at' => $this->updated_at,
      ];
        return parent::toArray($request);
    }
}
