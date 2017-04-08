<?php
    header('Access-Control-Allow-Origin:*');
    require_once 'HTTP/Request2.php';
    $username = $_POST['username'];
    $password = $_POST['password'];
    $region = $_POST['region'];
//    $username = $_GET['username'];
//    $password = $_GET['password'];
//    $region = $_GET['region'];
    
    $r = new Http_Request2('http://www.webserver'.rand(1,2).'.com/login.php');
    $r -> setMethod(HTTP_Request2::METHOD_POST);
    $r -> addPostParameter(array('username'=>$username,'password'=>$password,'region'=>$region));
    try{
        $body = $r->send()->getBody();
        $xml = simplexml_load_string($body);
    } catch (Exception $ex) {
        echo $ex -> getMessage();
    }
    $message = (string)$xml->message[0];
    if($message==="Verified"){
        session_start();
        $_SESSION['status'] = 'online';
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['region'] = $region;
        echo "okay";
        return;
    }else{
        echo "fail";
        return;
    }
?>

