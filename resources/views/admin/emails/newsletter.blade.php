<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8"> <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
    <meta name="x-apple-disable-message-reformatting">  <!-- Disable auto-scale in iOS 10 Mail entirely -->
    <title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->

    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,600,700|Lato:300,400,700" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- CSS Reset : BEGIN -->
    <style>

        /* What it does: Remove spaces around the email design added by some email clients. */
        /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
            background: #f1f1f1;
        }

        /* What it does: Stops email clients resizing small text. */
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        /* What it does: Centers email on Android 4.4 */
        div[style*="margin: 16px 0"] {
            margin: 0 !important;
        }

        /* What it does: Stops Outlook from adding extra spacing to tables. */
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        /* What it does: Fixes webkit padding issue. */
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }

        /* What it does: Uses a better rendering method when resizing images in IE. */
        img {
            -ms-interpolation-mode: bicubic;
        }

        /* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
        a {
            text-decoration: none;
        }

        /* What it does: A work-around for email clients meddling in triggered links. */
        *[x-apple-data-detectors], /* iOS */
        .unstyle-auto-detected-links *,
        .aBn {
            border-bottom: 0 !important;
            cursor: default !important;
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
        .a6S {
            display: none !important;
            opacity: 0.01 !important;
        }

        /* What it does: Prevents Gmail from changing the text color in conversation threads. */
        .im {
            color: inherit !important;
        }

        /* If the above doesn't work, add a .g-img class to any image in question. */
        img.g-img + div {
            display: none !important;
        }

        /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
        /* Create one of these media queries for each additional viewport size you'd like to fix */

        /* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
        @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
            u ~ div .email-container {
                min-width: 320px !important;
            }
        }

        /* iPhone 6, 6S, 7, 8, and X */
        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
            u ~ div .email-container {
                min-width: 375px !important;
            }
        }

        /* iPhone 6+, 7+, and 8+ */
        @media only screen and (min-device-width: 414px) {
            u ~ div .email-container {
                min-width: 414px !important;
            }
        }

    </style>

    <!-- CSS Reset : END -->

    <!-- Progressive Enhancements : BEGIN -->
    <style>

        /* What it does: Hover styles for buttons */
        .primary {
            background: #e3342f;
        }

        .bg_white {
            background: #ffffff;
        }

        .bg_light {
            background: #fafafa;
        }

        .bg_black {
            background: #000000;
        }

        .bg_dark {
            background: rgba(0,0,0,.8);
        }

        .email-section {
            padding: 2.5em;
        }

        .email-h2{
         color: #ffffff !important;
         font-family: Georgia, 'Times New Roman', Times, serif !important;
        }

        .email-h3{
         font-family: Georgia, 'Times New Roman', Times, serif !important; 
         font-size: 13px;

        }

        /*BUTTON*/
        .btn {
            padding: 5px 15px;
            display: inline-block;
        }

        .btn.btn-primary {
            border-radius: 30px;
            background: #e3342f;
            color: #ffffff;
        }

        .btn.btn-white {
            border-radius: 30px;
            background: #ffffff;
            color: #000000;
        }

        .btn.btn-white-outline {
            border-radius: 30px;
            background: transparent;
            border: 1px solid #fff;
            color: #fff;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Josefin Sans', sans-serif;
            color: #000000;
            margin-top: 0;
            font-weight: 400;
        }

        body {
            font-family: 'Josefin Sans', sans-serif;
            font-weight: 400;
            font-size: 15px;
            line-height: 1.8;
            color: rgba(0,0,0,.4);
        }

        a {
            color: #e3342f;
        }

        table {}

        /*LOGO*/
        .logo {
            margin: 0;
            display: inline-block;
            position: absolute;
            top: 10px;
            left: 0;
            right: 0;
            margin-bottom: 0;
        }

        .logo a {
            color: #fff;
            font-size: 24px;
            font-weight: 700;
            text-transform: uppercase;
            font-family: 'Josefin Sans', sans-serif;
            display: inline-block;
            border: 2px solid #fff;
            line-height: 1.3;
            padding: 10px 15px 4px 15px;
            margin: 0;
        }

        .logo h1 a span {
            line-height: 1;
        }

        .navigation {
            padding: 0;
        }

        .navigation li {
            list-style: none;
            display: inline-block;
            margin-left: 5px;
            font-size: 13px;
            font-weight: 500;
        }

        .navigation li a {
            color: rgba(0,0,0,.4);
        }

        /*HERO*/
        .hero {
            position: relative;
            z-index: 0;
        }

        .hero .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            content: '';
            width: 100%;
            background: #000000;
            z-index: -1;
            opacity: .3;
        }

        .hero .text {
            color: rgba(255,255,255,.9);
        }

        .hero .text h2 {
            color: #fff;
            font-size: 40px;
            margin-bottom: 0;
            font-weight: 600;
            line-height: 1;
            text-transform: uppercase;
        }

        .hero .text h2 span {
            font-weight: 600;
            color: #e3342f;
        }

        /*HEADING SECTION*/
        .heading-section {}

        .heading-section h2 {
            color: #000000;
            font-size: 28px;
            margin-top: 0;
            line-height: 1.4;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .heading-section .subheading {
            margin-bottom: 20px !important;
            display: inline-block;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: rgba(0,0,0,.4);
            position: relative;
        }

        .heading-section .subheading::after {
            position: absolute;
            left: 0;
            right: 0;
            bottom: -10px;
            content: '';
            width: 100%;
            height: 2px;
            background: #e3342f;
            margin: 0 auto;
        }

        .heading-section-white {
            color: rgba(255,255,255,.8);
        }

        .heading-section-white h2 {
            line-height: 1;
            padding-bottom: 0;
        }

        .heading-section-white h2 {
            color: #ffffff;
        }

        .heading-section-white .subheading {
            margin-bottom: 0;
            display: inline-block;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: rgba(255,255,255,.4);
        }

        .icon {
            text-align: center;
        }

        /*SERVICES*/
        .text-services {
            padding: 10px 10px 0;
            text-align: center;
        }

        .text-services h3 {
            font-size: 20px;
        }

        /*BLOG*/
        .text-services .meta {
            text-transform: uppercase;
            font-size: 14px;
        }

        /*COUNTER*/
        .counter {
            width: 100%;
            position: relative;
            z-index: 0;
        }

        .counter .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            content: '';
            width: 100%;
            background: #e3342f;
            z-index: -1;
            opacity: .3;
        }

        .counter-text {
            text-align: center;
        }

        .counter-text .num {
            display: block;
            color: #ffffff;
            font-size: 34px;
            font-weight: 700;
        }

        .counter-text .name {
            display: block;
            color: rgba(255,255,255,.9);
            font-size: 13px;
        }

        /*FOOTER*/

        .footer {
            color: rgba(255,255,255,.5);

        }

        .footer .heading {
            color: #ffffff;
            font-size: 20px;
        }

        .footer ul {
            margin: 0;
            padding: 0;
        }

        .footer ul li {
            list-style: none;
            margin-bottom: 10px;
        }

        .footer ul li a {
            color: rgba(255,255,255,1);
    
        }

    </style>

</head>
<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly;">
    <center style="width: 100%; background-color: #f1f1f1;">
        <div style="display: none; font-size: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
            Preheader text here.
        </div>
        <div style="max-width: 600px; margin: 0 auto;" class="email-container">
            <!-- BEGIN BODY --><table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
                <h1 class="mb-2 mt-n2 display-5">
                    @if($settings && $settings->logo_url)
                    <div style="text-align: center;">
                        <a href="{{ route('welcome') }}">
                            <img src="{{ asset($settings->logo_url) }}" alt="Website Logo" style="width: 150px; height: 100px; object-fit: contain;">
                        </a>
                    </div>
                @endif
                    
                </h1>
    <!-- end tr -->
    <tr>
        <td valign="middle" class="hero" style="background-image: url({{ asset($post->image_url) }}); background-size: cover; height: 400px;">
            <div class="overlay"></div>
            <table>
                <tr>
                    <td>
                        <div class="text" style="padding: 0 4em; text-align: center;">
                            <h4 class="email-h2">New Post Alert from 
                                <span class="mb-2 mt-n2 display-5 text-uppercase admin-website-name">
                                    @php
                                        $siteName = \App\Models\WebsiteSetting::getValue('site_name', 'Site Name');
                                        // Split the site name into parts
                                        $parts = explode(' ', $siteName);
                                        // First part in red, rest in black
                                        echo '<span style="color: red;">' . $parts[0] . '</span>';
                                        if (count($parts) > 1) {
                                            echo ' <span style="color: #6C7293;">' . implode(' ', array_slice($parts, 1)) . '</span>';
                                        }
                                    @endphp
                                </span>
                            </h4>
                            <h3 class="email-h2">{{ $post->headline }}</h3>
                            <p>
                                <a href="{{ route('post-news.read-more', [
                                        'year' => \Carbon\Carbon::parse($post->date)->format('Y'),
                                        'month' => \Carbon\Carbon::parse($post->date)->format('m'),
                                        'day' => \Carbon\Carbon::parse($post->date)->format('d'),
                                        'slug' => $post->slug
                                    ]) }}" class="btn btn-primary">Read more</a>
                             
                             
                             
                            </p>
                            
                            {{-- <p><a href="{{ route('post-news.read-more', ['slug' => $post->slug]) }}" class="btn btn-primary">Read more</a></p> --}}
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <!-- end tr -->
    <tr>
        <td class="bg_white email-section" style="padding: 2.5em;">
            <div class="heading-section" style="text-align: center; padding: 0 30px;">
                <h2>Latest News</h2>
                <p>Get the latest updates and insights.</p>
            </div>
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td valign="top" width="50%" style="padding: 0 2.5em;">
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td class="text-services">
                                    <div class="meta"><p>{{ \Carbon\Carbon::parse($post->date)->format('M d, Y') }}</p></div>
                                    <img src="{{ asset($post->image_url) }}" alt="" style="width: 100%; height: auto; margin: 0 auto; display: block;">
                                    <h3>{{ $post->headline }}</h3>

                                   
                                    <p>{!! Str::limit(strip_tags($post->content), 150) !!}</p>
                                    <p>
                                        <a href="{{ route('post-news.read-more', [
                                        'year' => \Carbon\Carbon::parse($post->date)->format('Y'),
                                        'month' => \Carbon\Carbon::parse($post->date)->format('m'),
                                        'day' => \Carbon\Carbon::parse($post->date)->format('d'),
                                        'slug' => $post->slug
                                    ]) }}" class="btn btn-primary">Read more</a>
                                     
                                 
                                     
                                    </p>
                                    
                                    {{-- <p><a href="{{ route('post-news.read-more', ['slug' => $post->slug]) }}" class="btn btn-primary">Read more</a></p> --}}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <!-- end: tr -->

    @if($previousPost)
    <tr>
        <td class="bg_white email-section" style="padding: 2.5em;">
            <div class="heading-section" style="text-align: center; padding: 0 30px;">
                <h3 class="email-h3">Don't Miss Our Previous Update!</h3>

            </div>
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td valign="top" width="50%" style="padding: 0 2.5em;">
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td class="text-services">
                                    <div class="meta"><p>{{ \Carbon\Carbon::parse($previousPost->date )->format('M d, Y') }}</p></div>
                                    <img src="{{ asset($previousPost->image_url) }}" alt="" style="width: 100%; height: auto; margin: 0 auto; display: block;">
                                    <h3>{{ $previousPost->headline }}</h3>
                                    <p>{!! Str::limit(strip_tags($previousPost->content), 150) !!}</p>
                                    <p>
                                        <a href="{{ route('post-news.read-more', [
                                        'year' => \Carbon\Carbon::parse($post->date)->format('Y'),
                                        'month' => \Carbon\Carbon::parse($post->date)->format('m'),
                                        'day' => \Carbon\Carbon::parse($post->date)->format('d'),
                                        'slug' => $post->slug
                                    ]) }}" class="btn btn-primary">Read more</a>
                                     
                                    
                                     
                                    </p>
                                
                                    {{-- <p><a href="{{ route('post-news.read-more', ['slug' => $previousPost->slug]) }}" class="btn btn-primary">Read more</a></p> --}}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    @endif
    <!-- end: tr -->

    <tr>
        <td class="bg_light" style="text-align: center; padding: 2em 0; background-color: #6C7293;">
            <!-- Connect with Us Section -->
            <div style="text-align: center;">
                <p style="margin-bottom: 5px;">Connect with us</p>
                <h2 style="margin: 0;">
                    @php
                        $siteName = \App\Models\WebsiteSetting::getValue('site_name', 'Site Name');
                        $parts = explode(' ', $siteName);
                        echo '<span style="color: red;">' . $parts[0] . '</span>';
                        if (count($parts) > 1) {
                            echo ' <span style="color: #fff;">' . implode(' ', array_slice($parts, 1)) . '</span>';
                        }
                    @endphp
                </h2>
            </div>
    
            <!-- Social Media Links and Logo -->
            <div style="display: flex; justify-content: center; align-items: center; gap: 10px; flex-wrap: wrap;">
                <a href="{{ $settings->twitter_link ?? '#' }}" style="color: #1DA1F2;">
                    <i class="fa-brands fa-square-x-twitter fa-2x"></i>
                </a>
                <a href="{{ $settings->facebook_link ?? '#' }}" style="color: #1877F2;">
                    <i class="fab fa-facebook fa-2x"></i>
                </a>
                <a href="{{ $settings->instagram_link ?? '#' }}" style="color: #C13584;">
                    <i class="fab fa-instagram fa-2x"></i>
                </a>
                <a href="{{ $settings->linkedin_link ?? '#' }}" style="color: #0A66C2;">
                    <i class="fab fa-linkedin fa-2x"></i>
                </a>
                @if($settings && $settings->logo_url)
                <div style="text-align: center;">
                    <a href="{{ route('welcome') }}">
                        <img src="{{ asset($settings->logo_url) }}" alt="Website Logo" style="width: 32px; height: 32px; object-fit: contain;">
                    </a>
                </div>
            @endif
                {{-- @if($settings->logo_url)
                <div style="text-align: center;">
                    <a href="{{ route('welcome') }}">
                        <img src="{{ asset($settings->logo_url) }}" alt="Website Logo" style="width: 32px; height: 32px; object-fit: contain;">
                    </a>
                </div>
            @endif --}}
            </div>
    
            <!-- Unsubscribe Section -->
            <div style="text-align: center; margin-top: 20px;">
                <p><a href="{{ url('unsubscribe?email=' . urlencode($email)) }}" class="btn btn-white-outline">Unsubscribe</a></p>
            </div>
    
            <!-- Footer Section -->
            <div style="text-align: center; margin-top: 20px;">
                <p>&copy; {{ date('Y') }} {{ $siteName }}. All Rights Reserved.</p>
            </div>
        </td>
    </tr>
</table>




        </div>
    </center>
</body>
</html>