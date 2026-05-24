<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Queue::fake();
        // RedirectIfNoUser middleware requires at least one user to exist
        // so unauthenticated requests redirect to /login (not /register)
        User::factory()->create();
    }

    public function test_unauthenticated_user_cannot_access_admin_dashboard(): void
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('login'));
    }

    public function test_unauthenticated_user_cannot_access_post_news_index(): void
    {
        $response = $this->get('/post-news');
        $response->assertRedirect(route('login'));
    }

    public function test_unauthenticated_user_cannot_access_categories(): void
    {
        $response = $this->get('/categories');
        $response->assertRedirect(route('login'));
    }

    public function test_writer_can_access_post_news_index(): void
    {
        $writer = User::factory()->writer()->create();

        $response = $this->actingAs($writer)->get('/post-news');
        $response->assertStatus(200);
    }

    public function test_writer_can_access_create_post_news(): void
    {
        $writer = User::factory()->writer()->create();

        $response = $this->actingAs($writer)->get('/post-news/create');
        $response->assertStatus(200);
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));
        $response->assertStatus(200);
    }

    public function test_admin_can_access_website_settings(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get('/admin/website-settings');
        $response->assertStatus(200);
    }

    public function test_writer_cannot_access_admin_only_env_settings(): void
    {
        $writer = User::factory()->writer()->create();

        // AdminRoleChecker redirects non-admins rather than returning 403
        $response = $this->actingAs($writer)->get('/admin/env-settings');
        $response->assertRedirect();
    }
}
