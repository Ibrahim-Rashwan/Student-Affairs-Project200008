<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subscriptionCount = Student::count() * 0.5;

        $courses = Course::inRandomOrder()->where('pre_requisite_id', '=', null)->get();
        $students = Student::inRandomOrder()->where('level', '=', 1)->get();

        for ($i=0; $i < $subscriptionCount; $i++) {
            $student = $students[fake()->numberBetween(0, count($students)-1)];
            $course = $courses[fake()->numberBetween(0, count($courses)-1)];

            $mark = fake()->numberBetween(0, 2) == 0 ? null : fake()->numberBetween(10, 80);
            $student->courses()->attach($course, ['mark' => $mark]);
        }
    }
}
