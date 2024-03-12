<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\School;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $school = School::where('short_name', 'FUTO')->firstOrFail();
        Grade::updateOrCreate(
            [
                'code' => 'A',
                'school_id' => $school->id,
            ],
            [
                'point' => 5,
                'lower_band_score' => 70,
                'higher_band_score' => 100,
                'label' => 'Excellent',
            ],
        );

        Grade::updateOrCreate(
            [
                'code' => 'B',
                'school_id' => $school->id,
            ],
            [
                'point' => 4,
                'lower_band_score' => 60,
                'higher_band_score' => 69,
                'label' => 'Very Good',
            ],
        );

        Grade::updateOrCreate(
            [
                'code' => 'C',
                'school_id' => $school->id,
            ],
            [
                'point' => 3,
                'lower_band_score' => 50,
                'higher_band_score' => 59,
                'label' => 'Good',
            ],
        );

        Grade::updateOrCreate(
            [
                'code' => 'D',
                'school_id' => $school->id,
            ],
            [
                'point' => 2,
                'lower_band_score' => 46,
                'higher_band_score' => 49,
                'label' => 'Pass',
            ],
        );

        Grade::updateOrCreate(
            [
                'code' => 'E',
                'school_id' => $school->id,
            ],
            [
                'point' => 1,
                'lower_band_score' => 40,
                'higher_band_score' => 45,
                'label' => 'Poor Pass',
            ],
        );

        Grade::updateOrCreate(
            [
                'code' => 'F',
                'label' => 'Failure',
                'school_id' => $school->id,
            ],
            [
                'point' => 0,
                'lower_band_score' => 0,
                'higher_band_score' => 39,
            ],
        );
    }
}
