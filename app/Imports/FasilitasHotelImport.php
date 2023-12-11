<?php

namespace App\Imports;

use App\Models\FasilitasHotel;
use Maatwebsite\Excel\Concerns\ToModel;

class FasilitasHotelImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new FasilitasHotel([
            'namaFasilitas' => $row[1],
            'deskripsi' => $row[2],
            'jumlahTamu' => $row[3],
            'status' => $row[4],
        ]);
    }
}
