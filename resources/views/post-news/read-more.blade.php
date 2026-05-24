@extends('layouts.app')

@section('meta_title', $post->meta_title ?: $post->headline)
@section('meta_description', $post->meta_description ?: Str::limit(strip_tags($post->content), 160))
@section('meta_keywords', $post->meta_keywords)
@section('og_type', 'article')
@section('og_image', asset($post->image_url))

@section('structured_data')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "NewsArticle",
  "headline": {{ json_encode($post->headline) }},
  "description": {{ json_encode($post->meta_description ?: Str::limit(strip_tags($post->content), 160)) }},
  "image": ["{{ asset($post->image_url) }}"],
  "datePublished": "{{ \Carbon\Carbon::parse($post->date)->toIso8601String() }}",
  "dateModified": "{{ $post->updated_at->toIso8601String() }}",
  "author": {
    "@type": "Person",
    "name": {{ json_encode($post->author->username ?? 'Admin') }}
  },
  "publisher": {
    "@type": "Organization",
    "name": {{ json_encode(\App\Models\WebsiteSetting::getValue('site_name', config('app.name'))) }},
    "logo": {
      "@type": "ImageObject",
      "url": "{{ asset($siteLogoUrl) }}"
    }
  },
  "url": "{{ url()->current() }}"
}
</script>
@endsection

@section('content')

<!-- Reading Progress Bar -->
<div id="reading-progress" style="position:fixed;top:0;left:0;height:3px;width:0%;background:var(--accent-color,#e63946);z-index:9999;transition:width 0.1s linear;"></div>
<script>
(function(){
    window.addEventListener('scroll', function(){
        var el = document.getElementById('reading-progress');
        if (!el) return;
        var scrollTop = window.scrollY;
        var docHeight = document.documentElement.scrollHeight - window.innerHeight;
        el.style.width = (docHeight > 0 ? (scrollTop / docHeight) * 100 : 0) + '%';
    }, {passive: true});
})();
</script>

<!-- Breadcrumb Start -->
<div class="container-fluid">
    <div class="container">
        <nav class="breadcrumb bg-transparent m-0 p-0">
            <a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
            <a class="breadcrumb-item" href="{{ route('categories.show', ['id' => $post->category->slug]) }}">{{ $post->category->name }}</a>
            {{-- <span class="breadcrumb-item active">{{ $post->headline }}</span> --}}
        </nav>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- News With Sidebar Start -->
<div class="container-fluid py-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-3">
                    <div class="card-body">
                        @if ($post->is_breaking)
                            <span class="badge breaking-badge">BREAKING</span>
                        @endif
                        <h2 class="card-title readmore-headline">{{ $post->headline }}</h2>
                        <p class="card-text allnews-headline">
                            <span class="allnews-headline" style="color: red;">{{ $post->category->name }}</span>
                            @if ($post->author)
                                <span class="mx-1">/</span>
                                <a href="{{ route('author.show', $post->author->username) }}" class="text-decoration-none">
                                    {{ $post->author->username }}
                                </a>
                            @endif
                            <span class="mx-1">/</span>
                            {{ \Carbon\Carbon::parse($post->date)->format('M d, Y') }}
                            <span class="mx-1">/</span>
                            <span class="reading-time-badge">
                                <i class="fa fa-clock"></i> {{ $post->reading_time }} min read
                            </span>
                            <span class="mx-1">/</span>
                            <span class="reading-time-badge">
                                <i class="fa fa-eye"></i> {{ number_format($post->post_views_count) }} views
                            </span>
                        </p>
                        <img 
                            src="{{ asset($post->image_url) }}" 
                            alt="{{ $post->headline }}" 
                            class="img-fluid mb-3" 
                            loading="lazy" 
                            fetchpriority="high"
                            sizes="(max-width: 768px) 100vw, 50vw"                        >
                        <p class="card-text">{!! $post->content !!}</p>

                   <!-- Bookmark Button Start -->
@auth
<div class="mt-3">
    <button
        id="bookmark-btn"
        class="btn bookmark-btn {{ $isBookmarked ? 'bookmarked' : '' }}"
        data-post-id="{{ $post->id }}"
        data-url="{{ route('bookmarks.toggle', $post->id) }}"
        aria-label="{{ $isBookmarked ? 'Remove bookmark' : 'Save article' }}"
    >
        <i class="fa {{ $isBookmarked ? 'fa-bookmark' : 'fa-bookmark' }}"></i>
        <span>{{ $isBookmarked ? 'Saved' : 'Save Article' }}</span>
    </button>
</div>
@endauth
<!-- Bookmark Button End -->

<!-- Share Button Start -->
<div class="share-buttons mt-3">
    <h5>Share this post:</h5>
    <div class="row">
        <div class="col-12 col-md-6 col-lg-4 mb-2">
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}&quote={{ urlencode($post->headline) }}"
               target="_blank"
               class="btn share-button share-btn-facebook w-100"
               data-share-type="facebook">
                <i class="fab fa-facebook-f"></i> Facebook
            </a>
        </div>
        <div class="col-12 col-md-6 col-lg-4 mb-2">
            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ $post->headline }}"
               target="_blank"
               class="btn share-button share-btn-x w-100"
               data-share-type="twitter">
                <i class="fa-brands fa-x-twitter"></i> X
            </a>
        </div>
        <div class="col-12 col-md-6 col-lg-4 mb-2">
            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->fullUrl()) }}&title={{ $post->headline }}"
               target="_blank"
               class="btn share-button share-btn-linkedin w-100"
               data-share-type="linkedin">
                <i class="fab fa-linkedin-in"></i> LinkedIn
            </a>
        </div>
        <div class="col-12 col-md-6 col-lg-4 mb-2">
            <a href="https://api.whatsapp.com/send?text={{ urlencode($post->headline . ' ' . request()->fullUrl()) }}"
               target="_blank"
               class="btn share-button share-btn-whatsapp w-100"
               data-share-type="whatsapp">
                <i class="fab fa-whatsapp"></i> WhatsApp
            </a>
        </div>
        <div class="col-12 col-md-6 col-lg-4 mb-2">
            <a href="https://telegram.me/share/url?url={{ urlencode(request()->fullUrl()) }}&text={{ $post->headline }}"
               target="_blank"
               class="btn share-button share-btn-telegram w-100"
               data-share-type="telegram">
                <i class="fab fa-telegram-plane"></i> Telegram
            </a>
        </div>
        <div class="col-12 col-md-6 col-lg-4 mb-2">
            <a href="https://www.tumblr.com/widgets/share/tool?canonicalUrl={{ urlencode(request()->fullUrl()) }}&title={{ $post->headline }}"
               target="_blank"
               class="btn share-button share-btn-tumblr w-100"
               data-share-type="tumblr">
                <i class="fab fa-tumblr"></i> Tumblr
            </a>
        </div>
    </div>
</div>
<!-- Share Button End -->

<!-- Print Button Start -->
<div class="mt-3 d-print-none">
    <button onclick="window.print()" class="btn btn-outline-secondary btn-sm">
        <i class="fa fa-print me-1"></i> Print Article
    </button>
</div>
<!-- Print Button End -->

                    </div>
                </div>

                <!-- Comments Start -->
                @if ($commentsEnabled)
                <div class="comments-section mt-4 mb-3">
                    <h3 class="mb-3">Comments ({{ $comments->count() }})</h3>

                    @if (session('comment_success'))
                        <div class="alert alert-success">{{ session('comment_success') }}</div>
                    @endif

                    @forelse ($comments as $comment)
                        <div class="comment-item mb-3 p-3" style="background:#f8f9fa; border-left: 3px solid #DC143C;">
                            <div class="d-flex justify-content-between mb-1">
                                <strong>{{ $comment->name }}</strong>
                                <small class="text-muted">{{ $comment->created_at->format('M d, Y \a\t g:i A') }}</small>
                            </div>
                            <p class="mb-0">{{ $comment->body }}</p>
                        </div>
                    @empty
                        <p class="text-muted">No comments yet. Be the first to comment.</p>
                    @endforelse

                    <div class="comment-form mt-4">
                        <h5>Leave a Comment</h5>
                        <form action="{{ route('comments.store', $post->id) }}" method="POST">
                            @csrf
                            @guest
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                            placeholder="Your Name *" value="{{ old('name') }}">
                                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                            placeholder="Your Email *" value="{{ old('email') }}">
                                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            @endguest
                            <div class="mb-3">
                                <textarea name="body" rows="4" class="form-control @error('body') is-invalid @enderror"
                                    placeholder="Write your comment...">{{ old('body') }}</textarea>
                                @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <button type="submit" class="btn btn-danger" style="background-color:#DC143C;">Post Comment</button>
                        </form>
                    </div>
                </div>
                @endif
                <!-- Comments End -->

                <!-- Related News Start -->
                <div class="related-news pt-3">
                    <h2 class="mb-3 h2-headline">Related News</h2>
                    <div class="row">
                        @foreach ($relatedNews as $related)
                            <div class="col-lg-4 col-md-6 mb-3 search-result">
                                <div class="card related-news">
                                    <img 
                                        class="card-img-top" 
                                        src="{{ asset($related->image_url) }}" 
                                        alt="{{ $related->headline }}" 
                                        loading="lazy" 
                                        fetchpriority="low"
                                        sizes="(max-width: 768px) 100vw, 50vw"                                    >
                                    <div class="card-body">
                                        <h5 class="card-title h5-headline">
                                            <a 
                                            href="{{ route('post-news.read-more', [
                                                'month' => \Carbon\Carbon::parse($related->date)->format('m'),
                                                'day' => \Carbon\Carbon::parse($related->date)->format('d'),
                                                'year' => \Carbon\Carbon::parse($related->date)->format('Y'),
                                                'slug' => $related->slug
                                            ]) }}" 
                                            aria-label="{{ $related->headline }}"
                                        >
                                            {{ $related->headline }}
                                        </a>
                                        
                                        </h5>
                                        <p class="card-text">{{ Str::limit(strip_tags($related->content), 220) }}</p>

                                        <a class="related-readmore-button"
                                        href="{{ route('post-news.read-more', [
                                            'month' => \Carbon\Carbon::parse($related->date)->format('m'),
                                            'day' => \Carbon\Carbon::parse($related->date)->format('d'),
                                            'year' => \Carbon\Carbon::parse($related->date)->format('Y'),
                                            'slug' => $related->slug
                                        ]) }}" 
                                        class="btn btn-primary" 
                                        aria-label="Read more about {{ $related->headline }}"
                                    >
                                        Read More
                                    </a>
                                    
                                    </div>
                                   
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Related News End -->
                
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
                            <a 
                                href="{{ $socialFollow->url }}" 
                                class="d-block py-2 px-3 text-white text-decoration-none" 
                                style="background: {{ $socialFollow->getBackgroundColor() }};"
                                aria-label="{{ $socialFollow->followers }} {{ $socialFollow->getFollowersLabel() }} on {{ $socialFollow->name }}"
                            >
                                <small class="fab {{ $socialFollow->icon_class }} me-2"></small>
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
                                <input 
                                    type="email" 
                                    name="email" 
                                    class="form-control form-control-lg subscriber-input" 
                                    placeholder="Your Email" 
                                    required
                                    aria-label="Your Email Address"
                                >
<button 
                                        class="btn newsletter-signup" 
                                        type="submit"
                                        aria-label="Sign Up for Newsletter"
                                    >
                                        Sign Up
                                    </button>
                            </div>
                        </form>
                        <small class="text-muted">We respect your privacy.</small>
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
                    <div class="d-flex flex-wrap gap-2">
                        @foreach ($tags as $tag)
                        <a href="{{ route('category.show', $tag->category->slug) }}" class="btn btn-sm btn-outline-secondary tag-link" aria-label="Tag: {{ $tag->category->name }}">
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const bookmarkBtn = document.getElementById('bookmark-btn');
        if (bookmarkBtn) {
            bookmarkBtn.addEventListener('click', function () {
                fetch(this.dataset.url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(r => r.json())
                .then(data => {
                    const saved = data.bookmarked;
                    bookmarkBtn.classList.toggle('bookmarked', saved);
                    bookmarkBtn.querySelector('span').textContent = saved ? 'Saved' : 'Save Article';
                    bookmarkBtn.setAttribute('aria-label', saved ? 'Remove bookmark' : 'Save article');
                })
                .catch(() => {});
            });
        }

        document.querySelectorAll('.share-button').forEach(function (button) {
            button.addEventListener('click', function () {
                // Pass the post ID dynamically from Blade to JavaScript
                let postId = {{ json_encode($post->id) }};
                let shareType = this.getAttribute('data-share-type');
                
                // Use fetch to make a POST request
                fetch(`/post-news/${postId}/share`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ share_type: shareType })
                }).then(response => response.json())
                  .then(data => {
                      if (data.message) {
                          console.log(data.message);
                      }
                  }).catch(error => {
                      console.error('Error sharing the post:', error);
                  });
            });
        });
    });
</script>

@endsection




















































































