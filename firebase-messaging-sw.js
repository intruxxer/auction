importScripts('https://quanto-1da38.firebaseapp.com/__/firebase/4.1.3/firebase-app.js');
importScripts('https://quanto-1da38.firebaseapp.com/__/firebase/4.1.3/firebase-messaging.js');
importScripts('https://quanto-1da38.firebaseapp.com/__/firebase/init.js');

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