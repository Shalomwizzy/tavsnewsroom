<!-- resources/views/admin/navbar-items/index.blade.php -->

@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 cat">
            <h4 class="text-white">Select Categories for Navbar</h4>
            <p class="mb-4">This page allows you to select up to three (3) categories that will be displayed prominently on the site's navbar. Simply check the categories you want to feature and click 'Save Changes' to update the navbar.</p>
            <div class="image-container text-center mb-4">
                <a href="{{ asset('admin-pictures/navbar-item.png') }}" target="">
                    <img src="{{ asset('admin-pictures/navbar-item.png') }}" alt="Top Bar Trending News" class="img-fluid">
                </a>
            </div>
            
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif

            <form action="{{ route('admin.navbar-items.store') }}" method="POST">
                @csrf
                <div class="row">
                    @foreach ($categories as $category)
                        <div class="col-lg-2 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="category_ids[]" id="category_{{ $category->id }}" value="{{ $category->id }}" 
                                    @if($selectedCategories->contains('category_id', $category->id)) checked @endif>
                                <label class="form-check-label" for="category_{{ $category->id }}">
                                    {{ $category->name }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
            </form>

            <!-- Pagination Links -->
            <div class="d-flex justify-content-center mt-4">
                {{ $categories->links('pagination::simple-bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection

