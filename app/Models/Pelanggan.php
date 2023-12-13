<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pelanggan extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $primaryKey = 'idPelanggan';
    protected $fillable = [
        'namaPelanggan',
        'alamat',
        'noTelepon',
        'email',
        'noIdentifikasi',
        'idUser'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $table = 'Pelanggan';
}
