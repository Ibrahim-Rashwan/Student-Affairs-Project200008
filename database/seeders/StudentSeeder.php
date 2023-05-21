<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'email' => 'student@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('student'),
            'remember_token' => Str::random(10),
            'name' => 'Amgad',
            'national_number' => '30202091600452',
            'phone' => '01556120630',
            'age' => 22,
            'gender' => 'male',
        ]);

        Student::create([
            'user_id' => $user->id,
            'department_id' => 1,
            'level' => 3,
        ]);
        
        // Student::factory()->has('user')->count(100)->create();
        Student::factory()->hasUser()->count(99)->create();
    }
}
