<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Queue::fake();
        Mail::fake();
        // RedirectIfNoUser middleware redirects to /register when no users exist
        User::factory()->create();
    }

    public function test_valid_contact_submission_stores_message(): void
    {
        $payload = [
            'name'        => 'John Doe',
            'email'       => 'john@example.com',
            'subject'     => 'Test Subject',
            'message'     => 'This is a test message.',
            '_honeypot'   => '',
            '_form_time'  => (string) (time() - 10),
        ];

        $response = $this->post('/contact', $payload);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('contacts', [
            'email'   => 'john@example.com',
            'subject' => 'Test Subject',
        ]);
    }

    public function test_missing_name_fails_validation(): void
    {
        $response = $this->post('/contact', [
            'email'       => 'john@example.com',
            'subject'     => 'Test',
            'message'     => 'Hello',
            '_honeypot'   => '',
            '_form_time'  => (string) (time() - 10),
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_missing_email_fails_validation(): void
    {
        $response = $this->post('/contact', [
            'name'        => 'John',
            'subject'     => 'Test',
            'message'     => 'Hello',
            '_honeypot'   => '',
            '_form_time'  => (string) (time() - 10),
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_invalid_email_fails_validation(): void
    {
        $response = $this->post('/contact', [
            'name'        => 'John',
            'email'       => 'not-an-email',
            'subject'     => 'Test',
            'message'     => 'Hello',
            '_honeypot'   => '',
            '_form_time'  => (string) (time() - 10),
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_honeypot_blocks_bot_without_storing(): void
    {
        $response = $this->post('/contact', [
            'name'        => 'Bot',
            'email'       => 'bot@example.com',
            'subject'     => 'Spam',
            'message'     => 'Spam message',
            '_honeypot'   => 'filled-by-bot',
            '_form_time'  => (string) (time() - 10),
        ]);

        // Honeypot returns success redirect to fool bots, but nothing is stored
        $response->assertRedirect();
        $this->assertDatabaseCount('contacts', 0);
    }

    public function test_too_fast_submission_blocked(): void
    {
        $response = $this->post('/contact', [
            'name'        => 'Fast Bot',
            'email'       => 'fast@example.com',
            'subject'     => 'Fast',
            'message'     => 'Too fast',
            '_honeypot'   => '',
            '_form_time'  => (string) time(), // submitted right now = 0 seconds elapsed
        ]);

        // Timer check returns fake success but stores nothing
        $response->assertRedirect();
        $this->assertDatabaseCount('contacts', 0);
    }
}
