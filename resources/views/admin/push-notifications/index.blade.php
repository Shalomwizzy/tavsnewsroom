@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Config warning --}}
    @if(!$isConfigured)
    <div class="alert alert-warning mt-3">
        <strong>OneSignal not configured.</strong>
        Add <code>ONESIGNAL_APP_ID</code> and <code>ONESIGNAL_REST_API_KEY</code> to your <code>.env</code> file.
        <a href="https://onesignal.com" target="_blank" class="alert-link">Get your keys at onesignal.com →</a>
    </div>
    @endif

    <div class="row mt-4 g-4">

        {{-- ── Send Custom Notification ────────────────────────────── --}}
        <div class="col-lg-6">
            <div class="card h-100 shadow-sm">
                <div class="card-header d-flex align-items-center gap-2">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    <strong>Send Custom Notification</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.push.send') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                   placeholder="Breaking: Something just happened…" maxlength="255"
                                   value="{{ old('title') }}" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Message <span class="text-danger">*</span></label>
                            <textarea name="message" class="form-control @error('message') is-invalid @enderror"
                                      rows="3" maxlength="500"
                                      placeholder="A short description that makes readers want to click…" required>{{ old('message') }}</textarea>
                            @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="text-muted">Max 500 characters</small>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Link URL <span class="text-muted fw-normal">(optional)</span></label>
                            <input type="url" name="url" class="form-control @error('url') is-invalid @enderror"
                                   placeholder="https://yoursite.com/2025/01/15/article-slug"
                                   value="{{ old('url') }}">
                            @error('url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="text-muted">Leave blank to link to the homepage</small>
                        </div>
                        <button type="submit" class="btn btn-danger w-100" {{ !$isConfigured ? 'disabled' : '' }}>
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" style="vertical-align:middle;margin-right:6px;"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
                            Send to All Subscribers
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ── Push a Published Article ────────────────────────────── --}}
        <div class="col-lg-6">
            <div class="card h-100 shadow-sm">
                <div class="card-header d-flex align-items-center gap-2">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14,2 14,8 20,8"/></svg>
                    <strong>Push a Published Article</strong>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">Select any published article and push it to all subscribers instantly — uses the article headline, summary, and image automatically.</p>
                    <form action="{{ route('admin.push.send-post') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Select Article <span class="text-danger">*</span></label>
                            <select name="post_id" class="form-select" required>
                                <option value="">— Choose a recent article —</option>
                                @foreach($recentPosts as $post)
                                    <option value="{{ $post->id }}">
                                        {{ \Illuminate\Support\Str::limit($post->headline, 70) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-danger w-100" {{ !$isConfigured ? 'disabled' : '' }}>
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" style="vertical-align:middle;margin-right:6px;"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
                            Push This Article
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ── Notification History ────────────────────────────────── --}}
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="12,8 12,12 14,14"/><path d="M3.05 11a9 9 0 1 0 .5-4.5"/><polyline points="3,3 3,11 11,11"/></svg>
                        <strong>Notification History</strong>
                    </div>
                    <span class="badge bg-secondary">{{ $notifications->total() }} total</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Title</th>
                                <th>Message</th>
                                <th>Type</th>
                                <th>Recipients</th>
                                <th>Sent By</th>
                                <th>Sent At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($notifications as $n)
                            <tr>
                                <td>
                                    @if($n->url)
                                        <a href="{{ $n->url }}" target="_blank" class="fw-semibold text-decoration-none">
                                            {{ \Illuminate\Support\Str::limit($n->title, 50) }}
                                        </a>
                                    @else
                                        <span class="fw-semibold">{{ \Illuminate\Support\Str::limit($n->title, 50) }}</span>
                                    @endif
                                </td>
                                <td class="text-muted small">{{ \Illuminate\Support\Str::limit($n->message, 80) }}</td>
                                <td>
                                    <span class="badge {{ $n->type === 'auto' ? 'bg-primary' : 'bg-success' }}">
                                        {{ ucfirst($n->type) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold">{{ number_format($n->recipients) }}</span>
                                </td>
                                <td class="small">{{ $n->sender?->name ?? ($n->type === 'auto' ? 'Auto' : '—') }}</td>
                                <td class="small text-muted">{{ $n->created_at->diffForHumans() }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No notifications sent yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($notifications->hasPages())
                <div class="card-footer">
                    {{ $notifications->links() }}
                </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
