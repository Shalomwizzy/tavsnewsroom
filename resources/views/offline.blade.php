@extends('layouts.app')

@section('meta_title', 'You are offline')

@section('content')
<div class="container-fluid py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center py-5">
                <i class="fa fa-wifi" style="font-size: 4rem; color: #DC143C; margin-bottom: 1.5rem; display: block;"></i>
                <h1 class="h2-headline mb-3">You are offline</h1>
                <p class="text-muted mb-4">It looks like you lost your internet connection. Please check your network and try again.</p>
                <button onclick="window.location.reload()" class="btn btn-danger px-4">
                    <i class="fa fa-rotate-right me-2"></i>Try Again
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
