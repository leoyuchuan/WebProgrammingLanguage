<?php
require_once './checklogin.php';
$tid = $_GET['tid'];
if (preg_match("/^[1-9][0-9]*$/", $tid) !== 1) {
    echo "<script>window.history.back();</script>";
}
require_once 'HTTP/Request2.php';
session_start();
$region = $_SESSION['region'];
$username = $_SESSION['username'];
$password = $_SESSION['password'];
$r = new Http_Request2('http://www.webserver' . rand(1, 2) . '.com/subscribe.php');
$r->setMethod(HTTP_Request2::METHOD_POST);
$r->addPostParameter(array('o' => 'un', 'team_id' => $tid, 'region' => $region,'username' => $username,'password' => $password));
$r->send();
echo "<script>window.history.back();</script>";
?>

