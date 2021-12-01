<?php

use App\Models\Congress;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCongressesToTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('table', function (Blueprint $table) {
          Congress::all();
          $current_congresses = [
            'AATSa 21',
            'ASCO 21',
            'ELCC 21',
            'ESMO 21',
            'ESMO Asia 21',
            'ESTS 21',
            'WCLC 21',
            'AATS 22',
            'ASCO 22',
            'ELCC 22',
            'ESMO 22',
            'ESMO Asia 22',
            'ESTS 22',
            'WCLC 22',
            'WCLC 20',
          ];
          foreach ($current_congresses as $congress)
            Congress::create([
              'name' => $congress,
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('table', function (Blueprint $table) {
            //
        });
    }
}
