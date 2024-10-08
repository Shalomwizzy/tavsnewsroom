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


























{{-- <div class="pb-3">
    <div class="bg-light py-2 px-4 mb-3">
        <h3 class="m-0">Trending</h3>
    </div>
    @foreach ($trendingNews as $news)
        @if ($news->section == 'body')
            <div class="d-flex mb-3">
                <img src="{{ asset($news->postNews->image_url) }}" style="width: 100px; height: 100px; object-fit: cover;" fetchpriority="high">
                <div class="w-100 d-flex flex-column justify-content-center bg-light px-3" style="height: 100px;">
                    <div class="mb-1 popular-latest" style="font-size: 13px;">
                        <a href="{{ route('category.show', $news->postNews->category->slug) }}">{{ $news->postNews->category->name }}</a>
                        <a href="">{{ $news->postNews->category->name }}</a>.
                        <span class="px-1">/</span>
                        <span>{{ \Carbon\Carbon::parse($news->postNews->date)->format('M d, Y') }}</span>
                    </div>
                    <a class="h4 m-0 popular-small-headline" href="{{ route('post-news.read-more', [
                        'year' => \Carbon\Carbon::parse($news->postNews->date)->format('Y'),
                        'month' => \Carbon\Carbon::parse($news->postNews->date)->format('m'),
                        'day' => \Carbon\Carbon::parse($news->postNews->date)->format('d'),
                        'slug' => $news->postNews->slug
                    ]) }}">{{ $news->postNews->headline }}</a>

                    <a class="h6 m-0" href="{{ route('post-news.read-more', $news->postNews->id) }}">{{ $news->postNews->headline }}</a>.
                </div>
            </div>
        @endif
    @endforeach
</div> --}}







































