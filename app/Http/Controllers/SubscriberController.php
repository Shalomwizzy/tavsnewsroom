<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;
use App\Mail\SendMailToSubscribers;
use App\Models\PostNews;
use App\Models\EmailSettings;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;


class SubscriberController extends Controller
{
    public function subscribe(Request $request)
    {
        // Validate form inputs and reCAPTCHA
        $validatedData = $request->validate([
            'email' => 'required|email|unique:subscribers,email',
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

        // Store subscriber email
        Subscriber::create(['email' => $request->email]);

        return redirect()->back()->with('success', 'Thank you for subscribing! Get ready for awesome updates!');
    }

    // public function subscribe(Request $request)
    // {
    //     $request->validate(['email' => 'required|email|unique:subscribers,email']);

    //     Subscriber::create(['email' => $request->email]);

    //   return redirect()->back()->with('success', 'Thank you for subscribing! Get ready for awesome updates!');

    // }



    // Add unsubscribe method in SubscriberController
public function unsubscribe(Request $request)
{
    $email = $request->query('email');
    if ($email) {
        Subscriber::where('email', $email)->delete();
        return redirect()->route('home')->with('success', 'You have been unsubscribed successfully.');
    }

    return redirect()->route('home')->with('error', 'Invalid unsubscribe request.');
}

public function index()
{
    $subscribers = Subscriber::paginate(20); // Paginate with 10 subscribers per page
    return view('admin.subscribers.index', compact('subscribers'));
}


    public function create()
   {
    return view('admin.subscribers.create-mail');
    }


    public function sendMail(Request $request)
    {
        $request->validate(['message' => 'required']);
    
        // Assuming you have a way to retrieve the settings, e.g., from a database
           // Retrieve email settings
           $settings = [
            'logo_url' => EmailSettings::getValue('logo_url'),
            'twitter_link' => EmailSettings::getValue('twitter_link'),
            'facebook_link' => EmailSettings::getValue('facebook_link'),
            'instagram_link' => EmailSettings::getValue('instagram_link'),
            'linkedin_link' => EmailSettings::getValue('linkedin_link'),
            'site_name' => EmailSettings::getValue('site_name', 'Site Name')
        ];

    
        $subscribers = Subscriber::all();
        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->send(new SendMailToSubscribers($request->message, $settings));
        }
    
        return redirect()->back()->with('success', 'Emails sent successfully!');
    }
}
