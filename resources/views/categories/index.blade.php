@extends('layouts.app')

@section('meta_title', 'All Categories')
@section('meta_description', 'Browse all news categories.')

@section('content')
<!-- Breadcrumb Start -->
<div class="container-fluid cate-breadcrumb">
    <div class="container">
        <nav class="breadcrumb bg-transparent m-0 p-0">
            <a class="breadcrumb-item" href="{{ route('welcome') }}">Home</a>
            <span class="breadcrumb-item active">Categories</span>
        </nav>
    </div>
</div>
<!-- Breadcrumb End -->

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h2>Categories</h2>
        </div>
    </div>

    <div class="row">
        @foreach ($categories as $category)
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100">
                <a href="{{ route('category.show', $category->slug) }}">
                    <img src="{{ asset($category->image) }}" class="card-img-top" alt="{{ $category->name }}" style="height: 150px; object-fit: cover;">
                </a>
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="{{ route('category.show', $category->slug) }}">{{ $category->name }}</a>
                    </h5>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
{{-- <a href="{{ route('categories.show', $navbarItem->category->slug) }}" class="nav-item nav-link">
    {{ $navbarItem->category->name }}
</a> --}}

