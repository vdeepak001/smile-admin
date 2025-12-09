<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CollegeInfo;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Get admin user for inserted_by field
        $admin = User::where('role', User::ROLE_ADMIN)->first();

        // Get all colleges
        $colleges = CollegeInfo::all();

        if ($colleges->isEmpty()) {
            $this->command->warn('No colleges found. Please run CollegeSeeder first.');
            return;
        }

        $courses = [
            [
                'course_name' => 'Introduction to Computer Science',
                'description' => 'Learn the fundamentals of computer science including programming, algorithms, and data structures.',
                'test_questions' => 50,
                'percent_require' => 70,
                'valid_from' => now()->subMonth(),
                'valid_until' => now()->addMonths(6),
                'active_status' => true,
            ],
            [
                'course_name' => 'Web Development Fundamentals',
                'description' => 'Master HTML, CSS, JavaScript and modern web development frameworks.',
                'test_questions' => 40,
                'percent_require' => 75,
                'valid_from' => now()->subMonth(),
                'valid_until' => now()->addMonths(6),
                'active_status' => true,
            ],
            [
                'course_name' => 'Database Management Systems',
                'description' => 'Comprehensive course on database design, SQL, and database administration.',
                'test_questions' => 45,
                'percent_require' => 70,
                'valid_from' => now()->subMonth(),
                'valid_until' => now()->addMonths(6),
                'active_status' => true,
            ],
            [
                'course_name' => 'Data Structures and Algorithms',
                'description' => 'Deep dive into various data structures and algorithmic problem-solving techniques.',
                'test_questions' => 60,
                'percent_require' => 80,
                'valid_from' => now()->subMonth(),
                'valid_until' => now()->addMonths(6),
                'active_status' => true,
            ],
            [
                'course_name' => 'Software Engineering Principles',
                'description' => 'Learn software development methodologies, design patterns, and best practices.',
                'test_questions' => 50,
                'percent_require' => 75,
                'valid_from' => now()->subMonth(),
                'valid_until' => now()->addMonths(6),
                'active_status' => true,
            ],
            [
                'course_name' => 'Mobile App Development',
                'description' => 'Build mobile applications for iOS and Android platforms using modern frameworks.',
                'test_questions' => 45,
                'percent_require' => 70,
                'valid_from' => now()->subMonth(),
                'valid_until' => now()->addMonths(6),
                'active_status' => true,
            ],
            [
                'course_name' => 'Machine Learning Basics',
                'description' => 'Introduction to machine learning concepts, algorithms, and practical applications.',
                'test_questions' => 55,
                'percent_require' => 75,
                'valid_from' => now()->subMonth(),
                'valid_until' => now()->addMonths(6),
                'active_status' => true,
            ],
            [
                'course_name' => 'Cybersecurity Fundamentals',
                'description' => 'Learn about network security, encryption, and protecting systems from threats.',
                'test_questions' => 50,
                'percent_require' => 80,
                'valid_from' => now()->subMonth(),
                'valid_until' => now()->addMonths(6),
                'active_status' => true,
            ],
        ];

        // Assign courses to colleges (distribute evenly)
        $collegeIndex = 0;
        foreach ($courses as $courseData) {
            $courseData['college_id'] = $colleges[$collegeIndex % $colleges->count()]->college_id;
            $courseData['inserted_by'] = $admin?->id;
            $courseData['inserted_on'] = now();

            Course::create($courseData);

            $collegeIndex++;
        }
    }
}

