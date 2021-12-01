<?php

namespace Database\Seeders;

use App\Models\Kee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use WisdomDiala\Countrypkg\Models\Country;

class GenerateKeeCountryCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $kees = Kee::where('country_id', null)->get();
      $countries = Country::all()->toArray();
      foreach ($kees as $kee) {
        foreach ($countries as $key => $country) {
          if ($kee->country == $country['name']) {
            DB::table('kees')
              ->where('country', $country['name'])
              ->update(['country_id' => $countries[$key]['id']]);
          }
        }
      }
    }
}
