<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeeRankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('kee_rank', function (Blueprint $table) {
        $table->integer('kee_id')->unsigned();
        $table->integer('rank_id')->unsigned();
        $table->softDeletes();
        $table->timestamps();
      });

      Schema::table('kee_rank', function (Blueprint $table) {
        $table->foreign('kee_id')
          ->constrained()
          ->references('id')
          ->on('kees')
          ->onDelete('cascade');

        $table->foreign('rank_id')
          ->constrained()
          ->references('id')
          ->on('ranks')
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
        Schema::dropIfExists('kee_rank');
    }
}
