<?php

namespace Database\Seeders;

use App\Models\Kee;
use App\Models\Rank;
use Illuminate\Database\Seeder;

class CreateKeeRankingDefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $kees = Kee::all()->toArray();
      foreach ($kees as $kee) {
        $rank = Rank::create([
          'kee_id' => $kee['id'],
          'engagement_id' => null,
          'understanding_data' => 0,
          'attendance'=> 'Default',
          'commitment' => 50,
          'performance_delivery' => 0,
          'rank' => 'D',
          'overall_rank_mark' => 0,
          'overall_rank_status' => 'Foundation',
          'performance_status' => 'Foundation',
          'understanding_data_status' => 'Foundation',
          'commitment_status' => 'Medium',
          'flaura' => 0,
          'mykonos' => 0,
          'elios' => 0,
          'savannah' => 0,
          'orchard' => 0,
          'flaura_2' => 0,
          'compel' => 0,
          'adaura' => 0,
          'neo_adaura' => 0,
          'st1_adaura' => 0,
          'target' => 0,
          'laura' => 0,
        ]);
        $rank->assignKeeToRank($kee['id']);
        $rank->save();
      }
    }
}
