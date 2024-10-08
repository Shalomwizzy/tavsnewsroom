@extends('layouts.app')

@section('content')
<div class="container">
    @php
        $cookiePolicyPage = \App\Models\BlogSetting::where('key', 'cookies_policy')->first();
    @endphp

    <h1>{{ $cookiePolicyPage->title }}</h1>
    <div>{!! $cookiePolicyPage->content !!}</div>
</div>
@endsection