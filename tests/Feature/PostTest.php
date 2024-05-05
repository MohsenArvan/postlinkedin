<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PostTest extends TestCase
{
    public function test_list_of_posts()
    {
        Post::factory()->count(10)->create();

        $response = $this->getJson('/api/posts');

        $response->assertStatus(200);
        $response->assertJsonCount(10, 'data');
    }

    public function test_show_post()
    {
        $post = Post::factory()->create();

        $response = $this->getJson("/api/posts/{$post->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $post->id,
                'title' => $post->title,
                'description' => $post->description,
                'image_url' => $post->image_url,
                'user_id' => $post->user_id,
            ]
        ]);
    }
    
    public function test_user_can_store_post(){
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $post = Post::factory()->make([
            'user_id' => null
        ]);

        $response = $this->postJson('/api/posts', $post->toArray());

        $response->assertStatus(201);
        $this->assertDatabaseHas('posts', [
            'title' => $post->title,
            'description' => $post->description,
            'image_url' => $post->image_url,
            'user_id' => $user->id,
        ]);
    }

    public function test_user_can_not_store_with_out_create_post(){
        $post = Post::factory()->make([
            'user_id' => null
        ]);

        $response = $this->postJson('/api/posts', $post->toArray());

        $response->assertStatus(401);
    }

    


}
