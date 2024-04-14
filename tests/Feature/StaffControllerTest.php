<?php

namespace Tests\Feature;

use App\Models\School;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class StaffControllerTest extends TestCase
{
    use WithFaker;

    public function test_staff_resource_is_ok(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard/staffs');

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
        $role = Role::factory()->create();

        $data = [
            'email' => 'faker23sd3@gmail.com',
            'first_name' => $this->faker->name(),
            'middle_name' => $this->faker->name(),
            'last_name' => $this->faker->name(),
            'phone_no' => Str::random(11),
            'gender' => 'Male',
            'school_id' => $school->id,
            'is_staff' => true,
            'created_by' => $authUser->id,
            'password' => bcrypt('password'),
            'role' => $role->id,
        ];
        $response = $this->post('api/staffs', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'email' => 'faker23sd3@gmail.com',
        ]);
    }

    public function test_can_successfully_update_staff_record(): void
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
            'email' => 'faker23sd3@gmail.com',
            'password' => bcrypt('password'),
            'school_id' => $school->id,
            'is_staff' => true
        ]);
        $role = Role::factory()->create();

        $data = [
            'email' => 'faker23sd3@gmail.com',
            'first_name' => $this->faker->name(),
            'middle_name' => $this->faker->name(),
            'last_name' => $this->faker->name(),
            'phone_no' => Str::random(11),
            'gender' => 'Male',
            'school_id' => $school->id,
            'is_staff' => true,
            'created_by' => $authUser->id,
            'role' => $role->id,
            'password' => ''
        ];

        $response = $this->post('api/staffs/'. $user->id, $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'email' => 'faker23sd3@gmail.com',
        ]);

    }

    public function test_can_successfully_get_staff_detail(): void
    {
        $school = School::factory()->create();
        $user = User::factory()->create([
            'school_id' => $school->id,
            'is_staff' => true
        ]);

        Sanctum::actingAs(
            $user,
            ['*']
        );
        $response = $this->getJson('api/staffs/'. $user->id);

        $response->assertStatus(200);
    }

    public function test_can_successfully_delete_staff_record(): void
    {
        $school = School::factory()->create();
        $user = User::factory()->create([
            'school_id' => $school->id,
        ]);

        Sanctum::actingAs(
            $user,
            ['*']
        );

        $response = $this->post('api/staffs/delete/'. $user->id);

        $response->assertStatus(200);
    }
}
