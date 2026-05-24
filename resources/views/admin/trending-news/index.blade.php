@extends('layouts.admin')

@section('content')
<div class="container trending-news">
    <div class="row">
        <div class="col-lg-12 ">
            <h2 class="trending-news-heading mb-4">Select Trending News</h2>
            <p>This page allows you to select up to eight (8) news articles that will be displayed in the trending sections of the homepage.</p>
            <form action="{{ route('admin.trending-news.update') }}" method="POST">
                @csrf
                    
                    {{-- Top Section --}}
                 
                <div class="card mb-4">
                    <div class="card-body">
                       
                       
                        <p class="card-title admin-paragraph">This allows you to select up to eight trending news that appear at the top bar of the homepage</p>
                        <div class="image-container text-center mb-4">
                            <a href="{{ asset('admin-pictures/top-bar-trending-news.png') }}" target="">
                                <img src="{{ asset('admin-pictures/top-bar-trending-news.png') }}" alt="Top Bar Trending News" class="img-fluid">
                            </a>
                        </div>

                        <div class="row">
                            @foreach ($posts as $post)
                                <div class="col-lg-3 mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="top_trending_news[]" value="{{ $post->id }}" id="topPost{{ $post->id }}" {{ in_array($post->id, $topSelectedNewsIds) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="topPost{{ $post->id }}">
                                            <h5 class="card-title trending-news-h5">{{ $post->headline }}</h5>
                                            <p class="card-text"><strong>Category:</strong> {{ $post->category->name }}</p>
                                            <p class="card-text"><strong>Date:</strong> {{ $post->date }}</p>
                                            <p class="card-text"><strong>Section:</strong> Top of Homepage</p>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                          <!-- Pagination Links for Top Section -->
                          <div class="d-flex justify-content-center mt-4">
                            {{ $posts->links('pagination::simple-bootstrap-5') }}
                        </div>
                    </div>
                </div>
                <hr><hr><hr><hr><hr>






                {{-- Body Section --}}
                <div class="card mb-4">
                    <div class="card-body">
                    


                        <h4 class="card-title admin-paragraph">This allows you to select up to eight (8) trending news that appear in the body of the homepage</h4>
                        <div class="image-container text-center mb-4">
                            <a href="{{ asset('admin-pictures/trending-for-body.png') }}" target="">
                                <img src="{{ asset('admin-pictures/trending-for-body.png') }}" alt="Top Bar Trending News" class="img-fluid styled-image">
                            </a>
                        </div>
                        
                        <div class="row">
                            @foreach ($posts as $post)
                                <div class="col-lg-3 mb-4">
                                    <div class="card h-100">
                                        <img src="{{ asset($post->image_url) }}" class="card-img-top" alt="{{ $post->headline }}">
                                        <div class="card-body">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="body_trending_news[]" value="{{ $post->id }}" id="bodyPost{{ $post->id }}" {{ in_array($post->id, $bodySelectedNewsIds) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="bodyPost{{ $post->id }}">
                                                    <h5 class="card-title trending-news-h5">{{ $post->headline }}</h5>
                                                    <p class="card-text"><strong>Category:</strong> {{ $post->category->name }}</p>
                                                    <p class="card-text"><strong>Date:</strong> {{ $post->date }}</p>
                                                    <p class="card-text"><strong>Section:</strong> Body of Homepage</p>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                          <!-- Pagination Links for Body Section -->
                          <div class="d-flex justify-content-center mt-4">
                            {{ $posts->links('pagination::simple-bootstrap-5') }}
                        </div>
                    </div>
                </div>



                <button type="submit" class="btn btn-primary mt-3">Save Selection</button>
            </form>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
    const image = document.querySelector('.zoomable-image');
    
    image.addEventListener('click', function () {
        if (this.style.transform === 'scale(1.5)') {
            this.style.transform = 'scale(1)';
        } else {
            this.style.transform = 'scale(1.5)';
        }
    });
});

</script>
@endsection








































{{-- @extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 trending-news">
            <h2 class="trending-news-heading mb-4">Select Trending News</h2>
            <p>This page allows you to select news articles that will be displayed in the trending section of the homepage.</p>
            <form action="{{ route('admin.trending-news.update') }}" method="POST">
                @csrf
                <div class="row">
                    @foreach ($posts as $post)
                        <div class="col-lg-3 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="selected_news[]" value="{{ $post->id }}" id="post{{ $post->id }}" {{ in_array($post->id, $selectedNewsIds) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="post{{ $post->id }}">
                                            <h5 class="card-title">{{ $post->headline }}</h5>
                                            <p class="card-text"><strong>Category:</strong> {{ $post->category->name }}</p>
                                            <p class="card-text"><strong>Date:</strong> {{ $post->date }}</p>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary mt-3">Save Selection</button>
            </form>
        </div>
    </div>
</div>
@endsection  --}}






