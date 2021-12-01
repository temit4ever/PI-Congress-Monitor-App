<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('roles_users', function (Blueprint $table) {
        $table->integer('role_id')->unsigned();
        $table->integer('user_id')->unsigned();
        $table->timestamps();
      });

      Schema::table('roles_users', function ( Blueprint $table) {
        $table->foreign('role_id')
          ->constrained()
          ->references('id')
          ->on('roles')
          ->onDelete('cascade');

        $table->foreign('user_id')
          ->constrained()
          ->references('id')
          ->on('users')
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
        Schema::dropIfExists('role_users');
    }
}
