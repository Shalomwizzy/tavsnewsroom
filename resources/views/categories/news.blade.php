@extends('layouts.app')

@section('content')

<!-- Breadcrumb Start -->
<div class="container-fluid">
    <div class="container">
        <nav class="breadcrumb bg-transparent m-0 p-0">
            <a class="breadcrumb-item" href="{{ route('welcome') }}">Home</a>
            <a class="breadcrumb-item" href="{{ route('categories.index') }}">Categories</a>
            <span class="breadcrumb-item active">{{ $category->name }}</span>
        </nav>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- News With Sidebar Start -->
<div class="container-fluid py-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                @foreach($posts as $post)
                                <div class="col-lg-6 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title h5-headline">
                                                <a href="{{ route('post-news.read-more', [
                                                    'year' => \Carbon\Carbon::parse($post->date)->format('Y'),
                                                    'month' => \Carbon\Carbon::parse($post->date)->format('m'),
                                                    'day' => \Carbon\Carbon::parse($post->date)->format('d'),
                                                    'slug' => $post->slug
                                                ]) }}">{{ $post->headline }}</a>
                                            </h5>
                                            {{-- <h5 class="card-title h5-headline">
                                                <a href="{{ route('post-news.read-more', $post->slug) }}">{{ $post->headline }}</a>
                                            </h5> --}}
                                            <p class="card-text">
                                                <span style="color: red;">{{ $post->category->name }}</span> / Date: {{ \Carbon\Carbon::parse($post->date)->format('Y-m-d') }}
                                            </p>
                                            <img src="{{ asset($post->image_url) }}" alt="{{ $post->headline }}" class="img-fluid mb-3" style="width: 100%; height: 200px; object-fit: cover;">
                                            <p class="card-text flex-grow-1">{!! Str::limit($post->content, 200) !!}</p>
                                            <a href="{{ route('post-news.read-more', [
                                                'year' => \Carbon\Carbon::parse($post->date)->format('Y'),
                                                'month' => \Carbon\Carbon::parse($post->date)->format('m'),
                                                'day' => \Carbon\Carbon::parse($post->date)->format('d'),
                                                'slug' => $post->slug
                                            ]) }}" class="btn btn-primary mt-auto">Read More</a>
                                            {{-- <a href="{{ route('post-news.read-more', $post->slug) }}" class="btn btn-primary mt-auto">Read More</a> --}}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            {{ $posts->links('pagination::simple-bootstrap-5') }}
                        </div>
                    </div>
                </div>
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
                            <a href="{{ $socialFollow->url }}" class="d-block py-2 px-3 text-white text-decoration-none" style="background: {{ $socialFollow->getBackgroundColor() }};">
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
                <input type="email" name="email" class="form-control form-control-lg subscriber-input"  placeholder= "Your Email" required>

                <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                <div class="input-group-append">
                    <button class="btn btn-primary newsletter-signup" type="submit">Sign Up</button>
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
                            <a href="{{ route('category.show', $tag->category->slug) }}" class="btn btn-sm btn-outline-secondary m-1">
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

@endsection

