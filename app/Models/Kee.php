<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class Kee extends Model implements HasMedia
{
  use HasFactory;
  use SoftDeletes;
  use InteractsWithMedia;

  protected $fillable = [
    'title',
    'firstname',
    'lastname',
    'email',
    'office_name',
    'country_id',
    'city',
    'avatar',
    'h1_link',
    'specialism',
  ];


  public function engagements(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    // Get the records of each kee that is attached to an engagement
    $related = $this->hasMany(Engagement::class);
    $related->setQuery(
      Kee::whereIn('id', $this->kee_id)->getQuery()
    )->withTimestamp();
  }

  public function ranks(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(Rank::class);
  }

  public function publications(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(Publication::class);
  }

  public function users(): \Illuminate\Database\Eloquent\Relations\BelongsTo
  {
    return $this->belongsTo(User::class);
  }

}
