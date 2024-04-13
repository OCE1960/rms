<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Role;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Illuminate\Support\Str;

class DashboardControllerTest extends TestCase
{
    use WithFaker;
    /**
     * Testing the Landing Dashboard.
     */
    public function test_landing_dashboard_page_is_ok(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
    }

    public function test_users_resource_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard/users');

        $response->assertStatus(200);
    }

    public function test_can_successfully_get_user_detail(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs(
            $user,
            ['*']
        );
        $response = $this->getJson('api/users/'.$user->id);

        $response->assertStatus(200);
    }

    public function test_can_successfully_create_new_user(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
        $phone_no = Str::random(11);
        $role = Role::factory()->create();
        $data = [
            'email' => $this->faker->safeEmail(),
            'phone_no' => $phone_no,
            'password' => 'password123',
            'first_name' => $this->faker->name(),
            'last_name' => $this->faker->name(),
            'role' => $role->id,
        ];
        $response = $this->post('api/users', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'phone_no' => $phone_no,
        ]);
    }

    public function test_can_successfully_update_user_record(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
        $user = User::factory()->create();
        $phone_no = Str::random(11);
        $role = Role::factory()->create();
        $data = [
            'email' => fake()->unique()->safeEmail(),
            'phone_no' => $phone_no,
            'first_name' => $this->faker->name(),
            'last_name' => $this->faker->name(),
            'role' => $role->id,
        ];
        $response = $this->post('api/users/update/'.$user->id, $data);

        $response->assertStatus(200);
    }
}
