<!-- resources/views/admin/blog-settings/edit.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-header">{{ ucfirst(str_replace('_', ' ', $setting->key)) }}</div>

                <div class="card-body">
                    <form action="{{ route('admin.blog-settings.update', $setting->key) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title">{{ ucfirst(str_replace('_', ' ', $setting->key)) }} Title</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ $setting->title }}">
                        </div>
                        <div class="form-group">
                            <label for="content">{{ ucfirst(str_replace('_', ' ', $setting->key)) }} Content</label>
                            <textarea name="content" id="content" class="form-control" rows="5">{{ $setting->content }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
