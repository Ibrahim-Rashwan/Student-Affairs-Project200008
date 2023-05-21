<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Database\Seeders\AdminSeeder;
use Database\Seeders\DoctorSeeder;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\CourseSeeder;
use Database\Seeders\StudentSeeder;
use Database\Seeders\SubscriptionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $seeders = [
            AdminSeeder::class,
            DoctorSeeder::class,
            DepartmentSeeder::class,
            CourseSeeder::class,
            StudentSeeder::class,
            SubscriptionSeeder::class
        ];

        $this->call($seeders);
    }
}
