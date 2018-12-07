<!doctype html>
<html class="no-js" lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?php echo site_url() ?>assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo site_url() ?>assets/css/foundation.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.css">
    <link rel="stylesheet" href="<?php echo site_url() ?>assets/css/app.css">
    <link rel="stylesheet" href="<?php echo site_url() ?>assets/css/app-new.css">
    <link rel="stylesheet" href="<?php echo site_url() ?>assets/css/app-self.css">
    <link rel="manifest" href="/manifest.json">
    <script type="text/javascript">
        window.$crisp = [];
        window.CRISP_WEBSITE_ID = "e12a37ca-152f-4f3d-8c07-136a408f215e";
        (function () {
            d = document;
            s = d.createElement("script");
            s.src = "https://client.crisp.im/l.js";
            s.async = 1;
            d.getElementsByTagName("head")[0].appendChild(s);
        })();
    </script>
</head>
<body class="<?= $body_class ?>">

<script src="<?php echo site_url() ?>assets/js/moment.min.js"></script>
<!-- <script src="<?php echo site_url() ?>assets/js/moment-timezone.min.js"></script> -->
<script src="<?php echo site_url() ?>assets/js/vendor/jquery.js"></script>
<script src="<?php echo site_url() ?>assets/js/vendor/what-input.js"></script>
<script src="<?php echo site_url() ?>assets/js/vendor/foundation.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.62/jquery.inputmask.bundle.js"></script>
<!-- <script src="<?= $this->template->get_theme_path() ?>js/jslib/a.min.js"></script> -->

<?php if ( $type == 'registration' ) { ?>
    <header id="main-header">
        <div class="row">
            <div class="columns small-12">
                <img src="<?php echo site_url(); ?>/assets/img/logo-header.svg" class="logo-main-header">
            </div>
        </div>
    </header>
    <section class="app-container">
        <div class="row">
            <div class="columns small-12">
                <section>
                    <div class="row">
						<?php echo $template['body']; ?>
                    </div>
                </section>
            </div>
        </div>
    </section>
<?php } else { ?>
    <header id="main-header">
        <div class="row">
            <div class="columns small-12">
                <img src="<?php echo site_url(); ?>/assets/img/logo-header.svg" class="logo-main-header">
                <!--
                <form id="search-form">
                    <input type="search" placeholder="Search">
                    <button class="search"><i class="fa fa-search"></i></button>
                </form>
                -->
                <ul class="profile-navigation">
                    <li>
                        <a rel="toggle-profile-navigation">Hi, <?php echo $user_name; ?> <span></span></a>
                        <ul class="is-hidden">
                            <li><a href="<?php echo $profile_link; ?>">Profile</a></li>
							<?php if ( $this->session->userdata( 'dealer_profile' ) ) { ?>
                                <li><a href="<?php echo $payment_link; ?>">Payment</a></li>
							<?php } ?>
							<?php if ( false ) { ?>
                                <li><a href="<?php echo $setting_link; ?>">Settings</a></li>
							<?php } ?>
                            <li><a href="<?php echo site_url( 'logout' ); ?>">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <section class="app-container">
        <div class="row">
            <div class="columns small-12 medium-7 large-9">
                <section>
                    <div class="row">
						<?php echo $template['body']; ?>
                    </div>
                </section>
            </div>
            <div class="columns small-12 medium-5 large-3">
                <aside>
                    <div class="row">
						<?php echo $sidebar; ?>
                    </div>
                </aside>
            </div>
        </div>
    </section>
<?php } ?>
<script src="<?php echo site_url() ?>assets/js/app.js"></script>
<?php if ( $type != 'registration' ) { ?>
    <footer id="main-footer">
        <div class="row">
            <hr>
        </div>
    </footer>
<?php } ?>
<?php if ( $this->session->userdata( 'login' ) ) { ?>

    <!-- Firebase App is always required and must be first -->
    <script src="https://www.gstatic.com/firebasejs/5.6.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.6.0/firebase-messaging.js"></script>

    <script src="<?= $this->template->get_theme_path() ?>js/firebase/fcm.js"></script>

    <script type="text/javascript">
        var firebase_permission = false;
        var firebase_messaging = firebase.messaging();
        var firebase_browser = setUserBrowser();
        var firebase_token;
        var firebase_user_id = "<?= $user_id ?>";
        var firebase_user_name = "<?= $user_name ?>";
        var firebase_user_email = "<?= $user_email ?>";
        var firebase_user_role = "<?= $user_role ?>";

        //if(firebase_browser=="chrome"){ requestPermission(); }

        /*requestPermission();

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
                // var isIE = /!*@cc_on!@*!/false || !!document.documentMode;
                // if(isIE){ firebase_browser = "ie"; }
                // // Edge 20+
                // var isEdge = !isIE && !!window.StyleMedia;
                // if(isEdge){ firebase_browser = "edge"; }
                return "other";
            }
        }


        firebase_messaging.onMessage(function(payload) {

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
                var notification = new Notification(notificationTitle,notificationOptions);
                notification.onclick = function(event) {
                    event.preventDefault(); // prevent the browser from focusing the Notification's tab
                    window.open(payload.notification.click_action , '_blank');
                    notification.close();
                }
            }
        });*/

    </script>
<?php }else{ ?>
    <script type="text/javascript">
        var user_browser = setUserBrowser();
        var user_email = window.localStorage.getItem('userEmail');

        window.localStorage.removeItem('sentToServer');
        window.localStorage.removeItem('userEmail');
        window.localStorage.removeItem('tokenToServer');

        if (user_email) {
            console.log('Removing FCM ID from Server...');
            var http = new XMLHttpRequest();
            var url = "<?= $this->config->item( 'api_url' ) ?>" + "engines/gcm/main.php";
            var params = "device_id=" + user_browser + "&device_type=web" + "&email=" + user_email + "&regId=del&name=anonym&type=anonym&user_id=anonym";
            http.open("POST", url, true);
            http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            http.onreadystatechange = function () {
                if (http.readyState == 4 && http.status == 200) {
                    console.log(http.responseText);
                }
            }
            http.send(params);
        }

        function setUserBrowser() {
            var isChrome = !!window.chrome && !!window.chrome.webstore;
            if (isChrome) {
                return "chrome";
            } else {
                return "other";
            }
        }

    </script>
<?php } ?>
</body>
</html>
