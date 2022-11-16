<?php

namespace App\Http\Controllers;

use WisdomDiala\Countrypkg\Models\Country;

class CountryController
{
    public function getCountries(): \Illuminate\Http\JsonResponse
    {
       return response()->json(Country::all());
    }


}