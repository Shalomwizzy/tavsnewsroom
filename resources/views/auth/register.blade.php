@extends('layouts.app')

@section('content')
<div class="container-fluid position-relative d-flex p-0">
    <div class="container-fluid">
        <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                <div class="rounded p-4 p-sm-5 my-4 mx-3 register-user">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <a href="{{ url('/') }}" class="">
                            <h3 class="text-primary">Site Name</h3>
                        </a>
                    </div>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="username" name="username" placeholder="jhondoe" value="{{ old('username') }}" required autocomplete="username">
                            <label for="username">Username</label>
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}" required autocomplete="email">
                            <label for="email">Email address</label>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required autocomplete="new-password">
                            <label for="password">Password</label>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="password-confirm" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
                            <label for="password-confirm">Confirm Password</label>
                        </div>
                        @if(\App\Models\User::count() > 0)
                        <div class="form-floating mb-3">
                            <select class="form-select" id="role" name="role" required>
                                <option value="guest">Guest</option>
                                <option value="writer">Writer</option>
                                <option value="admin">Admin</option>
                            </select>
                            <label for="role">Role</label>
                            @error('role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror                                                                                                                                                                                     
                        </div>
                        @endif
                        <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Register</button>
                        <p class="text-center mb-0">Already have an Account? <a href="{{ route('login') }}">Sign In</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .register-user {
        background-color: black !important;
        font-family: Georgia, 'Times New Roman', Times, serif; 
    }
</style>
@endsection
