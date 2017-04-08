<?php

header('Access-Control-Allow-Origin:*');
require_once 'HTTP/Request2.php';
$token = $_POST['token'];
$r = new Http_Request2('http://www.webserver' . rand(1, 2) . '.com/login.php');
$r->setMethod(HTTP_Request2::METHOD_POST);
$r->addPostParameter(array('o' => 'fb', 'token' => $token, 'region' => 'us'));
try {
    $body = $r->send()->getBody();
    if (preg_match("/^.*<message>.*$/", $body) > 0) {
        ;
    }else{
        $xml = simplexml_load_string($body);
        session_start();
        $_SESSION['status'] = 'online';
        $_SESSION['username'] = (string)$xml->username;
        $_SESSION['password'] = (string)$xml->password;
        $_SESSION['region'] = 'us';
        echo "okay";
        return;
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}

$r = new Http_Request2('http://www.webserver' . rand(1, 2) . '.com/login.php');
$r->setMethod(HTTP_Request2::METHOD_POST);
$r->addPostParameter(array('o' => 'fb', 'token' => $token, 'region' => 'cn'));
try {
    $body = $r->send()->getBody();
    if (preg_match("/^.*<message>.*$/", $body) > 0) {
        echo 'fail';
        return;
    }else{
        $xml = simplexml_load_string($body);
        session_start();
        $_SESSION['status'] = 'online';
        $_SESSION['username'] = $xml->username;
        $_SESSION['password'] = $xml->password;
        $_SESSION['region'] = 'cn';
        echo "okay";
        return;
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}
?>