@extends('layouts.admin')

@section('content')
<div class="container catpostnews">
    <h2 class="h2-headline-admin">Manage Categories News</h2>
    <p class="admin-paragraph">This page allows you to select up to six (6) categories and up to six (6) news items under each category to be displayed on the homepage.</p>
    <div class="image-container text-center mb-4">
        <a href="{{ asset('admin-pictures/trending-for-body.png') }}" target="">
            <img src="{{ asset('admin-pictures/categories-news.png') }}" alt="Top Bar Trending News" class="img-fluid styled-image">
        </a>
    </div>
    <form action="{{ route('admin.categoryPostNews.update') }}" method="POST">
        @csrf
        @foreach ($categories as $category)
            <div class="mb-4">
                <input type="checkbox" name="selected_categories[]" value="{{ $category->id }}"
                       {{ $category->isSelected() ? 'checked' : '' }}>
                <h3>{{ $category->name }}</h3>
                <div class="row">
                    @foreach ($category->postNews->where('status', 'published')->take(6) as $post)
                        <div class="col-lg-4 mb-3 category-post-news">
                            <div class="card h-100">
                                <img src="{{ asset($post->image_url) }}" class="card-img-top" alt="{{ $post->headline }}">
                                <div class="card-body">
                                    <input type="checkbox" name="selected_news[{{ $category->id }}][]" value="{{ $post->id }}"
                                           {{ $post->isSelected() ? 'checked' : '' }}>
                                    <h5 class="card-title">{{ $post->headline }}</h5>
                                    <p class="card-text">{{ $post->created_at->format('Y-m-d') }}</p>
                                    <p class="card-text">{!! Str::words(strip_tags($post->content), 5) !!}</p>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
        <!-- Pagination Links for Categories -->
        <div class="d-flex justify-content-center mt-4">
            {{ $categories->links('pagination::simple-bootstrap-5') }}
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>
@endsection










{{-- @extends('layouts.admin')

@section('content')
<div class="container catpostnews">
    <h2 class="h2-headline-admin">Manage Categories News</h2>
    <p>This page allows you to select up to six (6) categories and up to six (6) news items under each category to be displayed on the homepage.</p>
    <div class="image-container text-center mb-4">
        <a href="{{ asset('admin-pictures/trending-for-body.png') }}" target="">
            <img src="{{ asset('admin-pictures/categories-news.png') }}" alt="Top Bar Trending News" class="img-fluid styled-image">
        </a>
    </div>
    <form action="{{ route('admin.categoryPostNews.update') }}" method="POST">
        @csrf
        @foreach ($categories as $category)
            <div class="mb-4">
                <input type="checkbox" name="selected_categories[]" value="{{ $category->id }}"
                       {{ $category->isSelected() ? 'checked' : '' }}>
                <h3>{{ $category->name }}</h3>
                <div class="row">
                    @foreach ($category->postNews->where('status', 'published') as $post)
                        <div class="col-lg-4 mb-3 category-post-news">
                            <div class="card h-100">
                                <img src="{{ asset($post->image_url) }}" class="card-img-top" alt="{{ $post->headline }}">
                                <div class="card-body">
                                    <input type="checkbox" name="selected_news[{{ $category->id }}][]" value="{{ $post->id }}"
                                           {{ $post->isSelected() ? 'checked' : '' }}>
                                    <h5 class="card-title">{{ $post->headline }}</h5>
                                    <p class="card-text">{{ $post->created_at->format('Y-m-d') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div> 
@endsection --}}
  
































