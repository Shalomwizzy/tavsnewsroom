<?php

namespace App\Mail;

use App\Models\EmailSettings;
use App\Models\WebsiteSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeSubscriberEmail extends Mailable
{
    use Queueable, SerializesModels;

    public array $settings;

    public function __construct(public readonly string $subscriberEmail)
    {
        $emailSettings = EmailSettings::first();

        $this->settings = [
            'logo_url'       => $emailSettings->logo_url       ?? '',
            'twitter_link'   => $emailSettings->twitter_link   ?? '#',
            'facebook_link'  => $emailSettings->facebook_link  ?? '#',
            'instagram_link' => $emailSettings->instagram_link ?? '#',
            'linkedin_link'  => $emailSettings->linkedin_link  ?? '#',
            'site_name'      => WebsiteSetting::getValue('site_name', config('app.name')),
        ];
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to ' . $this->settings['site_name'] . '!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'admin.emails.welcome-subscriber',
            with: [
                'settings'        => $this->settings,
                'subscriberEmail' => $this->subscriberEmail,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
