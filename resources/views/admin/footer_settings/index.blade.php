@extends('layouts.admin')

@section('content')
<div class="container footer-settings-index">
    <h2 class="h2-headline-admin">Footer Settings</h2>
    <p>This page allows you to select up to five social icons that will be displayed in the footer along with their links. Please provide a short description about your website (maximum 100 words).</p>
    
    <form action="{{ route('admin.footer_settings.update') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control">{{ $footerSettings->description ?? '' }}</textarea>
        </div>

        <div class="form-group">
            <label>Social Links</label>
            @php
                $socialLinks = [
                    'twitter' => 'Twitter',
                    'facebook' => 'Facebook',
                    'linkedin' => 'LinkedIn',
                    'instagram' => 'Instagram',
                    'youtube' => 'YouTube',
                    'whatsapp' => 'WhatsApp',
                    'tiktok' => 'TikTok',
                    'telegram' => 'Telegram',
                    'email' => 'Email',
                    'snapchat' => 'Snapchat',
                    'reddit' => 'Reddit',
                    'vimeo' => 'Vimeo',
                    'threads' => 'Threads'
                ];
                $selectedLinks = json_decode($footerSettings->selected_links ?? '[]', true);
            @endphp

            <div class="row">
                @foreach ($socialLinks as $key => $name)
                    <div class="col-md-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="{{ $key }}_checkbox" name="selected_links[]" value="{{ $key }}" {{ in_array($key, $selectedLinks) ? 'checked' : '' }}>
                            <label class="form-check-label" for="{{ $key }}_checkbox">{{ $name }}</label>
                        </div>
                        <input type="text" 
                               class="form-control mt-2 {{ in_array($key, $selectedLinks) ? '' : 'd-none' }}" 
                               id="{{ $key }}_link" 
                               name="{{ $key }}_link" 
                               value="{{ $footerSettings->{$key . '_link'} ?? '' }}" 
                               placeholder="Enter {{ $name }} Link" 
                               aria-label="{{ $name }} Link">
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>

<script>
    document.querySelectorAll('.form-check-input').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const inputField = document.getElementById(this.id.replace('_checkbox', '_link'));
            if (this.checked) {
                inputField.classList.remove('d-none');
            } else {
                inputField.classList.add('d-none');
            }
        });
    });
</script>
@endsection
























{{-- @extends('layouts.admin')

@section('content')
<div class="container footer-settings-index">
    <h2>Footer Settings</h2>
    <p class="explanation">
        This page allows you to select up to five social icons that will display in the footer with the corresponding links. You can also write a short description about your website.
    </p>
    <form action="{{ route('admin.footer_settings.update') }}" method="POST">
        @csrf

    

        <div class="form-group">
            <label>Social Links</label>
            @php
                $socialLinks = [
                    'twitter' => 'Twitter',
                    'facebook' => 'Facebook',
                    'linkedin' => 'LinkedIn',
                    'instagram' => 'Instagram',
                    'youtube' => 'YouTube',
                    'whatsapp' => 'WhatsApp',
                    'tiktok' => 'TikTok',
                    'telegram' => 'Telegram',
                    'email' => 'Email',
                    'snapchat' => 'Snapchat',
                    'reddit' => 'Reddit',
                    'vimeo' => 'Vimeo',
                    'threads' => 'Threads'
                ];
                $selectedLinks = json_decode($footerSettings->selected_links ?? '[]', true);
            @endphp

            <div class="row">
                @foreach ($socialLinks as $key => $name)
                    <div class="col-md-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="{{ $key }}_checkbox" name="selected_links[]" value="{{ $key }}" {{ in_array($key, $selectedLinks) ? 'checked' : '' }}>
                            <label class="form-check-label {{ in_array($key, $selectedLinks) ? 'selected' : '' }}" for="{{ $key }}_checkbox">{{ $name }}</label>
                        </div>
                        <input type="text" class="form-control mt-2 {{ in_array($key, $selectedLinks) ? '' : 'd-none' }}" id="{{ $key }}_link" name="{{ $key }}_link" value="{{ $footerSettings->{$key . '_link'} ?? '' }}" placeholder="Enter {{ $name }} Link">
                    </div>
                @endforeach
            </div>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control">{{ $footerSettings->description ?? '' }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary save-selection-button">Save Changes</button>
    </form>
</div>

<script>
    document.querySelectorAll('.form-check-input').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const inputField = document.getElementById(this.id.replace('_checkbox', '_link'));
            const label = document.querySelector(`label[for="${this.id}"]`);
            if (this.checked) {
                inputField.classList.remove('d-none');
                label.classList.add('selected');
            } else {
                inputField.classList.add('d-none');
                label.classList.remove('selected');
            }
        });
    });
</script>
@endsection


<style>
    .footer-settings-index {
        background-color: white !important;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .footer-settings-index h2{
        margin-bottom: 20px;
        font-family: Georgia, 'Times New Roman', Times, serif;
        text-align: center !important;
    }
    .footer-settings-index .explanation {
        
        color: #555;
        margin-bottom: 20px;
        font-size: 1.1em;
        font-family: Georgia, 'Times New Roman', Times, serif;
        color: #666;
        margin-bottom: 20px;
    }
    .footer-settings-index .form-check-label {
        display: block;
        cursor: pointer;
        padding: 5px;
        border: 1px solid #ddd;
        border-radius: 4px;
        transition: background 0.3s, border-color 0.3s;
    }
    .footer-settings-index .form-check-input {
        margin-right: 10px;
    }
    .footer-settings-index .form-check-label.selected {
        background: green;
        color: white;
        border-color: green;
    }
    .footer-settings-index .form-check-label.selected:hover {
        background: gray;
    }
    .footer-settings-index .form-check-label:hover {
        border-color: #007bff;
    }
</style> --}}















































{{-- @extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Footer Settings</h1>
    <form action="{{ route('admin.footer_settings.update') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control">{{ $footerSettings->description ?? '' }}</textarea>
        </div>

        <div class="form-group">
            <label>Social Links</label>
            @php
                $socialLinks = [
                    'twitter' => 'Twitter',
                    'facebook' => 'Facebook',
                    'linkedin' => 'LinkedIn',
                    'instagram' => 'Instagram',
                    'youtube' => 'YouTube',
                    'whatsapp' => 'WhatsApp',
                    'tiktok' => 'TikTok',
                    'telegram' => 'Telegram',
                    'email' => 'Email',
                    'snapchat' => 'Snapchat',
                    'reddit' => 'Reddit',
                    'vimeo' => 'Vimeo',
                    'threads' => 'Threads'
                ];
                $selectedLinks = json_decode($footerSettings->selected_links ?? '[]', true);
            @endphp

            <div class="row">
                @foreach ($socialLinks as $key => $name)
                    <div class="col-md-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="{{ $key }}_checkbox" name="selected_links[]" value="{{ $key }}" {{ in_array($key, $selectedLinks) ? 'checked' : '' }}>
                            <label class="form-check-label" for="{{ $key }}_checkbox">{{ $name }}</label>
                        </div>
                        <input type="text" class="form-control mt-2 {{ in_array($key, $selectedLinks) ? '' : 'd-none' }}" id="{{ $key }}_link" name="{{ $key }}_link" value="{{ $footerSettings->{$key . '_link'} ?? '' }}" placeholder="Enter {{ $name }} Link">
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>

<script>
    document.querySelectorAll('.form-check-input').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const inputField = document.getElementById(this.id.replace('_checkbox', '_link'));
            if (this.checked) {
                inputField.classList.remove('d-none');
            } else {
                inputField.classList.add('d-none');
            }
        });
    });
</script>
@endsection --}}













































{{-- <!-- resources/views/admin/footer_settings.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Footer Settings</h1>
    <form action="{{ route('admin.footer_settings.update') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control">{{ $footerSettings->description ?? '' }}</textarea>
        </div>
        <div class="form-group">
            <label for="twitter_link">Twitter Link</label>
            <input type="text" name="twitter_link" id="twitter_link" class="form-control" value="{{ $footerSettings->twitter_link ?? '' }}">
        </div>
        <div class="form-group">
            <label for="facebook_link">Facebook Link</label>
            <input type="text" name="facebook_link" id="facebook_link" class="form-control" value="{{ $footerSettings->facebook_link ?? '' }}">
        </div>
        <div class="form-group">
            <label for="linkedin_link">LinkedIn Link</label>
            <input type="text" name="linkedin_link" id="linkedin_link" class="form-control" value="{{ $footerSettings->linkedin_link ?? '' }}">
        </div>
        <div class="form-group">
            <label for="instagram_link">Instagram Link</label>
            <input type="text" name="instagram_link" id="instagram_link" class="form-control" value="{{ $footerSettings->instagram_link ?? '' }}">
        </div>
        <div class="form-group">
            <label for="youtube_link">YouTube Link</label>
            <input type="text" name="youtube_link" id="youtube_link" class="form-control" value="{{ $footerSettings->youtube_link ?? '' }}">
        </div>
        <div class="form-group">
            <label for="whatsapp_link">WhatsApp Link</label>
            <input type="text" name="whatsapp_link" id="whatsapp_link" class="form-control" value="{{ $footerSettings->whatsapp_link ?? '' }}">
        </div>
        <div class="form-group">
            <label for="tiktok_link">TikTok Link</label>
            <input type="text" name="tiktok_link" id="tiktok_link" class="form-control" value="{{ $footerSettings->tiktok_link ?? '' }}">
        </div>
        <div class="form-group">
            <label for="telegram_link">Telegram Link</label>
            <input type="text" name="telegram_link" id="telegram_link" class="form-control" value="{{ $footerSettings->telegram_link ?? '' }}">
        </div>
        <div class="form-group">
            <label for="email_link">Email Link</label>
            <input type="text" name="email_link" id="email_link" class="form-control" value="{{ $footerSettings->email_link ?? '' }}">
        </div>
        <div class="form-group">
            <label for="snapchat_link">Snapchat Link</label>
            <input type="text" name="snapchat_link" id="snapchat_link" class="form-control" value="{{ $footerSettings->snapchat_link ?? '' }}">
        </div>
        <div class="form-group">
            <label for="reddit_link">Reddit Link</label>
            <input type="text" name="reddit_link" id="reddit_link" class="form-control" value="{{ $footerSettings->reddit_link ?? '' }}">
        </div>
        <div class="form-group">
            <label for="vimeo_link">Vimeo Link</label>
            <input type="text" name="vimeo_link" id="vimeo_link" class="form-control" value="{{ $footerSettings->vimeo_link ?? '' }}">
        </div>
        <div class="form-group">
            <label for="threads_link">Threads Link</label>
            <input type="text" name="threads_link" id="threads_link" class="form-control" value="{{ $footerSettings->threads_link ?? '' }}">
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection --}}
