<?php

namespace App\Exports;

use App\Models\Staff;
use Maatwebsite\Excel\Concerns\FromCollection;

class StaffExport implements FromCollection
{
    public function collection()
    {
        return Staff::all();
    }
}