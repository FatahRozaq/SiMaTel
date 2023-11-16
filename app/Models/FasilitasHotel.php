<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FasilitasHotel extends Model
{
    use HasFactory;

    protected $table = 'FasilitasHotel';
    protected $primaryKey = 'idFasilitas';

    protected $fillable = [
        'namaFasilitas',
        'status',
        'jumlahTamu',
        'deskripsi',
    ];
}
