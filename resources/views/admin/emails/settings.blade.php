@extends('layouts.admin')

@section('content')
<div class="container email-settings">
    <h2 class="h2-headline-admin">Email Settings</h2>
    
    <p class="admin-paragraph">This page allows you to upload the logo that will appear in all outgoing and incoming emails. You can also set the social media links that will be included in these emails. Make sure to provide valid URLs for each social media platform.</p>

    <form action="{{ route('admin.email-settings') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="logo">Logo</label>
            <input type="file" class="form-control" id="logo" name="logo" value="{{ $settings->logo ?? '' }}">
            @if($settings && $settings->logo_url)
                <img src="{{ asset($settings->logo_url) }}" alt="Website Logo" class="logo-preview">
            @endif
        </div>

        <div class="form-group">
            <label for="facebook_link">Facebook Link</label>
            <input type="url" class="form-control" id="facebook_link" name="facebook_link" value="{{ $settings->facebook_link ?? '' }}">
        </div>

        <div class="form-group">
            <label for="twitter_link">Twitter Link</label>
            <input type="url" class="form-control" id="twitter_link" name="twitter_link" value="{{ $settings->twitter_link ?? '' }}">
        </div>

        <div class="form-group">
            <label for="instagram_link">Instagram Link</label>
            <input type="url" class="form-control" id="instagram_link" name="instagram_link" value="{{ $settings->instagram_link ?? '' }}">
        </div>

        <div class="form-group">
            <label for="linkedin_link">LinkedIn Link</label>
            <input type="url" class="form-control" id="linkedin_link" name="linkedin_link" value="{{ $settings->linkedin_link ?? '' }}">
        </div>

        <button type="submit" class="btn btn-primary">Save Settings</button>
    </form>
</div>

<style>
    .email-settings {
        background-color: black;
        padding: 20px;
        border-radius: 8px;
        border: 1px solid white;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-width: 800px;
        margin: auto;
    }

    .email-settings h2 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #333;
    }

    .email-settings p {
        font-size: 14px;
        color: #666;
        margin-bottom: 20px;
    }

    .email-settings .form-group {
        margin-bottom: 15px;
    }

    .email-settings .form-group label {
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
        color: #6C7293;
    }

    .email-settings .form-control {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 10px;
        width: 100%;
        max-width: 500px; /* Limit the width of input fields */
    }

    .email-settings .logo-preview {
        display: block;
        margin-top: 10px;
        width: 150px;
        height: 100px;
        object-fit: contain;
        border: 1px solid #ddd;
        border-radius: 4px;
    }


    @media (max-width: 768px) {
        .email-settings {
            padding: 15px;
        }

        .email-settings .form-control {
            max-width: 100%; /* Full width on smaller screens */
        }
    }
</style>
@endsection
























{{-- @extends('layouts.admin')

@section('content')
<div class="container email-settings">
    <h2 class="h2-headline-admin">Email Settings</h2>
    
    <p class="admin-paragraph">This page allows you to upload the logo that will appear in all outgoing and incoming emails. You can also set the social media links that will be included in these emails. Make sure to provide valid URLs for each social media platform.</p>

    <form action="{{ route('admin.email-settings') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="logo">Logo</label>
            <input type="file" class="form-control" id="logo" name="logo" value="{{ $settings->logo ?? '' }}">
            @if($settings && $settings->logo_url)
                <img src="{{ asset($settings->logo_url) }}" alt="Website Logo" class="logo-preview">
            @endif
        </div>

        <div class="form-group">
            <label for="facebook_link">Facebook Link</label>
            <input type="url" class="form-control" id="facebook_link" name="facebook_link" value="{{ $settings->facebook_link ?? '' }}">
        </div>

        <div class="form-group">
            <label for="twitter_link">Twitter Link</label>
            <input type="url" class="form-control" id="twitter_link" name="twitter_link" value="{{ $settings->twitter_link ?? '' }}">
        </div>

        <div class="form-group">
            <label for="instagram_link">Instagram Link</label>
            <input type="url" class="form-control" id="instagram_link" name="instagram_link" value="{{ $settings->instagram_link ?? '' }}">
        </div>

        <div class="form-group">
            <label for="linkedin_link">LinkedIn Link</label>
            <input type="url" class="form-control" id="linkedin_link" name="linkedin_link" value="{{ $settings->linkedin_link ?? '' }}">
        </div>

        <button type="submit" class="btn btn-primary">Save Settings</button>
    </form>
</div>


<style>
    .email-settings {
    background-color: #0000;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.email-settings h1 {
    font-size: 24px;
    margin-bottom: 20px;
    color: #333;
}

.email-settings p {
    font-size: 14px;
    color: #666;
    margin-bottom: 20px;
}

.email-settings .form-group {
    margin-bottom: 15px;
}

.email-settings .form-group label {
    font-weight: bold;
    margin-bottom: 5px;
    display: block;
    color: #6C7293 !important; 
   
}

.email-settings .form-control {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 10px;
    width: 100%;
}




.email-settings .logo-preview {
    display: block;
    margin-top: 10px;
    width: 150px;
    height: 100px;
    object-fit: contain;
    border: 1px solid #ddd;
    border-radius: 4px;
}

</style>
@endsection

 --}}
