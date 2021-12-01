<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ranks', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('kee_id')->unsigned()->index()->nullable();
          $table->integer('engagement_id')->unsigned()->index()->nullable();
          $table->string('understanding_data')->default(0);
          $table->string('commitment')->default(0);
          $table->string('performance_delivery')->default(0);
          $table->string('rank')->default('D');
          $table->string('overall_rank_mark')->nullable();
          $table->string('overall_rank_status')->nullable();
          $table->string('attendance')->nullable();
          $table->string('performance_status')->nullable();
          $table->string('understanding_data_status')->nullable();
          $table->string('commitment_status')->nullable();
          $table->string('flaura')->nullable();
          $table->string('mykonos')->nullable();
          $table->string('elios')->nullable();
          $table->string('savannah')->nullable();
          $table->string( 'orchard')->nullable();
          $table->string( 'flaura_2')->nullable();
          $table->string( 'compel')->nullable();
          $table->string('adaura')->nullable();
          $table->string('neo_adaura')->nullable();
          $table->string( 'st1_adaura')->nullable();
          $table->string(  'target')->nullable();
          $table->string(  'laura')->nullable();
          $table->string(  'is_evaluated')->nullable();
          $table->softDeletes();
          $table->timestamps();
        });
      Schema::table('ranks', function ( Blueprint $table) {
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
        Schema::dropIfExists('ranks');
    }
}
