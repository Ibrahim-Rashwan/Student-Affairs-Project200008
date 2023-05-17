<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Doctor;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arr = json_encode([]);
        $hours = 3;

        $data = [
            [ 1, null, 'Scientific&Technical Report Writing' , 'GN170', $hours, $arr],
            [ 1, null, 'Fundamentals of Management' , 'GN112', $hours, $arr],
            [ 1, null, 'Quality' , 'GN160', $hours, $arr],
            [ 2, null, 'Mathematics-1' , 'MA111', $hours, $arr],
            [ 6, null, 'Discrete Mathematics' , 'OD111', $hours, $arr],
            [ 6, null, 'Fundamentals of Programming' , 'OD111', $hours, $arr],
            [ 3, null, 'Computer Introduction' , 'CS111', $hours, $arr],
            [ 3, null, 'Semiconductors' , 'CS110', $hours, $arr],
            [ 4, 8   , 'Logic Design-1' , 'IT181', $hours, $arr],
            [ 2, 4   , 'Mathematics-2' , 'MA112', $hours, $arr],
            [ 5, null, 'Introduction to IS' , 'IS111', $hours, $arr],
            [ 3, 6   , 'Computer Programming-1' , 'CS132', $hours, $arr],
            [ 4, 9   , 'Computer Architecture' , 'IT282', $hours, $arr],
            [ 4, 12  , 'Multimedia-1' , 'IT261', $hours, $arr],
            [ 4, 12  , 'Computer Programming-2' , 'CS233', $hours, $arr]
        ];

        foreach ($data as $entry) {
            Course::updateOrCreate(
                ['code' => $entry[4]],
                [
                    'department_id' => $entry[0],
                    'doctor_id' => fake()->numberBetween(1, Doctor::count()),
                    'pre_requisite_id' => $entry[1],
                    'name' => $entry[2],
                    'code' => $entry[3],
                    'number_of_hours' => $entry[4],
                    'materials' => $entry[5]
                ]
            );
        }

    }
}
