<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kees', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('user_id')->unsigned()->index()->nullable();
          $table->string('title')->nullable();
          $table->string('specialism')->nullable();
          $table->string('firstname')->nullable();
          $table->string('lastname')->nullable();
          $table->string('email')->nullable();
          $table->string('office_name')->nullable();
          $table->string('country_id')->nullable();
          $table->string('city')->nullable();
          $table->string('h1_link')->nullable();
          $table->string('kee_photo_path', 1024)->nullable();
          $table->softDeletes();
          $table->timestamps();
        });
      Schema::table('kees', function ( Blueprint $table) {
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
        Schema::dropIfExists('kees');
    }
}
