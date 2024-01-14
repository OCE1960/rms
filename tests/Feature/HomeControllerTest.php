<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_welcome_page_successfully_rendered(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
