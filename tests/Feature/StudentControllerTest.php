<?php

namespace Tests\Feature;

use App\Models\School;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class StudentControllerTest extends TestCase
{
    use WithFaker;

    public function test_student_resource_is_ok(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard/students');

        $response->assertStatus(200);
    }

    public function test_can_successfully_create_staff_record(): void
    {
        User::getQuery()->delete();
        $authUser = Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
        $school = School::factory()->create();

        $data = [
            'email' => 'fakerstudent23sd3@gmail.com',
            'first_name' => $this->faker->name(),
            'middle_name' => $this->faker->name(),
            'last_name' => $this->faker->name(),
            'phone_no' => Str::random(11),
            'gender' => 'Male',
            'school_id' => $school->id,
            'is_student' => true,
            'created_by' => $authUser->id,
            'registration_no' => 2016273682363,
            'password' => bcrypt('password'),
        ];
        $response = $this->post('api/students', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'email' => 'fakerstudent23sd3@gmail.com',
        ]);
    }

    public function test_can_successfully_update_student_record(): void
    {
        User::getQuery()->delete();
        $authUser = Sanctum::actingAs(
            User::factory()->create([
                'password' => bcrypt('password'),
                'is_staff' => true
            ]),
            ['*']
        );
        $school = School::factory()->create();
        $user = User::factory()->create([
            'email' => 'fakerstudent23sd3@gmail.com',
            'registration_no' => 2016273682363,
            'password' => bcrypt('password'),
            'school_id' => $school->id,
            'is_student' => true
        ]);

        $data = [
            'email' => 'fakerstudent23sd3@gmail.com',
            'first_name' => $this->faker->name(),
            'middle_name' => $this->faker->name(),
            'last_name' => $this->faker->name(),
            'phone_no' => Str::random(11),
            'gender' => 'Male',
            'school_id' => $school->id,
            'is_student' => true,
            'created_by' => $authUser->id,
            'registration_no' => 2016273682363,
        ];

        $response = $this->post('api/students/'. $user->id, $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'email' => 'fakerstudent23sd3@gmail.com',
        ]);

    }

    public function test_can_successfully_get_student_detail(): void
    {
        $school = School::factory()->create();
        $user = User::factory()->create([
            'school_id' => $school->id,
            'is_student' => true
        ]);

        Sanctum::actingAs(
            $user,
            ['*']
        );
        $response = $this->getJson('api/students/'. $user->id);

        $response->assertStatus(200);
    }

    public function test_can_successfully_delete_student_record(): void
    {
        $school = School::factory()->create();
        $user = User::factory()->create([
            'school_id' => $school->id,
        ]);

        Sanctum::actingAs(
            $user,
            ['*']
        );

        $response = $this->post('api/students/delete/'. $user->id);

        $response->assertStatus(200);
    }
}
