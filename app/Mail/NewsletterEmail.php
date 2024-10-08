<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use App\Models\PostNews;
use App\Models\EmailSettings;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $post;
    public $settings;
    public $email;
    public $previousPost;

    /**
     * Create a new message instance.
     */
    public function __construct(PostNews $post, string $email)
    {
        if ($post->status !== 'published') {
            throw new \InvalidArgumentException('Only published posts can be used.');
        }

        $this->post = $post;
        $this->settings = EmailSettings::first();
        $this->email = $email;
        $this->previousPost = PostNews::where('status', 'published')
                                      ->where('id', '<', $post->id)
                                      ->orderBy('id', 'desc')
                                      ->first();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $siteName = \App\Models\WebsiteSetting::getValue('site_name', 'Website');

        return new Envelope(
            subject: $siteName . ' - ' . $this->post->headline,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'admin.emails.newsletter',
            with: [
                'post' => $this->post,
                'settings' => $this->settings,
                'email' => $this->email,
                'previousPost' => $this->previousPost,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}