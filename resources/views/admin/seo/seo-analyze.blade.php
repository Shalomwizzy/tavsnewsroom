<!-- resources/views/admin/seo/seo-analyze.blade.php -->
@extends('layouts.admin')

@section('content')

<div class="container seo-analysis-container">
    <div class="row">
        <div class="col-lg-12">
            <h2>SEO Analysis for: {{ $post->headline }}</h2>
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">SEO Score</h5>
                    <p class="card-text">{{ $seo_score }}</p>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">SEO Suggestions</h5>
                    <ul class="list-group list-group-flush">
                        @foreach($seo_suggestions as $suggestion)
                            <li class="list-group-item">{{ $suggestion }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <a href="{{ route('seo.index') }}" class="btn btn-primary mt-4">Back to SEO Dashboard</a>
        </div>
    </div>
</div>
@endsection

