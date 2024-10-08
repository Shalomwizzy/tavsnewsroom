<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

     {{-- font awesome --}}
     <script src="https://kit.fontawesome.com/cc71075486.js" crossorigin="anonymous"></script>

      {{-- Jquery --}}
      <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

       {{-- LOGO --}}
    <link rel="shortcut icon" href="{{ asset($siteLogoUrl) }}">

    {{-- Chart . Js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- <script src="/node_modules/chart.js/dist/chart.cjs"></script> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.0.0-beta.7/chart.min.js" integrity="sha512-nV0W6KwUluEo8yQzZ+V/Hj39QOVlcwcgvcrV0fAcvdcqzPZjT9le1WPzS9CYngJx5vUdzADJHOXiUtpKMBxXdQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>





<!-- Waypoints Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>




       {{-- Javascript --}}

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

   <!-- Latest Bootstrap JS -->
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

   <!-- jQuery -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
   
   <!-- Tempus Dominus JS -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js"></script>



     <!-- Owl Carousel CSS Preload -->
     <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
     <noscript><link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" rel="stylesheet"></noscript>
 


    <script src="https://cdn.tiny.cloud/1/n3xzyq33q4z1xk17shiq3i4o7o0o701buqfmnzkbq221vn3i/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>


    {{-- CSS ANIMATION --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

        <!-- Include TinyMCE script only if $useTinyMCE is not set to false -->
        @if (!isset($useTinyMCE) || $useTinyMCE)
        {{-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> --}}
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
    // SCSS
    'resources/sass/app.scss', 
    
    // JS
    'resources/js/app.js',
    'resources/js/admin-main.js',
    'resources/js/main.js',
    'resources/js/calendar.js',
    'resources/js/todo-list.js',

    // CSS
    'resources/css/admin-style.css',
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
    'resources/css/featured-news.css',
    'resources/css/trending-news.css',
    'resources/css/popular-news.css',
    'resources/css/carousel-news.css',
    'resources/css/catpost-news.css',
    ])
     
</head>



<body id="body" class="body">
     
    <div id="app">
        {{-- @include('partials.admin-nav') --}}
        @include('partials.error')

  <!-- Conditionally include the appropriate navigation -->
@if(auth()->check() && auth()->user()->isAdmin())
@include('partials.admin-nav')
@elseif(auth()->check() && auth()->user()->isWriter())
@include('partials.writer-nav')
@else
<?php
// Redirect to the welcome page
header('Location: ' . route('welcome'));
exit();
?>
@endif


        
        {{-- @include('partials.topbar') --}}

        <main class="py-4 body">
            @yield('content')
        </main>

        @include('partials.error')

        {{-- @include('partials.footer') --}}
    </div>


           <!-- Back to Top Button -->
         <div id="backToTopBtn" title="Go to top">
            {{-- <i class="fas fa-arrow-up"></i> --}}
            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M8 256C8 119 119 8 256 8s248 111 248 248-111 248-248 248S8 393 8 256zm143.6 28.9l72.4-75.5V392c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V209.4l72.4 75.5c9.3 9.7 24.8 9.9 34.3.4l10.9-11c9.4-9.4 9.4-24.6 0-33.9L273 107.7c-9.4-9.4-24.6-9.4-33.9 0L106.3 240.4c-9.4 9.4-9.4 24.6 0 33.9l10.9 11c9.6 9.5 25.1 9.3 34.4-.4z"></path></svg>
        </div>
   
 
</body>
</html>
