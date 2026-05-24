@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="d-flex align-items-center justify-content-between mb-3">
                <h4 class="mb-0">Edit User — {{ $user->username }}</h4>
                <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fa fa-arrow-left me-1"></i> Back
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-header">Account Details</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('users.update', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                id="username" name="username" value="{{ old('username', $user->username) }}" required>
                            @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="role" class="form-label">Role</label>
                            <select id="role" name="role"
                                class="form-select @error('role') is-invalid @enderror"
                                onchange="togglePermissions(this.value)"
                                required>
                                <option value="writer" {{ old('role', $user->role) === 'writer' ? 'selected' : '' }}>Writer (Author)</option>
                                <option value="admin"  {{ old('role', $user->role) === 'admin'  ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- PERMISSIONS (writer only) --}}
                        @php
                            $sections     = config('writer_permissions.sections');
                            $userPerms    = old('permissions', $user->permissions ?? []);
                        @endphp

                        <div id="permissions-block" style="{{ old('role', $user->role) === 'writer' ? '' : 'display:none;' }}">
                            <label class="form-label fw-semibold">Dashboard Access</label>
                            <p class="text-muted small mb-2">Choose which sections this writer can access.</p>

                            <div class="row g-2">
                                @foreach ($sections as $key => $section)
                                    <div class="col-12 col-sm-6">
                                        <div class="form-check form-switch p-3 rounded border">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                name="permissions[]"
                                                value="{{ $key }}"
                                                id="perm_{{ $key }}"
                                                {{ in_array($key, $userPerms) ? 'checked' : '' }}
                                            >
                                            <label class="form-check-label ms-2" for="perm_{{ $key }}">
                                                <i class="fa {{ $section['icon'] }} me-1"></i>
                                                {{ $section['label'] }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-2 d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="toggleAll(true)">Select All</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="toggleAll(false)">Clear All</button>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-danger w-100">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Bio / profile update (own account only) --}}
            @if(Auth::id() === $user->id)
            <div class="card">
                <div class="card-header">Update Your Profile</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('user.updateAccount') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="bio" class="form-label">Bio</label>
                            <textarea class="form-control" id="bio" name="bio" rows="3" maxlength="500">{{ old('bio', $user->bio) }}</textarea>
                            <small class="text-muted">Shown on your public author page.</small>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="password" name="password" autocomplete="new-password">
                            <small class="text-muted">Leave blank to keep current password.</small>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
                        </div>

                        <div class="mb-3">
                            <label for="profile_picture" class="form-label">Profile Picture</label>
                            <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*">
                            @if($user->profile_picture)
                                <img src="{{ asset($user->profile_picture) }}" class="mt-2 rounded-circle" width="60" height="60" style="object-fit:cover;">
                            @endif
                        </div>

                        <button type="submit" class="btn btn-outline-secondary w-100">Update Profile</button>
                    </form>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>

<script>
function togglePermissions(role) {
    document.getElementById('permissions-block').style.display = role === 'writer' ? '' : 'none';
}
function toggleAll(state) {
    document.querySelectorAll('#permissions-block input[type="checkbox"]')
        .forEach(cb => cb.checked = state);
}
</script>
@endsection
