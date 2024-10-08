<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Mail\ReplyToContact;
use Illuminate\Support\Facades\Mail;
use App\Models\WebsiteSetting;
use App\Mail\AutoReplyToContact;
use App\Models\EmailSettings;
use App\Mail\ContactMessageToAdmin;
use Illuminate\Support\Facades\Http;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // Validate form inputs and reCAPTCHA
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'g-recaptcha-response' => 'required',
        ]);

        // Validate reCAPTCHA with Google's API
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        if (!json_decode($response->body())->success) {
            return back()->withErrors(['captcha' => 'reCAPTCHA verification failed.']);
        }

        // Store contact message
        $contactMessage = Contact::create($validatedData);

        // Retrieve email settings
        $settings = [
            'logo_url' => EmailSettings::getValue('logo_url'),
            'twitter_link' => EmailSettings::getValue('twitter_link'),
            'facebook_link' => EmailSettings::getValue('facebook_link'),
            'instagram_link' => EmailSettings::getValue('instagram_link'),
            'linkedin_link' => EmailSettings::getValue('linkedin_link'),
            'site_name' => EmailSettings::getValue('site_name', 'Site Name')
        ];

        // Send auto-reply and admin notification emails
        Mail::to($contactMessage->email)->send(new AutoReplyToContact($contactMessage, $settings));
        $adminEmail = WebsiteSetting::getValue('site_email');
        if ($adminEmail) {
            Mail::to($adminEmail)->send(new ContactMessageToAdmin($contactMessage, $settings));
        }

        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }

    public function showAllMessages()
    {
        $messages = Contact::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.dashboard.contact-index', compact('messages'));
    }

    public function replyToMessage(Request $request, $id)
    {
        $request->validate(['reply' => 'required|string|max:1000']);
        $message = Contact::find($id);

        if ($message) {
            Mail::to($message->email)->send(new ReplyToContact($request->reply));
            return redirect()->back()->with('success', 'Reply sent successfully!');
        } else {
            return redirect()->back()->with('error', 'Message not found.');
        }
    }
}


// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\Contact;
// use App\Mail\ReplyToContact;
// use Illuminate\Support\Facades\Mail;
// use App\Models\WebsiteSetting;
// use App\Mail\AutoReplyToContact;
// use App\Models\EmailSettings;
// use App\Mail\ContactMessageToAdmin;

// class ContactController extends Controller
// {

//     public function store(Request $request)
//     {
//         $validatedData = $request->validate([
//             'name' => 'required|string|max:255',
//             'email' => 'required|email|max:255',
//             'subject' => 'required|string|max:255',
//             'message' => 'required|string',
//         ]);
    
//         $contactMessage = Contact::create($validatedData);
    
//         // Retrieve email settings
//         $settings = [
//             'logo_url' => EmailSettings::getValue('logo_url'),
//             'twitter_link' => EmailSettings::getValue('twitter_link'),
//             'facebook_link' => EmailSettings::getValue('facebook_link'),
//             'instagram_link' => EmailSettings::getValue('instagram_link'),
//             'linkedin_link' => EmailSettings::getValue('linkedin_link'),
//             'site_name' => EmailSettings::getValue('site_name', 'Site Name')
//         ];
    
//         // Send automatic reply email
//         Mail::to($contactMessage->email)->send(new AutoReplyToContact($contactMessage, $settings));
    
//         // Get admin email from settings
//         $adminEmail = WebsiteSetting::getValue('site_email');
    
//         // Check if admin email is available and send email to admin
//         if ($adminEmail) {
//             Mail::to($adminEmail)->send(new ContactMessageToAdmin($contactMessage, $settings));
//         }
    
//         return redirect()->back()->with('success', 'Your message has been sent successfully!');
//     }
    




//     public function showAllMessages()
// {
//     $messages = Contact::orderBy('created_at', 'desc')->get();
//     return view('admin.dashboard.contact-index', compact('messages'));
// }

// public function replyToMessage(Request $request, $id)
// {
//     $message = Contact::find($id);

//     if ($message) {
//         // Send the reply email
//         Mail::to($message->email)->send(new ReplyToContact($request->reply));

//         return redirect()->back()->with('success', 'Reply sent successfully!');
//     } else {
//         return redirect()->back()->with('error', 'Message not found.');
//     }

// }
// }
