/*import firebase from "firebase/compat";*/

importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');

firebase.initializeApp({
    apiKey: "AIzaSyCc2eq23_efjual1WZ329gMP5bZlOunv9s",
    authDomain: "ajiriwa-push-notifications.firebaseapp.com",
    projectId: "ajiriwa-push-notifications",
    storageBucket: "ajiriwa-push-notifications.appspot.com",
    messagingSenderId: "117362381735",
    appId: "1:117362381735:web:0a00ccfa5024cc70fc9c82",
    measurementId: "G-JW3B32E4S6"
});

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function({data:{title,body,icon}}) {
    return self.registration.showNotification(title,{body,icon});
});
