<?php

namespace App\Exports;

use App\Models\KamarHotel;
use Maatwebsite\Excel\Concerns\FromCollection;

class KamarHotelExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return KamarHotel::all();
    }
}
