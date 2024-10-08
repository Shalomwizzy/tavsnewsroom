@extends('layouts.admin')

@section('content')
    <div class="quick-links-index">
        <div class="container">
            <h2 class="h2-headline-admin">Quick Links</h2>
            <p class="description">
                This page allows you to select the items that will be displayed in the footer quick links. Select the items you want to be active and appear on the footer.
            </p>
            <form action="{{ route('admin.quick_links.update') }}" method="POST">
                @csrf
                <div class="row">
                    @foreach ($quickLinks as $quickLink)
                        <div class="col-md-3 mb-3">
                            <div class="form-check">
                                <input type="hidden" name="quick_links[{{ $quickLink->id }}]" value="0"> <!-- Default value for unchecked boxes -->
                                <input type="checkbox" class="form-check-input" name="quick_links[{{ $quickLink->id }}]" value="1" {{ $quickLink->is_active ? 'checked' : '' }}>
                                <label class="form-check-label" for="quick_links[{{ $quickLink->id }}]">
                                    {{ $quickLink->title }} - {{ $quickLink->url }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary">Save Changes </button>
            </form>
        </div>
    </div>


@endsection
