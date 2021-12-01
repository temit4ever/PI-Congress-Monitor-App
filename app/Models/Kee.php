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
    'user_id',
    'title',
    'firstname',
    'lastname',
    'email',
    'place_of_work',
    'country',
    'city',
    'kee_photo_path',
    'h1_link',
    'specialism',
    'country_id',
  ];


  public function engagements(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany(Engagement::class);
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

  // this is the recommended way for declaring event handlers
  public static function boot() {
    parent::boot();
    self::deleting(function($kee) { // before delete() method call this
      $kee->ranks()->each(function($rank) {
        $rank->delete(); // <-- direct deletion
      });
    });
    }

}
