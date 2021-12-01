<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Engagement extends Model
{
    use HasFactory;
    use SoftDeletes;

  protected $hidden = ['deleted_at', 'pivot'];
  protected $fillable = [
    'platform',
    'kee_id',
    'name',
    'type',
    'house_number',
    'city',
    'address_1',
    'address_2',
    'post_code',
    'county_state',
    'congress_link',
    'description',
    'calendar_date',
    'start_time',
    'end_time',
    'data_set',
    'digital_link',
  ];

  public function kees(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->BelongsToMany(Kee::class)
      ->withTimestamps();
  }

  public function assignKee($kee_ids) {
    $this->kees()->attach($kee_ids);
  }

}

