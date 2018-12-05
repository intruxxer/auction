// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here, other Firebase libraries
// are not available in the service worker.
importScripts('https://www.gstatic.com/firebasejs/4.8.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/4.8.1/firebase-messaging.js');
//importScripts('https://quanto-7e4fa.firebaseapp.com/__/firebase/init.js');

/*
var push_messaging = firebase.messaging();

push_messaging.setBackgroundMessageHandler(function(payload) {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);
  const notificationTitle = '123Quanto';
  const notificationOptions = {
    body: 'You got a new message.',
    icon: 'quanto-logo.png'
  };

  return self.registration.showNotification(notificationTitle,
      notificationOptions);
});
*/


// Initialize the Firebase app in the service worker by passing in the
// messagingSenderId.
firebase.initializeApp({
    'messagingSenderId': '559692176742'
});


// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();

messaging.setBackgroundMessageHandler(function(payload) {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
    // Customize notification here
    const notificationTitle = '123Quanto';
    const notificationOptions = {
        body: 'You got a new message.',
        icon: 'quanto-logo.png'
    };

    return self.registration.showNotification(notificationTitle,
        notificationOptions);
});
