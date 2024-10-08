<!-- Example Blade View for About Page -->
@extends('layouts.app')

@section('content')
<div class="container">
    @php
        $aboutPage = \App\Models\BlogSetting::where('key', 'about')->first();
    @endphp

    <h1>{{ $aboutPage->title }}</h1>
    <div>{!! $aboutPage->content !!}</div>
</div>
@endsection
