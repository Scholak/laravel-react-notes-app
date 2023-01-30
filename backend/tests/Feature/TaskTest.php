<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    
    public function setUp(): void
    {
        parent::setUp();
    
        $this->user = User::create([
            'name' => 'example name',
            'email' => 'example@gmail.com',
            'password' => bcrypt('password'),
        ]);
    }
    
    /**
     * this function tests the authentication mechanism works correctly
     *
     * @return void
     */
    public function test_authenticated_user_cannot_access_protected_task_routes(): void
    {
        $response = $this->postJson('/api/tasks');

        $response->assertStatus(401);
    }

    /**
     * this function tests authenticated user can view own tasks
     *
     * @return void
     */
    public function test_authenticated_user_can_view_tasks(): void
    {
        Sanctum::actingAs($this->user);

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200);
    }

    /**
     * this function tests authenticated user must fill all required fields to create new task
     *
     * @return void
     */
    public function test_authenticated_user_must_fill_required_fields(): void
    {
        Sanctum::actingAs($this->user);

        $response = $this->postJson('/api/tasks', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'body']);
    }

    /**
     * this function tests authenticated user can create new task
     *
     * @return void
     */
    public function test_authenticated_user_can_create_new_task(): void
    {
        Sanctum::actingAs($this->user);

        $response = $this->postJson('/api/tasks', [
            'title' => 'example title',
            'body' => 'example body'
        ]);

        $response->assertStatus(200);
    }
}
