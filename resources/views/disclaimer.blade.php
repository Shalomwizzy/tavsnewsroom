@extends('layouts.app')

@section('content')
<div class="container">
    @php
        $disclaimerPage = \App\Models\BlogSetting::where('key', 'disclaimer')->first();
    @endphp

    <h1>{{ $disclaimerPage->title }}</h1>
    <div>{!! $disclaimerPage->content !!}</div>
</div>
@endsection