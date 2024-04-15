<?php

namespace Tests\Feature;

use App\Models\School;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GradeControllerTest extends TestCase
{
    use WithFaker;

    public function test_grade_resource_is_ok(): void
    {
        $school = School::factory()->create();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard/grades');

        $response->assertStatus(200);
    }

    public function test_can_successfully_create_course_record(): void
    {
        User::getQuery()->delete();
        $authUser = Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
        $school = School::factory()->create();

        $data = [
            'code' => 'A',
            'label' => 'Excellent',
            'point' => 3,
            'lower_band_score' => 70,
            'higher_band_score' => 100,
            'school_id' => $school->id,
        ];
        $response = $this->post('api/grading-systems/store', $data);

        $response->assertStatus(200);
    }

    public function test_can_successfully_update_grade_record(): void
    {
        Grade::getQuery()->delete();
        $authUser = Sanctum::actingAs(
            User::factory()->create([
                'password' => bcrypt('password'),
                'is_staff' => true
            ]),
            ['*']
        );
        $school = School::factory()->create();
        $grade = Grade::factory()->create([
            'code' => 'A',
            'label' => 'Excellent',
            'point' => 3,
            'lower_band_score' => 70,
            'higher_band_score' => 100,
            'school_id' => $school->id,
        ]);

        $data = [
            'code' => 'B',
            'label' => 'Very Good',
            'point' => 3,
            'lower_band_score' => 60,
            'higher_band_score' => 69,
            'school_id' => $school->id,
        ];

        $response = $this->post('api/grading-systems/update/'. $grade->id, $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('courses', [
            'course_code' =>  'EEE 306',
            'unit' => 2,
        ]);

    }

    public function test_can_successfully_get_grade_detail(): void
    {
        Grade::getQuery()->delete();
        $school = School::factory()->create();
        $grade = Grade::factory()->create([
            'code' => 'A',
            'label' => 'Excellent',
            'point' => 3,
            'lower_band_score' => 70,
            'higher_band_score' => 100,
            'school_id' => $school->id,
        ]);

        Sanctum::actingAs(
            User::factory()->create([
                'password' => bcrypt('password'),
                'is_staff' => true
            ]),
            ['*']
        );
        $response = $this->getJson('api/grading-systems/view-details/'. $grade->id);

        $response->assertStatus(200);
    }
}
