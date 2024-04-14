<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use App\Models\AcademicResult;
use App\Models\Course;
use App\Models\School;
use App\Models\Semester;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AcademicResultControllerTest extends TestCase
{
    use WithFaker;

    public function test_can_successfully_create_academic_result(): void
    {
        $authUser = Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
        $course = Course::factory()->create();
        $semester = Semester::factory()->create();
        $user = User::factory()->create();

        $data = [
            'course_id' => $course->id,
            'score' => 50,
            'created_by' => $authUser->id,
            'grade' => 'C',
            'user_id' => $user->id,
            'unit' => '2',
            'grade_point' => 2*3,
            'semester_id' => $semester->id,
        ];
        $response = $this->post('api/academic-results', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('academic_results', [
            'user_id' => $user->id,
        ]);
    }

    public function test_can_successfully_update_academic_result(): void
    {
        $authUser = Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
        $course = Course::factory()->create();
        $semester = Semester::factory()->create();
        $user = User::factory()->create();
        $academicResult = AcademicResult::factory()->create();

        $data = [
            'course_id' => $course->id,
            'score' => 50,
            'created_by' => $authUser->id,
            'grade' => 'C',
            'user_id' => $user->id,
            'unit' => '2',
            'grade_point' => 2*3,
            'semester_id' => $semester->id,
        ];
        $response = $this->post('api/academic-results/'. $academicResult->id, $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('academic_results', [
            'user_id' => $user->id,
            'score' => 50,
        ]);
    }

    public function test_can_successfully_get_academic_result_detail(): void
    {
        $school = School::factory()->create();
        $user = User::factory()->create([
            'school_id' => $school->id,
        ]);
        $academicResult = AcademicResult::factory()->create([
            'user_id' => $user->id,
        ]);

        Sanctum::actingAs(
            $user,
            ['*']
        );
        $response = $this->getJson('api/academic-results/'. $academicResult->id);

        $response->assertStatus(200);
    }

    public function test_can_successfully_delete_academic_result(): void
    {
        $school = School::factory()->create();
        $user = User::factory()->create([
            'school_id' => $school->id,
        ]);
        $academicResult = AcademicResult::factory()->create([
            'user_id' => $user->id,
        ]);

        Sanctum::actingAs(
            $user,
            ['*']
        );

        $response = $this->post('api/academic-results/delete/'. $academicResult->id);

        $response->assertStatus(200);
    }
}
