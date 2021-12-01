<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEngagementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('engagements', function (Blueprint $table) {
        $table->increments('id');
        $table->jsonb('kee_id');
        $table->string('platform')->nullable();
        $table->string('name');
        $table->string('type');
        $table->string('house_number')->nullable();
        $table->string('address_1', 150)->nullable();
        $table->string('address_2', 150)->nullable();
        $table->string('city')->nullable();
        $table->string('post_code')->nullable();
        $table->string('county_state')->nullable();
        $table->string('country_id')->nullable();
        $table->string('congress');
        $table->longText('description')->nullable();
        $table->string('calendar_date');
        $table->jsonb('start_time');
        $table->jsonb('end_time');
        $table->string('data_set')->nullable();
        $table->string('digital_link')->nullable();

        $table->softDeletes();
        $table->timestamps();
      });
      /*Schema::table('engagements', function ( Blueprint $table) {
        $table->foreign('kee_id')
          ->constrained()
          ->references('id')
          ->on('kees')
          ->onDelete('cascade');
      });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('engagements');
    }
}
