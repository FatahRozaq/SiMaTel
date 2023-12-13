<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\FasilitasHotel;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FasilitasHotel>
 */
class FasilitasHotelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $namaFasilitas = ['Gym', 'kolam renang', 'SPA', 'Taman', 'Restoran', 'Lobbi', 'Bar', 'Lapangan', 'Ballroom', 'Area Parkir', 'Toilet', 'Sauna'];
        $status = ['Buka', 'Penuh', 'Perbaikan'];
        
        $namaFasilitasRand = $this->faker->randomElement($namaFasilitas);
        $statusRand = $this->faker->randomElement($status);

        $data = [
            'namaFasilitas' => $namaFasilitasRand,
            'deskripsi' => $this->faker->paragraph,
            'status' => $statusRand,
        ];
        
        if ($namaFasilitasRand == 'Gym') {
            $data['jumlahTamu'] = $this->faker->numberBetween($min = 10, $max = 20);
        } else if ($namaFasilitasRand == 'kolam renang') {
            $data['jumlahTamu'] = $this->faker->numberBetween($min = 20, $max = 30);
        }  else if ($namaFasilitasRand == 'SPA') {
            $data['jumlahTamu'] = $this->faker->numberBetween($min = 2, $max = 4);
        }  else if ($namaFasilitasRand == 'Sauna') {
            $data['jumlahTamu'] = $this->faker->numberBetween($min = 4, $max = 6);
        }  else if ($namaFasilitasRand == 'Area Parkir') {
            $data['jumlahTamu'] = $this->faker->numberBetween($min = 50, $max = 100);
        }  else if ($namaFasilitasRand == 'Toilet') {
            $data['jumlahTamu'] = $this->faker->numberBetween($min = 5, $max = 7);
        }  else {
            $data['jumlahTamu'] = $this->faker->numberBetween($min = 10, $max = 15);
        }

        return $data;
    }
}
