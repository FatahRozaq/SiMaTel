<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Staff;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class StaffFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $jabatanHotel = ['Housekeeping', 'Chef', 'Waiter', 'Manager', 'Security'];
        $fasilitasHotel = ['Gym', 'kolam renang', 'SPA'];

        $jabatan = $this->faker->randomElement($jabatanHotel);

        $data = [
            'namaStaff' => $this->faker->name,
            'alamat' => $this->faker->address,
            'noTelepon' => $this->faker->phoneNumber,
            'jabatan' => $jabatan,
            'email' => $this->faker->unique()->safeEmail,
        ];

        // Tambahkan fasilitasHotel jika jabatannya Waiter atau Housekeeping
        if ($jabatan == 'Waiter' || $jabatan == 'Housekeeping') {
            $data['fasilitasHotel'] = $this->faker->randomElement($fasilitasHotel);
        } else {
            $data['fasilitasHotel'] = '-';
        }

        return $data;
    }
}
