<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('publications', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('kee_id')->unsigned()->index()->nullable();
        $table->string('name');
        $table->string('status');
        $table->longText('description')->nullable();
        $table->string('url_link')->nullable();
        $table->softDeletes();
        $table->timestamps();
      });
      Schema::table('publications', function ( Blueprint $table) {
        $table->foreign('kee_id')
          ->constrained()
          ->references('id')
          ->on('kees')
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
        Schema::dropIfExists('publications');
    }
}
