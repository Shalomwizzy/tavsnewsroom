<!-- Top News Slider Start -->
<div class="container-fluid py-3">
    <div class="container">
        <h2 class="top-news-title h2-headline">Top News</h2>
        <div class="swiper carousel-item-3 position-relative top-news-carousel">
            <div class="swiper-wrapper">
            @foreach ($topNews as $news)
                <div class="swiper-slide d-flex top-news-item" aria-label="Top News Item">
                   
                    <img
                        src="{{ asset($news->postNews->image_url) }}"
                        style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;"
                        width="80" height="80"
                        loading="lazy"
                        fetchpriority="low"
                        alt="{{ $news->postNews->headline }} - Top News Image"
                    >
                    <div class="d-flex align-items-center bg-light px-3 top-news-container" style="height: 80px; width: 200px;">
                        <a 
                            class="top-news-headline" 
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
            @endforeach
            </div>
            <button class="swiper-button-prev cs-arrow" aria-label="Previous slide">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <button class="swiper-button-next cs-arrow" aria-label="Next slide">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 6 15 12 9 18"/></svg>
            </button>
        </div>
    </div>
</div>
<!-- Top News Slider End -->






























<!-- Top News Slider Start -->
{{-- <div class="container-fluid py-3">
    <div class="container">
        <h2 class="top-news-title h2-headline">Top News</h2>
        <div class="owl-carousel owl-carousel-2 carousel-item-3 position-relative top-news-carousel">
            @foreach ($topNews as $news)
                <div class="d-flex top-news-item">
                    <img src="{{ asset($news->postNews->image_url) }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;" fetchpriority="high" loading="lazy"  alt="{{ $news->postNews->headline }} - Top News Image">
                    <div class="d-flex align-items-center bg-light px-3 top-news-container" style="height: 80px; width: 200px;">
                        <a class="top-news-headline" href="{{ route('post-news.read-more', [
                            'year' => \Carbon\Carbon::parse($news->postNews->date)->format('Y'),
                            'month' => \Carbon\Carbon::parse($news->postNews->date)->format('m'),
                            'day' => \Carbon\Carbon::parse($news->postNews->date)->format('d'),
                            'slug' => $news->postNews->slug
                        ]) }}">{{ $news->postNews->headline }}</a>
                    </div>
                </div>
            @endforeach
            @foreach ($topNews as $news)
                <div class="d-flex top-news-item">
                    <img src="{{ asset($news->postNews->image_url) }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;" loading="lazy">
                    <div class="d-flex align-items-center bg-light px-3 top-news-container" style="height: 80px; width: 200px;">
                        <a class="top-news-headline" href="{{ route('post-news.read-more', [
                            'year' => \Carbon\Carbon::parse($news->postNews->date)->format('Y'),
                            'month' => \Carbon\Carbon::parse($news->postNews->date)->format('m'),
                            'day' => \Carbon\Carbon::parse($news->postNews->date)->format('d'),
                            'slug' => $news->postNews->slug
                        ]) }}"
                         aria-label="{{ $news->postNews->headline }}"
                         >{{ $news->postNews->headline }}</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div> --}}
<!-- Top News Slider End -->






























