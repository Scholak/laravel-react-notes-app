<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name' => 'test name',
            'email' => 'test@gmail.com',
            'password' => bcrypt('password'),
        ]);
    }
    
    /**
     * this function tests the validation of register functionality
     *
     * @return void
     */
    public function test_user_must_fill_all_fields_to_register(): void
    {
        $response = $this->postJson('/api/register', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'password', 'password_confirmation']);
    }
    
    /**
     * this function test user can register to the system
     *
     * @return void
     */
    public function test_user_can_register_successfully(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'example name',
            'email' => 'example@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['email' => 'example@gmail.com']);
    }

    /**
     * this function tests the validation of login functionality
     *
     * @return void
     */
    public function test_user_must_fill_all_fields_to_login(): void
    {
        $response = $this->postJson('/api/login', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email', 'password']);
    }
    
    /**
     * this function test user can login to the system
     *
     * @return void
     */
    public function test_user_can_login_successfully(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => 'test@gmail.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
    }

     /**
     * this function test user can logout from the system
     *
     * @return void
     */
    public function test_authenticated_user_can_logout_successfully(): void
    {
        Sanctum::actingAs($this->user);
    
        $response = $this->postJson('/api/logout');

        $response->assertStatus(200);
    }

    /**
     * this function test user can fetch profile information from the system
     *
     * @return void
     */
    public function test_authenticated_user_can_fetch_profile_info_successfully(): void
    {
        Sanctum::actingAs($this->user);

        $response = $this->getJson('/api/profile');

        $response->assertStatus(200);
    }
}
