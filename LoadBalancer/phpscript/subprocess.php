<?php
require_once './checklogin.php';
$tid = $_GET['tid'];
$nid = $_GET['nid'];
require_once 'HTTP/Request2.php';
if (preg_match("/^[1-9][0-9]*$/", $tid) === 1) {
    session_start();
    $region = $_SESSION['region'];
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    $r = new Http_Request2('http://www.webserver' . rand(1, 2) . '.com/subscribe.php');
    $r->setMethod(HTTP_Request2::METHOD_POST);
    $r->addPostParameter(array('o' => 'subt', 'team_id' => $tid, 'region' => $region,'username' => $username,'password' => $password));
    $r->send();
    echo "<script>window.history.back();</script>";
}
if (preg_match("/^[1-9][0-9]*$/", $nid) !== 1) {
    echo "<script>window.history.back();</script>";
}
session_start();
$region = $_SESSION['region'];
$username = $_SESSION['username'];
$password = $_SESSION['password'];
$r = new Http_Request2('http://www.webserver' . rand(1, 2) . '.com/subscribe.php');
$r->setMethod(HTTP_Request2::METHOD_POST);
$r->addPostParameter(array('o' => 'subn', 'news_id' => $nid, 'region' => $region, 'username' => $username, 'password' => $password));
$r->send();
echo "<script>window.history.back();</script>";
?>

