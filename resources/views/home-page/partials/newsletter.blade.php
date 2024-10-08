

{{-- Newsletter Start  --}}
<div class="pb-3">
    <div class="bg-light py-2 px-4 mb-3">
        <h2 class="m-0 h2-headline">Newsletter</h2>
    </div>
    <div class="bg-light text-center p-4 mb-3">
        <p class="subscriber-text">Subscribe to our newsletter to stay updated with our latest news and offers.</p>
        <form action="{{ route('subscribe') }}" method="POST">
            @csrf
            <div class="input-group" style="width: 100%;">
                <input type="email" name="email" class="form-control form-control-lg subscriber-input"  placeholder= "Your Email" required>

                <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                <div class="input-group-append">
                    <button class="btn  newsletter-signup fs-4" type="submit" style="background-color: #b30000">Sign Up</button>
                </div>
            </div>
        </form>
         <small style="color: #555;">We respect your privacy.</small>
    </div>
</div>
<!-- Newsletter End -->



