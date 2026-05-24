<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\EmailSettings;
use Illuminate\Mail\Mailables\Envelope;
class SendMailToSubscribers extends Mailable
{
    use Queueable, SerializesModels;

    public $messageContent;
    public $settings;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($messageContent, $settings)
    {
        $this->messageContent = $messageContent;
        $this->settings = $settings;
    }

    public function envelope(): Envelope
    {
        $siteName = \App\Models\WebsiteSetting::getValue('site_name', 'Website');

        return new Envelope(
            subject: "$siteName"
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('admin.emails.send-mail-to-subscribers')
                    ->with([
                        'messageContent' => $this->messageContent,
                        'settings' => $this->settings,
                    ]);
    }
}
