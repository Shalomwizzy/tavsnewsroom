<!-- Example Blade View for Contact Page -->
@extends('layouts.app')

@section('content')
<div class="container">
    @php
        $contactPage = \App\Models\BlogSetting::where('key', 'contact')->first();
    @endphp

    <h1>{{ $contactPage->title }}</h1>
    <div>{!! $contactPage->content !!}</div>
</div>
@endsection
