@extends('layouts.app')

@section('content')

<!-- Breadcrumb Start -->
<div class="container-fluid cate-breadcrumb">
    <div class="container">
        <nav class="breadcrumb bg-transparent m-0 p-0">
            <a class="breadcrumb-item" href="{{ route('welcome') }}">Home</a>
            <span class="breadcrumb-item active">Categories</span>
        </nav>
    </div>
</div>
<!-- Breadcrumb End -->

<div class="container-fluid py-3">
    <div class="container">
        <div class="row">
            <!-- Categories Section -->
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>Categories</h2>
                    </div>
                </div>

                <div class="row">
                    @foreach ($categories as $category)
                    <div class="col-lg-6 mb-3">
                        <div class="card h-100">
                            <a href="{{ route('category.show', $category->slug) }}">
                                <img src="{{ asset($category->image) }}" class="card-img-top" alt="{{ $category->name }}" style="height: 150px; object-fit: cover;">
                            </a>
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="{{ route('category.show', $category->slug) }}">{{ $category->name }}</a>
                                </h5>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                {{ $categories->links('pagination::simple-bootstrap-5') }}
            </div>

            <!-- Sidebar Section -->
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
                        <h3 class="m-0">Newsletter</h3>
                    </div>
                    <div class="bg-light text-center p-4 mb-3">
                        <p>Subscribe to our newsletter for the latest updates.</p>
                        <form action="{{ route('subscribe') }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="email" name="email" class="form-control form-control-lg" placeholder="Your Email" required>
                                <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">Sign Up</button>
                                </div>
                            </div>
                        </form>
                        <small>We respect your privacy.</small>
                    </div>
                </div>
                <!-- Newsletter End -->

                <!-- Trending News Start -->
                <div class="pb-3">
                    <div class="bg-dark py-2 px-4 mb-3">
                        <h3 class="m-0 text-white">Trending</h3>
                    </div>
                    @foreach ($trendingNews as $news)
                    <div class="d-flex mb-3">
                        <img src="{{ asset($news->postNews->image_url) }}" width="100" height="100" style="object-fit: cover;" alt="{{ $news->postNews->headline }}">
                        <div class="w-100 d-flex flex-column justify-content-center bg-light px-3">
                            <div class="mb-1" style="font-size: 13px;">
                                <a href="{{ route('category.show', $news->postNews->category->slug) }}">{{ $news->postNews->category->name }}</a>
                                <span class="px-1">/</span>
                                <span>{{ \Carbon\Carbon::parse($news->postNews->date)->format('M d, Y') }}</span>
                            </div>
                            <a href="{{ route('post-news.read-more', [
                                'year' => \Carbon\Carbon::parse($news->postNews->date)->format('Y'),
                                'month' => \Carbon\Carbon::parse($news->postNews->date)->format('m'),
                                'day' => \Carbon\Carbon::parse($news->postNews->date)->format('d'),
                                'slug' => $news->postNews->slug
                            ]) }}">
                                {{ $news->postNews->headline }}
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- Trending News End -->

                <!-- Tags Start -->
                <div class="pb-3">
                    <div class="bg-light py-2 px-4 mb-3">
                        <h3 class="m-0">Tags</h3>
                    </div>
                    <div class="d-flex flex-wrap m-n1">
                        @foreach ($tags as $tag)
                        <a href="{{ route('category.show', $tag->category->slug) }}" class="btn btn-sm btn-outline-secondary m-1">{{ $tag->category->name }}</a>
                        @endforeach
                    </div>
                </div>
                <!-- Tags End -->
            </div>
        </div>
    </div>
</div>

@endsection














































{{-- @extends('layouts.app')

@section('content')
<!-- Breadcrumb Start -->
<div class="container-fluid cate-breadcrumb">
    <div class="container">
        <nav class="breadcrumb bg-transparent m-0 p-0">
            <a class="breadcrumb-item" href="{{ route('welcome') }}">Home</a>
            <span class="breadcrumb-item active">Categories</span>
        </nav>
    </div>
</div>
<!-- Breadcrumb End -->

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h2>Categories</h2>
        </div>
    </div>

    <div class="row">
        @foreach ($categories as $category)
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100">
                <a href="{{ route('category.show', $category->slug) }}">
                    <img src="{{ asset($category->image) }}" class="card-img-top" alt="{{ $category->name }}" style="height: 150px; object-fit: cover;">
                </a>
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="{{ route('category.show', $category->slug) }}">{{ $category->name }}</a>
                    </h5>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection --}}




{{-- <a href="{{ route('categories.show', $navbarItem->category->slug) }}" class="nav-item nav-link">
    {{ $navbarItem->category->name }}
</a> --}}

