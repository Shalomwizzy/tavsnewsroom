<?php

namespace Tests\Feature;

use App\Models\BlogSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Queue::fake();
        // RedirectIfNoUser middleware redirects to /register when no users exist
        User::factory()->create();
        // Static pages read BlogSetting records and crash on null without these
        $this->seedBlogSettings();
    }

    private function seedBlogSettings(): void
    {
        $pages = [
            'about', 'contact', 'privacy_policy', 'terms_conditions',
            'cookies_policy', 'dmca', 'disclaimer', 'advertise', 'affiliate_disclosure',
        ];
        foreach ($pages as $key) {
            BlogSetting::create([
                'key'     => $key,
                'title'   => ucwords(str_replace('_', ' ', $key)),
                'content' => '<p>Placeholder content for ' . $key . '.</p>',
            ]);
        }
    }

    public function test_homepage_loads(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_about_page_loads(): void
    {
        $response = $this->get('/about');
        $response->assertStatus(200);
    }

    public function test_contact_page_loads(): void
    {
        $response = $this->get('/contact');
        $response->assertStatus(200);
    }

    public function test_privacy_policy_loads(): void
    {
        $response = $this->get('/privacy-policy');
        $response->assertStatus(200);
    }

    public function test_terms_conditions_loads(): void
    {
        $response = $this->get('/terms-conditions');
        $response->assertStatus(200);
    }

    public function test_cookie_policy_loads(): void
    {
        $response = $this->get('/cookie-policy');
        $response->assertStatus(200);
    }

    public function test_dmca_page_loads(): void
    {
        $response = $this->get('/dmca');
        $response->assertStatus(200);
    }

    public function test_disclaimer_page_loads(): void
    {
        $response = $this->get('/disclaimer');
        $response->assertStatus(200);
    }

    public function test_home_route_redirects_to_welcome(): void
    {
        $response = $this->get('/home');
        $response->assertRedirect(route('welcome'));
    }

    public function test_categories_list_page_loads(): void
    {
        $response = $this->get('/categories/show');
        $response->assertStatus(200);
    }
}
