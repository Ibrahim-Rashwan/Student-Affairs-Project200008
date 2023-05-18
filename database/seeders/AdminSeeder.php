<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{

    private const EMAIL = "root@gmail.com";

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => AdminSeeder::EMAIL],
            [
                'email' => AdminSeeder::EMAIL,
                'email_verified_at' => now(),
                'password' => Hash::make('root'),
                'remember_token' => Str::random(10),
                'name' => 'Ibrahim Rashwan',
                'national_number' => '30202091600452',
                'phone' => '01556120630',
                'age' => 21,
                'gender' => 'male',
            ]
        );

        Admin::updateOrCreate(
            ['user_id' => $user->id]
        );

    }
}
