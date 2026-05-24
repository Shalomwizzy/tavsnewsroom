@extends('layouts.admin')
@section('title', 'AI Blog Generator')

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold">AI Blog Generator</h1>
            <p class="text-muted mb-0 small">Powered by <strong>Groq</strong> (writer) + <strong>Gemini</strong> (editor &amp; SEO)</p>
        </div>
        <span class="badge bg-success px-3 py-2" style="font-size:13px;">
            <i class="fa fa-circle me-1" style="font-size:8px;"></i> Active
        </span>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Stats row --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center py-4">
                    <div class="fw-bold fs-2 text-danger">{{ $stats['total'] }}</div>
                    <div class="text-muted small">Total Generated</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center py-4">
                    <div class="fw-bold fs-2 text-success">{{ $stats['today'] }}</div>
                    <div class="text-muted small">Published Today</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center py-4">
                    <div class="fw-bold fs-2 text-primary">{{ $stats['avg_score'] }}%</div>
                    <div class="text-muted small">Avg Humanness Score</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center py-4">
                    <div class="fw-bold fs-2">{{ number_format($stats['avg_words']) }}</div>
                    <div class="text-muted small">Avg Word Count</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Generate card --}}
    <div class="card border-0 shadow-sm mb-4" style="border-left: 4px solid #DC143C !important;">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-1">Generate New Article</h5>
            <p class="text-muted small mb-3">Gemini will pick a trending SEO topic, Groq will write it, Gemini will review and humanize it, then it auto-publishes.</p>

            <form action="{{ route('admin.ai-blog.generate') }}" method="POST">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold">Target Category <span class="text-muted fw-normal">(optional)</span></label>
                        <select name="category_id" class="form-select">
                            <option value="">Let AI decide</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-danger px-4 py-2 fw-semibold w-100">
                            <i class="fa fa-bolt me-2"></i>Generate Article Now
                        </button>
                    </div>
                    <div class="col-md-4">
                        <p class="text-muted small mb-0">
                            <i class="fa fa-clock me-1"></i> Takes 30–90 seconds.<br>
                            <i class="fa fa-refresh me-1"></i> Refresh this page to see the result.
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Pipeline info --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <h6 class="fw-bold mb-3">How It Works</h6>
            <div class="row g-2 text-center">
                @php
                $steps = [
                    ['icon'=>'fa-search','label'=>'Gemini','desc'=>'Picks trending SEO topic','color'=>'#4285F4'],
                    ['icon'=>'fa-pencil','label'=>'Groq','desc'=>'Writes 650+ word article','color'=>'#F56040'],
                    ['icon'=>'fa-user-check','label'=>'Gemini','desc'=>'Scores humanness (0–100)','color'=>'#4285F4'],
                    ['icon'=>'fa-sync','label'=>'Groq','desc'=>'Rewrites if score < 90%','color'=>'#F56040'],
                    ['icon'=>'fa-image','label'=>'Pexels','desc'=>'Downloads article image','color'=>'#05A081'],
                    ['icon'=>'fa-check-circle','label'=>'Auto-publish','desc'=>'Posted with full SEO meta','color'=>'#DC143C'],
                ];
                @endphp
                @foreach($steps as $i => $step)
                <div class="col-6 col-md-2">
                    <div class="p-2">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                             style="width:42px;height:42px;background:{{ $step['color'] }}20;">
                            <i class="fa {{ $step['icon'] }}" style="color:{{ $step['color'] }};"></i>
                        </div>
                        <div class="small fw-semibold">{{ $step['label'] }}</div>
                        <div class="text-muted" style="font-size:11px;">{{ $step['desc'] }}</div>
                    </div>
                    @if($i < count($steps)-1)
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Generation log --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
            <h6 class="fw-bold mb-0">Generation History</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Headline</th>
                            <th>Status</th>
                            <th>Humanness</th>
                            <th>Words</th>
                            <th>Attempts</th>
                            <th>Generated</th>
                            <th class="pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td class="ps-4" style="max-width:280px;">
                                <div class="fw-semibold text-truncate" title="{{ $log->headline }}">
                                    {{ $log->headline ?? 'Generating...' }}
                                </div>
                                @if($log->topic)
                                    <div class="text-muted small text-truncate" title="{{ $log->topic }}">{{ $log->topic }}</div>
                                @endif
                            </td>
                            <td>
                                @if($log->status === 'completed')
                                    <span class="badge bg-success">Published</span>
                                @elseif($log->status === 'failed')
                                    <span class="badge bg-danger" title="{{ $log->error }}">Failed</span>
                                @else
                                    <span class="badge bg-warning text-dark">In Progress</span>
                                @endif
                            </td>
                            <td>
                                @if($log->humanness_score)
                                    <span class="fw-semibold {{ $log->humanness_score >= 90 ? 'text-success' : ($log->humanness_score >= 75 ? 'text-warning' : 'text-danger') }}">
                                        {{ $log->humanness_score }}%
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>{{ $log->word_count ? number_format($log->word_count) : '—' }}</td>
                            <td>{{ $log->attempts }}</td>
                            <td class="text-muted small">{{ $log->created_at->diffForHumans() }}</td>
                            <td class="pe-4">
                                @if($log->post_news_id)
                                    <a href="{{ route('admin.post-news.show', $log->post_news_id) }}" class="btn btn-sm btn-outline-secondary">
                                        View Post
                                    </a>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fa fa-bolt fa-2x mb-3 d-block opacity-25"></i>
                                No articles generated yet. Hit <strong>Generate Article Now</strong> above.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($logs->hasPages())
                <div class="px-4 py-3">{{ $logs->links() }}</div>
            @endif
        </div>
    </div>

</div>
@endsection
