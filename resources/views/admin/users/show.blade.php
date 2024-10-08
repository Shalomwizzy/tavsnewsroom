@extends('layouts.admin')

@section('content')
<div class="container user-show">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('User Details') }}</div>

                <div class="card-body">
                    <p><strong>Username:</strong> {{ $user->username }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Your Role:</strong> {{ ucfirst($user->role) }}</p>
                    <p><strong>Profile Picture:</strong> <img src="{{ asset($user->profile_picture) }}" alt="Profile Picture" width="100"></p>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

