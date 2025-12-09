<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Create a single admin user (override attributes as needed)
        User::factory()->create([
            'email' => 'admin@example.com',
            'role' => User::ROLE_ADMIN,
            'first_name' => 'Site',
            'last_name' => 'Admin',
        ]);
    }
}
