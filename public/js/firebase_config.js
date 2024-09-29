// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
var firebaseConfig =  {
    apiKey: "AIzaSyBhqxR-cRN8CVHe7wPDkfPxF_ABOIaaj40",
    authDomain: "klasspe-150db.firebaseapp.com",
    projectId: "klasspe-150db",
    storageBucket: "klasspe-150db.appspot.com",
    messagingSenderId: "214567535335",
    appId: "1:214567535335:web:c771f84f89537fd8c89842",
    measurementId: "G-RJ7H814YB4"
  };
// Initialize Firebase
firebase.initializeApp(firebaseConfig);
var URL = $('meta[name="baseURL"]').attr('content');

console.log("Firebase started.");

// Facebook
var facebookProvider = new firebase.auth.FacebookAuthProvider();

var googleProvider = new firebase.auth.GoogleAuthProvider();