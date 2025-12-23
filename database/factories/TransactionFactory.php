<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userId = User::inRandomOrder()->first()->id;
        $type = $this->faker->randomElement(['invest', 'withdraw', 'profit']);
        $projectId = null;

        if ($type === 'invest') {
            // Hanya investasi yang terhubung dengan project
            $projectId = Project::inRandomOrder()->first()->id;
        }
        return [
            'user_id' => $userId,
            'project_id' => $projectId,
            'type' => $type,
            'amount' => $this->faker->randomFloat(2, 50000, 10000000),
            'payment_method' => $type === 'invest' ? $this->faker->randomElement(['Bank Transfer', 'E-Wallet', 'VA']) : null,
            'external_id' => $this->faker->unique()->numerify('PAY-########'),
            'status' => $this->faker->randomElement(['pending', 'success', 'failed']),
        ];
    }
}
