<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publication extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
      'name',
      'status',
      'description',
      'url_link',
      'kee_id',
      ];

    public function kees(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
      return $this->belongsTo(Kee::class);
    }

}
