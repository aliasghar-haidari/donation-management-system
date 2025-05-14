<?php

namespace Database\Seeders\Donor;

use Illuminate\Database\Seeder;
use App\Models\Donor\Donor;

class DonorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Donor::factory()->count(1000)->create();
    }
}
