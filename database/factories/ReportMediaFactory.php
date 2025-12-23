<?php

namespace Database\Factories;

use App\Models\FarmerReport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReportMedia>
 */
class ReportMediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'report_id' => FarmerReport::inRandomOrder()->first()->id,
            'type' => $this->faker->randomElement(['image', 'video']),
            'url' => $this->faker->url(),
        ];
    }
}
