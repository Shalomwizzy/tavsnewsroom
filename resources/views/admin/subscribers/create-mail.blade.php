


<!-- resources/views/admin/subscribers/create-mail.blade.php -->

@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="h2-headline-admin">Send Email to Subscribers</h2>
    <p class="description admin-paragraph">Use the form below to send an email to all subscribers. Make sure to provide a clear and concise message.</p>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.subscribers.mail') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="message">Message</label>
            <textarea name="message" id="message" rows="5" class="form-control">{{ old('message') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Send Email</button>
    </form>
</div>
@endsection
