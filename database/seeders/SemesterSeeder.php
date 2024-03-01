<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\Semester;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $school = School::where('short_name', 'FUTO')->firstOrFail();

        $semesters = [
            ['session' => '2008/2009', 'semester_name' => 'Harmattan Semester'],
            ['session' => '2008/2009', 'semester_name' => 'Rain Semester'],
        ];

        foreach ($semesters as $semester) {
            Semester::updateOrCreate(
                [
                    'session' => $semester['session'],
                    'semester_name' => $semester['semester_name'],
                    'school_id' => $school->id
                ],
                [

                ]
            );
        }
    }
}
