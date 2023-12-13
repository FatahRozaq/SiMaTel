<?php

namespace App\Exports;

use App\Models\FasilitasHotel;
use Maatwebsite\Excel\Concerns\FromCollection;

class FasilitasHotelExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return FasilitasHotel::all();
    }
}
