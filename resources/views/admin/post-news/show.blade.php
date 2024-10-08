@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10 adminshow">
            <h2 class="display-4"><strong>Headline:</strong> {{ $post->headline }}</h2>
            <p><strong>Category:</strong> {{ $post->category->name }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($post->date)->format('F d, Y') }}</p>
            <div class="text-center">
                <img src="{{ asset($post->image_url) }}" alt="{{ $post->headline }}" class="img-fluid mb-3 rounded img-thumbnail">
            </div>
            <p><strong>Meta Title:</strong> {!! $post->meta_title !!}</p>
            <p><strong>Meta Description:</strong> {!! $post->meta_description !!}</p>
            <p><strong>Meta Keywords:</strong> {!! $post->meta_keywords !!}</p>
            <p><strong>Scheduled For:</strong> {{ $post->scheduled_for ? \Carbon\Carbon::parse($post->scheduled_for)->format('F d, Y H:i') : 'Not Scheduled' }}</p>
            <p><strong>Content:</strong> {!! $post->content !!}</p>
            {{-- <div class="">{!! $post->content !!}</div> --}}
        </div>
    </div>
</div>
@endsection

<style>
    .adminshow {
        background-color: #0000; /* Light background color */
        padding: 30px; /* Add padding for spacing */
        border-radius: 10px; /* Rounded corners */
        border: 1px solid white;
        margin-top: 20px; /* Add margin at the top */
    }

    .adminshow h2,
    .adminshow p {
        color: #6C7293 !important; /* Text color */
    }

    .adminshow h2 {
        font-size: 2rem; /* Larger headline font size */
        margin-bottom: 20px; /* Spacing below the headline */
    }

    .adminshow p {
        font-size: 1.1rem; /* Slightly larger text for better readability */
        margin-bottom: 15px; /* Spacing below paragraphs */
        color: #6C7293 !important; 
    }

    .adminshow .img-fluid {
        max-width: 75%;
        height: auto; 
    }



    .adminshow strong {
        line-height: 1.6; /* Improve readability */
        font-size: 1.1rem; /* Font size for content */
        color: rgb(255, 0, 0); /* Slightly lighter text color */
    }
</style>


