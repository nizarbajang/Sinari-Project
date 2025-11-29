<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        // Ambil ID farmer dan admin yang sudah ada
        $farmer = User::where('role', 'farmer')->inRandomOrder()->first();
        $admin = User::where('role', 'admin')->inRandomOrder()->first();
        
        $totalUnits = fake()->numberBetween(50, 200);
        $soldUnits = fake()->numberBetween(0, $totalUnits / 2); // Awalnya terjual sebagian

        return [
            'farmer_id' => $farmer ? $farmer->id : User::factory()->farmer(),
            'admin_id' => $admin ? $admin->id : User::factory()->admin(),
            'title' => fake()->catchPhrase() . ' Farm Project',
            'description' => fake()->paragraph(5),
            'animal_type' => fake()->randomElement(['Sapi Bali', 'Kambing Etawa', 'Ayam Petelur']),
            'price_per_unit' => fake()->randomFloat(2, 50000, 200000), // Rp50rb - Rp200rb
            'total_units' => $totalUnits,
            'sold_units' => $soldUnits,
            'duration_months' => fake()->numberBetween(6, 18),
            'profit_percentage' => fake()->randomFloat(2, 10, 30), // 10% - 30% bagi hasil
            'status' => fake()->randomElement(['active', 'full', 'finished']),
        ];
    }
}