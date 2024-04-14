<?php

namespace Tests\Feature;

use App\Models\School;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CoursesControllerTest extends TestCase
{
    use WithFaker;

    public function test_course_resource_is_ok(): void
    {
        $school = School::factory()->create();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard/courses');

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
            'course_code' => $this->faker->name(),
            'course_name' => $this->faker->name(),
            'unit' => 3,
            'school_id' => $school->id,
        ];
        $response = $this->post('api/courses', $data);

        $response->assertStatus(200);
    }

    public function test_can_successfully_update_course_record(): void
    {
        Course::getQuery()->delete();
        $authUser = Sanctum::actingAs(
            User::factory()->create([
                'password' => bcrypt('password'),
                'is_staff' => true
            ]),
            ['*']
        );
        $school = School::factory()->create();
        $course = Course::factory()->create([
            'course_code' =>  'EEE 306',
            'course_name' => $this->faker->name(),
            'unit' => 3,
            'school_id' => $school->id,
        ]);

        $data = [
            'course_code' =>  'EEE 306',
            'course_name' => $this->faker->name(),
            'unit' => 2,
            'school_id' => $school->id,
        ];

        $response = $this->post('api/courses/'. $course->id, $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('courses', [
            'course_code' =>  'EEE 306',
            'unit' => 2,
        ]);

    }

    public function test_can_successfully_get_course_detail(): void
    {
        $school = School::factory()->create();
        $course = Course::factory()->create([
            'course_code' =>  'EEE 306',
            'course_name' => $this->faker->name(),
            'unit' => 3,
            'school_id' => $school->id,
        ]);

        Sanctum::actingAs(
            User::factory()->create([
                'password' => bcrypt('password'),
                'is_staff' => true
            ]),
            ['*']
        );
        $response = $this->getJson('api/courses/'. $course->id);

        $response->assertStatus(200);
    }

    public function test_can_successfully_delete_cpourse_record(): void
    {
        $school = School::factory()->create();
        $course = Course::factory()->create([
            'course_code' =>  'EEE 306',
            'course_name' => $this->faker->name(),
            'unit' => 3,
            'school_id' => $school->id,
        ]);

        Sanctum::actingAs(
            User::factory()->create([
                'password' => bcrypt('password'),
                'is_staff' => true
            ]),
            ['*']
        );

        $response = $this->post('api/courses/delete/'. $course->id);

        $response->assertStatus(200);
    }
}
