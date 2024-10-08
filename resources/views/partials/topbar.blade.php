<div class="container-fluid ">
    <div class="row align-items-center bg-light px-lg-5  topbar">
        <div class="col-12 col-md-8">
            <div class="d-flex justify-content-between">
                <div class="text-white text-center py-2 h2-headline" style="width: 100px; background-color: #b30000;">Trending</div>
        
                <!-- Carousel Container -->
                <div class="tranding-carousel-container position-relative d-inline-flex align-items-center ml-3" style="width: calc(100% - 100px); padding-left: 90px; overflow: hidden;">
                    <!-- Bootstrap Carousel for Trending News -->
                    <div id="trendingCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
                        <div class="carousel-inner">
                            @foreach ($trendingNews as $index => $news)
                                @if ($news->section == 'top')
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <div class="text-truncate">
                                            <a class="h4 m-0  trending-top-headline" href="{{ route('post-news.read-more', [
                                                'year' => \Carbon\Carbon::parse($news->postNews->date)->format('Y'),
                                                'month' => \Carbon\Carbon::parse($news->postNews->date)->format('m'),
                                                'day' => \Carbon\Carbon::parse($news->postNews->date)->format('d'),
                                                'slug' => $news->postNews->slug
                                            ]) }}">{{ $news->postNews->headline }}</a>
                                            {{-- <a class="text-secondary" href="{{ route('post-news.read-more', $news->postNews->slug) }}">{{ $news->postNews->headline }}</a> --}}
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
  

        <div class="col-md-4 text-right d-none d-md-block">
            {{ date('l, F j, Y') }}
        </div>
    </div>
    <div class="row align-items-center py-2 px-lg-5">
        <div class="col-lg-4">
            <a href="{{route('welcome')}}" class="navbar-brand d-block d-lg-block">
                <h1 
                    class="m-0 display-5 text-uppercase website-name" 
                    style="width: 100%; height: 60px; line-height: 60px;"
                >
                    @php
                        $siteName = \App\Models\WebsiteSetting::getValue('site_name', 'Site Name');
                        // Split the site name into parts
                        $parts = explode(' ', $siteName);
                        // First part in red, rest in black
                        echo '<span style="color: red;">' . $parts[0] . '</span>';
                        if (count($parts) > 1) {
                            echo ' <span style="color: black;">' . implode(' ', array_slice($parts, 1)) . '</span>';
                        }
                    @endphp
                </h1>
            </a>
        </div>

        {{-- <div class="col-lg-8 text-center text-lg-right">
            @include('home-page.partials.ads')
        </div> --}}
    </div>


</div>



