<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
  use HasApiTokens;
  use InteractsWithMedia;
  use HasFactory;
  use HasProfilePhoto;
  use Notifiable;
  use TwoFactorAuthenticatable;
  use SoftDeletes;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'title',
    'firstname',
    'lastname',
    'email',
    'password',
    'role_id',
    'profile_photo_path'
  ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

  public function roles()
  {
    return $this->belongsToMany(Role::class,'roles_users')->withTimestamps();
  }

  public function permissions(): BelongsToMany
  {
    return $this->belongsToMany(Permission::class,'permissions_users');
  }

  public function kees() {
    return $this->hasMany(Kee::class);
  }

  public function getRoleId()
  {
    return $this->roles()->pluck('id')->toArray();
  }

  public function getRoleName(): array
  {
    return $this->roles()->pluck('name')->toArray();
  }

  public function hasRole($role): bool
  {
    //dd($role);
    if ($this->whereIn('status', $role)) {
      return true;
    }
    return false;
  }

  public function assignRole($role) {
    $this->roles()->sync($role);
  }
}
