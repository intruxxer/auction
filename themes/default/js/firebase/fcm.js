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


var firebase_permission = false;
var firebase_messaging = firebase.messaging();
var firebase_browser = setUserBrowser();
var firebase_token;
var firebase_user_id = "<?= $user_id ?>";
var firebase_user_name = "<?= $user_name ?>";
var firebase_user_email = "<?= $user_email ?>";
var firebase_user_role = "<?= $user_role ?>";

//if(firebase_browser=="chrome"){ requestPermission(); }

requestPermission();

firebase_messaging.onTokenRefresh(function () {
    firebase_messaging.getToken()
        .then(function (refreshedToken) {
            console.log('Token refreshed: ' + refreshedToken);
            firebase_token = refreshedToken;
            sendTokenToServer(firebase_token);
        })
        .catch(function (err) {
            console.log('Unable to retrieve refreshed token ', err);
        });
});

firebase_messaging.onMessage(function (payload) {
    console.log("Message received. ", payload);
});

function requestPermission() {
    firebase_messaging.requestPermission()
        .then(function () {
            firebase_permission = true;
            console.log('Notification permission granted.');
            requestToken();
        })
        .catch(function (err) {
            firebase_permission = false;
            console.log('Unable to get permission to notify.', err);
        });
}

function requestToken() {
    console.log('Since permission is granted, retrieving token...');
    firebase_messaging.getToken()
        .then(function (currentToken) {
            if (currentToken) {
                firebase_token = currentToken;
                console.log(firebase_token);
                sendTokenToServer(firebase_token);
            } else {
                console.log('No Instance ID token available. Request permission to generate one.');
            }
        }).catch(function (err) {
        console.log('An error occurred while retrieving token. ', err);
    });
}

function sendTokenToServer(currentToken) {
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
}

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


firebase_messaging.onMessage(function (payload) {

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
