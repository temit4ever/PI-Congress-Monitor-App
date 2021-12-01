<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // Create Super admin credential
      $user = User::create([
        'title' => 'Mr.',
        'firstname' => 'Cygnus',
        'lastname' => 'Super-admin',
        'email' => 'superadmin@cygnus.co.uk',
        'password' => bcrypt('uB[ptDkz0c8_.!ZL90'),
      ]);

      $user->status = 'super-admin';
      $user->role_id = 1;
      $user->save();
      $role = Role::where('name', 'Super Admin')->pluck('id')->toArray();
      $user->assignRole($role);

      // Create Admin credential
      $user = User::create([
        'title' => 'Dr.',
        'firstname' => 'Admin',
        'lastname' => 'Admin',
        'email' => 'admin@cygnus.co.uk',
        'password' => bcrypt('uB[ptDkz0c8_.!ZL'),
      ]);

      $user->status = 'admin';
      $user->role_id = 2;
      $user->save();
      $role = Role::where('name', 'Admin')->pluck('id');
      $user->assignRole($role);

      // Create Member credential
      $user = User::create([
        'title' => 'Dr.',
        'firstname' => 'Member',
        'lastname' => 'Admin',
        'email' => 'member@cygnus.co.uk',
        'password' => bcrypt('olipr12345'),
      ]);

      $user->status = 'member';
      $user->role_id = 3;
      $user->save();
      $role = Role::where('name', 'Member')->pluck('id');
      $user->assignRole($role);

      // Create Super admin credential
      $user = User::create([
        'title' => 'Prof.',
        'firstname' => 'Mark',
        'lastname' => 'Tomas',
        'email' => 'mark@cygnus.co.uk',
        'password' => bcrypt('12345lopuum'),
      ]);

      $user->status = 'super-admin';
      $user->role_id = 1;
      $user->save();
      $role = Role::where('name', 'Super Admin')->pluck('id');
      $user->assignRole($role);

      // Create Admin credential
      $user = User::create([
        'title' => 'Miss.',
        'firstname' => 'Seal',
        'lastname' => 'Velo',
        'email' => 'velo@cygnus.co.uk',
        'password' => bcrypt('admin12345'),
      ]);

      $user->status = 'admin';
      $user->role_id = 2;
      $user->save();
      $role = Role::where('name', 'Admin')->pluck('id');
      $user->assignRole($role);

      // Create Member credential
      $user = User::create([
        'title' => 'Mrs.',
        'firstname' => 'Bella',
        'lastname' => 'Minns',
        'email' => 'minns@cygnus.co.uk',
        'password' => bcrypt('oli879pr12345'),
      ]);

      $user->status = 'member';
      $user->role_id = 3;
      $user->save();
      $role = Role::where('name', 'Member')->pluck('id');
      $user->assignRole($role);

// Get user with specific role
      /*$d = User::whereHas('Roles', function($query) {
        $query->where('name','Super Admin');
      })->get();*/
//dd($d);
    }
}
