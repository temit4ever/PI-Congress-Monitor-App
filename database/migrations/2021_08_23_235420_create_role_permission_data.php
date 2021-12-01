<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolePermissionData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // Create default permissions
      Permission::create(['name' => 'Manage Admin']);
      Permission::create(['name' => 'Manage Activities']);
      Permission::create(['name' => 'View Items']);

      // Create default roles
      $super_admin = Role::create(['name' => 'Super Admin', 'slug' => 'super-admin']);
      $admin = Role::create(['name' => 'Admin', 'slug' => 'admin']);
      $member = Role::create(['name' => 'Member', 'slug' => 'member']);

      // Assigned permissions to role
      $super_admin->permissions()->sync([1,2,3]);
      $admin->permissions()->sync([2,3]);
      $member->permissions()->sync([3]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_permission_data');
    }
}
