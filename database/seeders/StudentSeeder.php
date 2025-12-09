<?php

namespace Database\Seeders;

use App\Models\CollegeInfo;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Get all colleges
        $colleges = CollegeInfo::all();

        if ($colleges->isEmpty()) {
            $this->command->warn('No colleges found. Please run CollegeSeeder first.');
            return;
        }

        // Create students and assign to colleges
        $collegeIndex = 0;
        foreach (range(1, 10) as $i) {
            $college = $colleges[$collegeIndex % $colleges->count()];

            User::factory()->create([
                'email' => "student{$i}@example.com",
                'role' => User::ROLE_STUDENT,
                'college_id' => $college->college_id,
                'first_name' => "Student",
                'last_name' => "User {$i}",
            ]);

            $collegeIndex++;
        }
    }
}
