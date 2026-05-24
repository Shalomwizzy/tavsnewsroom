const CACHE  = 'newsroom-v3';
const OFFLINE = '/offline';

const PRECACHE = [
    '/',
    '/offline',
];

// Install: cache the app shell
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE).then(cache => cache.addAll(PRECACHE))
    );
    self.skipWaiting();
});

// Activate: remove old caches
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys =>
            Promise.all(keys.filter(k => k !== CACHE).map(k => caches.delete(k)))
        )
    );
    self.clients.claim();
});

self.addEventListener('fetch', event => {
    const req = event.request;

    // Only handle GET
    if (req.method !== 'GET') return;

    // Skip admin, api, and non-http requests
    const url = new URL(req.url);
    if (url.pathname.startsWith('/admin') || url.pathname.startsWith('/api')) return;
    if (!url.protocol.startsWith('http')) return;

    // Navigation requests: network-first, fallback to offline page
    if (req.mode === 'navigate') {
        event.respondWith(
            fetch(req)
                .then(res => {
                    const clone = res.clone();
                    caches.open(CACHE).then(c => c.put(req, clone));
                    return res;
                })
                .catch(() => caches.match(OFFLINE))
        );
        return;
    }

    // Images: cache-first, store on miss
    if (req.destination === 'image') {
        event.respondWith(
            caches.match(req).then(cached => {
                if (cached) return cached;
                return fetch(req).then(res => {
                    const clone = res.clone();
                    caches.open(CACHE).then(c => c.put(req, clone));
                    return res;
                }).catch(() => cached);
            })
        );
        return;
    }

    // Static assets (CSS/JS/fonts): cache-first
    if (['style', 'script', 'font'].includes(req.destination)) {
        event.respondWith(
            caches.match(req).then(cached => cached || fetch(req).then(res => {
                const clone = res.clone();
                caches.open(CACHE).then(c => c.put(req, clone));
                return res;
            }))
        );
    }
});
