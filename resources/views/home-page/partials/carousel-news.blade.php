<!-- Main News Slider Start -->
<div class="container-fluid py-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="swiper carousel-item-1 position-relative mb-3 mb-lg-0">
                    <div class="swiper-wrapper">
                    @foreach ($carouselNews as $news)
                        <div class="swiper-slide position-relative overflow-hidden" style="height: 435px;">
                            @if ($loop->first)
                            <link rel="preload" href="{{ asset($news->postNews->image_url) }}" as="image">
                            @endif
                            <img
                                class="img-fluid"
                                src="{{ asset($news->postNews->image_url) }}"
                                style="object-fit: cover; width: 100%; height: 435px;"
                                alt="{{ $news->postNews->headline }}"
                                width="700" height="435"
                                @if ($loop->first) loading="eager" fetchpriority="high" @else loading="lazy" @endif>

                                
                            <div class="overlay">
                                @if ($news->postNews->is_breaking)
                                    <span class="badge breaking-badge mb-1">BREAKING</span>
                                @endif
                                <div class="mb-1">
                                    <a class="category-headline" href="{{ route('category.show', $news->postNews->category->slug) }}"
                                       aria-label="View category: {{ $news->postNews->category->name }}">
                                        {{ $news->postNews->category->name }}
                                    </a>
                                    <span class="px-2 span-slash">/</span>
                                    <a class="" href="#" aria-label="News date: {{ \Carbon\Carbon::parse($news->postNews->date)->format('F d, Y') }}">
                                        {{ \Carbon\Carbon::parse($news->postNews->date)->format('F d, Y') }}
                                    </a>
                                </div>
                                <a class="h2 m-0 fw-bold carousel-headline" href="{{ route('post-news.read-more', [
                                   
                                    'month' => \Carbon\Carbon::parse($news->postNews->date)->format('m'),
                                    'day' => \Carbon\Carbon::parse($news->postNews->date)->format('d'),
                                     'year' => \Carbon\Carbon::parse($news->postNews->date)->format('Y'),
                                    'slug' => $news->postNews->slug
                                ]) }}" aria-label="Read more: {{ $news->postNews->headline }}">
                                    {{ $news->postNews->headline }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                    </div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="d-flex align-items-center justify-content-between bg-light py-2 px-4 mb-3">
                    <h2 class="m-0 h2-headline">Categories</h2>
                    <a class="text-secondary fw-medium text-decoration-none h2-headline" href="{{ route('categories.show') }}" aria-label="View all categories">View All</a>
                </div>
                @foreach ($categories as $category)
                    @if ($category->show_on_homepage)
                        <div class="position-relative overflow-hidden mb-3" style="height: 80px;">
                            <!-- Preload category image -->
                            <link rel="preload" href="{{ asset($category->image) }}" as="image">

                            <img 
                           src="{{ asset($category->image) }}"                            width="425" 
                           height="106"
                           alt="{{ $category->name }} -Category Image" 
                           loading="lazy">
                            
                            
                            <a href="{{ route('category.show', $category->slug) }}" class="overlay align-items-center justify-content-center h4 m-0 text-white text-decoration-none" aria-label="View category: {{ $category->name }}">
                                {{ $category->name }}
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>

    .carousel-headline{
        font-family: Georgia, 'Times New Roman', Times, serif !important; 
        font-size: 25px !important;
        color: #ffffff !important;
        font-weight: bolder !important;
    }
    
    </style>
<!-- Main News Slider End -->
















































