{{-- <div class="container">
    @if ($showCookieConsent ?? false)
    <div class="cookie-consent-banner row" role="banner" aria-label="Cookie Consent Banner">
        <div class="col-md-9 col-8">
            <p class="mb-0">
                We use cookies to improve your experience. By continuing to use our site, you accept our use of cookies.
                <a href="{{ route('cookie-policy') }}" aria-label="Learn more about cookies policy">Learn more</a>.
            </p>
        </div>
        <div class="col-md-3 col-4 text-right d-flex justify-content-end align-items-center">
            <button id="accept-cookies" class="btn btn-sm" style="background-color: #b30000; color: white;" aria-label="Accept cookies">Accept</button>
            <button id="reject-cookies" class="btn btn-link btn-sm ml-2" aria-label="Reject cookies">
                <i class="fas fa-times"></i> Reject
            </button>
            <button id="cancel-cookies" class="btn btn-link btn-sm ml-2" aria-label="Dismiss cookie consent">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const acceptButton = document.getElementById('accept-cookies');
            const rejectButton = document.getElementById('reject-cookies');
            const cancelButton = document.getElementById('cancel-cookies');
    
            function handleConsent(action) {
                let url = '';
                let adStorage = 'denied';
                let analyticsStorage = 'denied';
    
                if (action === 'accept') {
                    url = '{{ route('accept-cookies') }}';
                    adStorage = 'granted';
                    analyticsStorage = 'granted';
                } else if (action === 'reject') {
                    url = '{{ route('reject-cookies') }}';
                } else if (action === 'dismiss') {
                    // Just dismiss, no server action needed
                    document.querySelector('.cookie-consent-banner').style.display = 'none';
                    return;
                }
    
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    credentials: 'same-origin'
                })
                .then(response => {
                    if (response.ok) {
                        document.querySelector('.cookie-consent-banner').style.display = 'none';
                        if (action === 'accept') {
                            updateConsent(adStorage, analyticsStorage);
                        }
                    }
                });
            }
    
            function updateConsent(adStorage, analyticsStorage) {
                gtag('consent', 'update', {
                    'ad_storage': adStorage,
                    'analytics_storage': analyticsStorage
                });
            }
    
            if (acceptButton) {
                acceptButton.addEventListener('click', () => handleConsent('accept'));
            }
    
            if (rejectButton) {
                rejectButton.addEventListener('click', () => handleConsent('reject'));
            }
    
            if (cancelButton) {
                cancelButton.addEventListener('click', () => handleConsent('dismiss'));
            }
        });
    </script>
    
</div> --}}
























