@extends('layouts.admin')

@section('content')
    <h2 class="h2-headline-admin">Edit Announcement</h2>
    
    <form action="{{ route('announcements.update', $announcement->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" value="{{ $announcement->title }}" required>
        </div>
        <div class="form-group">
            <label for="message">Message</label>
            <textarea name="message" class="form-control" required>{{ $announcement->message }}</textarea>
        </div>
        <div class="form-group">
            <label for="active">Active</label>
            <input type="checkbox" name="active" value="1" {{ $announcement->active ? 'checked' : '' }}>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
