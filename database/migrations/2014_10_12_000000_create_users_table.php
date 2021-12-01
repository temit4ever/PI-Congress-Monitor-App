<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
          $table->increments('id');
          $table->string('title')->nullable();
          $table->string('firstname');
          $table->string('lastname');
          $table->string('email')->nullable();
          $table->string('status')->nullable();
          $table->integer('role_id')->unsigned()->index()->nullable();
          $table->timestamp('email_verified_at')->nullable();
          $table->string('password');
          $table->rememberToken();
          $table->foreignId('current_team_id')->nullable();
          $table->string('profile_photo_path', 2048)->default('placeholder-profile.jpg');
          $table->softDeletes();
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
