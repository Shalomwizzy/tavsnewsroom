@extends('layouts.admin')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-12">
        
            <div class="top-news-admin">
                <h2>Select Top News</h2>
                <p>On this page, you can select up to eight (8) top news items that will be featured prominently on the welcome page. Each news item is displayed with its image and headline. Simply check the box next to each news item you want to mark as top news.</p>
                {{-- <div class="image-container text-center mb-4">
                    <img src="{{ asset('admin-pictures/top-news.png') }}" alt="Top Bar Trending News" class="img-fluid">
                </div> --}}

                <div class="image-container text-center mb-4">
                    <a href="{{ asset('admin-pictures/top-news.png') }}" target="">
                        <img src="{{ asset('admin-pictures/top-news.png') }}" alt="Top Bar Trending News" class="img-fluid ">
                    </a>
                </div>
                <form action="{{ route('admin.top-news.update') }}" method="POST">
                    @csrf
                    <div class="row">
                        @foreach ($posts as $post)
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <img src="{{ asset($post->image_url) }}" class="card-img-top" alt="{{ $post->headline }}" style="height: 200px; object-fit: cover; border-radius: 8px 8px 0 0;">
                                <div class="card-body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="top_news[]" value="{{ $post->id }}" id="post{{ $post->id }}" {{ $post->topNews ? 'checked' : '' }}>
                                        <label class="form-check-label" for="post{{ $post->id }}">
                                            <h5 class="card-title">{{ $post->headline }}</h5>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Save Selection</button>
                </form>

                  <!-- Pagination Links -->
                  <div class="d-flex justify-content-center mt-4">
                    {{ $posts->links('pagination::simple-bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


