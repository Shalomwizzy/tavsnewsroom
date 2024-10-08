<!-- Category News Slider Start -->
<div class="container-fluid">
    <div class="container">
        <div class="row">
            @foreach($categories as $category)
                <div class="col-lg-6 py-3">
                    <div 
                        class="bg-light py-2 px-4 mb-3 d-flex align-items-center justify-content-between" 
                        aria-label="Category: {{ $category->name }}"
                        style="height: 60px; width: 100%;"
                    >
                        <h2 class="m-0 h2-headline" style="color: #333;">
                            {{ $category->name }}
                        </h2>
                    </div>
                    <div class="owl-carousel owl-carousel-3 carousel-item-2 position-relative">
                        @foreach($category->postNews as $news)
                            <div 
                                class="position-relative category-post-news-item" 
                                style="height: 300px; width: 100%;" 
                                aria-label="News Item: {{ $news->headline }}"
                            >
                                <img 
                                    class="img-fluid w-100 h-100" 
                                    src="{{ asset($news->image_url) }}" 
                                    style="object-fit: cover;" 
                                    alt="{{ $news->headline }} - Image"
                                    loading="lazy" 
                                    width="100%" 
                                    height="300px" 
                                >
                                <div 
                                    class="overlay position-absolute" 
                                    style="background-color: rgba(0, 0, 0, 0.6); padding: 15px; height: 100%; width: 100%; top: 0; left: 0;" 
                                    aria-label="Overlay for {{ $news->headline }}"
                                >
                                    <div 
                                        class="mb-2" 
                                        style="font-size: 13px; color: #ffffff;"
                                    >
                                        <a 
                                            href="{{ route('category.show', $news->category->slug) }}" 
                                            class="categoy-categoryname" 
                                            style="color: #ffffff; text-decoration: underline;"
                                            aria-label="Category: {{ $category->name }}"
                                        >
                                            {{ $category->name }}
                                        </a>
                                        <span class="px-1 span-slash">/</span>
                                        <span class="date-headline"
                                            aria-label="Date: {{ \Carbon\Carbon::parse($news->date)->format('F d, Y') }}"
                                        >
                                            {{ \Carbon\Carbon::parse($news->date)->format('F d, Y') }}
                                        </span>
                                    </div>
                                    <a 
                                        class="h4 m-0 category-post-news-headline" 
                                        href="{{ route('post-news.read-more', [
                                           
                                            'month' => \Carbon\Carbon::parse($news->date)->format('m'),
                                            'day' => \Carbon\Carbon::parse($news->date)->format('d'),
                                             'year' => \Carbon\Carbon::parse($news->date)->format('Y'),
                                            'slug' => $news->slug
                                        ]) }}" 
                                        style="color: #ffffff;"
                                        aria-label="{{ $news->headline }}"
                                    >
                                        {{ $news->headline }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Category News Slider End -->






















<!-- Category News Slider Start -->
{{-- <div class="container-fluid">
    <div class="container">
        <div class="row">
            @foreach($categories as $category)
                <div class="col-lg-6 py-3">
                    <div class="bg-light py-2 px-4 mb-3 d-flex align-items-center justify-content-between">
                        <h2 class="m-0 h2-headline" style="color: #333;">{{ $category->name }}</h2> <!-- Darkened category name -->
                    </div>
                    <div class="owl-carousel owl-carousel-3 carousel-item-2 position-relative">
                        @foreach($category->postNews as $news)
                            <div class="position-relative category-post-news-item" style="height: 300px; width: 100%;"> <!-- Fixed height and width -->
                                <img class="img-fluid w-100 h-100" src="{{ asset($news->image_url) }}" style="object-fit: cover;" fetchpriority="high"> <!-- Ensures image covers the entire container -->
                                <div class="overlay position-absolute" style="background-color: rgba(0, 0, 0, 0.6); padding: 15px; height: 100%; width: 100%; top: 0; left: 0;"> <!-- Full overlay covering image -->
                                    <div class="mb-2" style="font-size: 13px; color: #ffffff;"> <!-- Lightened the date color -->
                                        <a href="{{ route('category.show', $news->category->slug) }}" class="categoy-categoryname" style="color: #ffffff; text-decoration: underline;">{{ $category->name }}</a> <!-- Lightened and underlined category link -->
                                        <span class="px-1" style="color: #ffffff;">/</span> <!-- Lightened the separator -->
                                        <span>{{ \Carbon\Carbon::parse($news->date)->format('Y-m-d') }}</span>
                                    </div>
                                    <a class="h4 m-0 category-post-news-headline" href="{{ route('post-news.read-more', [
                                        'year' => \Carbon\Carbon::parse($news->date)->format('Y'),
                                        'month' => \Carbon\Carbon::parse($news->date)->format('m'),
                                        'day' => \Carbon\Carbon::parse($news->date)->format('d'),
                                        'slug' => $news->slug
                                    ]) }}" style="color: #ffffff;">{{ $news->headline }}</a> <!-- Lightened the headline -->
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div> --}}




























































