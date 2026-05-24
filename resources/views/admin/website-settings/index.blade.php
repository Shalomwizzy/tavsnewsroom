<!-- resources/views/admin/website-settings.blade.php -->


@extends('layouts.admin')

@section('content')
<div class="website-settings container">
    
    <div class="row">
        <div class="col-md-8 offset-md-2">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h2 class="h2-headline-admin">Website Settings</h2>
                    <p class="drop-down-write">This page allows administrators to configure various settings related to the website. Admins can update the site name, contact email, copyright information, and logo. The settings are displayed dynamically and can be saved via a form submission.</p>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.website-settings.save') }}" method="POST" enctype="multipart/form-data">
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
                            <label for="site_phone">Site Phone Number</label>
                            <small class="form-text text-muted">Specify the phone number for your website.</small>
                            <input type="text" name="site_phone" id="site_phone" class="form-control" value="{{ $sitePhone }}">
                        </div>
                        
                        <div class="form-group">
                            <label for="site_copyright">Site Copyright</label>
                            <small class="form-text text-muted">Copyright information of your website.</small>
                            <input type="text" name="site_copyright" id="site_copyright" class="form-control" value="{{ $siteCopyright }}">
                        </div>
                        <div class="form-group">
                            <label for="site_logo">Site Logo</label>
                            <small class="form-text text-muted">Upload your website's logo.</small>
                            <input type="file" name="site_logo" id="site_logo" class="form-control-file">
                            @if($siteLogoUrl)
                                <img src="{{ asset($siteLogoUrl) }}" alt="Site Logo" class="mt-2" style="max-height: 100px;">
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="site_default_meta_description">Default Meta Description</label>
                            <small class="form-text text-muted">Used as the site-wide fallback meta description when a page has none set. Max 160 characters.</small>
                            <textarea name="site_default_meta_description" id="site_default_meta_description" class="form-control" rows="2" maxlength="320">{{ $siteDefaultMetaDesc }}</textarea>
                        </div>

                        <hr>
                        <h5 class="mt-3 mb-3">robots.txt</h5>
                        <div class="form-group">
                            <label for="robots_txt">robots.txt content</label>
                            <small class="form-text text-muted d-block mb-1">Controls which pages search engines are allowed to crawl. One directive per line.</small>
                            <textarea name="robots_txt" id="robots_txt" class="form-control" rows="8" style="font-family: monospace; font-size: 13px;">{{ $robotsTxt }}</textarea>
                        </div>

                        <hr>
                        <h5 class="mt-3 mb-3">Comments</h5>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="comments_enabled" name="comments_enabled" value="1"
                                {{ $commentsEnabled ? 'checked' : '' }}>
                            <label class="form-check-label" for="comments_enabled">Enable comments on articles</label>
                            <small class="form-text text-muted d-block">When unchecked, the comment form and all comments are hidden from article pages.</small>
                        </div>

                        <hr>
                        <h5 class="mt-3 mb-3">Google Analytics</h5>

                        <div class="form-group">
                            <label for="ga_tracking_id">GA Tracking ID (gtag)</label>
                            <small class="form-text text-muted">Your Google Analytics 4 Measurement ID, e.g. <code>G-XXXXXXXXXX</code>. Leave blank to disable analytics.</small>
                            <input type="text" name="ga_tracking_id" id="ga_tracking_id" class="form-control" value="{{ $gaTrackingId }}" placeholder="G-XXXXXXXXXX">
                        </div>

                        <div class="form-group">
                            <label for="ga_property_id">GA Property ID (Data API)</label>
                            <small class="form-text text-muted">Your numeric Google Analytics property ID for the admin dashboard analytics widget, e.g. <code>450095341</code>.</small>
                            <input type="text" name="ga_property_id" id="ga_property_id" class="form-control" value="{{ $gaPropertyId }}" placeholder="450095341">
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection


{{-- @extends('layouts.admin')

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
                    <form action="{{ route('admin.website-settings.save') }}" method="POST">
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
                        <div class="form-group">
                            <label for="site_logo_url">Site Logo URL</label>
                            <small class="form-text text-muted">Specify the URL of your website's logo.</small>
                            <input type="text" name="site_logo_url" id="site_logo_url" class="form-control" value="{{ $siteLogoUrl }}">
                        </div>
                        <div class="form-group">
                            <label for="site_description">Site Description</label>
                            <small class="form-text text-muted">Provide a brief description of your website.</small>
                            <textarea name="site_description" id="site_description" class="form-control" rows="3">{{ $siteDescription }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="footer_text">Footer Text</label>
                            <small class="form-text text-muted">Custom text to display in the footer.</small>
                            <input type="text" name="footer_text" id="footer_text" class="form-control" value="{{ $footerText }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}

{{-- <style>
    .website-settings {
        background-color: white;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .website-settings .form-group {
        margin-bottom: 20px;
    }
    .website-settings label {
        display: block;
        margin-bottom: 5px;
    }
    .website-settings .form-control {
        display: inline-block;
        width: calc(100% - 150px);
        margin-left: 20px;
    }
    .website-settings .form-text {
        display: block;
        margin-top: 0;
        margin-bottom: 10px;
        font-size: 0.875rem;
    }
</style> --}}
{{-- @endsection --}}
