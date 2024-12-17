// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
    apiKey: "AIzaSyAGdOZJ7afDT1hDzRYYTxk5vg1Mv3_mrkQ",
    authDomain: "project-iot-13e38.firebaseapp.com",
    databaseURL: "https://project-iot-13e38-default-rtdb.firebaseio.com",
    projectId: "project-iot-13e38",
    storageBucket: "project-iot-13e38.firebasestorage.app",
    messagingSenderId: "680907399883",
    appId: "1:680907399883:web:9701113de7b59a859e314e",
    measurementId: "G-ZF8QJG1CG8",
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);
