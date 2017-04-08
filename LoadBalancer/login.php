<?php
session_start();
$status = $_SESSION['status'];
if ($status === 'online') {
    echo '<script>window.location = "home.php"</script>';
    return;
}
?>

<!--<html xmlns:wb="http://open.weibo.com/wb">-->
    <html>
        <head>
<!--            <script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js?appkey=2337125943" type="text/javascript" charset="utf-8"></script>-->
            <meta charset="UTF-8">
            <title>TopSpaceHL!</title>
            <link rel="stylesheet" href="css/style.css" media="screen" type="text/css" />
        </head>
        <body>
            <script>
                function statusChangeCallback(response) {
                    if (response.status === 'connected') {
                        FB.api('/me', function (response) {
                            var id = response.id;
                            var inputs = document.getElementsByTagName('input');
                            var region = inputs[2].value;
                            var xmlhttp;
                            if (window.XMLHttpRequest)
                            {// code for IE7+, Firefox, Chrome, Opera, Safari
                                xmlhttp = new XMLHttpRequest();
                            }
                            else
                            {// code for IE6, IE5
                                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                            }
                            xmlhttp.onreadystatechange = function ()
                            {
                                if (xmlhttp.responseText.trim() === "okay") {
                                    window.location = "./home.php";
                                    return;
                                }
                                if(xmlhttp.responseText.trim() === "fail"){
                                    window.location = "./register.php?token="+id;
                                    return;
                                }
                            };
                            xmlhttp.open("POST", "./phpscript/fb.php", true);
                            var params = "token=" + id;
                            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                            xmlhttp.setRequestHeader("Accept-Encoding", "gzip,deflat");
                            xmlhttp.send(params);
                        });
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
            <div id="loginform">
                <div id="mainlogin">
                    <h1>Log in with awesome new thing</h1>
                    <form action="javascript:void(0);" method="POST">
                        <input type="text" placeholder="username" value="" required name="username">
                        <input type="password" placeholder="password" value="" required name="password">
                        <input type="text" name="region" value="us/cn">
                        <button type="submit" onclick="login()"><i class="fa fa-arrow-right"></i></button>
                    </form>
                    <div id="note">
                        <h1>Don't have an account?<br/> Super Fast <a href="register.php">Sign Up</a> Here! Or By<br/><fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
                            </fb:login-button></h1>
                    </div>

                    <script>
                        function login() {
                            var inputs = document.getElementsByTagName('input');
                            var username = inputs[0].value;
                            var password = inputs[1].value;
                            var region = inputs[2].value;
                            if (username.trim() === "") {
//                                alert('username fail');
                                return;
                            }
                            if (password.trim() === "") {
//                                alert('password fail');
                                return;
                            }
                            if (region.trim() !== "cn" && region.trim() !== "us") {
//                                alert('region fail');
                                return;
                            }
                            var xmlhttp;
                            if (window.XMLHttpRequest)
                            {// code for IE7+, Firefox, Chrome, Opera, Safari
                                xmlhttp = new XMLHttpRequest();
                            }
                            else
                            {// code for IE6, IE5
                                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                            }
                            xmlhttp.onreadystatechange = function ()
                            {
                                loginProcess(xmlhttp.responseText);
                                return;
                            };
                            xmlhttp.open("POST", "./phpscript/loginprocess.php", true);
                            var params = "username=" + username.trim() + "&password=" + password.trim() + "&region=" + region.trim();
                            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                            xmlhttp.setRequestHeader("Accept-Encoding","gzip,deflat");
                            xmlhttp.send(params);
                        }

                        function loginProcess(message) {
                            if (message.trim() == 'okay') {
                                window.location = "./home.php";
                            }
                        }
                    </script>

                </div>
            </div>


        </body>

    </html>