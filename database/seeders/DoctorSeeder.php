<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $user = User::create([
            'email' => 'doctor@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('doctor'),
            'remember_token' => Str::random(10),
            'name' => 'Ahmed El-Shiekh',
            'national_number' => '30202091600452',
            'phone' => '01556120630',
            'age' => 32,
            'gender' => 'male',
        ]);

        Doctor::create([
            'user_id' => $user->id
        ]);
        
        Doctor::factory()->hasUser()->count(14)->create();
    }
}
