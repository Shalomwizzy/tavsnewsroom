<!-- Social Follow Start -->
<div class="pb-3">
    <div class="bg-light py-2 px-4 mb-3">
        <h3 class="m-0">Follow Us</h3>
    </div>
    <div class="row">
        @foreach ($socialFollows as $socialFollow)
        <div class="col-6 mb-3">
            <a 
                href="{{ $socialFollow->url }}" 
                class="d-block py-2 px-3 text-white text-decoration-none" 
                style="background: {{ $socialFollow->getBackgroundColor() }};"
                aria-label="Follow us on {{ $socialFollow->platform }} - {{ $socialFollow->followers }} {{ $socialFollow->getFollowersLabel() }}"
            >
                <small class="fab {{ $socialFollow->icon_class }} mr-2"></small>
                <small>{{ $socialFollow->followers }} {{ $socialFollow->getFollowersLabel() }}</small>
            </a>
        </div>
        @endforeach
    </div>
</div>
<!-- Social Follow End -->






























{{-- 
<!-- Social Follow Start -->
<div class="pb-3">
    <div class="bg-light py-2 px-4 mb-3">
        <h3 class="m-0">Follow Us</h3>
    </div>
    <div class="row">
        @foreach ($socialFollows as $socialFollow)
        <div class="col-6 mb-3">
            <a href="{{ $socialFollow->url }}" class="d-block py-2 px-3 text-white text-decoration-none" style="background: {{ $socialFollow->getBackgroundColor() }};">
                <small class="fab {{ $socialFollow->icon_class }} mr-2"></small>
                <small>{{ $socialFollow->followers }} {{ $socialFollow->getFollowersLabel() }}</small>
            </a>
        </div>
        @endforeach
    </div>
</div>
<!-- Social Follow End --> --}}