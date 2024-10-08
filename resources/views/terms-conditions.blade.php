<!-- Example Blade View for Terms and Conditions Page -->
@extends('layouts.app')

@section('content')
<div class="container">
    @php
        $termsConditionsPage = \App\Models\BlogSetting::where('key', 'terms_conditions')->first();
    @endphp

    <h1>{{ $termsConditionsPage->title }}</h1>
    <div>{!! $termsConditionsPage->content !!}</div>
</div>
@endsection
