<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // When ready for deploying uncomment code and use this to create one time super admin credential.
      $user = User::create([
        'title' => 'Dr.',
        'firstname' => 'Super',
        'lastname' => 'Admin',
        'email' => 'super-admin@cygnus.co.uk',
        'password' => bcrypt('uB[ptDkz0c8_.!ZL'),
      ]);

      $user->status = 'super-admin';
      $user->role_id = 1;
      $user->save();
      $role = Role::where('name', 'Super Admin')->pluck('id');
      $user->assignRole($role);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_user');
    }
}
