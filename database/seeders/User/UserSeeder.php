<?php

namespace Database\Seeders\User;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a default user for login (e.g., admin)
        User::create([
            'name' => 'Admin User',
            'user_name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin'),
        ]);

        // Create 1000 random users using the UserFactory
        User::factory()->count(20)->create();
    }
}
