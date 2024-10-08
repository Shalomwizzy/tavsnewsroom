
@extends('layouts.admin')

@section('content')
<section>
    <div class="container-fluid py-3">
        <div class="container featured-news">
           
            <h3 class="featured-news-heading mb-4">Select Featured News</h3>
            <p>This page allows you to select up to eight (8) news articles that will be displayed in the featured news section of the homepage.</p>


            <div class="image-container text-center mb-4">
                <a href="{{ asset('admin-pictures/feature-news.png') }}" target="">
                    <img src="{{ asset('admin-pictures/feature-news.png') }}" alt="Top Bar Trending News" class="img-fluid styled-image">
                </a>
            </div>

            <form action="{{ route('admin.featured_news.update') }}" method="POST">
                @csrf
                <div class="row">
                    @foreach ($posts as $post)
                        <div class="col-lg-3 mb-4">
                            <div class="card h-100 position-relative">
                                <img src="{{ asset($post->image_url) }}" class="card-img-top" alt="{{ $post->headline }}">
                                <div class="card-body">
                                    <input class="form-check-input position-absolute start-0" type="checkbox" name="featured_news[]" value="{{ $post->id }}" {{ $post->isFeature() ? 'checked' : '' }}>
                                    <div class="overlay">
                                        <div class="mb-1" style="font-size: 13px;">
                                            <a class="text-white card-text" href="#">{{ $post->category->name }}</a>
                                            <span class="px-1 text-white card-text">/</span>
                                            <a class="text-white card-text" href="#">{{ $post->date }}</a>
                                        </div>
                                        <a class="h4 m-0 text-white card-text" href="#">{{ $post->headline }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-3">
                    <button type="submit" class="btn btn-primary">Save Selection</button>
                </div>
            </form>
        </div>
            <!-- Pagination Links -->
            <div class="d-flex justify-content-center mt-4">
                {{ $posts->links('pagination::simple-bootstrap-5') }}
            </div>
             
</section>
@endsection

