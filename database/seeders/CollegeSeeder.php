<?php

namespace Database\Seeders;

use App\Models\CollegeInfo;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CollegeSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Get admin user for created_by field
        $admin = User::where('role', User::ROLE_ADMIN)->first();

        $colleges = [
            [
                'college_name' => 'Harvard University',
                'email' => 'harvard@example.com',
                'contact_person' => 'John Smith',
                'max_students' => 5000,
                'valid_from' => now()->subYear(),
                'valid_until' => now()->addYears(2),
                'active_status' => true,
                'created_by' => $admin?->id,
            ],
            [
                'college_name' => 'MIT',
                'email' => 'mit@example.com',
                'contact_person' => 'Sarah Johnson',
                'max_students' => 3000,
                'valid_from' => now()->subYear(),
                'valid_until' => now()->addYears(2),
                'active_status' => true,
                'created_by' => $admin?->id,
            ],
            [
                'college_name' => 'Stanford University',
                'email' => 'stanford@example.com',
                'contact_person' => 'Michael Brown',
                'max_students' => 4000,
                'valid_from' => now()->subYear(),
                'valid_until' => now()->addYears(2),
                'active_status' => true,
                'created_by' => $admin?->id,
            ],
            [
                'college_name' => 'Oxford University',
                'email' => 'oxford@example.com',
                'contact_person' => 'Emma Wilson',
                'max_students' => 3500,
                'valid_from' => now()->subYear(),
                'valid_until' => now()->addYears(2),
                'active_status' => true,
                'created_by' => $admin?->id,
            ],
            [
                'college_name' => 'Cambridge University',
                'email' => 'cambridge@example.com',
                'contact_person' => 'David Lee',
                'max_students' => 3200,
                'valid_from' => now()->subYear(),
                'valid_until' => now()->addYears(2),
                'active_status' => true,
                'created_by' => $admin?->id,
            ],
        ];

        foreach ($colleges as $college) {
            // Create a college user account first
            $collegeUser = User::create([
                'email' => $college['email'],
                'password' => Hash::make('password123'),
                'role' => User::ROLE_COLLEGE,
                'first_name' => $college['college_name'],
                'last_name' => 'Admin',
                'active_status' => $college['active_status'],
            ]);

            // Create college info linked to the user
            CollegeInfo::create([
                'college_name' => $college['college_name'],
                'user_id' => $collegeUser->id,
                'contact_person' => $college['contact_person'],
                'max_students' => $college['max_students'],
                'valid_from' => $college['valid_from'],
                'valid_until' => $college['valid_until'],
                'active_status' => $college['active_status'],
                'created_by' => $college['created_by'],
            ]);
        }
    }
}
