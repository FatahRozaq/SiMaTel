<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KamarHotel extends Model
{
    use HasFactory;

    protected $table = 'KamarHotel';
    protected $primaryKey = 'idKamar';

    protected $fillable = [
        'tipeKamar',
        'hargaPerMalam',
        'kapasitas',
        'status',
    ];

    public function reservasi()
    {
        return $this->hasMany(Reservasi::class, 'idKamar');
    }

}
