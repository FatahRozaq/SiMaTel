<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'Transaksi';
    protected $primaryKey = 'idTransaksi';

    protected $fillable = [
        'idReservasi',
        'tanggalPembayaran',
        'jumlahPembayaran',
        'metodePembayaran',
        'status'
    ];
}
