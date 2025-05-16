<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            \Database\Seeders\User\UserSeeder::class,
            \Database\Seeders\Donor\DonorSeeder::class,
            \Database\Seeders\Donor\DonationCauseSeeder::class,
        ]);
    }
}