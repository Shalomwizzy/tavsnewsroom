<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ \App\Models\WebsiteSetting::getValue('site_name', config('app.name')) }} | Admin</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    {{-- LOGO --}}
    <link rel="shortcut icon" href="{{ asset($siteLogoUrl) }}">

    {{-- Font Awesome 6 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    {{-- CSS Animation --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    {{-- Apply saved theme before CSS renders to prevent flash --}}
    <script>
        (function () {
            var t = localStorage.getItem('adminTheme') || 'dark';
            document.documentElement.setAttribute('data-admin-theme', t);
        })();
    </script>

    {{-- jQuery (single copy — admin JS depends on it; Bootstrap comes from Vite app.js) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Waypoints --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>

    {{-- Moment.js + Tempus Dominus (required for inline calendar datepicker) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js"></script>

    {{-- TinyMCE --}}
    <script src="https://cdn.tiny.cloud/1/{{ config('services.tinymce.api_key') }}/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

    @if (!isset($useTinyMCE) || $useTinyMCE)
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            mergetags_list: [
                { value: 'First.Name', title: 'First Name' },
                { value: 'Email', title: 'Email' },
            ],
            ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
        });
    </script>
    @endif

    <!-- Scripts -->
    @vite([
        'resources/sass/app.scss',
        'resources/js/app.js',
        'resources/js/admin-main.js',
        'resources/js/calendar.js',
        'resources/js/todo-list.js',
        'resources/css/admin-style.css',
        'resources/css/style.css',
        'resources/css/dashboard.css',
        'resources/css/user.css',
        'resources/css/pending-news.css',
        'resources/css/published-news.css',
        'resources/css/draft.css',
        'resources/css/postnews-admin-index.css',
    ])
</head>

<body id="body" class="body">

    <div id="app">
        @include('partials.error')

        @if(auth()->check() && auth()->user()->isAdmin())
            @include('partials.admin-nav')
        @elseif(auth()->check() && auth()->user()->isWriter())
            @include('partials.writer-nav')
        @else
            <?php header('Location: ' . route('welcome')); exit(); ?>
        @endif

        <main class="py-4 body">
            @yield('content')
        </main>

        @include('partials.error')
    </div>

    <!-- Back to Top Button -->
    <div id="backToTopBtn" title="Go to top">
        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M8 256C8 119 119 8 256 8s248 111 248 248-111 248-248 248S8 393 8 256zm143.6 28.9l72.4-75.5V392c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V209.4l72.4 75.5c9.3 9.7 24.8 9.9 34.3.4l10.9-11c9.4-9.4 9.4-24.6 0-33.9L273 107.7c-9.4-9.4-24.6-9.4-33.9 0L106.3 240.4c-9.4 9.4-9.4 24.6 0 33.9l10.9 11c9.6 9.5 25.1 9.3 34.4-.4z"></path></svg>
    </div>

</body>
</html>
