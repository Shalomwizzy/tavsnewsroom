<div class="row mb-3">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between" style="background-color: #f8f9fa; padding: 12px 16px; margin-bottom: 12px;">
            <h2 style="margin: 0; color: #222; font-size: 24px; font-weight: 600;">Popular News</h2>
        
        </div>
    </div>

    @foreach ($popularNews as $index => $news)
        @if ($index < 2)
            <!-- Headline news for the first two items -->
            <div class="col-lg-6">
                <div class="position-relative mb-3 card" style="height: 400px; width: 100% !important;">
                    <!-- Properly Sized Image with Lazy Loading -->
                    <img 
                        class="img-fluid w-100" 
                        src="{{ asset($news->postNews->image_url) }}" 
                        srcset="{{ asset($news->postNews->image_url) }} 600w, 
                                {{ asset($news->postNews->image_url) }} 300w" 
                        sizes="(max-width: 600px) 300px, 600px"
                        alt="{{ $news->postNews->headline }} - News Image" 
                        style="object-fit: cover; height: 200px !important;" 
                        loading="lazy" 
                        fetchpriority="high" 
                    >
                    <div class="overlay position-relative p-3" style="height: 200px !important; background-color: #f8f9fa; color: #222;">
                        <div class="mb-2" style="font-size: 14px; color: #DC143C;">
                            <a class="popu-lates-headline"
                                href="{{ route('category.show', $news->postNews->category->slug) }}" 
                                aria-label="Category: {{ $news->postNews->category->name }}" 
                                style="color: #DC143C; font-weight: 600;"
                            >
                                {{ $news->postNews->category->name }}
                            </a>
                            <span class="px-1 popu-lates-slash" style="color: #DC143C;">/</span>
                            <span  class="popu-lates-headline"
                                aria-label="Published on {{ \Carbon\Carbon::parse($news->postNews->date)->format('F d, Y') }}" 
                                style="color: #DC143C;"
                            >
                                {{ \Carbon\Carbon::parse($news->postNews->date)->format('F d, Y') }}
                            </span>
                        </div>

                        <a class="popu-lates-headline"
                            href="{{ route('post-news.read-more', [
                               
                                'month' => \Carbon\Carbon::parse($news->postNews->date)->format('m'),
                                'day' => \Carbon\Carbon::parse($news->postNews->date)->format('d'),
                                 'year' => \Carbon\Carbon::parse($news->postNews->date)->format('Y'),
                                'slug' => $news->postNews->slug
                            ]) }}" 
                            aria-label="Read more about {{ $news->postNews->headline }}" 
                            style="font-size: 16px; font-weight: 600; color: #222;"
                        >
                            {{ $news->postNews->headline }}
                        </a>
                        <p class="m-0" style="color: #333;">{{ Str::limit(strip_tags($news->postNews->content), 80) }}</p>

                        <!-- Read More Button -->
                        <a 
                            href="{{ route('post-news.read-more', [
                                
                                'month' => \Carbon\Carbon::parse($news->postNews->date)->format('m'),
                                'day' => \Carbon\Carbon::parse($news->postNews->date)->format('d'),
                                'year' => \Carbon\Carbon::parse($news->postNews->date)->format('Y'),
                                'slug' => $news->postNews->slug
                            ]) }}" 
                            class="btn btn-danger mt-2" 
                            style="background-color: #DC143C; color: #fff; padding: 8px 12px; text-decoration: none;"
                            aria-label="Read more about {{ $news->postNews->headline }}"
                        >
                            Read More
                        </a>

                        {{-- <p class="m-0" style="color: #333;">{!! Str::limit($news->postNews->content, 100) !!}</p> --}}
                    </div>
                </div>
            </div>
        @else
            <!-- Smaller news items for the rest -->
            <div class="col-lg-6">
                <div class="d-flex mb-3" style="height: 100px !important; width: 100% !important;">
                    <!-- Properly Sized Image with Lazy Loading -->
                    <img 
                        src="{{ asset($news->postNews->image_url) }}" 
                        srcset="{{ asset($news->postNews->image_url) }} 100w, 
                                {{ asset($news->postNews->image_url) }} 50w" 
                        sizes="100px" 
                        alt="{{ $news->postNews->headline }} - News Image" 
                        style="width: 100px; height: 100px; object-fit: cover;" 
                        loading="lazy" 
                        fetchpriority="low" 
                    >
                    <div class="w-100 px-3" style="height: 100px !important; background-color: #f8f9fa;">
                        <div class="mb-1" style="font-size: 13px; color: #DC143C;">
                            <a class="category-headline popu-lates-headline"
                                href="{{ route('category.show', $news->postNews->category->slug) }}" 
                                aria-label="Category: {{ $news->postNews->category->name }}" 
                                style="color: #DC143C; font-weight: 600;"
                            >
                                {{ $news->postNews->category->name }}
                            </a>
                            <span class="px-1 popu-lates-slash" style="color: #DC143C;">/</span>
                            <span class="popu-lates-headline"
                                aria-label="Published on {{ \Carbon\Carbon::parse($news->postNews->date)->format('F d, Y') }}" 
                                style="color: #DC143C;"
                            >
                                {{ \Carbon\Carbon::parse($news->postNews->date)->format('F d, Y') }}
                            </span>
                        </div>

                        <a class="small-headline"
                            href="{{ route('post-news.read-more', [
                              
                                'month' => \Carbon\Carbon::parse($news->postNews->date)->format('m'),
                                'day' => \Carbon\Carbon::parse($news->postNews->date)->format('d'),
                                  'year' => \Carbon\Carbon::parse($news->postNews->date)->format('Y'),
                                'slug' => $news->postNews->slug
                            ]) }}" 
                            aria-label="Read more about {{ $news->postNews->headline }}" 
                            style="font-size: 12px; font-weight: 600; color: #222; font-family: Georgia, 'Times New Roman', Times, serif !important;"
                        >
                            {{ $news->postNews->headline }}
                        </a>
                        
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>
<style>
    .small-headline:hover{
    color:rgb(178, 34, 34)!important; 
    font-weight: bolder !important;
    font-family: Georgia, 'Times New Roman', Times, serif !important; 
}
</style>






























































<!-- Popular News End -->
{{-- <div class="row mb-3">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between bg-light py-2 px-4 mb-3">
            <h3 class="m-0">Popular</h3>
            <a class="text-secondary font-weight-medium text-decoration-none" href="">View All</a>
        </div>
    </div>

    @foreach ($popularNews as $index => $news)
        @if ($index < 2)
            <!-- Headline news for the first two items -->
            <div class="col-lg-6">
                <div class="position-relative mb-3">
                    <img class="img-fluid w-100" src="{{ $news->postNews->image_url }}" style="object-fit: cover;">
                    <div class="overlay position-relative bg-light">
                        <div class="mb-2" style="font-size: 14px;">
                            <a href="">{{ $news->postNews->category->name }}</a>
                            <span class="px-1">/</span>
                            <span>{{ $news->postNews->date }}</span>
                        </div>
                      
                        <a class="h4" href="{{ route('post-news.read-more', $news->postNews->id) }}">{{ $news->postNews->headline }}</a>
                        <p class="m-0">{{ Str::limit($news->postNews->content, 100) }}</p>
                    </div>
                </div>
            </div>
        @else
            <!-- Smaller news items for the rest -->
            <div class="col-lg-6">
                <div class="d-flex mb-3">
                    <img src="{{ $news->postNews->image_url }}" style="width: 100px; height: 100px; object-fit: cover;">
                    <div class="w-100 d-flex flex-column justify-content-center bg-light px-3" style="height: 100px;">
                        <div class="mb-1" style="font-size: 13px;">
                            <a href="">{{ $news->postNews->category->name }}</a>
                            <span class="px-1">/</span>
                            <span>{{ $news->postNews->date }}</span>
                        </div>
                        <a class="h4 m-0 text-white" href="{{ route('post-news.read-more', $post->slug) }}">{{ $post->headline }}</a>

                        <a class="h6 m-0" href="{{ route('post-news.read-more', $news->postNews->id) }}">{{ $news->postNews->headline }}</a>
                   
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div> --}}