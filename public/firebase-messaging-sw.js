importScripts('https://www.gstatic.com/firebasejs/10.7.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.7.0/firebase-messaging-compat.js');

firebase.initializeApp({
  apiKey: 'AIzaSyD7iQpIq5pjC3OFLcHCheXvUCd3_Tr-dcc',
  authDomain: 'realestate-services-plat-30007.firebaseapp.com',
  projectId: 'realestate-services-plat-30007',
  storageBucket: 'realestate-services-plat-30007.firebasestorage.app',
  messagingSenderId: '311963055314',
  appId: '1:311963055314:web:ea916081d697432962a90b',
  measurementId: 'G-571R98TR0G'
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage(payload => {
  console.log('Background message received: ', payload);
});

self.addEventListener('notificationclick', event => {
  event.notification.close();
  const targetUrl = event.notification.data?.url || '/';
  event.waitUntil(clients.openWindow(targetUrl));
});
