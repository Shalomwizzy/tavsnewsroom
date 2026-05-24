<?php

namespace Tests\Unit;

use App\Models\WebsiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class WebsiteSettingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Prevent sitemap generation during tests
        Artisan::spy();
    }

    public function test_get_value_returns_null_when_key_missing(): void
    {
        $this->assertNull(WebsiteSetting::getValue('nonexistent_key'));
    }

    public function test_get_value_returns_default_when_key_missing(): void
    {
        $value = WebsiteSetting::getValue('nonexistent_key', 'default_value');
        $this->assertSame('default_value', $value);
    }

    public function test_get_value_returns_stored_value(): void
    {
        WebsiteSetting::withoutEvents(function () {
            WebsiteSetting::create(['key' => 'site_name', 'value' => 'My News Site']);
        });

        $this->assertSame('My News Site', WebsiteSetting::getValue('site_name'));
    }

    public function test_set_value_creates_new_setting(): void
    {
        WebsiteSetting::withoutEvents(function () {
            WebsiteSetting::setValue('site_email', 'admin@example.com');
        });

        $this->assertDatabaseHas('website_settings', [
            'key'   => 'site_email',
            'value' => 'admin@example.com',
        ]);
    }

    public function test_set_value_updates_existing_setting(): void
    {
        WebsiteSetting::withoutEvents(function () {
            WebsiteSetting::create(['key' => 'site_name', 'value' => 'Old Name']);
            WebsiteSetting::setValue('site_name', 'New Name');
        });

        $this->assertSame('New Name', WebsiteSetting::getValue('site_name'));
        $this->assertDatabaseCount('website_settings', 1);
    }

    public function test_set_value_with_null_stores_empty_string(): void
    {
        WebsiteSetting::withoutEvents(function () {
            WebsiteSetting::setValue('nullable_key', null);
        });

        $this->assertDatabaseHas('website_settings', [
            'key'   => 'nullable_key',
            'value' => '',
        ]);
    }
}
