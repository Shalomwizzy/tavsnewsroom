<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use App\Models\EmailSettings;
use Illuminate\Queue\SerializesModels;

class ReplyToContact extends Mailable
{
    use Queueable, SerializesModels;

    public $replyMessage;
    public $settings;

    /**
     * Create a new message instance.
     */
    public function __construct($replyMessage)
    {
        $this->replyMessage = $replyMessage;
        $this->settings = EmailSettings::first();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $siteName = \App\Models\WebsiteSetting::getValue('site_name', 'Website');

        return new Envelope(
            subject: "Reply to Your Contact Message from $siteName"
        );
    }

    /**
     * Get the message content definition.
     */
    public function build()
    {
        return $this->view('admin.emails.reply-to-contact')
                    ->with([
                        'replyMessage' => $this->replyMessage,
                        'settings' => $this->settings,
                    ]);
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
