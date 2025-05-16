<?php

namespace Database\Seeders\Donor;

use App\Models\Donor\DonationCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DonationCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 random donation categories using the factory
        // DonationCategory::factory()->count(10)->create();

        // Create specific categories
        $categories = [
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

        foreach ($categories as $category) {
            DonationCategory::firstOrCreate(['name' => $category]);
        }
    }
}