<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
  public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'password' => Hash::make('password'), // password: password
            'role' => fake()->randomElement(['investor', 'farmer']),
            'address' => fake()->address(),
            'avatar' => null,
            'status' => 'active',
        ];
    }

    // States khusus untuk role
    public function admin(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'email' => 'admin@mail.com',
        ]);
    }

    public function investor(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'investor',
        ]);
    }

    public function farmer(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'farmer',
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
