<div class="container-fluid p-0 mb-3">
    <nav class="navbar navbar-expand-lg bg-light navbar-light py-2 py-lg-0 px-lg-5">
        @if(isset($siteLogoUrl))
    <a href="{{ route('welcome') }}" class="navbar-brand">
        <img 
            src="{{ asset($siteLogoUrl) }}" 
            srcset="{{ asset($siteLogoUrl) }} 120w, 
                    {{ asset($siteLogoUrl) }} 240w, 
                    {{ asset($siteLogoUrl) }} 480w"
            sizes="(max-width: 576px) 100px, (max-width: 768px) 100px, 120px"
            width="120" 
            height="50" 
            loading="lazy" 
            aria-label="Navigate to home"
            alt="Site Logo"
        >
    </a>
@endif

    
         <!-- Updated navbar-toggler button with aria-label -->
         <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        {{-- <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button> --}}
        <div class="collapse navbar-collapse justify-content-between px-0 px-lg-3" id="navbarCollapse">
            <div class="navbar-nav mr-auto py-0">
                <a href="{{ route('welcome') }}" class="nav-item nav-link {{ request()->routeIs('welcome') ? 'active' : '' }}">Home</a>
                <a href="{{ route('admin.dashboard') }}" class="nav-item nav-link {{ request()->routeIs('welcome') ? 'active' : '' }}">Admin Dashboard</a>
                <a href="{{ route('categories.show') }}" class="nav-item nav-link {{ request()->routeIs('categories.show') ? 'active' : '' }}">Categories</a>
                <a href="{{ route('post-news.show') }}" class="nav-item nav-link {{ request()->routeIs('post-news.show') ? 'active' : '' }}">All News</a>
                @foreach(\App\Models\NavbarItem::with('category')->get() as $navbarItem)
                    <a href="{{ route('category.show', $navbarItem->category->slug) }}" class="nav-item nav-link {{ Request::is('category/'.$navbarItem->category->slug) ? 'active' : '' }}">
                        {{ $navbarItem->category->name }}
                    </a>
                @endforeach
                <a href="{{ route('contact-us') }}" class="nav-item nav-link {{ request()->routeIs('contact-us') ? 'active' : '' }}">Contact us</a>
            </div>
            <form action="{{ route('search') }}" method="GET" class="input-group ml-auto" style="width: 100%; max-width: 300px;">
                <input type="text" name="query" class="form-control" placeholder="Keyword" required>
                <div class="input-group-append">
                    <button type="submit" class="input-group-text text-secondary" aria-label="Search">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </form>



        </div>
    </nav>
</div>

<script>
    (function ($) {
        "use strict";
        
        // Dropdown on mouse hover
        $(document).ready(function () {
            function toggleNavbarMethod() {
                if ($(window).width() > 992) {
                    $('.navbar .dropdown').on('mouseover', function () {
                        $('.dropdown-toggle', this).trigger('click');
                    }).on('mouseout', function () {
                        $('.dropdown-toggle', this).trigger('click').blur();
                    });
                } else {
                    $('.navbar .dropdown').off('mouseover').off('mouseout');
                }
            }
            toggleNavbarMethod();
            $(window).resize(toggleNavbarMethod);
        });
    })(jQuery);
    </script>
