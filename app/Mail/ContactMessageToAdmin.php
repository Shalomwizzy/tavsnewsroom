<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessageToAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $contactMessage;
    public $settings;

    public function __construct(Contact $contactMessage, $settings)
    {
        $this->contactMessage = $contactMessage;
        $this->settings = $settings;
    }

    public function build()
    {
        return $this->view('admin.emails.contact-message-to-admin')
                    ->with([
                        'contactMessage' => $this->contactMessage,
                        'settings' => $this->settings
                    ])
                    ->subject('New Contact Message Received');
    }
}
