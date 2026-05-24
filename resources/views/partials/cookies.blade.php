<div class="container">
    @if ($showCookieConsent ?? false)
    <div class="cookie-consent-banner" role="banner" aria-label="Cookie Consent">
        <div class="cookie-text">
            <p>We use cookies to improve your experience and analyse site traffic. By clicking <strong>Accept</strong> you agree to our use of cookies.
               <a href="{{ route('cookie-policy') }}" aria-label="Learn more about our cookie policy">Learn more</a>
            </p>
        </div>
        <div class="cookie-actions">
            <button id="accept-cookies" aria-label="Accept cookies">Accept</button>
            <button id="reject-cookies" aria-label="Reject cookies">✕ Reject</button>
            <button id="cancel-cookies" aria-label="Dismiss">&times;</button>
        </div>
    </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const acceptBtn = document.getElementById('accept-cookies');
            const rejectBtn = document.getElementById('reject-cookies');
            const cancelBtn = document.getElementById('cancel-cookies');

            function handleConsent(action) {
                const banner = document.querySelector('.cookie-consent-banner');
                if (action === 'dismiss') { banner.style.display = 'none'; return; }

                const url = action === 'accept'
                    ? '{{ route('accept-cookies') }}'
                    : '{{ route('reject-cookies') }}';

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    credentials: 'same-origin'
                }).then(r => {
                    if (r.ok) {
                        banner.style.display = 'none';
                        if (action === 'accept' && typeof gtag !== 'undefined') {
                            gtag('consent', 'update', { ad_storage: 'granted', analytics_storage: 'granted' });
                        }
                    }
                });
            }

            acceptBtn?.addEventListener('click', () => handleConsent('accept'));
            rejectBtn?.addEventListener('click', () => handleConsent('reject'));
            cancelBtn?.addEventListener('click', () => handleConsent('dismiss'));
        });
    </script>
</div>
