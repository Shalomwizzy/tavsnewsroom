@extends('layouts.admin')

@section('content')
<div class="container maintenance-mode">
    <h2 class="h2-headline-admin">Maintenance Mode</h2>
    <form action="{{ route('admin.toggle.maintenance') }}" method="POST">
        @csrf
        <div class="form-group">
            <p class="admin-paragraph">The website is currently <strong>{{ $maintenanceMode ? 'in' : 'not in' }}</strong> maintenance mode.</p>
            
            @if($maintenanceMode)
                <button type="submit" class="btn btn-danger" name="disable">Disable Maintenance Mode</button>
            @else
                <p class="admin-paragraph"><strong>Note:</strong> Before enabling maintenance mode, please note down the secret key: <code>temitopemi247</code>. This key allows access to the site during maintenance.</p>
                <p class="admin-paragraph"><strong>Important:</strong> All maintenance activities should be concluded within one day to avoid any negative impact on your website's SEO ranking by search engines like Google.</p>
                <button type="submit" class="btn btn-primary" name="enable">Enable Maintenance Mode</button>
            @endif
        </div>
    </form>
</div>


@endsection












{{-- @extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Maintenance Mode</h1>
    <form action="{{ route('admin.toggle.maintenance') }}" method="POST">
        @csrf
        <div class="form-group">
            <p>The website is currently <strong>{{ $maintenanceMode ? 'in' : 'not in' }}</strong> maintenance mode.</p>
            @if($maintenanceMode)
                <button type="submit" class="btn btn-danger" name="disable">Disable Maintenance Mode</button>
            @else
                <button type="submit" class="btn btn-primary" name="enable">Enable Maintenance Mode</button>
            @endif
        </div>
    </form>
</div>
@endsection --}}
