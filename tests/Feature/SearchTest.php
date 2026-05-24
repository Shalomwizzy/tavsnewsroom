<?php

namespace Tests\Feature;

use App\Models\PostNews;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Queue::fake();
        // RedirectIfNoUser middleware redirects to /register when no users exist
        User::factory()->create();
    }

    public function test_empty_search_query_redirects_with_error(): void
    {
        $response = $this->get('/search');
        $response->assertRedirect();
        $response->assertSessionHasErrors();
    }

    public function test_search_returns_published_results(): void
    {
        PostNews::factory()->published()->create([
            'headline' => 'Laravel Testing Guide',
        ]);

        $response = $this->get('/search?query=Laravel');

        $response->assertStatus(200);
        $response->assertSee('Laravel Testing Guide');
    }

    public function test_search_does_not_return_draft_posts(): void
    {
        PostNews::factory()->draft()->create([
            'headline' => 'Secret Draft Article',
        ]);

        $response = $this->get('/search?query=Secret');

        $response->assertStatus(200);
        $response->assertDontSee('Secret Draft Article');
    }

    public function test_search_does_not_return_pending_posts(): void
    {
        PostNews::factory()->pending()->create([
            'headline' => 'Pending News Item',
        ]);

        $response = $this->get('/search?query=Pending News');

        $response->assertStatus(200);
        $response->assertDontSee('Pending News Item');
    }

    public function test_search_with_no_results_shows_page(): void
    {
        $response = $this->get('/search?query=xyznonexistent123');

        $response->assertStatus(200);
    }
}
