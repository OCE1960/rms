<?php

namespace Tests\Feature;

use App\Models\School;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SchoolControllerTest extends TestCase
{
    use WithFaker;

    public function test_school_resource_is_ok(): void
    {
        $school = School::factory()->create();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard/schools');

        $response->assertStatus(200);
    }

    public function test_can_successfully_create_school_record(): void
    {
        School::getQuery()->delete();
        $authUser = Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
        $school = School::factory()->create();

        $data = [
            'full_name' => $this->faker->name(),
            'address_mailbox' => fake()->unique()->safeEmail(),
            'type' => 'University',
            'geo_zone' => 'South East',
        ];
        $response = $this->post('api/schools', $data);

        $response->assertStatus(200);
    }

    public function test_can_successfully_update_school_record(): void
    {
        School::getQuery()->delete();
        $authUser = Sanctum::actingAs(
            User::factory()->create([
                'password' => bcrypt('password'),
                'is_staff' => true
            ]),
            ['*']
        );

        $school = School::factory()->create([
            'full_name' => 'Nnamdi Azikiwe University',
            'short_name' => 'UNIZIK',
            'type' => 'University',
            'geo_zone' => 'South East',
            'address_mailbox' => fake()->unique()->safeEmail(),
        ]);

        $data = [
            'full_name' => 'Nnamdi Azikiwe University',
            'short_name' => 'UNIZIK',
            'address_mailbox' => fake()->unique()->safeEmail(),
            'type' => 'University',
            'geo_zone' => 'South East',
        ];

        $response = $this->post('api/schools/'. $school->id, $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('schools', [
            'full_name' => 'Nnamdi Azikiwe University',
            'short_name' => 'UNIZIK',
        ]);

    }

    public function test_can_successfully_get_school_detail(): void
    {
        School::getQuery()->delete();
        $school = School::factory()->create([
            'full_name' => 'Nnamdi Azikiwe University',
            'short_name' => 'UNIZIK',
            'type' => 'University',
            'geo_zone' => 'South East',
            'address_mailbox' => fake()->unique()->safeEmail(),
        ]);

        Sanctum::actingAs(
            User::factory()->create([
                'password' => bcrypt('password'),
                'is_staff' => true
            ]),
            ['*']
        );
        $response = $this->getJson('api/schools/'. $school->id);

        $response->assertStatus(200);
    }

    public function test_can_successfully_delete_school_record(): void
    {
        School::getQuery()->delete();
        $school = School::factory()->create([
            'full_name' => 'Nnamdi Azikiwe University',
            'short_name' => 'UNIZIK',
            'type' => 'University',
            'geo_zone' => 'South East',
            'address_mailbox' => fake()->unique()->safeEmail(),
        ]);

        Sanctum::actingAs(
            User::factory()->create([
                'password' => bcrypt('password'),
                'is_staff' => true
            ]),
            ['*']
        );

        $response = $this->post('api/schools/delete/'. $school->id);

        $response->assertStatus(200);
    }
}
