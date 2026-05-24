@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 carousel-news ">
           
                <h2 class="carousel-news-heading mb-4">Select Carousel News</h2>
                <p>This page allows you to select up to six (6) news articles that will be displayed in the carousel section of the homepage.</p>

                <div class="image-container text-center mb-4">
                    <a href="{{ asset('admin-pictures/carousel-news.png') }}" target="">
                        <img src="{{ asset('admin-pictures/carousel-news.png') }}" alt="Top Bar Trending News" class="img-fluid styled-image">
                    </a>
                </div>
            
            <form action="{{ route('admin.carousel.update') }}" method="POST">
                @csrf
                <div class="row ">
                    @foreach ($posts as $post)
                        <div class="col-lg-3 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <input class="form-check-input" type="checkbox" name="carousel_news[]" value="{{ $post->id }}" {{ $post->isFeatured() ? 'checked' : '' }}>
                                    <label class="form-check-label" for="post{{ $post->id }}">
                                        <img src="{{ asset($post->image_url) }}" alt="{{ $post->headline }}" class="img-fluid mb-3">
                                        <p class="card-text"><strong>Category:</strong> {{ $post->category->name }}</p>
                                        <p class="card-text"><strong>Date:</strong> {{ $post->date }}</p>
                                        <p class="card-text">{{ $post->headline }}</p>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary mt-3">Save Selection</button>
            </form>
           

        </div>
          <!-- Pagination Links -->
          <div class="d-flex justify-content-center mt-4">
            {{ $posts->links('pagination::simple-bootstrap-5') }}
        </div>

             
    </div>
</div>
@endsection



