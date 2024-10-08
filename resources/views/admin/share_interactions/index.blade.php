@extends('layouts.admin')

@section('content')
<div class="container share-interactions">
    <h2 class="h2-headline-admin">Share Interactions</h2>
    <p class="admin-paragraph">This page displays the interactions of posts shared across different platforms. Each post is listed with the platform it was shared on and the total number of shares on that platform.</p>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Post Title</th>
                <th>Share Type</th>
                <th>Share Count</th>
            </tr>
        </thead>
        <tbody>
            @foreach($shareInteractions as $index => $interaction)
                <tr>
                    <td>{{ ($shareInteractions->currentPage() - 1) * $shareInteractions->perPage() + $index + 1 }}</td>
                    <td>{{ $interaction->postNews->headline }}</td>
                    <td>{{ ucfirst($interaction->share_type) }}</td>
                    <td>{{ $interaction->share_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center mt-4">
        {{ $shareInteractions->links('pagination::simple-bootstrap-5') }}
    </div>
</div>
@endsection


