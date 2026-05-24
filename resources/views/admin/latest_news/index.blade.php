@extends('layouts.admin')

@section('content')


<section>
    <div class="container-fluid py-3">
        <div class="container latest-news">
            <h2 class="h2-headline-admin mb-4">Select Latest News</h2>
            <p class="admin-paragraph">This page allows you to select up to eight (8) news articles that will be displayed in the latest news section of the homepage.</p>
            <div class="image-container text-center mb-4">
                <a href="{{ asset('admin-pictures/latest-news.png') }}" target="">
                    <img src="{{ asset('admin-pictures/latest-news.png') }}" alt="Top Bar Trending News" class="img-fluid styled-image">
                </a>
            </div>
            <form action="{{ route('admin.latest_news.update') }}" method="POST">
                @csrf
                <div class="row">
                    @foreach ($posts as $post)
                    <div class="col-lg-3 mb-4">
                        <div class="card h-100 position-relative">
                            <input class="form-check-input" type="checkbox" name="latest_news[]" value="{{ $post->id }}" {{ $post->isLatest() ? 'checked' : '' }}>
                            <img src="{{ asset($post->image_url) }}" class="card-img-top" alt="{{ $post->headline }}">
                            <div class="card-body">
                                <div class="mb-1" style="font-size: 13px;">
                                    <a class="text-dark card-text" href="#">{{ $post->category->name }}</a>
                                    <span class="px-1 text-dark card-text">/</span>
                                    <a class="text-dark card-text" href="#">{{ $post->date }}</a>
                                </div>
                                <h4 class="card-title">{{ $post->headline }}</h4>
                                <p class="card-text">{!! Str::words(strip_tags($post->content), 15) !!}</p>

                                {{-- <p class="card-text">{{ Str::words($post->content, 15) }}</p> --}}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-3">
                    <button type="submit" class="btn btn-primary">Save Selection</button>
                </div>
            </form>

               <!-- Pagination Links -->
               <div class="d-flex justify-content-center mt-4">
                {{ $posts->links('pagination::simple-bootstrap-5') }}
            </div>
        </div>
    </div>
</section>
@endsection
