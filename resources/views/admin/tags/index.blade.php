<!-- resources/views/admin/select_tags.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container admin-tags">
    <h2 class="h2-headline-admin">Select Tags to Display</h2>
    <p class="description admin-paragraph">This page allows you to select the tags that will be displayed on the home page. Select the tags you want to display and click 'Save'.</p>
    <div class="image-container text-center mb-4">
        <a href="{{ asset('admin-pictures/tags.png') }}" target="">
            <img src="{{ asset('admin-pictures/tags.png') }}" alt="Top Bar Trending News" class="img-fluid styled-image">
        </a>
    </div>
    <form action="{{ route('tags.update') }}" method="POST">
        @csrf
        <div class="tag-grid">
            @foreach($categories as $category)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="selected_tags[]" value="{{ $category->id }}" id="category-{{ $category->id }}"
                    {{ in_array($category->id, $selectedTags) ? 'checked' : '' }}>
                    <label class="form-check-label" for="category-{{ $category->id }}">
                        {{ $category->name }}
                    </label>
                </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary save-selection-button">Save Selection</button>
    </form>
</div>
@endsection


<style>
    /* Add this to your CSS file or inside a <style> block in the Blade template */

.admin-tags {
    background-color: #0000;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.admin-tags h2 {
    font-size: 24px;
    margin-bottom: 10px;
    text-align: center;
    font-family: Georgia, 'Times New Roman', Times, serif;
}

.admin-tags .description {
    font-size: 16px;
    color: #6C7293 !important; 
    font-family: Georgia, 'Times New Roman', Times, serif;
    margin-bottom: 20px;
}

.admin-tags .tag-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
}

.admin-tags .form-check {
    background-color: #0000;
    color: #6C7293 !important; 
    padding: 10px;
    border-radius: 5px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

.admin-tags .form-check-input {
    margin-right: 10px;
    color: #6C7293 !important; 
}

.admin-tags .form-check-label {
    font-size: 14px;
    color: #6C7293 !important; 
}



</style>