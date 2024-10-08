<!-- Featured News Carousel Start -->
<div class="container-fluid py-3">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between bg-light py-2 px-4 mb-3">
            <h2 class="m-0 h2-headline">Featured News</h2>
        </div>
        <div class="owl-carousel owl-carousel-2 carousel-item-4 position-relative">
            @foreach ($featuredNews as $post)
                <div 
                    class="position-relative overflow-hidden" 
                    style="height: 300px;" 
                    aria-label="Featured News Item"
                >
                    <!-- Properly Sized Image with Lazy Loading -->
                    <img 
                        class="img-fluid w-100 h-100" 
                        src="{{ asset($post->postNews->image_url) }}" 
                        srcset="{{ asset($post->postNews->image_url) }} 600w, 
                                {{ asset($post->postNews->image_url) }} 300w" 
                        sizes="(max-width: 600px) 300px, 600px"
                        style="object-fit: cover;" 
                        alt="{{ $post->postNews->headline }} - Image" 
                        loading="lazy"   
                        fetchpriority="low"
                    >
                    <div class="overlay">
                        <div class="mb-1" style="font-size: 13px;">
                            <a 
                                class="category-headline" 
                                href="{{ route('category.show', $post->postNews->category->slug) }}"
                                aria-label="Category: {{ $post->postNews->category->name }}"
                            >
                                {{ $post->postNews->category->name }}
                            </a>
                            <span class="px-1 span-slash">/</span>
                            <a 
                                class="date-headline" 
                                href="#" 
                                aria-label="Date: {{ \Carbon\Carbon::parse($post->date)->format('F d, Y') }}"
                            >
                                {{ \Carbon\Carbon::parse($post->date)->format('F d, Y') }}
                            </a>
                        </div>
                        <a 
                            class="h4 m-0 feature-headline" 
                            href="{{ route('post-news.read-more', [
                               
                                'month' => \Carbon\Carbon::parse($post->postNews->date)->format('m'),
                                'day' => \Carbon\Carbon::parse($post->postNews->date)->format('d'),
                                 'year' => \Carbon\Carbon::parse($post->postNews->date)->format('Y'),
                                'slug' => $post->postNews->slug
                            ]) }}" 
                            aria-label="{{ $post->postNews->headline }}"
                        >
                            {{ $post->postNews->headline }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>

.feature-headline{
    font-family: Georgia, 'Times New Roman', Times, serif !important; 
    font-size: 14px !important;
    color: #ffffff !important;
    font-weight: bolder !important;
}

</style>
<!-- Featured News Carousel End -->


















<!-- Featured News Carousel Start -->
<!-- Featured News Slider Start -->
{{-- <div class="container-fluid py-3">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between bg-light py-2 px-4 mb-3">
            <h2 class="m-0 h2-headline">Featured News</h2>
          
        </div>
        <div class="owl-carousel owl-carousel-2 carousel-item-4 position-relative">
            @foreach ($featuredNews as $post)
                <div class="position-relative overflow-hidden" style="height: 300px;">
                    <img class="img-fluid w-100 h-100" src="{{ asset($post->postNews->image_url) }}" style="object-fit: cover;" fetchpriority="high">
                    <div class="overlay">
                        <div class="mb-1" style="font-size: 13px;">
                            <a class="text-white" href="{{ route('category.show', $post->postNews->category->slug) }}">{{ $post->postNews->category->name }}</a>
                            <span class="px-1 text-white">/</span>
                            <a class="text-white" href="#">{{ \Carbon\Carbon::parse($post->date)->format('Y-m-d') }}</a>
                        </div>
                        <a class="h4 m-0 text-white" href="{{ route('post-news.read-more', [
                            'year' => \Carbon\Carbon::parse($post->postNews->date)->format('Y'),
                            'month' => \Carbon\Carbon::parse($post->postNews->date)->format('m'),
                            'day' => \Carbon\Carbon::parse($post->postNews->date)->format('d'),
                            'slug' => $post->postNews->slug
                        ]) }}">{{ $post->postNews->headline }}</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div> --}}
<!-- Featured News Slider End -->










