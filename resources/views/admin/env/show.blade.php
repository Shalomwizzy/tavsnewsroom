@extends('layouts.app')

@section('content')
<div class="container env-settings">
    <h4 class="h2-env-h4">Environment Settings</h4>
    <form method="POST" action="{{ route('admin.env.update') }}">
        @csrf
        <div id="step-1" class="step">
            <div class="form-group">
                <label for="APP_NAME">App Name</label>
                <input type="text" class="form-control" id="APP_NAME" name="APP_NAME" placeholder="Example: MyApp - Your Gateway to Remote Opportunities" required>
            </div>
            <div class="form-group">
                <label for="APP_URL">App URL</label>
                <input type="url" class="form-control" id="APP_URL" name="APP_URL" placeholder="Example: http://myapp.com" required>
            </div>
            <button type="button" class="btn btn-primary" onclick="showStep(2)">Next</button>
        </div>

        <div id="step-2" class="step" style="display:none;">
            <div class="form-group">
                <label for="DB_DATABASE">Database Name</label>
                <input type="text" class="form-control" id="DB_DATABASE" name="DB_DATABASE" placeholder="Example: myapp_db" required>
            </div>
            <div class="form-group">
                <label for="DB_USERNAME">Database Username</label>
                <input type="text" class="form-control" id="DB_USERNAME" name="DB_USERNAME" placeholder="Example: root" required>
            </div>
            <div class="form-group">
                <label for="DB_PASSWORD">Database Password</label>
                <input type="password" class="form-control" id="DB_PASSWORD" name="DB_PASSWORD" placeholder="Example: password" required>
            </div>
            <button type="button" class="btn btn-secondary" onclick="showStep(1)">Previous</button>
            <button type="button" class="btn btn-primary" onclick="showStep(3)">Next</button>
        </div>

        <div id="step-3" class="step" style="display:none;">
            <div class="form-group">
                <label for="MAIL_MAILER">Mail Mailer</label>
                <input type="text" class="form-control" id="MAIL_MAILER" name="MAIL_MAILER" placeholder="Example: smtp" required>
            </div>
            <div class="form-group">
                <label for="MAIL_HOST">Mail Host</label>
                <input type="text" class="form-control" id="MAIL_HOST" name="MAIL_HOST" placeholder="Example: smtp.mailtrap.io" required>
            </div>
            <div class="form-group">
                <label for="MAIL_PORT">Mail Port</label>
                <input type="number" class="form-control" id="MAIL_PORT" name="MAIL_PORT" placeholder="Example: 2525" required>
            </div>
            <div class="form-group">
                <label for="MAIL_USERNAME">Mail Username</label>
                <input type="text" class="form-control" id="MAIL_USERNAME" name="MAIL_USERNAME" placeholder="Example: user" required>
            </div>
            <div class="form-group">
                <label for="MAIL_PASSWORD">Mail Password</label>
                <input type="password" class="form-control" id="MAIL_PASSWORD" name="MAIL_PASSWORD" placeholder="Example: password" required>
            </div>
            <div class="form-group">
                <label for="MAIL_FROM_ADDRESS">Mail From Address</label>
                <input type="email" class="form-control" id="MAIL_FROM_ADDRESS" name="MAIL_FROM_ADDRESS" placeholder="Example: hello@example.com" required>
            </div>
            <div class="form-group">
                <label for="MAIL_FROM_NAME">Mail From Name</label>
                <input type="text" class="form-control" id="MAIL_FROM_NAME" name="MAIL_FROM_NAME" placeholder="Example: {{ config('app.name') }}" required>
            </div>
            <button type="button" class="btn btn-secondary" onclick="showStep(2)">Previous</button>
            <button type="submit" class="btn btn-primary">Save Settings</button>
        </div>
    </form>
</div>

<script>
    function showStep(step) {
        document.querySelectorAll('.step').forEach(function (element) {
            element.style.display = 'none';
        });
        document.getElementById('step-' + step).style.display = 'block';
    }
</script>

<style>
    .container {
        max-width: 600px;
        margin: auto;
        padding: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .btn {
        margin-top: 10px;
    }

    .env-settings {
        background-color: black !important;
        font-family: Georgia, 'Times New Roman', Times, serif !important;
    }

    .h2-env-h4 {
        color: #6C7293 !important;
    }

    .env-settings label {
        color: #6C7293 !important;
        font-family: Georgia, 'Times New Roman', Times, serif !important;
    }
</style>
@endsection













































{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h1>Environment Settings</h1>
    <form method="POST" action="{{ route('admin.env.update') }}">
        @csrf
        <div class="form-group">
            <label for="APP_NAME">App Name</label>
            <input type="text" class="form-control" id="APP_NAME" name="APP_NAME" required>
        </div>
        <div class="form-group">
            <label for="APP_URL">App URL</label>
            <input type="url" class="form-control" id="APP_URL" name="APP_URL" required>
        </div>
        <div class="form-group">
            <label for="DB_DATABASE">Database Name</label>
            <input type="text" class="form-control" id="DB_DATABASE" name="DB_DATABASE" required>
        </div>
        <div class="form-group">
            <label for="DB_USERNAME">Database Username</label>
            <input type="text" class="form-control" id="DB_USERNAME" name="DB_USERNAME" required>
        </div>

        <div class="form-group">
            <label for="DB_PASSWORD">Database Password</label>
            <input type="password" class="form-control" id="DB_PASSWORD" name="DB_PASSWORD" required>
        </div>
        <div class="form-group">
            <label for="MAIL_MAILER">Mail Mailer</label>
            <input type="text" class="form-control" id="MAIL_MAILER" name="MAIL_MAILER" required>
        </div>
        <div class="form-group">
            <label for="MAIL_HOST">Mail Host</label>
            <input type="text" class="form-control" id="MAIL_HOST" name="MAIL_HOST" required>
        </div>
        <div class="form-group">
            <label for="MAIL_PORT">Mail Port</label>
            <input type="number" class="form-control" id="MAIL_PORT" name="MAIL_PORT" required>
        </div>
        <div class="form-group">
            <label for="MAIL_USERNAME">Mail Username</label>
            <input type="text" class="form-control" id="MAIL_USERNAME" name="MAIL_USERNAME" required>
        </div>
        <div class="form-group">
            <label for="MAIL_PASSWORD">Mail Password</label>
            <input type="password" class="form-control" id="MAIL_PASSWORD" name="MAIL_PASSWORD" required>
        </div>
        <button type="submit" class="btn btn-primary">Save Settings</button>
    </form>
</div>
@endsection --}}

























{{-- @extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Environment Settings</h1>
    <form method="POST" action="{{ route('admin.env.update') }}">
        @csrf
        @foreach($settings as $setting)
            <div class="form-group">
                <label for="{{ $setting->key }}">{{ ucwords(str_replace('_', ' ', $setting->key)) }}</label>
                <input type="text" class="form-control" id="{{ $setting->key }}" name="{{ $setting->key }}" value="{{ $setting->value }}" required>
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Save Settings</button>
    </form>
</div>
@endsection --}}
