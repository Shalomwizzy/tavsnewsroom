<!-- Top News Slider Start -->
<div class="container-fluid py-3">
    <div class="container">
        <h2 class="top-news-title h2-headline">Top News</h2>
        <div class="owl-carousel owl-carousel-2 carousel-item-3 position-relative top-news-carousel">
            @foreach ($topNews as $news)
                <div class="d-flex top-news-item" aria-label="Top News Item">
                   
                    <img 
                        src="{{ asset($news->postNews->image_url) }}" 
                        style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;" 
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
                    <img src="{{ asset($news->postNews->image_url) }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;">
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






























