<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected Task $task;
    
    public function setUp(): void
    {
        parent::setUp();
    
        $this->user = User::create([
            'name' => 'example name',
            'email' => 'example@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $this->task = Task::create([
            'title' => 'example task title',
            'body' => 'example task body',
            'completed' => false,
            'user_id' => $this->user->id,
        ]);
    }
    
    /**
     * this function tests the authentication mechanism works correctly
     *
     * @return void
     */
    public function test_authenticated_user_cannot_access_protected_task_routes(): void
    {
        $response = $this->getJson('/api/tasks');
        $response = $this->postJson('/api/tasks');
        $response = $this->putJson('/api/tasks/'.$this->task->id);
        $response = $this->deleteJson('/api/tasks/'.$this->task->id);

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
    public function test_authenticated_user_must_fill_required_fields_to_create_new_task(): void
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

    /**
     * this function tests authenticated user must fill all required fields to update task
     *
     * @return void
     */
    public function test_authenticated_user_must_fill_required_fields_to_update_task(): void
    {
        Sanctum::actingAs($this->user);

        $response = $this->putJson('/api/tasks/'.$this->task->id, []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'body', 'completed']);
    }

    /**
     * this function tests unexisting task returns 404 status code for delete function
     *
     * @return void
     */
    public function test_unexisting_task_must_return_not_found_status_code_for_update_route(): void
    {
        Sanctum::actingAs($this->user);

        $response = $this->putJson('/api/tasks/0', [
            'title' => 'example title updated',
            'body' => 'example body updated',
            'completed' => true,
        ]);

        $response->assertStatus(404);
    }

    /**
     * this function tests authenticated user can update task
     *
     * @return void
     */
    public function test_authenticated_user_can_update_task(): void
    {
        Sanctum::actingAs($this->user);

        $response = $this->putJson('/api/tasks/'.$this->task->id, [
            'title' => 'example title updated',
            'body' => 'example body updated',
            'completed' => true,
        ]);

        $response->assertStatus(200);
    }

    /**
     * this function tests unexisting task returns 404 status code for delete function
     *
     * @return void
     */
    public function test_unexisting_task_must_return_not_found_status_code_for_delete_route(): void
    {
        Sanctum::actingAs($this->user);

        $response = $this->deleteJson('/api/tasks/0', []);

        $response->assertStatus(404);
    }

    /**
     * this function tests authenticated user can delete task
     *
     * @return void
     */
    public function test_authenticated_user_can_delete_task(): void
    {
        Sanctum::actingAs($this->user);

        $response = $this->deleteJson('/api/tasks/'.$this->task->id, []);

        $response->assertStatus(200);
    }
}
