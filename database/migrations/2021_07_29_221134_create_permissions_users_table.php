<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('permissions_users', function (Blueprint $table) {
        $table->integer('user_id')->unsigned();
        $table->integer('permission_id')->unsigned();
        $table->timestamps();
      });

      Schema::table('permissions_users', function ( Blueprint $table) {
        $table->foreign('user_id')
          ->references('id')
          ->on('users')
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
        Schema::dropIfExists('permission_users');
    }
}
