<!-- Example Blade View for Advertise Page -->
@extends('layouts.app')

@section('content')
<div class="container">
    @php
        $advertisePage = \App\Models\BlogSetting::where('key', 'advertise')->first();
    @endphp

    <h1>{{ $advertisePage->title }}</h1>
    <div>{!! $advertisePage->content !!}</div>
</div>
@endsection
