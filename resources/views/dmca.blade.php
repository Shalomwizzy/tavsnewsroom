@extends('layouts.app')

@section('content')
<div class="container">
    @php
        $dmcaPage = \App\Models\BlogSetting::where('key', 'dmca')->first();
    @endphp

    <h1>{{ $dmcaPage->title }}</h1>
    <div>{!! $dmcaPage->content !!}</div>
</div>
@endsection