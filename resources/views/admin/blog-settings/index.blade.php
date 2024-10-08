<!-- resources/views/admin/blog-settings.blade.php -->

@extends('layouts.admin')

@section('content')
<div class="quick-link-setting container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-header">
                  <h2 class="h2-headline-admin">Quick Link Write up</h2>
                </div>

                <div class="card-body">
                    <p class="description">
                        This page allows you to manage the text content for each quick link that will be displayed on the footer. Click on any item to edit its content.
                    </p>
                    <div class="row">
                        @foreach($settings as $setting)
                            @if ($setting->key !== 'brand_name')
                                <div class="col-md-6 mb-3">
                                    <div class="list-group-item">
                                        <a href="{{ route('admin.blog-settings.edit', $setting->key) }}">
                                            {{ ucfirst(str_replace('_', ' ', $setting->key)) }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection






<!-- resources/views/admin/blog-settings.blade.php -->
{{-- @extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-header">Blog Settings</div>

                <div class="card-body">
                    <form action="{{ route('admin.blog-settings.save') }}" method="POST">
                        @csrf
                        @foreach($settings as $setting)
                            <div class="form-group">
                                <label for="title_{{ $setting->key }}">{{ ucfirst(str_replace('_', ' ', $setting->key)) }} Title</label>
                                <input type="text" name="settings[{{ $loop->index }}][title]" id="title_{{ $setting->key }}" class="form-control" value="{{ $setting->title }}">
                                <input type="hidden" name="settings[{{ $loop->index }}][key]" value="{{ $setting->key }}">
                            </div>
                            <div class="form-group">
                                <label for="content_{{ $setting->key }}">{{ ucfirst(str_replace('_', ' ', $setting->key)) }} Content</label>
                                <textarea name="settings[{{ $loop->index }}][content]" id="content_{{ $setting->key }}" class="form-control" rows="5">{{ $setting->content }}</textarea>
                            </div>
                        @endforeach
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}

{{-- @extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-header">Update Brand Name</div>

                <div class="card-body">
                    <form action="{{ route('admin.blog-settings.save') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="brand_name">Brand Name</label>
                            <input type="text" name="brand_name" id="brand_name" class="form-control" value="{{ $brandName }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
