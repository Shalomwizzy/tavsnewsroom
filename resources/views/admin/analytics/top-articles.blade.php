@extends('layouts.admin')

@section('content')
<div class="container admin-view-index">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="display-4 h2-headline-admin">Top Articles</h2>
            <p class="admin-paragraph">Articles ranked by page views from your own visitor tracking.</p>

            <form method="GET" action="{{ route('admin.top-articles') }}" class="mb-4 d-flex align-items-center gap-2">
                <label class="me-2 mb-0 fw-bold">Period:</label>
                @foreach(['7' => 'Last 7 days', '30' => 'Last 30 days', '90' => 'Last 90 days', 'all' => 'All time'] as $value => $label)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="period" id="period_{{ $value }}"
                        value="{{ $value }}" {{ $period === $value ? 'checked' : '' }}
                        onchange="this.form.submit()">
                    <label class="form-check-label" for="period_{{ $value }}">{{ $label }}</label>
                </div>
                @endforeach
            </form>

            @if ($posts->isEmpty())
                <div class="alert alert-info">No view data recorded yet.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Headline</th>
                                <th>Category</th>
                                <th>Published</th>
                                <th class="text-end">Views</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $index => $post)
                            <tr>
                                <td>{{ ($posts->currentPage() - 1) * $posts->perPage() + $index + 1 }}</td>
                                <td>{{ $post->headline }}</td>
                                <td>{{ $post->category->name ?? '—' }}</td>
                                <td>{{ \Carbon\Carbon::parse($post->date)->format('M d, Y') }}</td>
                                <td class="text-end fw-bold">{{ number_format($post->views_count) }}</td>
                                <td>
                                    <a href="{{ route('post-news.read-more', [
                                        'year'  => \Carbon\Carbon::parse($post->date)->format('Y'),
                                        'month' => \Carbon\Carbon::parse($post->date)->format('m'),
                                        'day'   => \Carbon\Carbon::parse($post->date)->format('d'),
                                        'slug'  => $post->slug,
                                    ]) }}" target="_blank" class="btn btn-sm btn-outline-secondary">View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $posts->appends(['period' => $period])->links('pagination::simple-bootstrap-5') }}
            @endif
        </div>
    </div>
</div>
@endsection
