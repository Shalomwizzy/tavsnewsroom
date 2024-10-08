@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 cat">
            <h4 class="text-white">Select Categories to Display on Homepage</h4>
            <p class="mb-4">This page allows you to select up to six (6) categories that will be displayed prominently on the homepage. Simply check the categories you want to feature and click 'Update' to save your changes.</p>
            {{-- <div class="image-container text-center mb-4">
                <img src="{{ asset('admin-pictures/category-news.png') }}" alt="Top Bar Trending News" class="img-fluid">
            </div> --}}

            <div class="image-container text-center mb-4">
                <a href="{{ asset('admin-pictures/category-news.png') }}" target="">
                    <img src="{{ asset('admin-pictures/category-news.png') }}" alt="Top Bar Trending News" class="img-fluid category-styled-image">
                </a>
            </div>
            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
            @endif
            <form action="{{ route('categories.update_homepage') }}" method="POST">
                @csrf
                <div class="row">
                    @foreach ($categories as $category)
                    <div class="col-lg-2 mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="categories[]" id="category_{{ $category->id }}" value="{{ $category->id }}" {{ $category->show_on_homepage ? 'checked' : '' }}>
                            <label class="form-check-label" for="category_{{ $category->id }}">
                                {{ $category->name }}
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary mt-3">Update</button>
            </form>

              <!-- Pagination Links -->
              <div class="d-flex justify-content-center mt-4">
                {{ $categories->links('pagination::simple-bootstrap-5') }}
            </div>

           
        </div>
    </div>
</div>
@endsection





