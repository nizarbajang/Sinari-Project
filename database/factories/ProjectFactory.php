<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $farmerId = User::where('role', 'farmer')->inRandomOrder()->first()->id ?? User::factory()->farmer()->create()->id;
        $adminId = User::where('role', 'admin')->inRandomOrder()->first()->id ?? User::factory()->admin()->create()->id;
        $totalUnits = $this->faker->numberBetween(100, 500);
        return [
            'farmer_id' => $farmerId,
            'admin_id' => $adminId,
            'title' => $this->faker->sentence(3) . ' Farming Project',
            'description' => $this->faker->paragraph(3),
            'animal_type' => $this->faker->randomElement(['Ayam Kampung', 'Kambing Etawa', 'Sapi Potong', 'Ikan Lele']),
            'price_per_unit' => $this->faker->randomFloat(2, 50000, 200000),
            'total_units' => $totalUnits,
            'sold_units' => $this->faker->numberBetween(0, (int)($totalUnits * 0.7)), // Maksimal 70% terjual
            'duration_months' => $this->faker->numberBetween(3, 12),
            'profit_percentage' => $this->faker->randomFloat(2, 10, 30),
            'status' => $this->faker->randomElement(['active', 'full', 'finished', 'draft']),
        ];
    }
}
