<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('roles_permissions', function (Blueprint $table) {
        $table->integer('role_id')->unsigned();
        $table->integer('permission_id')->unsigned();
        $table->timestamps();
      });

      Schema::table('roles_permissions', function ( Blueprint $table) {
        $table->foreign('role_id')
          ->references('id')
          ->on('roles')
          ->onDelete('cascade');

        $table->foreign('permission_id')
          ->references('id')
          ->on('permissions')
          ->onDelete('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_permissions');
    }
}
