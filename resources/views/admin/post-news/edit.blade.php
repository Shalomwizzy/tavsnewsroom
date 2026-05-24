<!-- resources/views/admin/post-news/edit.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h2>Edit News Post</h2>

            <div id="aiSuggestBanner" class="alert alert-success d-none" role="alert">
                <strong>✨ AI filled in:</strong> category, meta keywords, meta title and meta description. Review and adjust if needed.
            </div>
            <div id="aiSuggestError" class="alert alert-danger d-none" role="alert"></div>

            <form action="{{ route('post-news.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="headline">Headline:</label>
                    <input type="text" class="form-control" id="headline" name="headline" value="{{ $post->headline }}">
                </div>
                <div class="form-group">
                    <label for="category_id">Category:</label>
                    <select class="form-control" id="category_id" name="category_id">
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $post->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="date">Date:</label>
                    <input type="date" class="form-control" id="date" name="date" value="{{ $post->date }}">
                </div>
                <div class="form-group">
                    <label for="image">Image:</label>
                    <input type="file" class="form-control-file" id="image" name="image">
                </div>
                <div class="form-group">
                    <label for="content">Content:</label>
                    <textarea class="form-control" id="content" name="content" rows="6">{{ $post->content }}</textarea>
                </div>

                <!-- AI Suggest Button -->
                <div class="ai-suggest-bar">
                    <button type="button" id="aiSuggestBtn" class="btn btn-ai-suggest">
                        <span id="aiSuggestIdle">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" style="vertical-align:middle;margin-right:5px;"><path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z"/></svg>
                            AI Suggest — Fill Category, Keywords &amp; SEO Meta
                        </span>
                        <span id="aiSuggestLoading" class="d-none">
                            <span class="spinner-border spinner-border-sm" role="status"></span>
                            Analysing article…
                        </span>
                    </button>
                    <small class="text-muted ms-2">Powered by Gemini AI — fills 4 fields in one click</small>
                </div>

                <div class="form-group">
                    <label for="meta_title">Meta Title:</label>
                    <input type="text" class="form-control" id="meta_title" name="meta_title" value="{{ $post->meta_title }}">
                </div>
                <div class="form-group">
                    <label for="meta_description">Meta Description:</label>
                    <textarea class="form-control" id="meta_description" name="meta_description" rows="3">{{ $post->meta_description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="meta_keywords">Meta Keywords:</label>
                    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" value="{{ $post->meta_keywords }}">
                </div>
                <div class="form-group">
                    <label for="status">Status:</label>
                    <select class="form-control" id="status" name="status">
                        <option value="draft" {{ $post->status == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="pending" {{ $post->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="published" {{ $post->status == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                </div>
                <div class="form-group form-check mt-2">
                    <input type="checkbox" class="form-check-input" id="is_breaking" name="is_breaking" value="1" {{ $post->is_breaking ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_breaking">Mark as Breaking News</label>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
@include('admin.post-news._ai-suggest-script')
@endpush
@endsection
