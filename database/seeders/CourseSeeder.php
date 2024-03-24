<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\School;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $school = School::where('short_name', 'FUTO')->firstOrFail();

        $courses = [
            ['course_code' => 'GST101', 'course_name' => 'Use of English 1', 'unit' => '2'],
            ['course_code' => 'ENG101', 'course_name' => 'Workshop Practice', 'unit' => '1'],
            ['course_code' => 'MTH101', 'course_name' => 'Elementary Mathematics', 'unit' => '4'],
            ['course_code' => 'GST103', 'course_name' => 'Humanities', 'unit' => '1'],
            ['course_code' => 'ENG103', 'course_name' => 'Engineering Drawing 1', 'unit' => '1'],
            ['course_code' => 'PHY101', 'course_name' => 'General Physics', 'unit' => '4'],
            ['course_code' => 'CHM101', 'course_name' => 'General Chemistry', 'unit' => '4'],
            ['course_code' => 'BIO101', 'course_name' => 'Biology for Physical Science', 'unit' => '3'],
        ];

        foreach ($courses as $course) {
            Course::updateOrCreate(
                [
                    'course_code' => $course['course_code'],
                    'course_name' => $course['course_name'],
                ],
                [
                    'unit' => $course['unit'],
                    'school_id' => $school->id,
                ] 
            );
        }
    }
}
