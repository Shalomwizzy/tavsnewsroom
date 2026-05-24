<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use App\Models\EmailSettings;
use App\Models\Contact;
use Illuminate\Contracts\Queue\ShouldQueue;

class AutoReplyToContact extends Mailable
{
    use Queueable, SerializesModels;

    public $contactMessage;
    public $settings;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contactMessage, $settings)
    {
        $this->contactMessage = $contactMessage;
        $this->settings = $settings;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('admin.emails.auto-reply-to-contact')
                    ->subject('Thank you for contacting us!')
                    ->with([
                        'contactMessage' => $this->contactMessage,
                        'settings' => $this->settings,
                    ]);
    }
}













