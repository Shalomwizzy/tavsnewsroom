<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to {{ $settings['site_name'] }}</title>
    <style>
        body {
            font-family: Georgia, 'Times New Roman', Times, serif;
            background-color: #f1f1f1;
            margin: 0;
            padding: 0;
            width: 100%;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            text-align: center;
        }
        .email-header {
            background-color: #6C7293;
            padding: 16px;
        }
        .email-header img {
            width: 150px;
            height: 80px;
            object-fit: contain;
        }
        .email-body {
            padding: 30px 24px;
            color: #333;
            line-height: 1.7;
        }
        .email-body h2 {
            color: #DC143C;
            margin-bottom: 8px;
        }
        .cta-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 28px;
            background-color: #DC143C;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
            font-size: 15px;
            font-weight: 600;
        }
        .email-footer {
            background-color: #6C7293;
            color: #ffffff;
            padding: 16px;
            font-size: 13px;
        }
        .email-footer a {
            color: #ffffff;
            margin: 0 6px;
            text-decoration: none;
        }
        .unsubscribe {
            margin-top: 12px;
            font-size: 11px;
            color: #ddd;
        }
        .unsubscribe a {
            color: #ddd;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="email-container">

        <div class="email-header">
            @if ($settings['logo_url'])
                <a href="{{ url('/') }}">
                    <img src="{{ asset($settings['logo_url']) }}" alt="{{ $settings['site_name'] }} Logo">
                </a>
            @endif
        </div>

        <div class="email-body">
            <h2>Welcome aboard!</h2>
            <p>Thank you for subscribing to <strong>{{ $settings['site_name'] }}</strong>.</p>
            <p>You're now part of our community. We'll send you the latest news and updates straight to your inbox.</p>
            <a href="{{ url('/') }}" class="cta-btn">Explore Latest News</a>
        </div>

        <div class="email-footer">
            <div style="margin-bottom: 10px;">
                @if ($settings['twitter_link'] && $settings['twitter_link'] !== '#')
                    <a href="{{ $settings['twitter_link'] }}">X (Twitter)</a>
                @endif
                @if ($settings['facebook_link'] && $settings['facebook_link'] !== '#')
                    <a href="{{ $settings['facebook_link'] }}">Facebook</a>
                @endif
                @if ($settings['instagram_link'] && $settings['instagram_link'] !== '#')
                    <a href="{{ $settings['instagram_link'] }}">Instagram</a>
                @endif
                @if ($settings['linkedin_link'] && $settings['linkedin_link'] !== '#')
                    <a href="{{ $settings['linkedin_link'] }}">LinkedIn</a>
                @endif
            </div>
            <p>&copy; {{ date('Y') }} {{ $settings['site_name'] }}. All Rights Reserved.</p>
            <div class="unsubscribe">
                <a href="{{ route('unsubscribe', ['email' => $subscriberEmail]) }}">Unsubscribe</a>
            </div>
        </div>

    </div>
</body>
</html>
