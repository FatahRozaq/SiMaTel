<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Reservasi', function (Blueprint $table) {
            $table->id('idReservasi');
            $table->unsignedBigInteger('idKamar');
            $table->unsignedBigInteger('idPelanggan');
            $table->date('tanggalCheckIn');
            $table->date('tanggalCheckOut');
            $table->integer('jumlahTamu');
            $table->double('totalBiaya', 8, 2);
            $table->string('status');
            $table->string('metodePembayaran');
            $table->timestamps();

            $table->foreign('idKamar')->references('idKamar')->on('KamarHotel');
            $table->foreign('idPelanggan')->references('idPelanggan')->on('Pelanggan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservasis');
    }
};
