<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Student::factory()->has('user')->count(100)->create();
        Student::factory()->hasUser()->count(100)->create();
    }
}
