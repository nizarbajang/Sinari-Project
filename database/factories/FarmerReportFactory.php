<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FarmerReport>
 */
class FarmerReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Ambil Project yang statusnya 'active' atau 'finished'
        $project = Project::whereIn('status', ['active', 'finished'])->inRandomOrder()->first();
        // Ambil ID Farmer yang sesuai dengan Project tersebut
        $farmerId = $project->farmer_id ?? User::where('role', 'farmer')->inRandomOrder()->first()->id;

        return [
            'project_id' => $project->id ?? Project::inRandomOrder()->first()->id,
            'farmer_id' => $farmerId,
            'weight' => $this->faker->randomFloat(2, 5, 50),
            'health_status' => $this->faker->randomElement(['Sehat', 'Sakit Ringan', 'Karantina']),
            'notes' => $this->faker->sentence(),
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }
}
