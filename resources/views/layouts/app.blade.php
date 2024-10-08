<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Default description')">
    <meta name="keywords" content="@yield('meta_keywords', 'default, keywords')">

    <!-- Title -->
    <title>@yield('meta_title', config('app.name', 'Default App Name'))</title>




    @isset($metaTags)
    <meta property="og:url" content="{{ $metaTags['og_url'] }}">
    <meta property="og:type" content="{{ $metaTags['og_type'] }}">
    <meta property="og:title" content="{{ $metaTags['og_title'] }}">
    <meta property="og:description" content="{{ $metaTags['og_description'] }}">
    <meta property="og:image" content="{{ $metaTags['og_image'] }}">
    @isset($metaTags['og_image_width'])
        <meta property="og:image:width" content="{{ $metaTags['og_image_width'] }}">
    @endisset
    @isset($metaTags['og_image_height'])
        <meta property="og:image:height" content="{{ $metaTags['og_image_height'] }}">
    @endisset
    
    <meta name="twitter:card" content="{{ $metaTags['twitter_card'] }}">
    <meta name="twitter:title" content="{{ $metaTags['twitter_title'] }}">
    <meta name="twitter:description" content="{{ $metaTags['twitter_description'] }}">
    <meta name="twitter:image" content="{{ $metaTags['twitter_image'] }}">
@endisset

    <link rel="canonical" href="https://www.tavsnewsroom.com/" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Logo -->
    <link rel="shortcut icon" href="{{ asset($siteLogoUrl) }}" loading="lazy">

    {{-- Google Recaptpha --}}
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>


    <!-- Preload Critical CSS -->
    <link rel="preload" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"></noscript>

    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet"></noscript>

    <!-- Defer Non-essential Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" defer></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" defer></script>

     <!-- Icons -->
     <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon_io/apple-touch-icon.png') }}">
     <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
     <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
     <link rel="manifest" href="{{ asset('site.webmanifest') }}">


 
 

    {{-- <script src="js/jquery.waypoints.min.js"></script> --}}


    <!-- Google tag (gtag.js) with Consent Mode -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-4Q4Y273STF"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    </script>

     <!-- Owl Carousel CSS Preload -->
     <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
     <noscript><link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" rel="stylesheet"></noscript>
 
     <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
     <noscript><link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" rel="stylesheet"></noscript>
 
     <!-- Lazy-load Owl Carousel Script -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" defer></script>




    
    <!-- Styles -->
    @vite([
        'resources/sass/app.scss',
        'resources/js/app.js',
        'resources/js/admin-main.js',
        'resources/js/main.js',
        'resources/js/calendar.js', 
        'resources/js/todo-list.js',
        'resources/css/app.css',
        'resources/css/style.css',
        'resources/css/dashboard.css',
        'resources/css/user.css',
        'resources/css/footer.css',
        'resources/css/pending-news.css',
        'resources/css/published-news.css',
        'resources/css/draft.css',
        'resources/css/postnews-admin-index.css',
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
        @include('cookie-consent::index')
        {{-- @include('partials.cookies') --}}
    </main>

    @include('partials.footer')
</div>

<!-- Back to Top Button -->
<div id="backToTopBtn" title="Go to top" aria-label="Back to top button">
    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
        <path d="M8 256C8 119 119 8 256 8s248 111 248 248-111 248-248 248S8 393 8 256zm143.6 28.9l72.4-75.5V392c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V209.4l72.4 75.5c9.3 9.7 24.8 9.9 34.3.4l10.9-11c9.4-9.4 9.4-24.6 0-33.9L273 107.7c-9.4-9.4-24.6-9.4-33.9 0L106.3 240.4c-9.4 9.4-9.4 24.6 0 33.9l10.9 11c9.6 9.5 25.1 9.3 34.4-.4z"></path>
    </svg>
</div>

<!-- Initialize Owl Carousel -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('.owl-carousel').owlCarousel({
            loop: false,
            margin: 10,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 4
                }
            }
        });

        // Passive event listeners for improved scroll performance
        let supportsPassive = false;
        try {
            const options = {
                get passive() {
                    supportsPassive = true;
                    return false;
                }
            };
            window.addEventListener('test', null, options);
        } catch (err) {}

        document.addEventListener('touchstart', function(e) {
            // Your code here
        }, supportsPassive ? { passive: true } : false);

        document.addEventListener('touchmove', function(e) {
            // Your code here
        }, supportsPassive ? { passive: true } : false);

        document.addEventListener('wheel', function(e) {
            // Your code here
        }, supportsPassive ? { passive: true } : false);
    });
</script>

<!-- Lazy-load Images -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var lazyImages = [].slice.call(document.querySelectorAll("img.lazyload"));
        if ("IntersectionObserver" in window) {
            let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        let lazyImage = entry.target;
                        lazyImage.src = lazyImage.dataset.src;
                        lazyImageObserver.unobserve(lazyImage);
                    }
                });
            });

            lazyImages.forEach(function(lazyImage) {
                lazyImageObserver.observe(lazyImage);
            });
        } else {
            // Fallback for browsers without IntersectionObserver support
            lazyImages.forEach(function(lazyImage) {
                lazyImage.src = lazyImage.dataset.src;
            });
        }
    });
</script>
</body>
</html>