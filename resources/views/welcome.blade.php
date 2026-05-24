@extends('layouts.app')

@section('content')

@include('home-page.partials.announcement')
@include('home-page.partials.top-news')
@include('home-page.partials.carousel-news')
@include('home-page.partials.featured-news')
@include('home-page.partials.categories-news')

<!-- News With Sidebar Start -->
<div class="container-fluid py-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                @include('home-page.partials.popular-news')
                @include('home-page.partials.ads')
                @include('home-page.partials.latest-news')
            </div>
            <div class="col-lg-4 pt-3 pt-lg-0">
                @include('home-page.partials.social-follow')
                @include('home-page.partials.newsletter')
                @include('home-page.partials.ads')
                @include('home-page.partials.trending-news')
                @include('home-page.partials.tags')
            </div>
        </div>
    </div>
</div>
<!-- News With Sidebar End -->

@endsection





