// Initialize Firebase
var config = {
    apiKey: "AIzaSyAdEQbcHsexfT5zMcPZxMOqQCQD4DNgMMw",
    authDomain: "quanto-7e4fa.firebaseapp.com",
    databaseURL: "https://quanto-7e4fa.firebaseio.com",
    projectId: "quanto-7e4fa",
    storageBucket: "quanto-7e4fa.appspot.com",
    messagingSenderId: "559692176742"
};
firebase.initializeApp(config);

const messaging = firebase.messaging();

// check if browser supports notifications
if (
    'Notification' in window &&
    'serviceWorker' in navigator &&
    'localStorage' in window &&
    'fetch' in window &&
    'postMessage' in window
) {



    // sign up for notifications if haven't signed yet
    if (Notification.permission === 'granted') {
        getToken();
    }

    // ask the user permission to notify
    $('#subscribe').on('click', function () {
        //subscribe();
    });

    // handle catch the notification on current page
    messaging.onMessage(function (payload) {

        console.log('[firebase-messaging-sw.js] Received foreground message ', payload);

        var notificationTitle = '123Quanto';
        var notificationOptions = {
            body: 'You got a new message.',
            icon: 'quanto-logo.png'
        };

        // Let's check whether notification permissions have already been granted
        Notification.requestPermission(function(permission) {
            if (permission === 'granted') {
                // If it's okay let's create a notification
                var notification = new Notification(notificationTitle,notificationOptions);
                notification.onclick = function(event) {
                    event.preventDefault(); // prevent the browser from focusing the Notification's tab
                    window.open(payload.notification.click_action , '_blank');
                    notification.close();
                }
            }
        });

        /*// Let's check whether notification permissions have already been granted
        if (Notification.permission === "granted") {
            // If it's okay let's create a notification
            var notification = new Notification(notificationTitle,notificationOptions);
            notification.onclick = function(event) {
                event.preventDefault(); // prevent the browser from focusing the Notification's tab
                window.open(payload.notification.click_action , '_blank');
                notification.close();
            }
        }*/

    });

    // Callback fired if Instance ID token is updated.
    messaging.onTokenRefresh(function () {
        messaging.getToken()
            .then(function (refreshedToken) {
                console.log('Token refreshed' + refreshedToken);
                // Send Instance ID token to app server.
                firebase_token = refreshedToken;
                sendTokenToServer(refreshedToken);
                //updateUIForPushEnabled(refreshedToken);
            })
            .catch(function (error) {
                //showError('Unable to retrieve refreshed token', error);
                console.log('Unable to retrieve refreshed token ', error);
            });
    });

} else {


    if (!('Notification' in window)) {
       // showError('Notification not supported');
    } else if (!('serviceWorker' in navigator)) {
        //showError('ServiceWorker not supported');
    } else if (!('localStorage' in window)) {
       // showError('LocalStorage not supported');
    } else if (!('fetch' in window)) {
       // showError('fetch not supported');
    } else if (!('postMessage' in window)) {
       // showError('postMessage not supported');
    }

    console.warn('This browser does not support desktop notification.');
    console.log('Is HTTPS', window.location.protocol === 'https:');
    console.log('Support Notification', 'Notification' in window);
    console.log('Support ServiceWorker', 'serviceWorker' in navigator);
    console.log('Support LocalStorage', 'localStorage' in window);
    console.log('Support fetch', 'fetch' in window);
    console.log('Support postMessage', 'postMessage' in window);

}


function getToken() {
    console.log('Since permission is granted, retrieving token...');
    messaging.requestPermission()
        .then(function () {
            firebase_permission = true;
            console.log('Notification permission granted.');
            // Get Instance ID token. Initially this makes a network call, once retrieved
            // subsequent calls to getToken will return from cache.
            messaging.getToken()
                .then(function (currentToken) {

                    if (currentToken) {
                        firebase_token = currentToken;
                        console.log(firebase_token);
                        sendTokenToServer(firebase_token);
                    } else {
                        //showError('No Instance ID token available. Request permission to generate one');
                        console.log('No Instance ID token available. Request permission to generate one.');
                        setTokenSentToServer(false);
                    }
                })
                .catch(function (error) {
                    //showError('An error occurred while retrieving token', error);
                    console.log('An error occurred while retrieving token. ', error);
                    //updateUIForPushPermissionRequired();
                    setTokenSentToServer(false);
                });
        })
        .catch(function (error) {
            //showError('Unable to get permission to notify', error);
            console.log('Unable to get permission to notify', error);
        });
}

// Send the Instance ID token your application server, so that it can:
// - send messages back to this app
// - subscribe/unsubscribe the token from topics
function sendTokenToServer(currentToken) {
    if (!isTokenSentToServer(currentToken)) {
        console.log('Sending token to server...');


        var http = new XMLHttpRequest();
        var url = "https://qa.api.123quanto.com/engines/gcm/main.php";
        var params = "user_id=" + firebase_user_id + "&device_id=" + firebase_browser + "&device_type=web&name=" + firebase_user_name + "&email=" + firebase_user_email + "&type=" + firebase_user_role + "&regId=" + currentToken;
        http.open("POST", url, true);
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        http.onreadystatechange = function () {
            if (http.readyState == 4 && http.status == 200) {
                console.log(http.responseText);
            }
        }
        http.send(params);

        // send current token to server
        //$.post(url, {token: currentToken});
        //setTokenSentToServer(currentToken);
        setTokenValueSentToServer(currentToken, firebase_user_email);
    } else {
        console.log('Token already sent to server so won\'t send it again unless it changes');
    }
}


/*function sendTokenToServer(currentToken) {
    if (!isSameTokenSentToServer(currentToken)) {
        console.log('Sending token to server...');
        var http = new XMLHttpRequest();
        var url = "https://api.123quanto.com/engines/gcm/main.php";
        var params = "user_id=" + firebase_user_id + "&device_id=" + firebase_browser + "&device_type=web&name=" + firebase_user_name + "&email=" + firebase_user_email + "&type=" + firebase_user_role + "&regId=" + currentToken;
        http.open("POST", url, true);
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        http.onreadystatechange = function () {
            if (http.readyState == 4 && http.status == 200) {
                console.log(http.responseText);
            }
        }
        http.send(params);
        setTokenValueSentToServer(currentToken, firebase_user_email);
    } else {
        console.log('Same token was already sent to server, unless it changes, no need to resend.');
    }
}*/

function isTokenSentToServer() {
    return window.localStorage.getItem('sentToServer') == 1;
}

function setTokenSentToServer(sent) {
    window.localStorage.setItem('sentToServer', sent ? 1 : 0);
}

function isSameTokenSentToServer(currentToken) {
    var oldToken = window.localStorage.getItem('tokenToServer');
    if (oldToken == currentToken) {
        window.localStorage.setItem('sentToServer', 1);
        return true;
    } else {
        window.localStorage.setItem('sentToServer', 0);
        return false;
    }
}

function setTokenValueSentToServer(token, email) {
    window.localStorage.setItem('tokenToServer', token);
    window.localStorage.setItem('userEmail', email);
    window.localStorage.setItem('sentToServer', 1);
}

function setUserBrowser() {
    // Chrome 1+
    var isChrome = !!window.chrome && !!window.chrome.webstore;
    if (isChrome) {
        return "chrome";
    } else {
        // // Opera 8.0+
        // var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
        // if(isOpera){ firebase_browser = "opera"; }
        // // Firefox 1.0+
        // var isFirefox = typeof InstallTrigger !== 'undefined';
        // if(isFirefox){ firebase_browser = "firefox"; }
        // // Safari 3.0+ "[object HTMLElementConstructor]"
        // var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || (typeof safari !== 'undefined' && safari.pushNotification));
        // if(isSafari){ firebase_browser = "safari"; }
        // // Internet Explorer 6-11
        // var isIE = /*@cc_on!@*/false || !!document.documentMode;
        // if(isIE){ firebase_browser = "ie"; }
        // // Edge 20+
        // var isEdge = !isIE && !!window.StyleMedia;
        // if(isEdge){ firebase_browser = "edge"; }
        return "other";
    }
}


messaging.onMessage(function (payload) {

    console.log('[firebase-messaging-sw.js] Received foreground message ', payload);

    var notificationTitle = '123Quanto';
    var notificationOptions = {
        body: 'You got a new message.',
        icon: 'quanto-logo.png'
    };

    if (!("Notification" in window)) {
        console.log("This browser does not support system notifications");
    }
    // Let's check whether notification permissions have already been granted
    else if (Notification.permission === "granted") {
        // If it's okay let's create a notification
        var notification = new Notification(notificationTitle, notificationOptions);
        notification.onclick = function (event) {
            event.preventDefault(); // prevent the browser from focusing the Notification's tab
            window.open(payload.notification.click_action, '_blank');
            notification.close();
        }
    }
});
