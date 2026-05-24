@extends('layouts.app')

@section('meta_title', 'My Saved Articles')
@section('meta_description', 'Your bookmarked articles.')

@section('content')
<div class="container-fluid py-3">
    <div class="container">

        <div class="d-flex align-items-center justify-content-between mb-3" style="background-color: #f8f9fa; padding: 12px 16px;">
            <h1 style="margin: 0; font-size: 24px; font-weight: 600;">My Saved Articles</h1>
        </div>

        @if ($bookmarks->isEmpty())
            <p class="text-muted">You have no saved articles yet. Click <strong>Save Article</strong> on any article to bookmark it.</p>
        @else
            <div class="row">
                @foreach ($bookmarks as $bookmark)
                    @if ($bookmark->postNews)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            <img
                                src="{{ asset($bookmark->postNews->image_url) }}"
                                alt="{{ $bookmark->postNews->headline }}"
                                class="card-img-top"
                                style="object-fit: cover; height: 180px;"
                                loading="lazy"
                            >
                            <div class="card-body d-flex flex-column">
                                @if ($bookmark->postNews->is_breaking)
                                    <span class="badge breaking-badge mb-2">BREAKING</span>
                                @endif
                                <small class="text-muted mb-1">
                                    {{ $bookmark->postNews->category->name ?? '' }}
                                    &middot;
                                    {{ \Carbon\Carbon::parse($bookmark->postNews->date)->format('M d, Y') }}
                                </small>
                                <h5 class="card-title" style="font-size: 15px; font-weight: 600;">
                                    <a href="{{ route('post-news.read-more', [
                                        'year'  => \Carbon\Carbon::parse($bookmark->postNews->date)->format('Y'),
                                        'month' => \Carbon\Carbon::parse($bookmark->postNews->date)->format('m'),
                                        'day'   => \Carbon\Carbon::parse($bookmark->postNews->date)->format('d'),
                                        'slug'  => $bookmark->postNews->slug,
                                    ]) }}" style="color: #222; text-decoration: none;">
                                        {{ $bookmark->postNews->headline }}
                                    </a>
                                </h5>
                                <p class="card-text text-muted mt-auto" style="font-size: 13px;">
                                    {{ Str::limit(strip_tags($bookmark->postNews->content), 100) }}
                                </p>
                                <a href="{{ route('post-news.read-more', [
                                    'year'  => \Carbon\Carbon::parse($bookmark->postNews->date)->format('Y'),
                                    'month' => \Carbon\Carbon::parse($bookmark->postNews->date)->format('m'),
                                    'day'   => \Carbon\Carbon::parse($bookmark->postNews->date)->format('d'),
                                    'slug'  => $bookmark->postNews->slug,
                                ]) }}" class="btn btn-sm btn-danger mt-2" style="background-color: #DC143C;">
                                    Read More
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>

            {{ $bookmarks->links('pagination::simple-bootstrap-5') }}
        @endif

    </div>
</div>
@endsection
