<?php

namespace Tests\Unit;

use App\Models\PostNews;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class PostNewsModelTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Queue::fake();
    }

    public function test_post_news_can_be_created(): void
    {
        $post = PostNews::factory()->create();
        $this->assertDatabaseHas('post_news', ['id' => $post->id]);
    }

    public function test_draft_post_has_draft_status(): void
    {
        $post = PostNews::factory()->draft()->create();
        $this->assertSame('draft', $post->status);
    }

    public function test_pending_post_has_pending_status(): void
    {
        $post = PostNews::factory()->pending()->create();
        $this->assertSame('pending', $post->status);
    }

    public function test_published_post_has_published_status(): void
    {
        $post = PostNews::factory()->published()->create();
        $this->assertSame('published', $post->status);
    }

    public function test_post_belongs_to_category(): void
    {
        $post = PostNews::factory()->create();
        $this->assertNotNull($post->category);
    }

    public function test_is_featured_returns_false_when_not_featured(): void
    {
        $post = PostNews::factory()->create();
        $this->assertFalse($post->isFeatured());
    }

    public function test_is_popular_returns_false_when_not_popular(): void
    {
        $post = PostNews::factory()->create();
        $this->assertFalse($post->isPopular());
    }

    public function test_is_latest_returns_false_when_not_in_latest(): void
    {
        $post = PostNews::factory()->create();
        $this->assertFalse($post->isLatest());
    }

    public function test_get_date_attribute_returns_carbon_instance(): void
    {
        $post = PostNews::factory()->create(['date' => '2024-01-15']);
        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $post->date);
    }

    public function test_slug_is_unique(): void
    {
        $post1 = PostNews::factory()->create();
        $post2 = PostNews::factory()->create();
        $this->assertNotSame($post1->slug, $post2->slug);
    }
}
