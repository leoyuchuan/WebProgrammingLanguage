<?php
session_start();
session_destroy();
?>
<html>
    <body>
        <script>
            function statusChangeCallback(response) {
                    if (response.status === 'connected') {
                        FB.logout();
                    } else if (response.status === 'not_authorized') {
                        // The person is logged into Facebook, but not your app.
                        ;
                    } else {
                        // The person is not logged into Facebook, so we're not sure if
                        // they are logged into this app or not.
                        ;
                    }
                }

                // This function is called when someone finishes with the Login
                // Button.  See the onlogin handler attached to it in the sample
                // code below.
                function checkLoginState() {
                    FB.getLoginStatus(function (response) {
                        statusChangeCallback(response);
                    });
                }

                window.fbAsyncInit = function () {
                    FB.init({
                        appId: '885891358122608',
                        cookie: true, // enable cookies to allow the server to access 
                        // the session
                        xfbml: true, // parse social plugins on this page
                        version: 'v2.1' // use version 2.1
                    });

                    FB.getLoginStatus(function (response) {
                        statusChangeCallback(response);
                        window.location="../login.php";
                    });

                };
                (function (d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id))
                        return;
                    js = d.createElement(s);
                    js.id = id;
                    js.src = "//connect.facebook.net/en_US/sdk.js";
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
        </script>
    </body>
</html>

