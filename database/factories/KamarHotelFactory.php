<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\KamarHotel;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KamarHotel>
 */
class KamarHotelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $tipeKamar = ['Standard', 'Suite', 'Deluxe'];
        $status = ['Tersedia', 'Terisi', 'Perbaikan'];
        
        $tipeKamarRand = $this->faker->randomElement($tipeKamar);
        $statusRand = $this->faker->randomElement($status);

        $data = [
            'tipeKamar' => $tipeKamarRand,
            'status' => $statusRand,
        ];
        
        if ($tipeKamarRand == 'Standard') {
            $data['hargaPerMalam'] = '100000';
            $data['kapasitas'] = '2';
        } else if ($tipeKamarRand == 'Suite') {
            $data['hargaPerMalam'] = '150000';
            $data['kapasitas'] = '4';
        }  else {
            $data['hargaPerMalam'] = '200000';
            $data['kapasitas'] = '6';
        }

        return $data;
    }
}
