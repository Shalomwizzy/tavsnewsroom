<!-- resources/views/admin/clear-caches.blade.php -->

@extends('layouts.admin')

@section('content')
<div class="container clear-caches">
    <h2 class="h2-headline-admin">Clear Caches & Optimize</h2>
    <p class="admin-paragraph">This page allows you to clear all caches and optimize the application. Please use this functionality to ensure the application runs smoothly and efficiently.</p>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="form-container">
        <form action="{{ route('admin.clear.caches') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Clear Caches & Optimize</button>
        </form>
    </div>
</div>
@endsection

@section('styles')

@endsection


