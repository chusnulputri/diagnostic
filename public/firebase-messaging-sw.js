/*
Give the service worker access to Firebase Messaging.
Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.
*/
importScripts('https://www.gstatic.com/firebasejs/8.2.5/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.2.5/firebase-messaging.js');

/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
* New configuration for app@pulseservice.com
*/
firebase.initializeApp({
    apiKey: "AIzaSyA1oboaLdQ6Z_I5WL57T_YJ2ZbyzC3X92I",

  authDomain: "general-projects-323509.firebaseapp.com",

  projectId: "general-projects-323509",

  storageBucket: "general-projects-323509.appspot.com",

  messagingSenderId: "764688620206",

  appId: "1:764688620206:web:f41c7a5ab58867b1a66b3f",

  measurementId: "G-85Q6YGJFSC"

});

/*
Retrieve an instance of Firebase Messaging so that it can handle background messages.
*/
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
    // Customize notification here
    const notificationTitle = 'Background Message Title';
    const notificationOptions = {
        body: 'Background Message body.',
        icon: '/firebase-logo.png'
    };

    return self.registration.showNotification(notificationTitle,
        notificationOptions);
});

if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('../firebase-messaging-sw.js')
        .then(function (registration) {
            console.log('Registration successful, scope is:', registration.scope);
        }).catch(function (err) {
            console.log('Service worker registration failed, error:', err);
        });
}
