<?php

namespace Tests\Feature;

use App\Models\School;
use App\Models\Semester;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SemesterControllerTest extends TestCase
{
    use WithFaker;

    public function test_semester_resource_is_ok(): void
    {
        $school = School::factory()->create();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard/semesters');

        $response->assertStatus(200);
    }

    public function test_can_successfully_create_semester_record(): void
    {
        User::getQuery()->delete();
        $authUser = Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
        $school = School::factory()->create();

        $data = [
            'semester_session' => '2008/2009',
            'semester_name' => 'Harmattan Semester',
            'created_by' => $authUser->id,
            'school_id' => $school->id,
        ];
        $response = $this->post('api/semesters', $data);

        $response->assertStatus(200);
    }

    public function test_can_successfully_update_semester_record(): void
    {
        Semester::getQuery()->delete();
        $authUser = Sanctum::actingAs(
            User::factory()->create([
                'password' => bcrypt('password'),
                'is_staff' => true
            ]),
            ['*']
        );
        $school = School::factory()->create();
        $semester = Semester::factory()->create([
            'semester_session' => '2008/2009',
            'semester_name' => 'Harmattan Semester',
            'created_by' => $authUser->id,
            'school_id' => $school->id,
        ]);

        $data = [
            'semester_session' => '2008/2009',
            'semester_name' => 'Rain Semester',
            'created_by' => $authUser->id,
            'school_id' => $school->id,
        ];

        $response = $this->post('api/semesters/'. $semester->id, $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('courses', [
            'course_code' =>  'EEE 306',
            'unit' => 2,
        ]);

    }

    public function test_can_successfully_get_semester_detail(): void
    {
        Semester::getQuery()->delete();
        $school = School::factory()->create();
        $semester = Semester::factory()->create([
            'semester_session' => '2008/2009',
            'semester_name' => 'Harmattan Semester',
            'school_id' => $school->id,
        ]);

        Sanctum::actingAs(
            User::factory()->create([
                'password' => bcrypt('password'),
                'is_staff' => true
            ]),
            ['*']
        );
        $response = $this->getJson('api/semesters/'. $semester->id);

        $response->assertStatus(200);
    }

    public function test_can_successfully_delete_semester_record(): void
    {
        $school = School::factory()->create();
        $semester = Semester::factory()->create([
            'semester_session' => '2008/2009',
            'semester_name' => 'Harmattan Semester',
            'school_id' => $school->id,
        ]);

        Sanctum::actingAs(
            User::factory()->create([
                'password' => bcrypt('password'),
                'is_staff' => true
            ]),
            ['*']
        );

        $response = $this->post('api/semesters/delete/'. $semester->id);

        $response->assertStatus(200);
    }
}
