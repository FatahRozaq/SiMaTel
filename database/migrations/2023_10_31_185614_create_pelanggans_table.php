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
        Schema::create('Pelanggan', function (Blueprint $table) {
            $table->id('idPelanggan');
            $table->string('namaPelanggan');
            $table->string('alamat');
            $table->string('noTelepon');
            $table->string('email')->unique();
            $table->string('noIdentifikasi')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Pelanggan');
    }
};
