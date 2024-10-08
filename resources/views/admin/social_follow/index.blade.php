@extends('layouts.admin')

@section('content')
<div class="container social-follows">
    <h2 class="h2-headline-admin">Manage Social Follow Links</h2>
    <p class="mt-3 admin-paragraph">This page allows you to manage social media links that appear on the homepage. You can select up to 8 social media platforms from the list below. Simply check the box next to each platform you want to display, and enter the corresponding URL and follower count if applicable. Click "Save Changes" to update your selections. If you wish to remove any platform, click the "Delete" button next to its details.</p>

    <div class="image-container text-center mb-4">
        <a href="{{ asset('admin-pictures/social-follow.png') }}" target="">
            <img src="{{ asset('admin-pictures/social-follow.png') }}" alt="Top Bar Trending News" class="img-fluid styled-image">
        </a>
    </div>

    <form action="{{ route('admin.social_follows.store') }}" method="POST">
        @csrf

        <div class="row">
            <!-- Checkbox and fields for Facebook -->
            <div class="col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="facebookCheckbox" name="platforms[]" value="facebook" 
                           @if(in_array('facebook', $socialFollows->pluck('platform')->toArray())) checked @endif>
                    <label class="form-check-label" for="facebookCheckbox">Facebook</label>
                </div>
                <div id="facebookFields" style="display: none;">
                    <div class="form-group">
                        <label for="facebookUrl">Facebook URL</label>
                        <input type="url" class="form-control" id="facebookUrl" name="facebook_url"
                               value="{{ $socialFollows->where('platform', 'facebook')->first()->url ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label for="facebookFollowers">Facebook Followers</label>
                        <input type="number" class="form-control" id="facebookFollowers" name="facebook_followers"
                               value="{{ $socialFollows->where('platform', 'facebook')->first()->followers ?? '' }}">
                    </div>
                </div>
            </div>

            <!-- Checkbox and fields for Twitter -->
            <div class="col-md-3 social-follows">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="twitterCheckbox" name="platforms[]" value="twitter" 
                           @if(in_array('twitter', $socialFollows->pluck('platform')->toArray())) checked @endif>
                    <label class="form-check-label" for="twitterCheckbox">Twitter</label>
                </div>
                <div id="twitterFields" style="display: none;">
                    <div class="form-group">
                        <label for="twitterUrl">Twitter URL</label>
                        <input type="url" class="form-control" id="twitterUrl" name="twitter_url"
                               value="{{ $socialFollows->where('platform', 'twitter')->first()->url ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label for="twitterFollowers">Twitter Followers</label>
                        <input type="number" class="form-control" id="twitterFollowers" name="twitter_followers"
                               value="{{ $socialFollows->where('platform', 'twitter')->first()->followers ?? '' }}">
                    </div>
                </div>
            </div>

            <!-- Checkbox and fields for WhatsApp -->
            <div class="col-md-3 social-follows">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="whatsappCheckbox" name="platforms[]" value="whatsapp"
                           @if(in_array('whatsapp', $socialFollows->pluck('platform')->toArray())) checked @endif>
                    <label class="form-check-label" for="whatsappCheckbox">WhatsApp</label>
                </div>
                <div id="whatsappFields" style="display: none;">
                    <div class="form-group">
                        <label for="whatsappUrl">WhatsApp URL</label>
                        <input type="url" class="form-control" id="whatsappUrl" name="whatsapp_url"
                               value="{{ $socialFollows->where('platform', 'whatsapp')->first()->url ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label for="whatsappFollowers">WhatsApp Followers</label>
                        <input type="number" class="form-control" id="whatsappFollowers" name="whatsapp_followers"
                               value="{{ $socialFollows->where('platform', 'whatsapp')->first()->followers ?? '' }}">
                    </div>
                </div>
            </div>

          <!-- Checkbox and fields for Snapchat-->
            <div class="col-md-3 social-follows">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="snapchatCheckbox" name="platforms[]" value="snapchat"
                           @if(in_array('snapchat', $socialFollows->pluck('platform')->toArray())) checked @endif>
                    <label class="form-check-label" for="snapchatCheckbox">Snapchat</label>
                </div>
                <div id="snapchatFields" style="display: none;">
                    <div class="form-group">
                        <label for="snapchatUrl">Snapchat URL</label>
                        <input type="url" class="form-control" id="snapchatUrl" name="snapchat_url"
                               value="{{ $socialFollows->where('platform', 'snapchat')->first()->url ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label for="snapchatFollowers">Snapchat Score</label>
                        <input type="number" class="form-control" id="snapchatFollowers" name="snapchat_followers"
                               value="{{ $socialFollows->where('platform', 'snapchat')->first()->followers ?? '' }}">
                    </div>
                </div>
            </div>

          <!-- Checkbox and fields for Tiktok-->
            <div class="col-md-3 social-follows">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="tiktokCheckbox" name="platforms[]" value="tiktok"
                           @if(in_array('tiktok', $socialFollows->pluck('platform')->toArray())) checked @endif>
                    <label class="form-check-label" for="tiktokCheckbox">Tiktok</label>
                </div>
                <div id="tiktokFields" style="display: none;">
                    <div class="form-group">
                        <label for="tiktokUrl">Tiktok URL</label>
                        <input type="url" class="form-control" id="tiktokUrl" name="tiktok_url"
                               value="{{ $socialFollows->where('platform', 'tiktok')->first()->url ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label for="tiktokFollowers">Tiktok Followers</label>
                        <input type="number" class="form-control" id="tiktokFollowers" name="tiktok_followers"
                               value="{{ $socialFollows->where('platform', 'tiktok')->first()->followers ?? '' }}">
                    </div>
                </div>
            </div>

            <!-- Checkbox and fields for Instagram -->
            <div class="col-md-3 social-follows">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="instagramCheckbox" name="platforms[]" value="instagram"
                           @if(in_array('instagram', $socialFollows->pluck('platform')->toArray())) checked @endif>
                    <label class="form-check-label" for="instagramCheckbox">Instagram</label>
                </div>
                <div id="instagramFields" style="display: none;">
                    <div class="form-group">
                        <label for="instagramUrl">Instagram URL</label>
                        <input type="url" class="form-control" id="instagramUrl" name="instagram_url"
                               value="{{ $socialFollows->where('platform', 'instagram')->first()->url ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label for="instagramFollowers">Instagram Followers</label>
                        <input type="number" class="form-control" id="instagramFollowers" name="instagram_followers"
                               value="{{ $socialFollows->where('platform', 'instagram')->first()->followers ?? '' }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Checkbox and fields for Telegram -->
            <div class="col-md-3 social-follows">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="telegramCheckbox" name="platforms[]" value="telegram"
                           @if(in_array('telegram', $socialFollows->pluck('platform')->toArray())) checked @endif>
                    <label class="form-check-label" for="telegramCheckbox">Telegram</label>
                </div>
                <div id="telegramFields" style="display: none;">
                    <div class="form-group">
                        <label for="telegramUrl">Telegram URL</label>
                        <input type="url" class="form-control" id="telegramUrl" name="telegram_url"
                               value="{{ $socialFollows->where('platform', 'telegram')->first()->url ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label for="telegramFollowers">Telegram Followers</label>
                        <input type="number" class="form-control" id="telegramFollowers" name="telegram_followers"
                               value="{{ $socialFollows->where('platform', 'telegram')->first()->followers ?? '' }}">
                    </div>
                </div>
            </div>

            <!-- Checkbox and fields for LinkedIn -->
            <div class="col-md-3 social-follows">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="linkedinCheckbox" name="platforms[]" value="linkedin"
                           @if(in_array('linkedin', $socialFollows->pluck('platform')->toArray())) checked @endif>
                    <label class="form-check-label" for="linkedinCheckbox">LinkedIn</label>
                </div>
                <div id="linkedinFields" style="display: none;">
                    <div class="form-group">
                        <label for="linkedinUrl">LinkedIn URL</label>
                        <input type="url" class="form-control" id="linkedinUrl" name="linkedin_url"
                               value="{{ $socialFollows->where('platform', 'linkedin')->first()->url ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label for="linkedinFollowers">LinkedIn Followers</label>
                        <input type="number" class="form-control" id="linkedinFollowers" name="linkedin_followers"
                               value="{{ $socialFollows->where('platform', 'linkedin')->first()->followers ?? '' }}">
                    </div>
                </div>
            </div>

          <!-- Checkbox and fields for Youtube -->
            <div class="col-md-3 social-follows">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="youtubeCheckbox" name="platforms[]" value="youtube"
                           @if(in_array('youtube', $socialFollows->pluck('platform')->toArray())) checked @endif>
                    <label class="form-check-label" for="youtubeCheckbox">Youtube</label>
                </div>
                <div id="youtubeFields" style="display: none;">
                    <div class="form-group">
                        <label for="youtubeUrl">Youtube URL</label>
                        <input type="url" class="form-control" id="youtubeUrl" name="youtube_url"
                               value="{{ $socialFollows->where('platform', 'youtube')->first()->url ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label for="youtubeFollowers">Youtube Followers</label>
                        <input type="number" class="form-control" id="youtubeFollowers" name="youtube_followers"
                               value="{{ $socialFollows->where('platform', 'youtube')->first()->followers ?? '' }}">
                    </div>
                </div>
            </div>

            <!-- Checkbox and fields for Reddit -->
            <div class="col-md-3 social-follows">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="redditCheckbox" name="platforms[]" value="reddit"
                           @if(in_array('reddit', $socialFollows->pluck('platform')->toArray())) checked @endif>
                    <label class="form-check-label" for="redditCheckbox">Reddit</label>
                </div>
                <div id="redditFields" style="display: none;">
                    <div class="form-group">
                        <label for="redditUrl">Reddit URL</label>
                        <input type="url" class="form-control" id="redditUrl" name="reddit_url"
                               value="{{ $socialFollows->where('platform', 'reddit')->first()->url ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label for="redditFollowers">Reddit Followers</label>
                        <input type="number" class="form-control" id="redditFollowers" name="reddit_followers"
                               value="{{ $socialFollows->where('platform', 'reddit')->first()->followers ?? '' }}">
                    </div>
                </div>
            </div>

              <!-- Checkbox and fields for Vimeo -->
            <div class="col-md-3 social-follows">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="vimeoCheckbox" name="platforms[]" value="vimeo"
                           @if(in_array('vimeo', $socialFollows->pluck('platform')->toArray())) checked @endif>
                    <label class="form-check-label" for="vimeoCheckbox">Vimeo</label>
                </div>
                <div id="vimeoFields" style="display: none;">
                    <div class="form-group">
                        <label for="vimeoUrl">Vimeo URL</label>
                        <input type="url" class="form-control" id="vimeoUrl" name="vimeo_url"
                               value="{{ $socialFollows->where('platform', 'vimeo')->first()->url ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label for="vimeoFollowers">Vimeo Followers</label>
                        <input type="number" class="form-control" id="vimeoFollowers" name="vimeo_followers"
                               value="{{ $socialFollows->where('platform', 'vimeo')->first()->followers ?? '' }}">
                    </div>
                </div>
            </div>

            <!-- Checkbox and fields for Email -->
            <div class="col-md-3 social-follows">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="emailCheckbox" name="platforms[]" value="email"
                           @if(in_array('email', $socialFollows->pluck('platform')->toArray())) checked @endif>
                    <label class="form-check-label" for="emailCheckbox">Email</label>
                </div>
                <div id="emailFields" style="display: none;">
                    <div class="form-group">
                        <label for="emailUrl">Email Address</label>
                        <input type="email" class="form-control" id="emailUrl" name="email_url"
                               value="{{ $socialFollows->where('platform', 'email')->first()->url ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label for="emailFollowers">Email Connection</label>
                        <input type="number" class="form-control" id="emailFollowers" name="email_followers"
                               value="{{ $socialFollows->where('platform', 'email')->first()->followers ?? '' }}">
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-4">Save Changes</button>
    </form>

    <div class="social-follows-admin-dispaly">
        <h3 class="mt-5 h2-headline-admin">Existing Social Follows</h3>
        <p>This is a list of already selected icons that will appear on the homepage. You can delete any entry you don't want.</p>
    
        <ul class="list-group-socialfollow mt-3">
            @php
                $displayedPlatforms = [];
            @endphp
        
            @foreach($socialFollows as $follow)
                @if (!in_array($follow->platform, $displayedPlatforms))
                    @php
                        $displayedPlatforms[] = $follow->platform;
                    @endphp
        
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <i class="fa {{ $follow->icon_class }} mr-2"></i>
                        {{ ucfirst($follow->platform) }} (
                        @switch($follow->platform)
                         @case('facebook')
                            {{ $follow->followers }} Fans
                            @break
                            @case('instagram')
                                {{ $follow->followers }} Fans
                                @break
                            @case('youtube')
                                {{ $follow->followers }} Subscribers
                                @break

                             @case('tiktok')
                                {{ $follow->followers }} Followers
                                @break
                                @case('email')
                                {{ $follow->followers }} Connection
                                @break
                            @case('vimeo')
                                {{ $follow->followers }} Subscribers
                                @break
                            @case('twitter')
                                {{ $follow->followers }}  Followers
                                @break
                            @case('linkedin')
                                {{ $follow->followers }} Connections
                                @break
                            @case('whatsapp')
                                {{ $follow->followers }} Followers
                                @break

                                @case('snapchat')
                                {{ $follow->followers }} Score
                                @break
                            @default
                                {{ $follow->followers }} <!-- Default term -->
                        @endswitch
                        )
                        <span>
                            <form action="{{ route('admin.social_follows.destroy', $follow->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </span>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
    
    

</div>



<script>
    // Toggle display of input fields based on checkbox selection
    document.getElementById('facebookCheckbox').addEventListener('change', function() {
        document.getElementById('facebookFields').style.display = this.checked ? 'block' : 'none';
    });

    document.getElementById('twitterCheckbox').addEventListener('change', function() {
        document.getElementById('twitterFields').style.display = this.checked ? 'block' : 'none';
    });

    document.getElementById('whatsappCheckbox').addEventListener('change', function() {
        document.getElementById('whatsappFields').style.display = this.checked ? 'block' : 'none';
    });

    document.getElementById('snapchatCheckbox').addEventListener('change', function() {
        document.getElementById('snapchatFields').style.display = this.checked ? 'block' : 'none';
    });

    document.getElementById('tiktokCheckbox').addEventListener('change', function() {
        document.getElementById('tiktokFields').style.display = this.checked ? 'block' : 'none';
    });

    document.getElementById('instagramCheckbox').addEventListener('change', function() {
        document.getElementById('instagramFields').style.display = this.checked ? 'block' : 'none';
    });

    document.getElementById('telegramCheckbox').addEventListener('change', function() {
        document.getElementById('telegramFields').style.display = this.checked ? 'block' : 'none';
    });

    document.getElementById('linkedinCheckbox').addEventListener('change', function() {
        document.getElementById('linkedinFields').style.display = this.checked ? 'block' : 'none';
    });

    document.getElementById('youtubeCheckbox').addEventListener('change', function() {
        document.getElementById('youtubeFields').style.display = this.checked ? 'block' : 'none';
    });

    document.getElementById('redditCheckbox').addEventListener('change', function() {
        document.getElementById('redditFields').style.display = this.checked ? 'block' : 'none';
    });

    document.getElementById('vimeoCheckbox').addEventListener('change', function() {
        document.getElementById('vimeoFields').style.display = this.checked ? 'block' : 'none';
    });

    document.getElementById('emailCheckbox').addEventListener('change', function() {
        document.getElementById('emailFields').style.display = this.checked ? 'block' : 'none';
    });


    document.addEventListener('DOMContentLoaded', function () {
        const platforms = ['facebook', 'twitter', 'whatsapp', 'instagram', 'telegram', 'linkedin','youtube', 'reddit', 'email','vimeo','snapchat','tiktok'];
        platforms.forEach(platform => {
            const checkbox = document.getElementById(`${platform}Checkbox`);
            const fields = document.getElementById(`${platform}Fields`);
            if (checkbox.checked) {
                fields.style.display = 'block';
            }
            checkbox.addEventListener('change', function () {
                fields.style.display = checkbox.checked ? 'block' : 'none';
            });
        });
    });
</script>
@endsection












































{{-- @extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Manage Social Follow Links</h2>

    <form action="{{ route('admin.social_follows.store') }}" method="POST">
        @csrf

        <!-- Checkbox for Facebook -->
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="facebookCheckbox" name="platforms[]" value="facebook">
            <label class="form-check-label" for="facebookCheckbox">Facebook</label>
        </div>
        <div id="facebookFields" style="display: none;">
            <div class="form-group">
                <label for="facebookUrl">Facebook URL</label>
                <input type="url" class="form-control" id="facebookUrl" name="facebook_url">
            </div>
            <div class="form-group">
                <label for="facebookFollowers">Facebook Followers</label>
                <input type="number" class="form-control" id="facebookFollowers" name="facebook_followers">
            </div>
        </div>

        <!-- Checkbox for Twitter -->
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="twitterCheckbox" name="platforms[]" value="twitter">
            <label class="form-check-label" for="twitterCheckbox">Twitter</label>
        </div>
        <div id="twitterFields" style="display: none;">
            <div class="form-group">
                <label for="twitterUrl">Twitter URL</label>
                <input type="url" class="form-control" id="twitterUrl" name="twitter_url">
            </div>
            <div class="form-group">
                <label for="twitterFollowers">Twitter Followers</label>
                <input type="number" class="form-control" id="twitterFollowers" name="twitter_followers">
            </div>
        </div>


                <!-- Checkbox for WhatsApp -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="whatsappCheckbox" name="platforms[]" value="whatsapp">
                    <label class="form-check-label" for="whatsappCheckbox">WhatsApp</label>
                </div>
                <div id="whatsappFields" style="display: none;">
                    <div class="form-group">
                        <label for="whatsappUrl">WhatsApp URL</label>
                        <input type="url" class="form-control" id="whatsappUrl" name="whatsapp_url">
                    </div>
                    <div class="form-group">
                        <label for="whatsappFollowers">WhatsApp Followers</label>
                        <input type="number" class="form-control" id="whatsappFollowers" name="whatsapp_followers">
                    </div>
                </div>


                    <!-- Checkbox for Instagram -->
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="instagramCheckbox" name="platforms[]" value="instagram">
            <label class="form-check-label" for="instagramCheckbox">Instagram</label>
        </div>
        <div id="instagramFields" style="display: none;">
            <div class="form-group">
                <label for="instagramUrl">Instagram URL</label>
                <input type="url" class="form-control" id="instagramUrl" name="instagram_url">
            </div>
            <div class="form-group">
                <label for="instagramFollowers">Instagram Followers</label>
                <input type="number" class="form-control" id="instagramFollowers" name="instagram_followers">
            </div>
        </div>

        <!-- Repeat similar structure for other social media platforms -->

        <button type="submit" class="btn btn-primary">Add Social Follow Links</button>
    </form>

    <h3 class="mt-4">Current Social Follow Links</h3>
    <ul class="list-group">
        @foreach($socialFollows as $follow)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $follow->platform }} ({{ $follow->followers }} followers)
                <div>
                    <a href="{{ route('admin.social_follow.edit', $follow->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                    <form action="{{ route('admin.social_follow.destroy', $follow->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
</div>

<script>
    // Toggle display of input fields based on checkbox selection
    document.getElementById('facebookCheckbox').addEventListener('change', function() {
        document.getElementById('facebookFields').style.display = this.checked ? 'block' : 'none';
    });

    document.getElementById('twitterCheckbox').addEventListener('change', function() {
        document.getElementById('twitterFields').style.display = this.checked ? 'block' : 'none';
    });

    document.getElementById('whatsappCheckbox').addEventListener('change', function() {
        document.getElementById('whatsappFields').style.display = this.checked ? 'block' : 'none';
    });

    document.getElementById('instagramCheckbox').addEventListener('change', function() {
        document.getElementById('instagramFields').style.display = this.checked ? 'block' : 'none';
    });

    // whatsappCheckbox

   
    // Repeat similar event listeners for other checkboxes
</script>

@endsection --}}























































{{-- @extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Manage Social Follow Links</h2>

    <form action="{{ route('admin.social_follows.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="platform">Platform</label>
            <input type="text" class="form-control" id="platform" name="platform" required>
        </div>
        <div class="form-group">
            <label for="url">URL</label>
            <input type="url" class="form-control" id="url" name="url" required>
        </div>
        <div class="form-group">
            <label for="icon_class">Icon Class</label>
            <input type="text" class="form-control" id="icon_class" name="icon_class" required>
        </div>
        <div class="form-group">
            <label for="followers">Followers</label>
            <input type="number" class="form-control" id="followers" name="followers" required>
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="is_active" name="is_active">
            <label class="form-check-label" for="is_active">Display on Home Screen</label>
        </div>
        <button type="submit" class="btn btn-primary">Add Social Follow Link</button>
    </form>

    <h3 class="mt-4">Current Social Follow Links</h3>
    <ul class="list-group">
        @foreach($socialFollows as $follow)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $follow->platform }} ({{ $follow->followers }} followers)
                <div>
                    <a href="{{ route('admin.social_follow.edit', $follow->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                    <form action="{{ route('admin.social_follow.destroy', $follow->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
</div>
@endsection --}}
