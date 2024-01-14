<?php

namespace Tests\Feature;

use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LeaveRequestControllerTest extends TestCase
{
    use WithFaker;

    public function test_leave_request_resource_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard/leave-requests');

        $response->assertStatus(200);
    }

    public function test_can_successfully_get_leave_request_detail(): void
    {
        $user = User::factory()->create();

        $leaveRequest = LeaveRequest::factory()->create();

        Sanctum::actingAs(
            $user,
            ['*']
        );
        $response = $this->getJson('api/leave-requests/'.$leaveRequest->id);

        $response->assertStatus(200);
    }

    public function test_can_successfully_create_new_leave_request(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs(
            $user,
            ['*']
        );

        $leaveRequest = LeaveRequest::factory()->create();

        $data = [
            'user_id' => $user->id,
            'title' => $this->faker->word(),
            'description' => $this->faker->text(100),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
        ];

        $response = $this->post('api/leave-requests', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('leave_requests', [
            'user_id' => $user->id,
        ]);
    }

    public function test_can_successfully_update_leave_request_record(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs(
            $user,
            ['*']
        );

        $leaveRequest = LeaveRequest::factory()->create();

        $data = [
            'status' => true,
        ];

        $response = $this->post('api/leave-requests/'.$leaveRequest->id, $data);

        $response->assertStatus(200);
    }
}
