@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h2>Create New News Post</h2>
            <form id="newsForm" action="{{ route('post-news.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="headline">Headline:</label>
                    <input type="text" class="form-control" id="headline" name="headline" required>
                </div>
                <div class="form-group">
                    <label for="category_id">Category:</label>
                    <select class="form-control" id="category_id" name="category_id" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="date">Date:</label>
                    <input type="date" class="form-control" id="date" name="date" required>
                </div>
                <div class="form-group">
                    <label for="image">Featured Image:</label>
                    <input type="file" class="form-control-file" id="image" name="image" required>
                </div>
                <div class="form-group">
                    <label for="content">Content:</label>
                    <textarea id="content" name="content" rows="10" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="meta_title">Meta Title:</label>
                    <input type="text" class="form-control" id="meta_title" name="meta_title">
                </div>
                <div class="form-group">
                    <label for="meta_description">Meta Description:</label>
                    <textarea class="form-control" id="meta_description" name="meta_description" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="meta_keywords">Meta Keywords:</label>
                    <textarea class="form-control" id="meta_keywords" name="meta_keywords" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="status">Status:</label>
                    <select class="form-control" id="status" name="status">
                        <option value="draft">Draft</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="scheduled_for">Schedule for:</label>
                    <input type="datetime-local" class="form-control" id="scheduled_for" name="scheduled_for">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection








