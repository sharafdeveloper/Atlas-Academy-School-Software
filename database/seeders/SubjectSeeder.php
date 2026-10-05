<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            [
                'name' => 'Physics',
                'monthly_fee' => 1000,
                'status' => true,
            ],

            [
                'name' => 'Chemistry',
                'monthly_fee' => 1500,
                'status' => true,
            ],

            [
                'name' => 'Mathematics',
                'monthly_fee' => 1900,
                'status' => true,
            ],

            [
                'name' => 'English',
                'monthly_fee' => 3000,
                'status' => true,
            ],

            [
                'name' => 'Biology',
                'monthly_fee' => 5000,
                'status' => true,
            ],

            [
                'name' => 'Computer',
                'monthly_fee' => 5000,
                'status' => true,
            ],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}