@extends('layouts.app')

@section('meta_title', 'Admin Login')

@section('content')
<div class="container-fluid d-flex p-0" style="min-height:100vh;">
    <div class="container-fluid">
        <div class="row h-100 align-items-center justify-content-center" style="min-height:100vh;">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                <div class="rounded p-4 p-sm-5 my-4 mx-3" style="background:#0d0d0d;">

                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <a href="{{ url('/') }}" class="text-decoration-none">
                            <h3 style="color:#DC143C;font-family:Georgia,serif;margin:0;">
                                {{ \App\Models\WebsiteSetting::getValue('site_name', config('app.name')) }}
                            </h3>
                        </a>
                        <span class="text-white fw-semibold">Admin Portal</span>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success mb-3">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('admin.login.post') }}">
                        @csrf

                        <div class="form-floating mb-3">
                            <input
                                type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                id="email"
                                name="email"
                                placeholder="name@example.com"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                                autofocus
                            >
                            <label for="email">Email address</label>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-floating mb-4">
                            <input
                                type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                id="password"
                                name="password"
                                placeholder="Password"
                                required
                                autocomplete="current-password"
                            >
                            <label for="password">Password</label>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="form-check">
                                <input
                                    type="checkbox"
                                    class="form-check-input"
                                    id="remember"
                                    name="remember"
                                    {{ old('remember') ? 'checked' : '' }}
                                >
                                <label class="form-check-label text-secondary" for="remember">Remember me</label>
                            </div>
                            <a href="{{ route('password.request') }}" class="text-secondary">Forgot Password?</a>
                        </div>

                        <button type="submit" class="btn w-100 py-3 mb-4 fw-bold" style="background:#DC143C;color:#fff;">
                            Sign In as Admin
                        </button>

                        <p class="text-center text-secondary mb-0" style="font-size:.875rem;">
                            Are you a writer? <a href="{{ route('author.login') }}" style="color:#DC143C;">Author login</a>
                        </p>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
