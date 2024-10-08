@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 contacts-section">
            <h4>Contacts</h4>
            <ul class="list-group">
                @foreach ($users as $user)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="{{ route('messages.index', ['receiver_id' => $user->id]) }}">
                            {{ $user->username }}
                        </a>
                        @if($unreadMessages->has($user->id))
                            <span class="badge bg-danger">{{ $unreadMessages[$user->id] }}</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-9 chat-section">
            @if($receiver_id)
            <div class="chat-window">
                <div class="chat-header">
                    <h4>Chat with {{ \App\Models\User::find($receiver_id)->name }}</h4>
                </div>
                <div class="chat-body" style="display: flex; flex-direction: column; height: 100%; overflow-y: auto;">
                    @foreach ($messages as $message)
                        <div style="padding: 10px; border-radius: 10px; margin-bottom: 10px; max-width: 60%; word-wrap: break-word; {{ $message->sender_id == Auth::id() ? 'background-color: blue; color: white; align-self: flex-end;' : 'background-color: #e9ecef; border: 1px solid #ccc; align-self: flex-start;' }}">
                            <p>{{ $message->message }}</p>
                            <small>{{ $message->created_at->diffForHumans() }}</small>
                        </div>
                    @endforeach
                </div>
                <div class="chat-footer">
                    <form action="{{ route('messages.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $receiver_id }}">
                        <div class="input-group">
                            <textarea class="form-control" name="message" rows="1" placeholder="Type a message"></textarea>
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </form>
                </div>
            </div>
            @else
            <div class="chat-window">
                <div class="chat-header">
                    <h4>Select a contact to start chatting</h4>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')

@endsection

@section('head-scripts')
<script>
// If you need any specific scripts for this view, you can add them here
</script>
@endsection

@php
    $useTinyMCE = false;
@endphp






















































{{-- @extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 contacts-section">
            <h4>Contacts</h4>
            <ul class="list-group">
                @foreach ($users as $user)
                    <li class="list-group-item">
                        <a href="{{ route('messages.index', ['receiver_id' => $user->id]) }}">
                            {{ $user->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-9 chat-section">
            @if($receiver_id)
            <div class="chat-window">
                <div class="chat-header">
                    <h4>Chat with {{ \App\Models\User::find($receiver_id)->name }}</h4>
                </div>
                <div class="chat-body" style="display: flex; flex-direction: column; height: 100%; overflow-y: auto;">
                    @foreach ($messages as $message)
                        <div style="padding: 10px; border-radius: 10px; margin-bottom: 10px; max-width: 60%; word-wrap: break-word; {{ $message->sender_id == Auth::id() ? 'background-color: blue; color: white; align-self: flex-end;' : 'background-color: #e9ecef; border: 1px solid #ccc; align-self: flex-start;' }}">
                            <p>{{ $message->message }}</p>
                            <small>{{ $message->created_at->diffForHumans() }}</small>
                        </div>
                    @endforeach
                </div>
                <div class="chat-footer">
                    <form action="{{ route('messages.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $receiver_id }}">
                        <div class="input-group">
                            <textarea class="form-control" name="message" rows="1" placeholder="Type a message"></textarea>
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </form>
                </div>
            </div>
            @else
            <div class="chat-window">
                <div class="chat-header">
                    <h4>Select a contact to start chatting</h4>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .contacts-section {
        padding: 10px;
        background-color: #f8f9fa;
        border-right: 1px solid #dee2e6;
        height: 100vh;
    }

    .chat-section {
        display: flex;
        flex-direction: column;
        height: 100vh;
    }

    .chat-window {
        display: flex;
        flex-direction: column;
        height: 100%;
        width: 100%;
    }

    .chat-header, .chat-footer {
        padding: 10px;
        background-color: #f1f1f1;
        border-bottom: 1px solid #dee2e6;
    }

    .chat-body {
        flex: 1;
        padding: 10px;
        overflow-y: auto;
        background-color: #fff;
    }

    .chat-message {
        padding: 10px;
        border-radius: 10px;
        margin-bottom: 10px;
        max-width: 60%;
    }

    .chat-message-sent {
        background-color: blue;
        color: white;
        align-self: flex-end;
    }

    .chat-message-received {
        background-color: #e9ecef;
        border: 1px solid #ccc;
        align-self: flex-start;
    }

    .input-group {
        display: flex;
        align-items: center;
    }

    .input-group textarea {
        flex: 1;
        resize: none;
        border-radius: 15px;
        border: 1px solid #ced4da;
        padding: 10px;
    }

    .input-group button {
        margin-left: 10px;
        border-radius: 50%;
    }
</style>
@endsection

@section('head-scripts')
<script>
// If you need any specific scripts for this view, you can add them here
</script>
@endsection

@php
    $useTinyMCE = false;
@endphp --}}



















































{{-- @extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 contacts-section">
            <h4>Contacts</h4>
            <ul class="list-group">
                @foreach ($users as $user)
                    <li class="list-group-item">
                        <a href="{{ route('messages.index', ['receiver_id' => $user->id]) }}">
                            {{ $user->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-9 chat-section">
            @if($receiver_id)
            <div class="chat-window">
                <div class="chat-header">
                    <h4>Chat with {{ \App\Models\User::find($receiver_id)->name }}</h4>
                </div>
                <div class="chat-body">
                    @foreach ($messages as $message)
                        <div class="chat-message {{ $message->sender_id == Auth::id() ? 'chat-message-sent' : 'chat-message-received' }}">
                            <p>{{ $message->message }}</p>
                            <small>{{ $message->created_at->diffForHumans() }}</small>
                        </div>
                    @endforeach
                </div>
                <div class="chat-footer">
                    <form action="{{ route('messages.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $receiver_id }}">
                        <div class="input-group">
                            <textarea class="form-control" name="message" rows="1" placeholder="Type a message"></textarea>
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </form>
                </div>
            </div>
            @else
            <div class="chat-window">
                <div class="chat-header">
                    <h4>Select a contact to start chatting</h4>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .contacts-section {
        padding: 10px;
        background-color: #f8f9fa;
        border-right: 1px solid #dee2e6;
        height: 100vh;
    }

    .chat-section {
        display: flex;
        flex-direction: column;
        height: 100vh;
    }

    .chat-window {
        display: flex;
        flex-direction: column;
        height: 100%;
        width: 100%;
    }

    .chat-header, .chat-footer {
        padding: 10px;
        background-color: #f1f1f1;
        border-bottom: 1px solid #dee2e6;
    }

    .chat-body {
        flex: 1;
        padding: 10px;
        overflow-y: auto;
        background-color: #fff;
    }

    .chat-message {
        padding: 10px;
        border-radius: 10px;
        margin-bottom: 10px;
        max-width: 60%;
    }

    .chat-message-sent {
        /* background-color: #dcf8c6; */
        background-color: blue !important;
        align-self: flex-end;
    }

    .chat-message-received {
        background-color: #fff;
        align-self: flex-start;
        border: 1px solid #ccc;
    }

    .input-group {
        display: flex;
        align-items: center;
    }

    .input-group textarea {
        flex: 1;
        resize: none;
        border-radius: 15px;
        border: 1px solid #ced4da;
        padding: 10px;
    }

    .input-group button {
        margin-left: 10px;
        border-radius: 50%;
    }
</style>
@endsection

@section('head-scripts')
<script>
// If you need any specific scripts for this view, you can add them here
</script>
@endsection

@php
    $useTinyMCE = false;
@endphp --}}




