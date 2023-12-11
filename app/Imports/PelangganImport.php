<?php

namespace App\Imports;

use App\Models\Pelanggan;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class PelangganImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Pelanggan([
            'namaPelanggan' => $row[1],
            'alamat' => $row[2],
            'noTelepon' => $row[3],
            'email' => $row[4],
            'noIdentifikasi' => $row[5],
        ]);
    }
}
