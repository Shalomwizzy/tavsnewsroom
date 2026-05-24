@php
    $siteName  = \App\Models\WebsiteSetting::getValue('site_name', config('app.name'));
    $siteDesc  = \App\Models\WebsiteSetting::getValue('site_default_meta_description', '');
    $pageTitle = trim(View::yieldContent('meta_title'));
    $fullTitle = $pageTitle ? $pageTitle . ' | ' . $siteName : $siteName;
    $metaDesc  = trim(View::yieldContent('meta_description')) ?: $siteDesc;
    $ogImage   = trim(View::yieldContent('og_image')) ?: asset($siteLogoUrl);
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <script>
        (function(){
            var t = localStorage.getItem('theme');
            if (t === 'dark') document.documentElement.setAttribute('data-theme', 'dark');
        })();
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $metaDesc }}">
    <meta name="keywords" content="@yield('meta_keywords')">

    <!-- Title -->
    <title>{{ $fullTitle }}</title>

    <link rel="canonical" href="{{ url()->current() }}" />

    <!-- Open Graph -->
    <meta property="og:type"        content="@yield('og_type', 'website')">
    <meta property="og:title"       content="{{ $fullTitle }}">
    <meta property="og:description" content="{{ $metaDesc }}">
    <meta property="og:url"         content="{{ url()->current() }}">
    <meta property="og:image"       content="{{ $ogImage }}">
    <meta property="og:site_name"   content="{{ $siteName }}">

    <!-- Twitter / X Card -->
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="{{ $fullTitle }}">
    <meta name="twitter:description" content="{{ $metaDesc }}">
    <meta name="twitter:image"       content="{{ $ogImage }}">

    @yield('structured_data')

    <!-- RSS Autodiscovery -->
    <link rel="alternate" type="application/rss+xml" title="{{ $siteName }} RSS Feed" href="{{ route('rss') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon & PWA -->
    <link rel="icon"             type="image/svg+xml" href="{{ asset('icons/icon.svg') }}">
    <link rel="icon"             type="image/png"     href="{{ asset('icons/icon-192.png') }}" sizes="192x192">
    <link rel="apple-touch-icon"                      href="{{ asset('icons/icon-180.png') }}">
    <link rel="shortcut icon"                         href="{{ asset($siteLogoUrl) }}">
    <link rel="manifest"                              href="{{ route('pwa.manifest') }}">
    <meta name="theme-color"     content="{{ \App\Models\WebsiteSetting::getValue('theme_color', '#DC143C') }}">
    <meta name="mobile-web-app-capable"         content="yes">
    <meta name="apple-mobile-web-app-capable"   content="yes">
    <meta name="apple-mobile-web-app-title"     content="{{ $siteName }}">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">


    <!-- Font Awesome 6 -->
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"></noscript>


    @php $gaId = \App\Models\WebsiteSetting::getValue('ga_tracking_id') @endphp
    @if($gaId)
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '{{ $gaId }}');
    </script>
    @endif



    <!-- Styles -->
    @vite([
        'resources/sass/app.scss',
        'resources/js/app.js',
        'resources/js/main.js',
        'resources/css/style.css',
        'resources/css/footer.css',
        'resources/css/share-interation.css',
        'resources/css/top-news.css',
        'resources/css/welcome.css',
        'resources/css/featured-news.css',
        'resources/css/trending-news.css',
        'resources/css/popular-news.css',
        'resources/css/carousel-news.css',
        'resources/css/catpost-news.css',
        'resources/css/cookies.css',
    ])
</head>
<body>
<div id="app">
    <div class="container-fluid">
        @include('partials.topbar')
        @include('partials.navbar')
    </div>

    @include('partials.error')

    <main>
        @yield('content')
        @include('partials.cookies')
    </main>

    @include('partials.footer')
</div>

<!-- Back to Top Button -->
<div id="backToTopBtn" title="Go to top" aria-label="Back to top button">
    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
        <path d="M8 256C8 119 119 8 256 8s248 111 248 248-111 248-248 248S8 393 8 256zm143.6 28.9l72.4-75.5V392c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V209.4l72.4 75.5c9.3 9.7 24.8 9.9 34.3.4l10.9-11c9.4-9.4 9.4-24.6 0-33.9L273 107.7c-9.4-9.4-24.6-9.4-33.9 0L106.3 240.4c-9.4 9.4-9.4 24.6 0 33.9l10.9 11c9.6 9.5 25.1 9.3 34.4-.4z"></path>
    </svg>
</div>

@include('partials.pwa-install-prompt')

<!-- Service Worker Registration -->
<script>
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function () {
        navigator.serviceWorker.register('/sw.js', { scope: '/' })
            .catch(function () {});
    });
}
</script>
</body>
</html>