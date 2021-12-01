<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Rank extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
      'understanding_data',
      'commitment',
      'performance_delivery',
      'clinical_trial',
      'attendance',
      'rank',
      'flaura',
      'mykonos',
      'elios',
      'savannah',
      'orchard',
      'flaura-2',
      'compel',
      'adaura',
      'neo_adaura',
      'st1_adaura',
      'flauraStudy',
      'investigator_in_study',
      'target',
      'laura',
      'kee_id',
      'engagement_id',
      'is_evaluated',
    ];

  public function kees(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany(Kee::class) ;
  }

  public function assignKeeToRank($kee_id) {
    $this->kees()->attach($kee_id);
  }

  public function engagements(): \Illuminate\Database\Eloquent\Relations\BelongsTo
  {
    return $this->belongsTo(Engagement::class);
  }
}

