{{-- PWA Install Prompt — shown once unless user says "never" --}}
@php $siteName = \App\Models\WebsiteSetting::getValue('site_name', config('app.name')); @endphp

<div id="pwa-overlay" class="pwa-overlay" role="dialog" aria-modal="true" aria-label="Install app" hidden>
    <div class="pwa-backdrop" id="pwa-backdrop"></div>

    <div class="pwa-sheet" id="pwa-sheet">
        <!-- Drag handle -->
        <div class="pwa-handle"></div>

        <!-- Header -->
        <div class="pwa-header">
            <div class="pwa-app-icon">
                <img src="/icons/icon.svg?v=3" alt="{{ $siteName }} icon" width="64" height="64">
            </div>
            <div class="pwa-app-info">
                <h2 class="pwa-app-name">{{ $siteName }}</h2>
                <p class="pwa-app-sub">Install for a faster, richer experience</p>
                <div class="pwa-stars">
                    <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                    <i class="fa fa-star"></i><i class="fa fa-star-half-alt"></i>
                    <span>4.8</span>
                </div>
            </div>
            <button class="pwa-close" id="pwa-close-x" aria-label="Dismiss">&times;</button>
        </div>

        <!-- Benefits strip -->
        <div class="pwa-benefits">
            <div class="pwa-benefit">
                <i class="fa fa-bolt"></i>
                <span>Instant load</span>
            </div>
            <div class="pwa-benefit">
                <i class="fa fa-wifi-slash"></i>
                <span>Works offline</span>
            </div>
            <div class="pwa-benefit">
                <i class="fa fa-bell"></i>
                <span>Breaking alerts</span>
            </div>
            <div class="pwa-benefit">
                <i class="fa fa-expand"></i>
                <span>Full-screen</span>
            </div>
        </div>

        <!-- Step-by-step instructions (platform-specific, toggled by JS) -->

        {{-- iOS Safari steps --}}
        <div class="pwa-steps" id="pwa-steps-ios" hidden>
            <p class="pwa-steps-title">Install on iPhone / iPad</p>
            <ol class="pwa-step-list">
                <li class="pwa-step">
                    <span class="pwa-step-num">1</span>
                    <div class="pwa-step-body">
                        <strong>Tap the Share button</strong>
                        <span>The <i class="fa fa-share-square"></i> icon at the bottom of your browser</span>
                    </div>
                </li>
                <li class="pwa-step">
                    <span class="pwa-step-num">2</span>
                    <div class="pwa-step-body">
                        <strong>Tap "Add to Home Screen"</strong>
                        <span>Scroll down in the share sheet to find this option</span>
                    </div>
                </li>
                <li class="pwa-step">
                    <span class="pwa-step-num">3</span>
                    <div class="pwa-step-body">
                        <strong>Tap "Add"</strong>
                        <span>The app icon will appear on your Home Screen instantly</span>
                    </div>
                </li>
            </ol>
        </div>

        {{-- Chrome / Android native prompt steps --}}
        <div class="pwa-steps" id="pwa-steps-native" hidden>
            <p class="pwa-steps-title">One-tap install</p>
            <ol class="pwa-step-list">
                <li class="pwa-step">
                    <span class="pwa-step-num">1</span>
                    <div class="pwa-step-body">
                        <strong>Tap "Install Now" below</strong>
                        <span>Your browser will show a confirmation popup</span>
                    </div>
                </li>
                <li class="pwa-step">
                    <span class="pwa-step-num">2</span>
                    <div class="pwa-step-body">
                        <strong>Confirm the install</strong>
                        <span>Tap "Install" in the browser dialog that appears</span>
                    </div>
                </li>
                <li class="pwa-step">
                    <span class="pwa-step-num">3</span>
                    <div class="pwa-step-body">
                        <strong>Done — open from your Home Screen</strong>
                        <span>The app icon is now saved on your device</span>
                    </div>
                </li>
            </ol>
        </div>

        {{-- Desktop Chrome / Edge steps --}}
        <div class="pwa-steps" id="pwa-steps-desktop" hidden>
            <p class="pwa-steps-title">Install on your computer</p>
            <ol class="pwa-step-list">
                <li class="pwa-step">
                    <span class="pwa-step-num">1</span>
                    <div class="pwa-step-body">
                        <strong>Look for the install icon</strong>
                        <span>Click the <strong>⊕</strong> icon at the right end of your address bar</span>
                    </div>
                </li>
                <li class="pwa-step">
                    <span class="pwa-step-num">2</span>
                    <div class="pwa-step-body">
                        <strong>Click "Install"</strong>
                        <span>A small dialog will confirm — click Install to proceed</span>
                    </div>
                </li>
                <li class="pwa-step">
                    <span class="pwa-step-num">3</span>
                    <div class="pwa-step-body">
                        <strong>App opens as its own window</strong>
                        <span>Find it in your Start Menu, Dock, or Desktop</span>
                    </div>
                </li>
            </ol>
        </div>

        {{-- Fallback / unsupported browser --}}
        <div class="pwa-steps" id="pwa-steps-fallback" hidden>
            <p class="pwa-steps-title">Add to your device</p>
            <ol class="pwa-step-list">
                <li class="pwa-step">
                    <span class="pwa-step-num">1</span>
                    <div class="pwa-step-body">
                        <strong>Open your browser menu</strong>
                        <span>Tap the <strong>⋮</strong> or <strong>⋯</strong> icon in your browser</span>
                    </div>
                </li>
                <li class="pwa-step">
                    <span class="pwa-step-num">2</span>
                    <div class="pwa-step-body">
                        <strong>Find "Add to Home Screen"</strong>
                        <span>Or "Install App" — it varies by browser</span>
                    </div>
                </li>
                <li class="pwa-step">
                    <span class="pwa-step-num">3</span>
                    <div class="pwa-step-body">
                        <strong>Confirm and you're done!</strong>
                        <span>The app will appear on your device</span>
                    </div>
                </li>
            </ol>
        </div>

        <!-- Action buttons -->
        <div class="pwa-actions">
            <button class="pwa-btn-install" id="pwa-install-btn">
                <i class="fa fa-download me-2"></i>Install Now
            </button>
            <div class="pwa-soft-actions">
                <button class="pwa-btn-later" id="pwa-later-btn">Maybe Later</button>
                <span class="pwa-divider">·</span>
                <button class="pwa-btn-never" id="pwa-never-btn">Never show again</button>
            </div>
        </div>
    </div>
</div>

<style>
/* ── Overlay & Backdrop ── */
.pwa-overlay {
    position: fixed;
    inset: 0;
    z-index: 99999;
    display: flex;
    align-items: flex-end;
    justify-content: center;
    pointer-events: none;
}
.pwa-overlay.pwa-visible { pointer-events: all; }

.pwa-backdrop {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0);
    backdrop-filter: blur(0);
    transition: background .4s ease, backdrop-filter .4s ease;
}
.pwa-overlay.pwa-visible .pwa-backdrop {
    background: rgba(0,0,0,.65);
    backdrop-filter: blur(6px);
}

/* ── Sheet ── */
.pwa-sheet {
    position: relative;
    z-index: 1;
    width: 100%;
    max-width: 480px;
    background: #12121f;
    border-radius: 24px 24px 0 0;
    padding: 0 0 env(safe-area-inset-bottom,16px);
    transform: translateY(110%);
    transition: transform .45s cubic-bezier(.34,1.56,.64,1);
    box-shadow: 0 -8px 40px rgba(0,0,0,.5);
    overflow: hidden;
}
.pwa-overlay.pwa-visible .pwa-sheet { transform: translateY(0); }

@media (min-width: 600px) {
    .pwa-overlay {
        align-items: center;
    }
    .pwa-sheet {
        border-radius: 20px;
        margin-bottom: 0;
        max-width: 440px;
        transform: translateY(40px) scale(.96);
        opacity: 0;
        transition: transform .4s cubic-bezier(.34,1.56,.64,1), opacity .3s ease;
    }
    .pwa-overlay.pwa-visible .pwa-sheet {
        transform: translateY(0) scale(1);
        opacity: 1;
    }
}

/* ── Handle ── */
.pwa-handle {
    width: 40px;
    height: 4px;
    border-radius: 2px;
    background: rgba(255,255,255,.18);
    margin: 12px auto 0;
}
@media (min-width: 600px) { .pwa-handle { display: none; } }

/* ── Header ── */
.pwa-header {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 16px 20px 12px;
    position: relative;
}
.pwa-app-icon img {
    border-radius: 16px;
    box-shadow: 0 4px 16px rgba(220,20,60,.4);
}
.pwa-app-info { flex: 1; min-width: 0; }
.pwa-app-name {
    font-size: 1.15rem;
    font-weight: 700;
    color: #fff;
    margin: 0 0 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.pwa-app-sub {
    font-size: .8rem;
    color: rgba(255,255,255,.55);
    margin: 0 0 5px;
}
.pwa-stars {
    color: #f5a623;
    font-size: .78rem;
    display: flex;
    align-items: center;
    gap: 2px;
}
.pwa-stars span {
    color: rgba(255,255,255,.6);
    margin-left: 4px;
    font-size: .75rem;
}
.pwa-close {
    position: absolute;
    top: 14px;
    right: 16px;
    background: rgba(255,255,255,.1);
    border: none;
    color: #fff;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    font-size: 1.1rem;
    line-height: 1;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background .2s;
}
.pwa-close:hover { background: rgba(255,255,255,.2); }

/* ── Benefits ── */
.pwa-benefits {
    display: flex;
    justify-content: space-around;
    padding: 10px 16px 14px;
    border-bottom: 1px solid rgba(255,255,255,.07);
}
.pwa-benefit {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
    font-size: .72rem;
    color: rgba(255,255,255,.7);
    text-align: center;
}
.pwa-benefit i {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: rgba(220,20,60,.15);
    color: #DC143C;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .95rem;
}

/* ── Steps ── */
.pwa-steps { padding: 16px 20px 4px; }
.pwa-steps-title {
    font-size: .72rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: #DC143C;
    margin: 0 0 12px;
}
.pwa-step-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.pwa-step {
    display: flex;
    align-items: flex-start;
    gap: 12px;
}
.pwa-step-num {
    flex-shrink: 0;
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: linear-gradient(135deg, #DC143C, #a01030);
    color: #fff;
    font-size: .78rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(220,20,60,.4);
    margin-top: 1px;
}
.pwa-step-body {
    display: flex;
    flex-direction: column;
    gap: 1px;
}
.pwa-step-body strong {
    font-size: .86rem;
    color: #fff;
    font-weight: 600;
}
.pwa-step-body span {
    font-size: .78rem;
    color: rgba(255,255,255,.5);
}

/* ── Actions ── */
.pwa-actions {
    padding: 14px 20px 20px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.pwa-btn-install {
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 14px;
    background: linear-gradient(135deg, #DC143C, #a01030);
    color: #fff;
    font-size: 1rem;
    font-weight: 700;
    cursor: pointer;
    letter-spacing: .02em;
    box-shadow: 0 4px 20px rgba(220,20,60,.45);
    transition: transform .15s, box-shadow .15s;
}
.pwa-btn-install:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 24px rgba(220,20,60,.55);
}
.pwa-btn-install:active { transform: translateY(0); }

.pwa-soft-actions {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}
.pwa-btn-later,
.pwa-btn-never {
    background: none;
    border: none;
    font-size: .82rem;
    cursor: pointer;
    padding: 4px 8px;
    border-radius: 6px;
    transition: background .2s, color .2s;
}
.pwa-btn-later { color: rgba(255,255,255,.6); }
.pwa-btn-later:hover { color: #fff; background: rgba(255,255,255,.08); }
.pwa-btn-never { color: rgba(255,255,255,.35); }
.pwa-btn-never:hover { color: rgba(255,255,255,.7); background: rgba(255,255,255,.05); }
.pwa-divider { color: rgba(255,255,255,.2); font-size: .7rem; }

/* ── Closing animation ── */
.pwa-overlay.pwa-hiding .pwa-sheet { transform: translateY(110%) !important; }
.pwa-overlay.pwa-hiding .pwa-backdrop { background: rgba(0,0,0,0) !important; backdrop-filter: blur(0) !important; }
@media (min-width: 600px) {
    .pwa-overlay.pwa-hiding .pwa-sheet {
        transform: translateY(20px) scale(.95) !important;
        opacity: 0 !important;
    }
}
</style>

<script>
(function () {
    'use strict';

    // ── Guard: already installed or permanently dismissed ──────────────────
    if (window.matchMedia('(display-mode: standalone)').matches) return;
    if (navigator.standalone) return;                          // iOS standalone
    if (localStorage.getItem('pwa_prompt') === 'never') return;

    // ── Guard: "later" within 3 days ──────────────────────────────────────
    var snoozed = localStorage.getItem('pwa_prompt_snooze');
    if (snoozed && Date.now() < parseInt(snoozed, 10)) return;

    // ── Platform detection ────────────────────────────────────────────────
    var ua       = navigator.userAgent;
    var isIOS    = /iphone|ipad|ipod/i.test(ua);
    var isSafari = isIOS && /safari/i.test(ua) && !/crios|fxios/i.test(ua);
    var isDesktop = !(/android|iphone|ipad|ipod/i.test(ua));

    var deferredPrompt = null;
    var platform = isIOS ? (isSafari ? 'ios' : 'fallback')
                         : (isDesktop ? 'desktop' : 'fallback');

    // Capture the native install event (Chrome/Edge/Android)
    window.addEventListener('beforeinstallprompt', function (e) {
        e.preventDefault();
        deferredPrompt = e;
        platform = 'native';
        if (document.getElementById('pwa-overlay')) {
            activatePlatformSteps('native');
        }
    });

    // ── DOM refs ──────────────────────────────────────────────────────────
    var overlay    = document.getElementById('pwa-overlay');
    var installBtn = document.getElementById('pwa-install-btn');
    var laterBtn   = document.getElementById('pwa-later-btn');
    var neverBtn   = document.getElementById('pwa-never-btn');
    var closeX     = document.getElementById('pwa-close-x');
    var backdrop   = document.getElementById('pwa-backdrop');

    if (!overlay) return;

    function activatePlatformSteps(p) {
        ['native','ios','desktop','fallback'].forEach(function (k) {
            var el = document.getElementById('pwa-steps-' + k);
            if (el) el.hidden = (k !== p);
        });
        // Hide install button for iOS/fallback since it's a manual process
        if (installBtn) {
            installBtn.style.display = (p === 'native') ? '' : 'none';
        }
    }

    function showPrompt() {
        overlay.hidden = false;
        activatePlatformSteps(platform);
        // Force reflow then animate in
        requestAnimationFrame(function () {
            requestAnimationFrame(function () {
                overlay.classList.add('pwa-visible');
            });
        });
    }

    function hidePrompt(callback) {
        overlay.classList.add('pwa-hiding');
        overlay.classList.remove('pwa-visible');
        setTimeout(function () {
            overlay.hidden = true;
            overlay.classList.remove('pwa-hiding');
            if (callback) callback();
        }, 450);
    }

    // ── Button handlers ───────────────────────────────────────────────────
    installBtn && installBtn.addEventListener('click', function () {
        if (deferredPrompt) {
            deferredPrompt.prompt();
            deferredPrompt.userChoice.then(function (choice) {
                if (choice.outcome === 'accepted') {
                    localStorage.setItem('pwa_prompt', 'never');
                }
                deferredPrompt = null;
                hidePrompt();
            });
        } else {
            hidePrompt();
        }
    });

    laterBtn && laterBtn.addEventListener('click', function () {
        // Snooze for 3 days
        localStorage.setItem('pwa_prompt_snooze', String(Date.now() + 3 * 24 * 60 * 60 * 1000));
        hidePrompt();
    });

    neverBtn && neverBtn.addEventListener('click', function () {
        localStorage.setItem('pwa_prompt', 'never');
        hidePrompt();
    });

    closeX && closeX.addEventListener('click', function () {
        // Close X behaves same as "Later"
        localStorage.setItem('pwa_prompt_snooze', String(Date.now() + 3 * 24 * 60 * 60 * 1000));
        hidePrompt();
    });

    // Tap backdrop to dismiss (like "Later")
    backdrop && backdrop.addEventListener('click', function () {
        localStorage.setItem('pwa_prompt_snooze', String(Date.now() + 3 * 24 * 60 * 60 * 1000));
        hidePrompt();
    });

    // ── Show after 3 s delay ──────────────────────────────────────────────
    setTimeout(showPrompt, 3000);
})();
</script>
