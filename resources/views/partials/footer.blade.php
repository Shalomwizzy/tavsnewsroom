<!-- Footer Start -->
<div class="container-fluid bg-light pt-5 px-sm-3 px-md-5">
    <div class="row">
        <div class="col-lg-3 col-md-6 mb-5">
            @if(isset($siteLogoUrl))
            <a href="{{ route('welcome') }}" class="navbar-brand">
                <img
                    src="{{ asset($siteLogoUrl) }}"
                    width="120"
                    height="50"
                    loading="lazy"
                    aria-label="Navigate to home"
                    alt="Site Logo"
                >
            </a>
        @endif
        
        
        
            @if ($footerSettings)
                <p>{!! $footerSettings->description !!}</p>
                <div class="d-flex justify-content-start mt-4">
                    @php
                        $selectedLinks = json_decode($footerSettings->selected_links, true) ?? [];
                    @endphp
                    @foreach ($selectedLinks as $link)
                        @if ($footerSettings->{$link . '_link'})
                            <a class="btn btn-outline-secondary text-center me-2 px-0" style="width: 38px; height: 38px;" href="{{ $footerSettings->{$link . '_link'} }}">
                                <i class="fab fa-{{ $link }}"></i>
                            </a>
                        @endif
                    @endforeach
                </div>
            @else
                <p>No footer settings available.</p>
            @endif
        </div>

        <div class="col-lg-3 col-md-6 mb-5">
            <h4 class="fw-bold mb-4">Categories</h4>
            <div class="d-flex flex-wrap gap-2">
                @foreach ($tags as $tag)
                <a href="{{ route('category.show', $tag->category->slug) }}" class="btn btn-sm btn-outline-secondary tag-link">
                    {{ $tag->category->name }}
                </a>
                @endforeach
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-5">
            <h4 class="fw-bold mb-4">Tags</h4>
            <div class="d-flex flex-wrap gap-2">
                @foreach ($tags as $tag)
                <a href="{{ route('category.show', $tag->category->slug) }}" class="btn btn-sm btn-outline-secondary tag-link">
                    {{ $tag->category->name }}
                </a>
                @endforeach
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-5">
            <h4 class="fw-bold mb-4">Quick Links</h4>
            <div class="d-flex flex-column justify-content-start">
                @foreach ($quickLinks as $quickLink)
                @if ($quickLink->is_active)
                    <a class="mb-2 tag-link" href="{{ $quickLink->url }}" style="text-decoration: none;">
                        <i class="fa fa-angle-right me-2"></i>{{ $quickLink->title ?? 'Unnamed Link' }}
                    </a>
                @endif
                @endforeach
            </div>
        </div>
        

    </div>
</div>

<div class="container-fluid py-4 px-sm-3 px-md-5 bg-light">
    <p class="m-0 text-center">
        &copy; <a class="fw-bold" href="#" style="color: #b30000;">{{ \App\Models\WebsiteSetting::getValue('site_name', 'Your Site Name') }}</a>. {{ date('Y') }} {{ \App\Models\WebsiteSetting::getValue('site_copyright', 'All Rights Reserved.') }}
    </p>
</div>
<!-- Footer End -->

 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 {{-- <!-- Footer Start -->
<div class="container-fluid bg-light pt-5 px-sm-3 px-md-5">
    <div class="row">
        <div class="col-lg-3 col-md-6 mb-5">
            @if(isset($siteLogoUrl))
            <a href="{{ route('welcome') }}" class="navbar-brand">
                <img src="{{ asset($siteLogoUrl) }}" alt="Site Logo" class="d-block" style="max-height: 50px; width: auto;">
            </a>
            @endif
        
            @if ($footerSettings)
                <p>{!! $footerSettings->description !!}</p>
                <div class="d-flex justify-content-start mt-4">
                    @php
                        $selectedLinks = json_decode($footerSettings->selected_links, true) ?? [];
                    @endphp
                    @foreach ($selectedLinks as $link)
                        @if ($footerSettings->{$link . '_link'})
                            <a class="btn btn-outline-secondary text-center me-2 px-0" style="width: 38px; height: 38px;" href="{{ $footerSettings->{$link . '_link'} }}">
                                <i class="fab fa-{{ $link }}"></i>
                            </a>
                        @endif
                    @endforeach
                </div>
            @else
                <p>No footer settings available.</p>
            @endif
        </div>

        <div class="col-lg-3 col-md-6 mb-5">
            <h4 class="fw-bold mb-4">Categories</h4>
            <div class="d-flex flex-wrap m-n1">
                @foreach ($tags as $tag)
                    <a href="{{ route('category.show', $tag->category->slug) }}" class="btn btn-sm btn-outline-secondary m-1">
                        {{ $tag->category->name }}
                    </a>
                @endforeach
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-5">
            <h4 class="fw-bold mb-4">Tags</h4>
            <div class="d-flex flex-wrap m-n1">
                @foreach ($tags as $tag)
                    <a href="{{ route('category.show', $tag->category->slug) }}" class="btn btn-sm btn-outline-secondary m-1">
                        {{ $tag->category->name }}
                    </a>
                @endforeach
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-5">
            <h4 class="fw-bold mb-4">Quick Links</h4>
            <div class="d-flex flex-column justify-content-start">
                @foreach ($quickLinks as $quickLink)
                    @if ($quickLink->is_active)
                        <a class="text-secondary mb-2" href="{{ $quickLink->url }}">
                            <i class="fa fa-angle-right text-dark me-2"></i>{{ $quickLink->title ?? 'Unnamed Link' }}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>

    </div>
</div>

<div class="container-fluid py-4 px-sm-3 px-md-5">
    <p class="m-0 text-center">
        &copy; <a class="fw-bold" href="#">{{ \App\Models\WebsiteSetting::getValue('site_name', 'Your Site Name') }}</a>. {{ date('Y') }} {{ \App\Models\WebsiteSetting::getValue('site_copyright', 'All Rights Reserved.') }}
    </p>
</div> --}}
<!-- Footer End -->

 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 