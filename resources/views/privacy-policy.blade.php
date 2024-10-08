<!-- Example Blade View for Privacy Policy Page -->
@extends('layouts.app')

@section('content')
<div class="container">
    @php
        $privacyPolicyPage = \App\Models\BlogSetting::where('key', 'privacy_policy')->first();
    @endphp

    <h1>{{ $privacyPolicyPage->title }}</h1>
    <div>{!! $privacyPolicyPage->content !!}</div>
</div>
@endsection
