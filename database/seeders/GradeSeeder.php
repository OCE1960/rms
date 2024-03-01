<?php

namespace Database\Seeders;

use App\Models\Grade;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Grade::updateOrCreate(
            [
                'code' => 'A',
                'label' => 'Excellent',
            ],
            [
                'point' => 5,
                'lower_band_score' => 70,
                'higher_band_score' => 100,
            ],
        );

        Grade::updateOrCreate(
            [
                'code' => 'B',
                'label' => 'Very Good',
            ],
            [
                'point' => 4,
                'lower_band_score' => 60,
                'higher_band_score' => 69,
            ],
        );

        Grade::updateOrCreate(
            [
                'code' => 'C',
                'label' => 'Good',
            ],
            [
                'point' => 3,
                'lower_band_score' => 50,
                'higher_band_score' => 59,
            ],
        );

        Grade::updateOrCreate(
            [
                'code' => 'D',
                'label' => 'Pass',
            ],
            [
                'point' => 2,
                'lower_band_score' => 46,
                'higher_band_score' => 49,
            ],
        );

        Grade::updateOrCreate(
            [
                'code' => 'E',
                'label' => 'Poor Pass',
            ],
            [
                'point' => 1,
                'lower_band_score' => 40,
                'higher_band_score' => 45,
            ],
        );

        Grade::updateOrCreate(
            [
                'code' => 'F',
                'label' => 'Failure',
            ],
            [
                'point' => 0,
                'lower_band_score' => 0,
                'higher_band_score' => 39,
            ],
        );
    }
}
