<?php

namespace App\Imports;

use App\Models\Kee;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;

class KeesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return Model|null
    */
    public function model(array $row)
    {
        return new Kee([
          'user_id' => $row[0],
          'title' => $row[1],
          'firstname' => $row[2],
          'lastname' => $row[3],
          //'email' => $row[4],
          'specialism' => $row[4],
          'place_of_work' => $row[5],
          'city' => $row[6],
          'country' => $row[7],
          'h1_link' => $row[8]
        ]);
    }
}
