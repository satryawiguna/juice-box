<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_register_a_user()
    {
        $this->artisan('db:seed');

        $data = [
            "username" => "tjahyono",
            "email" => "tjahyono_kumolo@mailto.plus",
            "password" => "!Q2w3e4r5t",
            "password_confirmation" => "!Q2w3e4r5t",
            "first_name" => "Tjahyono",
            "last_name" => "Kumolo",
            "mobile_phone" => "+628128726378"
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'type',
                'code_status',
                'message'
            ]);

        $this->assertDatabaseHas('users', ['email' => 'tjahyono_kumolo@mailto.plus']);
    }

    /** @test */
    public function it_can_login_a_user()
    {
        $this->artisan('db:seed');

        User::factory()->create([
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
        ]);

        $loginData = [
            'identity' => 'john@example.com',
            'password' => 'password',
        ];

        $response = $this->postJson('/api/login', $loginData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'type',
                'code_status',
                'result' => [
                    'id',
                    'email',
                    'access_token',
                    'token_type',
                    'permissions' => [
                        '*' => [
                            'id',
                            'title',
                            'slug',
                        ],
                    ],
                    'policies' => [
                        '*' => [
                            'id',
                            'title',
                            'slug',
                        ],
                    ],
                ],
            ]);
    }

    /** @test */
    public function it_can_logout_a_user()
    {
        $this->artisan('db:seed');

        $user = \App\Models\User::factory()->create([
            'email' => 'testuser@domain.com',
            'password' => bcrypt('password123'),
        ]);

        $loginData = [
            'identity' => 'testuser@domain.com',
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/login', $loginData);

        $token = $response['result']['access_token'];

        $this->assertAuthenticatedAs($user);

        $logoutResponse = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/logout', ['id' => Auth::id()]);

        $logoutResponse->assertStatus(200)
            ->assertJson([
                'type' => 'SUCCESS',
                'code_status' => 200,
                'message' => 'You have logged out',
            ]);
    }

    /** @test */
    public function it_can_get_user_by_id()
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'testuser1@domain.com',
            'username' => 'testuser1',
            'password' => bcrypt('password123'),
            'status' => 'ENABLE'
        ]);

        $this->actingAs($user);

        $response = $this->getJson('/api/user/' . $user->id);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'type',
                'code_status',
                'result' => [
                    'id',
                    'email',
                    'username',
                    'status'
                ],
            ])
            ->assertJson([
                'result' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'username' => $user->username,
                    'status' => $user->status,
                ],
            ]);
    }
}
