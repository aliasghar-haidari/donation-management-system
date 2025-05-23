<?php

namespace Database\Factories\Donor;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Donor\DonationCause>
 */
class DonationCauseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Education', 'Healthcare', 'Disaster Relief']),
            'description' => $this->faker->paragraph(3),
        ];
    }
}
