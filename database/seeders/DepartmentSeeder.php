<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['General', 'GN'],
            ['Mathematics', 'MA'],
            ['Computer Science', 'CS'],
            ['Information Technology', 'IT'],
            ['Information Systems', 'IS'],
            ['Operation Research', 'OD']
        ];

        foreach ($data as $entry) {
            Department::updateOrCreate(
                ['code' => $entry[1]],
                ['name' => $entry[0], 'code' => $entry[1]]
            );
        }
    }
}
