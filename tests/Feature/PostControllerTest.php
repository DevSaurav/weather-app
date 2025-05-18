<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    #[Test]
    public function it_creates_a_post(): void
    {
        $payload = [
            'title' => 'Test Post',
            'content' => 'This is a test post.'
        ];

        $response = $this->actingAs($this->user, 'sanctum')
            ->postJson('/api/posts', $payload);

        $response->assertCreated()
            ->assertJsonFragment(['title' => 'Test Post']);

        $this->assertDatabaseHas('posts', ['title' => 'Test Post']);
    }

    #[Test]
    public function it_validates_post_creation(): void
    {
        $response = $this->actingAs($this->user, 'sanctum')
            ->postJson('/api/posts', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'content']);
    }

    #[Test]
    public function it_updates_a_post(): void
    {
        $post = Post::factory()->for($this->user)->create();

        $response = $this->actingAs($this->user, 'sanctum')
            ->patchJson("/api/posts/{$post->id}", [
                'title' => 'Updated Title'
            ]);

        $response->assertOk()
            ->assertJsonFragment(['title' => 'Updated Title']);

        $this->assertDatabaseHas('posts', ['title' => 'Updated Title']);
    }

    #[Test]
    public function it_deletes_a_post(): void
    {
        $post = Post::factory()->for($this->user)->create();

        $response = $this->actingAs($this->user, 'sanctum')
            ->deleteJson("/api/posts/{$post->id}");

        $response->assertNoContent();

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}