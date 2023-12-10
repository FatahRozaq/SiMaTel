<?php

namespace App\Imports;

use App\Models\Staff;
use Maatwebsite\Excel\Concerns\ToModel;

class StaffImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Staff([
            'namaStaff' => $row[1],
            'alamat' => $row[2], 
            'noTelepon' => $row[3], 
            'email' => $row[4], 
            'jabatan' => $row[5], 
        ]);
    }
}
