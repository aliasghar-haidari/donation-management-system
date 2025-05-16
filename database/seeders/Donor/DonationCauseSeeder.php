<?php

namespace Database\Seeders\Donor;

use App\Models\Donor\DonationCause;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DonationCauseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 random donation causes using the factory
        // DonationCause::factory()->count(10)->create();

        // Create specific causes
        $causes = [
            'Education',
            'Healthcare',
            'Disaster Relief',
            'Poverty Alleviation',
            'Environment & Wildlife',
            'Human Rights',
            'Arts & Culture',
            'Religious Causes',
            'Animal Welfare',
            'Veteran Support'
        ];

        foreach ($causes as $cause) {
            DonationCause::firstOrCreate(['name' => $cause]);
        }
    }
}