@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2 class="h2-headline-admin">Create Announcement</h2>
        
        <form action="{{ route('announcements.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea name="message" class="form-control" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="active">Active</label>
                <input type="checkbox" name="active" value="1">
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection

