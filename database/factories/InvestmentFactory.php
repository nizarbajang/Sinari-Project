<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Investment>
 */
class InvestmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Ambil Project dan Investor
        $project = Project::inRandomOrder()->first();
        $investorId = User::where('role', 'investor')->inRandomOrder()->first()->id;
        $units = $this->faker->numberBetween(1, 10);
        $amount = $units * $project->price_per_unit;

        // Mencari Transaction yang tipenya 'invest' dan status 'success'
        $transaction = Transaction::where('type', 'invest')->where('status', 'success')->inRandomOrder()->first();
        return [
            'user_id' => $investorId,
            'project_id' => $project->id,
            'units' => $units,
            'amount' => $amount,
            'status' => $this->faker->randomElement(['paid', 'cancelled']),
            // Pastikan transaction_id ada dan relevan
            'transaction_id' => $transaction->id ?? null,
        ];
    }
}
