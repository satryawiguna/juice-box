<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_get_all_post()
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'testuser1@domain.com',
            'username' => 'testuser1',
            'password' => bcrypt('password123'),
            'status' => 'ENABLE'
        ]);

        $this->actingAs($user);

        $response = $this->getJson('/api/blog/posts');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'type',
                'code_status',
                'result' => [
                    '*' => [
                        'id',
                        'title',
                        'slug',
                        'publish_date',
                        'content',
                        'status'
                    ],
                ],
            ]);
    }

    /** @test */
    public function it_can_get_all_post_with_search()
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'testuser1@domain.com',
            'username' => 'testuser1',
            'password' => bcrypt('password123'),
            'status' => 'ENABLE'
        ]);

        $postData = [
            'search' => null
        ];

        $this->actingAs($user);

        $response = $this->postJson('/api/blog/posts/search', $postData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'type',
                'code_status',
                'total_count',
                'result' => [
                    '*' => [
                        'id',
                        'title',
                        'slug',
                        'publish_date',
                        'content',
                        'status'
                    ],
                ],
            ]);
    }

    /** @test */
    public function it_can_get_all_post_with_search_and_page()
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'testuser1@domain.com',
            'username' => 'testuser1',
            'password' => bcrypt('password123'),
            'status' => 'ENABLE'
        ]);

        $this->actingAs($user);

        $postData = [
            'order_by' => 'created_at',
            'sort' => 'ASC',
            'search' => null,
            'page' => 1,
            'per_page' => 10
        ];

        $response = $this->postJson('/api/blog/posts/search/page', $postData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'type',
                'code_status',
                'total_count',
                'per_page',
                'current_page',
                'result' => [
                    '*' => [
                        'id',
                        'title',
                        'slug',
                        'publish_date',
                        'content',
                        'status'
                    ],
                ],
            ]);
    }

    /** @test */
    public function it_can_create_a_post()
    {
        $this->artisan('db:seed');

        $user = \App\Models\User::factory()->create([
            'email' => 'testuser1@domain.com',
            'username' => 'testuser1',
            'password' => bcrypt('password123'),
            'status' => 'ENABLE'
        ]);

        $this->actingAs($user);

        $data = [
            "title" => "Title blog one",
	        "content" => "Title blog one Title blog one"
        ];

        $response = $this->postJson('/api/blog/post', $data);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'type',
                'code_status',
                'result' => [
                    "id",
                    "title",
                    "slug",
                    "publish_date",
                    "content",
                    "status",
                ]
            ]);

        $this->assertDatabaseHas('posts', ['title' => 'Title blog one']);
    }

    /** @test */
    public function it_can_update_a_post()
    {
        $this->artisan('db:seed');

        $user = \App\Models\User::factory()->create([
            'email' => 'testuser1@domain.com',
            'username' => 'testuser1',
            'password' => bcrypt('password123'),
            'status' => 'ENABLE'
        ]);

        $this->actingAs($user);

        $post = \App\Models\Post::factory()->create([
            "title" => "Title blog one",
            "content" => "Title blog one content"
        ]);

        $updateData = [
            "title" => "Updated blog title",
            "content" => "Updated blog content"
        ];

        $response = $this->patchJson("/api/blog/post/{$post->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'type' => 'SUCCESS',
                'code_status' => 200,
                'result' => true
            ]);

        $this->assertDatabaseHas('posts', ['title' => 'Updated blog title']);
    }

    /** @test */
    public function it_can_delete_a_post()
    {
        $this->artisan('db:seed');

        $user = \App\Models\User::factory()->create([
            'email' => 'testuser1@domain.com',
            'username' => 'testuser1',
            'password' => bcrypt('password123'),
            'status' => 'ENABLE'
        ]);

        $this->actingAs($user);

        $post = \App\Models\Post::factory()->create([
            "title" => "Title blog one",
            "content" => "Title blog one content"
        ]);

        $response = $this->deleteJson("/api/blog/post/{$post->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'type',
                'code_status',
                'message'
            ]);

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}
