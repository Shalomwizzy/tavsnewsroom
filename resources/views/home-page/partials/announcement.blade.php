
@if ($announcements->count() > 0)
    <div 
        class="announcement-bar sticky-top" 
        aria-label="Announcement bar with important updates"
        style="color:  #333;" 
    >
        <div 
            class="marquee" 
            aria-live="polite" 
        >
            @foreach ($announcements as $announcement)
                @if ($announcement->active)
                    <div 
                        class="announcement" 
                        aria-label="Announcement: {{ $announcement->title }} - {{ strip_tags($announcement->message) }}"
                    >
                        <i class="fa fa-bullhorn" aria-hidden="true"></i>
                        <div class="announcement-content">
                            <strong>{{ $announcement->title }}:</strong>
                            <span style="color: #333" class="announcement-message">{!! $announcement->message !!}</span>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endif








{{-- @if ($announcements->count() > 0)
    <div class="announcement-bar sticky-top">
        <div class="marquee">
            @foreach ($announcements as $announcement)
                @if ($announcement->active)
                    <div class="announcement">
                        <i class="fa fa-bullhorn"></i>
                        <div class="announcement-content">
                            <strong>{{ $announcement->title }}:</strong>
                            <span class="announcement-message">{!! $announcement->message !!}</span>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endif --}}

