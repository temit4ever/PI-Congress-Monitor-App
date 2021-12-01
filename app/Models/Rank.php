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
      'fluara',
      'mykonos',
      'elios',
      'savannah',
      'orchard',
      'flaura-2',
      'compel',
      'adaura',
      'neo_adaura',
      'st1_adaura',
      'target',
      'laura',
      'kee_id'
    ];

  public function kees(){
    return $this->hasMany(Kee::class, 'id');
  }
}

