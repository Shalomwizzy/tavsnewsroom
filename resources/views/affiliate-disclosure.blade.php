@extends('layouts.app')

@section('content')
<div class="container">
    @php
        $affiliateDisclosurePage = \App\Models\BlogSetting::where('key', 'affiliate_disclosure')->first();
    @endphp

    <h1>{{ $affiliateDisclosurePage->title }}</h1>
    <div>{!! $affiliateDisclosurePage->content !!}</div>
</div>
@endsection