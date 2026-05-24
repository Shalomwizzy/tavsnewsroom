<!-- resources/views/admin/seo/index.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container-fluid pt-4 px-4 seo-insight">
    <div class="text-center rounded p-4">
        
            <h2 class=" h2-headline-admin">All Posts with SEO Scores and Suggestions</h2>
          
        
        <p class="admin-paragraph">
            This page displays a list of all posts along with their SEO scores and suggestions. You can review and analyze each post's SEO performance to make necessary improvements.
        </p>
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-white">
                        <th scope="col">No</th>
                        <th scope="col">Date</th>
                        <th scope="col">Headline</th>
                        <th scope="col">SEO&nbsp;Score</th>
                        <th scope="col">SEO Suggestions</th>
                        <th scope="col">Action</th>
                       
                    </tr>
                </thead>
                <tbody>
                    @foreach ($allPosts as $index => $post)
                    <tr>
                        <td>{{ ($allPosts->currentPage() - 1) * $allPosts->perPage() + $index + 1 }}</td>
                        <td>{{ $post->date }}</td>
                        <td>{{ $post->headline }}</td>
                        <td>{{ $post->seo_score }}</td>
                        <td>{{ $post->seo_suggestions }}</td>
                        <td><a class="btn btn-sm btn-primary" href="{{ route('seo.analyze', $post->id) }}">Analyze</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center mt-4">
            {{ $allPosts->links('pagination::simple-bootstrap-5') }}
        </div>
    </div>
</div>
@endsection

