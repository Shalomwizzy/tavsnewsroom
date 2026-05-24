@extends('layouts.app')

@section('meta_title', $author->username . ' — Author')
@section('meta_description', $author->bio ? Str::limit($author->bio, 160) : 'Articles by ' . $author->username)

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Author card -->
        <div class="col-12 mb-5">
            <div class="d-flex align-items-center gap-4 flex-wrap">
                @if ($author->profile_picture)
                    <img
                        src="{{ asset($author->profile_picture) }}"
                        alt="{{ $author->username }}"
                        class="rounded-circle"
                        width="100" height="100"
                        style="object-fit:cover;"
                        loading="lazy"
                    >
                @else
                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                         style="width:100px;height:100px;background:var(--accent-color,#DC143C);flex-shrink:0;">
                        <i class="fa fa-user fa-2x text-white"></i>
                    </div>
                @endif
                <div>
                    <h1 class="h2 mb-1">{{ $author->username }}</h1>
                    @if ($author->isAdmin())
                        <span class="badge bg-danger mb-2">Editor</span>
                    @elseif ($author->isWriter())
                        <span class="badge bg-secondary mb-2">Writer</span>
                    @endif
                    @if ($author->bio)
                        <p class="mb-0 text-muted">{{ $author->bio }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Articles -->
        <div class="col-12">
            <h2 class="h4 mb-4">Articles by {{ $author->username }}</h2>

            @if ($posts->isEmpty())
                <p class="text-muted">No published articles yet.</p>
            @else
                <div class="row g-4">
                    @foreach ($posts as $post)
                        <div class="col-12 col-sm-6 col-lg-4">
                            <div class="card h-100 shadow-sm">
                                @if ($post->image_url)
                                    <img
                                        src="{{ asset($post->image_url) }}"
                                        alt="{{ $post->headline }}"
                                        class="card-img-top"
                                        style="height:180px;object-fit:cover;"
                                        width="576" height="180"
                                        loading="lazy"
                                    >
                                @endif
                                <div class="card-body d-flex flex-column">
                                    @if ($post->is_breaking)
                                        <span class="badge breaking-badge mb-2 align-self-start">BREAKING</span>
                                    @endif
                                    <h3 class="h6 card-title">
                                        <a href="{{ route('post-news.read-more', [
                                            'year'  => $post->date->year,
                                            'month' => $post->date->month,
                                            'day'   => $post->date->day,
                                            'slug'  => $post->slug,
                                        ]) }}" class="text-decoration-none stretched-link">
                                            {{ $post->headline }}
                                        </a>
                                    </h3>
                                    <p class="card-text text-muted small mb-0 mt-auto">
                                        {{ $post->date->format('M d, Y') }}
                                        <span class="ms-2"><i class="fa fa-eye"></i> {{ number_format($post->post_views_count) }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
