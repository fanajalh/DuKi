const CACHE_NAME = 'duki-v1';

self.addEventListener('install', (event) => {
    console.log('DuKi Service Worker: Ter-install');
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    console.log('DuKi Service Worker: Aktif');
    event.waitUntil(clients.claim());
});

self.addEventListener('fetch', (event) => {
    event.respondWith(fetch(event.request));
});
