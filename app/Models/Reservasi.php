<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    protected $table = 'Reservasi';
    protected $primaryKey = 'idReservasi';

    protected $fillable = [
        'idKamar',
        'idPelanggan',
        'tanggalCheckIn',
        'tanggalCheckOut',
        'jumlahTamu',
        'totalBiaya',
        'status',
        'metodePembayaran'
    ];

    public function kamarHotel()
    {
        return $this->belongsTo(KamarHotel::class, 'idKamar');
    }
}
