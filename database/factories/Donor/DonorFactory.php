<?php

namespace Database\Factories\Donor;

use App\Models\Donor\Donor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Donor\Donor>
 */
class DonorFactory extends Factory
{
    protected $model = Donor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->optional()->phoneNumber(),
            'type' => $this->faker->randomElement(['INDIVIDUAL', 'CORPORATE']),
        ];
    }
}