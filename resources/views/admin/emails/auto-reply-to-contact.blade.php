<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reply to Contact Message</title>
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,600,700|Lato:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
           font-family: Georgia, 'Times New Roman', Times, serif !important;
            background-color: #f1f1f1;
            margin: 0;
            padding: 0;
            width: 100%;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .email-header {
            background-color: #6C7293;
            padding: 10px;
            color: white;
        }
        .email-header img {
            width: 150px;
            height: 100px;
            object-fit: contain;
        }
        .email-body {
            padding: 20px;
        }
        .email-footer {
            background-color: #6C7293;
            color: white;
            padding: 10px;
            text-align: center;
        }
        .email-footer a {
            margin: 0 5px;
            color: white;
        }
        .email-footer a:hover {
            color: #e3342f;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            @if($settings['logo_url'])
                <a href="{{ route('welcome') }}">
                    <img src="{{ asset($settings['logo_url']) }}" alt="Website Logo">
                </a>
            @endif
        </div>
        <div class="email-body">
            <h2>Thank you for reaching out to us!</h2>
            <p>Dear {{ $contactMessage->name }},</p>
            <p>We have received your message. Our team will respond to you as soon as possible.</p>
            <p>Here is a copy of your message:</p>
            <p>{{ $contactMessage->message }}</p>
            <p>In the meantime, explore our website to discover exciting news and the latest updates. We have a lot of interesting content that you wouldn't want to miss!</p>
            <p><a href="{{ url('/') }}" class="btn btn-primary">Explore Now</a></p>
        </div>
        <div class="email-footer">
            <p>Follow us on social media for the latest updates and news.</p>
            <h2 style="margin: 0;">
                @php
                    $parts = explode(' ', $settings['site_name']);
                    echo '<span style="color: red;">' . $parts[0] . '</span>';
                    if (count($parts) > 1) {
                        echo ' <span style="color: #fff;">' . implode(' ', array_slice($parts, 1)) . '</span>';
                    }
                @endphp
            </h2>
            <div style="display: flex; justify-content: center; align-items: center; gap: 10px; flex-wrap: wrap;">
                <a href="{{ $settings['twitter_link'] ?? '#' }}" style="color: #1DA1F2;">
                    <i class="fa-brands fa-square-x-twitter fa-2x"></i>
                </a>
                <a href="{{ $settings['facebook_link'] ?? '#' }}" style="color: #1877F2;" >
                    <i class="fab fa-facebook fa-2x"></i>
                </a>
                <a href="{{ $settings['instagram_link'] ?? '#' }}" style="color: #C13584;" >
                    <i class="fab fa-instagram fa-2x"></i>
                </a>
                <a href="{{ $settings['linkedin_link'] ?? '#' }}" style="color: #0A66C2;">
                    <i class="fab fa-linkedin fa-2x"></i>
                </a>
                @if($settings['logo_url'])
                <div style="text-align: center;">
                    <a href="{{ route('welcome') }}">
                        <img src="{{ asset($settings['logo_url']) }}" alt="Website Logo" style="width: 32px; height: 32px; object-fit: contain;">
                    </a>
                </div>
            @endif
            </div>
            <div style="text-align: center; margin-top: 20px;">
                <p>&copy; {{ date('Y') }} {{ $settings['site_name'] }}. All Rights Reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>



