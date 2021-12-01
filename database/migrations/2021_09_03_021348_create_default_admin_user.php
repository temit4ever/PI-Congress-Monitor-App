<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefaultAdminUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // Create Leica Super admin credential
      $user = User::create([
        'title' => 'Mr.',
        'firstname' => 'Leica',
        'lastname' => 'Super-admin',
        'email' => 'leica-superadmin@cygnus.co.uk',
        'password' => bcrypt('w5ROIyY80Z_ICMqr'),
      ]);

      $user->status = 'super-admin';
      $user->role_id = 1;
      $user->save();
      $user->profile_photo_path = 'placeholder-profile.jpg';
      $role = Role::find(1);
      $user->assignRole($role);
      $user->save();

      // Create Cygnus Super admin credential
      $user = User::create([
        'title' => 'Mr.',
        'firstname' => 'Cygnus-Super',
        'lastname' => 'SuperAdmin',
        'email' => 'super-admin@cygnus.co.uk',
        'password' => bcrypt('uB[ptDkz0c8_.!ZL'),
      ]);

      $user->status = 'super-admin';
      $user->role_id = 1;
      $user->save();
      $user->profile_photo_path = 'placeholder-profile.jpg';
      $role_id = Role::find(1);
      $user->assignRole($role_id);
      $user->save();

      // Create Cygnus Admin credential
      $user = User::create([
        'title' => 'Mr.',
        'firstname' => 'Cygnus-Admin',
        'lastname' => 'Admin',
        'email' => 'admin@cygnus.co.uk',
        'password' => bcrypt('vLbeN2HptpcW-joz'),
      ]);

      $user->status = 'admin';
      $user->role_id = 2;
      $user->save();
      $user->profile_photo_path = 'placeholder-profile.jpg';
      $role = Role::find(2);
      $user->assignRole($role);
      $user->save();


      // Create Cygnus Member credential
      $user = User::create([
        'title' => 'Mr',
        'firstname' => 'Cygnus-Member',
        'lastname' => 'Member',
        'email' => 'member@cygnus.co.uk',
        'password' => bcrypt('G]QUKtaIxc8mi97)'),
      ]);

      $user->status = 'member';
      $user->role_id = 3;
      $user->save();
      $user->profile_photo_path = 'placeholder-profile.jpg';
      $role = Role::find(3);
      $user->assignRole($role);
      $user->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('default_admin_user');
    }
}
