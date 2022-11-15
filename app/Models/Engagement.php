<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Engagement extends Model
{
    use HasFactory;
    use SoftDeletes;

  protected $hidden = ['deleted_at', 'pivot'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i:s',
        'updated_at' => 'datetime:Y-m-d h:i:s',
        'deleted_at' => 'datetime:Y-m-d h:i:s',
        'calendar_date' => 'datetime:Y-m-d'
    ];
  protected $fillable = [
    'platform',
    'kee_id',
    'name',
    'type',
    'house_number',
    'city',
    'country_id',
    'address_1',
    'address_2',
    'post_code',
    'county_state',
    'congress',
    'description',
    'calendar_date',
    'start_time',
    'end_time',
    'data_set',
    'digital_link',
  ];
  protected $appends = ['engagement_month'];

  public function kees(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany(Kee::class);
  }

  public function assignKee($kee_ids) {
    $this->kees()->attach($kee_ids);
  }

  public function getEngagementMonthAttribute(){
    return Carbon::parse($this->calendar_date)->format('F');
  }

  public function ranks(): \Illuminate\Database\Eloquent\Relations\HasOne
  {
    return $this->hasOne(Rank::class);
  }
}

