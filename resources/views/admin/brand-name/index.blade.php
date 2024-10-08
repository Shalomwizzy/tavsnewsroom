
<!-- resources/views/admin/website-settings.blade.php -->

@extends('layouts.admin')

@section('content')
<div class="website-settings container">
    <h2>Website Information</h2>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-header">Website Settings</div>

                <div class="card-body">
                    <form action="{{ route('admin.brand-name.save') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="site_name">Site Name</label>
                            <small class="form-text text-muted">Specify the name of your website.</small>
                            <input type="text" name="site_name" id="site_name" class="form-control" value="{{ $siteName }}">
                        </div>
                        <div class="form-group">
                            <label for="site_email">Site Email</label>
                            <small class="form-text text-muted">Specify the email address of your website.</small>
                            <input type="email" name="site_email" id="site_email" class="form-control" value="{{ $siteEmail }}">
                        </div>
                        <div class="form-group">
                            <label for="site_copyright">Site Copyright</label>
                            <small class="form-text text-muted">Copyright information of your website.</small>
                            <input type="text" name="site_copyright" id="site_copyright" class="form-control" value="{{ $siteCopyright }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
























{{-- <!-- resources/views/admin/brand-name.blade.php -->

@extends('layouts.admin')

@section('content')
<div class="brand-name-setting container">
    <h2>Website Information</h2>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-header">Brand Name</div>

                <div class="card-body">
                    <form action="{{ route('admin.brand-name.save') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="brand_name">Brand Name</label>
                            <input type="text" name="brand_name" id="brand_name" class="form-control" value="{{ $brandName }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .brand-name-setting {
        background-color: white;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .brand-name-setting .form-group {
        margin-bottom: 20px;
    }
</style>
@endsection --}}
