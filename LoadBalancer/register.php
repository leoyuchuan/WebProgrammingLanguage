<?php
session_start();
$status = $_SESSION['status'];
if ($status === 'online') {
    echo '<script>window.location = "home.php"</script>';
    return;
}
?>
<html xmlns:wb="http://open.weibo.com/wb">
    <html>
        <head>
            <script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js?appkey=2337125943" type="text/javascript" charset="utf-8"></script>
            <meta charset="UTF-8">
            <meta property="wb:webmaster" content="e0b944bd6d4935df" />
            <title>TopSpaceHL!</title>
            <link rel="stylesheet" href="css/style.css" media="screen" type="text/css" />
        </head>
        <body>
            <div id="loginform">

                <div id="mainlogin">
                    <h1>Sign Up</h1>
                    <form action="javascript:void(0);" method="POST">
                        <input type="text" placeholder="username" value="" required name="username">
                        <input type="password" placeholder="password" value="" required name="password">
                        <input type="text" name="region" value="us/cn">
                        <button type="submit" onclick="register()"><i class="fa fa-arrow-right"></i></button>
                    </form>
                    <div id="note">
                        <h1>Sign up using Social Networking Service <a href="http://helmos.com.cn/wplproj/login.php">Here</a></h1>
                    </div>

                    <script>
                        function loginwb(o) {
                            alert("Welcome, " + o.screen_name);
                            window.location = "http://helmos.com.cn/wplproj/weibo.php";
                            // redirect here...
                        }
                        function logoutwb() {
                            alert('logout');
                        }
                        function register() {
                            var inputs = document.getElementsByTagName('input');
                            var username = inputs[0].value;
                            var password = inputs[1].value;
                            var region = inputs[2].value;
                            var token = "";
<?php
$token = $_GET['token'];
echo "token = '$token';";
?>
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
                                registerProcess(xmlhttp.responseText);
                                return;
                            };
                            xmlhttp.open("POST", "./phpscript/register.php", true);
                            var params = "";
                            if (token.trim() === "") {
                                params = "username=" + username.trim() + "&password=" + password.trim() + "&region=" + region.trim();
                            } else {
                                params = "username=" + username.trim() + "&password=" + password.trim() + "&region=" + region.trim() + "&token=" + token;
                            }

                            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                            xmlhttp.setRequestHeader("Accept-Encoding","gzip,deflat");
                            xmlhttp.send(params);
                        }

                        function registerProcess(message) {
                            if (message.trim() === 'okay') {
                                window.location = "./home.php";
                            }
                            if (message.trim() === 'fail') {
                                alert("Fail");
                            }
                        }
                    </script>

                </div>
            </div>


        </body>

    </html>