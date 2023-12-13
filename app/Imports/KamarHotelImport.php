<?php

namespace App\Imports;

use App\Models\KamarHotel;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class KamarHotelImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new KamarHotel([
            'tipeKamar' => $row[1],
            'hargaPerMalam' => $row[2], 
            'kapasitas' => $row[3], 
            'status' => $row[4],
        ]);
    }
}
