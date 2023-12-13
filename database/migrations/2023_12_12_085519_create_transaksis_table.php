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
        Schema::create('Transaksi', function (Blueprint $table) {
            $table->id('idTransaksi');
            $table->unsignedBigInteger('idReservasi');
            $table->date('tanggalPembayaran');
            $table->double('jumlahPembayaran', 8, 2);
            $table->string('metodePembayaran');
            $table->string('status');
            $table->timestamps();

            $table->foreign('idReservasi')->references('idReservasi')->on('Reservasi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Transaksi');
    }
};
