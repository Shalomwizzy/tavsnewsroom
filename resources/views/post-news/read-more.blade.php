@extends('layouts.app')

@section('meta_title', $post->meta_title)
@section('meta_description', $post->meta_description)
@section('meta_keywords', $post->meta_keywords)

@isset($metaTags)
    @foreach ($metaTags as $key => $value)
        <meta property="{{ $key }}" content="{{ $value }}">
    @endforeach
@endisset
@section('content')

<!-- Breadcrumb Start -->
<div class="container-fluid">
    <div class="container">
        <nav class="breadcrumb bg-transparent m-0 p-0">
            <a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
            <a class="breadcrumb-item" href="{{ route('categories.show', ['id' => $post->category->slug]) }}">{{ $post->category->name }}</a>
            {{-- <span class="breadcrumb-item active">{{ $post->headline }}</span> --}}
        </nav>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- News With Sidebar Start -->
<div class="container-fluid py-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="card-title readmore-headline">{{ $post->headline }}</h2>
                        <p class="card-text allnews-headline">
                            <span class="allnews-headline" style="color: red;">{{ $post->category->name }}</span> / Date:  {{ \Carbon\Carbon::parse($post->date)->format('m-d-Y') }}
                        </p>
                        <img 
                            src="{{ asset($post->image_url) }}" 
                            alt="{{ $post->headline }}" 
                            class="img-fluid mb-3" 
                            loading="lazy" 
                            fetchpriority="high"
                            sizes="(max-width: 768px) 100vw, 50vw"
                            srcset="{{ asset($post->image_url) }} 600w, {{ asset($post->image_url) }} 1200w"
                        >
                        <p class="card-text">{!! $post->content !!}</p>

                   <!-- Share Button Start -->
<div class="share-buttons mt-3">
    <h5>Share this post:</h5>
    <div class="row">
        <div class="col-12 col-md-6 col-lg-4 mb-2">
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}&quote={{ urlencode($post->headline) }}" 
               target="_blank" 
               class="btn btn-primary share-button w-100" 
               data-share-type="facebook" 
               style="background-color: #3b5998; border-color: #3b5998;">
                <i class="fab fa-facebook-f"></i> Facebook
            </a>
        </div>
        <div class="col-12 col-md-6 col-lg-4 mb-2">
            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ $post->headline }}" 
               target="_blank" 
               class="btn btn-info share-button w-100" 
               data-share-type="twitter" 
               style="background-color: #1DA1F2; border-color: #1DA1F2;">
                <i class="fab fa-twitter"></i> Twitter
            </a>
        </div>
        <div class="col-12 col-md-6 col-lg-4 mb-2">
            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->fullUrl()) }}&title={{ $post->headline }}" 
               target="_blank" 
               class="btn btn-success share-button w-100" 
               data-share-type="linkedin" 
               style="background-color: #0077B5; border-color: #0077B5;">
                <i class="fab fa-linkedin-in"></i> LinkedIn
            </a>
        </div>
        <div class="col-12 col-md-6 col-lg-4 mb-2">
            <a href="https://api.whatsapp.com/send?text={{ urlencode($post->headline . ' ' . request()->fullUrl()) }}" 
               target="_blank" 
               class="btn btn-success share-button w-100" 
               data-share-type="whatsapp" 
               style="background-color: #25D366; border-color: #25D366;">
                <i class="fab fa-whatsapp"></i> WhatsApp
            </a>
        </div>
        <div class="col-12 col-md-6 col-lg-4 mb-2">
            <a href="https://telegram.me/share/url?url={{ urlencode(request()->fullUrl()) }}&text={{ $post->headline }}" 
               target="_blank" 
               class="btn btn-info share-button w-100" 
               data-share-type="telegram" 
               style="background-color: #0088cc; border-color: #0088cc;">
                <i class="fab fa-telegram-plane"></i> Telegram
            </a>
        </div>
        <div class="col-12 col-md-6 col-lg-4 mb-2">
            <a href="https://www.tumblr.com/widgets/share/tool?canonicalUrl={{ urlencode(request()->fullUrl()) }}&title={{ $post->headline }}" 
               target="_blank" 
               class="btn btn-primary share-button w-100" 
               data-share-type="tumblr" 
               style="background-color: #35465c; border-color: #35465c;">
                <i class="fab fa-tumblr"></i> Tumblr
            </a>
        </div>
    </div>
</div>
<!-- Share Button End -->


                    </div>
                </div>
                
                <!-- Related News Start -->
                <div class="related-news pt-3">
                    <h2 class="mb-3 h2-headline">Related News</h2>
                    <div class="row">
                        @foreach ($relatedNews as $related)
                            <div class="col-lg-6 mb-3 search-result">
                                <div class="card related-news">
                                    <img 
                                        class="card-img-top" 
                                        src="{{ asset($related->image_url) }}" 
                                        alt="{{ $related->headline }}" 
                                        loading="lazy" 
                                        fetchpriority="low"
                                        sizes="(max-width: 768px) 100vw, 50vw"
                                        srcset="{{ asset($related->image_url) }} 600w, {{ asset($related->image_url) }} 1200w"
                                    >
                                    <div class="card-body">
                                        <h5 class="card-title h5-headline">
                                            <a 
                                            href="{{ route('post-news.read-more', [
                                                'month' => \Carbon\Carbon::parse($related->date)->format('m'),
                                                'day' => \Carbon\Carbon::parse($related->date)->format('d'),
                                                'year' => \Carbon\Carbon::parse($related->date)->format('Y'),
                                                'slug' => $related->slug
                                            ]) }}" 
                                            aria-label="{{ $related->headline }}"
                                        >
                                            {{ $related->headline }}
                                        </a>
                                        
                                        </h5>
                                        <p class="card-text">{!! Str::limit($related->content, 220) !!}</p>

                                        <a class="related-readmore-button"
                                        href="{{ route('post-news.read-more', [
                                            'month' => \Carbon\Carbon::parse($related->date)->format('m'),
                                            'day' => \Carbon\Carbon::parse($related->date)->format('d'),
                                            'year' => \Carbon\Carbon::parse($related->date)->format('Y'),
                                            'slug' => $related->slug
                                        ]) }}" 
                                        class="btn btn-primary" 
                                        aria-label="Read more about {{ $related->headline }}"
                                    >
                                        Read More
                                    </a>
                                    
                                    </div>
                                   
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Related News End -->
                
            </div>

            <div class="col-lg-4 pt-3 pt-lg-0">

                <!-- Social Follow Start -->
                <div class="pb-3">
                    <div class="bg-light py-2 px-4 mb-3">
                        <h3 class="m-0">Follow Us</h3>
                    </div>
                    <div class="row">
                        @foreach ($socialFollows as $socialFollow)
                        <div class="col-6 mb-3">
                            <a 
                                href="{{ $socialFollow->url }}" 
                                class="d-block py-2 px-3 text-white text-decoration-none" 
                                style="background: {{ $socialFollow->getBackgroundColor() }};"
                                aria-label="{{ $socialFollow->followers }} {{ $socialFollow->getFollowersLabel() }} on {{ $socialFollow->name }}"
                            >
                                <small class="fab {{ $socialFollow->icon_class }} mr-2"></small>
                                <small>{{ $socialFollow->followers }} {{ $socialFollow->getFollowersLabel() }}</small>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- Social Follow End -->

                <!-- Newsletter Start -->
                <div class="pb-3">
                    <div class="bg-light py-2 px-4 mb-3">
                        <h2 class="m-0 h2-headline">Newsletter</h2>
                    </div>
                    <div class="bg-light text-center p-4 mb-3">
                        <p class="subscriber-text">Subscribe to our newsletter to stay updated with our latest news and offers.</p>
                        <form action="{{ route('subscribe') }}" method="POST">
                            @csrf
                            <div class="input-group" style="width: 100%;">
                                <input 
                                    type="email" 
                                    name="email" 
                                    class="form-control form-control-lg subscriber-input" 
                                    placeholder="Your Email" 
                                    required
                                    aria-label="Your Email Address"
                                >

                                <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                                <div class="input-group-append">
                                    <button 
                                        class="btn btn-primary newsletter-signup" 
                                        type="submit"
                                        aria-label="Sign Up for Newsletter"
                                    >
                                        Sign Up
                                    </button>
                                </div>
                            </div>
                        </form>
                        <small>We respect your privacy.</small>
                    </div>
                </div>
                <!-- Newsletter End -->

                <!-- Ads Start -->
                <div class="mb-3 pb-3">
                    @include('home-page.partials.ads')
                </div>
                <!-- Ads End -->

                <!-- Trending News Start -->
                <div class="pb-3">
                    <div class="bg-dark py-2 px-4 mb-3">
                        <h3 class="m-0 text-white">Trending</h3>
                    </div>
                    @foreach ($trendingNews as $news)
                        @if ($news->section == 'body')
                            <div 
                                class="d-flex mb-3" 
                                aria-label="Trending News Item: {{ $news->postNews->headline }}"
                            >
                                <img 
                                    src="{{ asset($news->postNews->image_url) }}" 
                                    width="100" 
                                    height="100" 
                                    style="object-fit: cover;" 
                                    loading="lazy" 
                                    fetchpriority="high" 
                                    alt="{{ $news->postNews->headline }} - Image"
                                >
                                <div 
                                    class="w-100 d-flex flex-column justify-content-center bg-light px-3" 
                                    style="height: 100px;"
                                >
                                    <div 
                                        class="mb-1 trending-top-headline" 
                                        style="font-size: 13px;"
                                    >
                                         <a class="trending-top-headline"
                                            href="{{ route('category.show', $news->postNews->category->slug) }}"
                                            class="text-white"
                                            aria-label="Category: {{ $news->postNews->category->name }}"
                                        >
                                            {{ $news->postNews->category->name }}
                                        </a>
                                        <span class="px-1">/</span>
                                        <span 
                                            aria-label="Date: {{ \Carbon\Carbon::parse($news->postNews->date)->format('M d, Y') }}"
                                        >
                                            {{ \Carbon\Carbon::parse($news->postNews->date)->format('M d, Y') }}
                                        </span>
                                    </div>
                                    <a 
                                        class="h4 m-0 trending-small-headline" 
                                        href="{{ route('post-news.read-more', [
                                           
                                            'month' => \Carbon\Carbon::parse($news->postNews->date)->format('m'),
                                            'day' => \Carbon\Carbon::parse($news->postNews->date)->format('d'),
                                             'year' => \Carbon\Carbon::parse($news->postNews->date)->format('Y'),
                                            'slug' => $news->postNews->slug
                                        ]) }}"
                                        aria-label="{{ $news->postNews->headline }}"
                                    >
                                        {{ $news->postNews->headline }}
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                {{-- Trending End --}}
                
              
                   <!-- Tags Start -->
                   <div class="pb-3">
                    <div class="bg-light py-2 px-4 mb-3">
                        <h3 class="m-0">Tags</h3>
                    </div>
                    <div class="d-flex flex-wrap m-n1">
                        @foreach ($tags as $tag)
                        <a href="{{ route('category.show', $tag->category->slug) }}" class="btn btn-sm btn-outline-secondary m-1" style="color: #333; border-color: #333; background-color: #fff;" aria-label="Tag: {{ $tag->category->name }}">
                            {{ $tag->category->name }}
                        </a>
                        @endforeach
                    </div>
                </div>
                <!-- Tags End -->
                
             
              
                
            </div>
        </div>
    </div>
</div>
<!-- News With Sidebar End -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.share-button').forEach(function (button) {
            button.addEventListener('click', function () {
                // Pass the post ID dynamically from Blade to JavaScript
                let postId = {{ json_encode($post->id) }};
                let shareType = this.getAttribute('data-share-type');
                
                // Use fetch to make a POST request
                fetch(`/post-news/${postId}/share`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ share_type: shareType })
                }).then(response => response.json())
                  .then(data => {
                      if (data.message) {
                          console.log(data.message);
                      }
                  }).catch(error => {
                      console.error('Error sharing the post:', error);
                  });
            });
        });
    });
</script>

@endsection




















































































