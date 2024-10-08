@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Environment Settings</h1>
    <form method="POST" action="{{ route('admin.env_settings') }}">
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
@endsection
