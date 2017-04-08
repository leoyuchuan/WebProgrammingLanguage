<?php
require_once './checklogin.php';
$comment = $_POST['comment'];
$news_id = $_POST['nid'];
require_once 'HTTP/Request2.php';
if (preg_match("/^[1-9][0-9]*$/", $news_id) === 1) {
    session_start();
    $region = $_SESSION['region'];
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    $r = new Http_Request2('http://www.webserver' . rand(1, 2) . '.com/postcomment.php');
    $r->setMethod(HTTP_Request2::METHOD_POST);
    $r->addPostParameter(array('news_id' => $news_id, 'region' => $region,'username' => $username,'password' => $password, 'content'=>$comment));
    try{
        $body = $r->send()->getBody();
        $xml = simplexml_load_string($body);
    } catch (Exception $ex) {
        echo $ex -> getMessage();
    }
    $message = (string)$xml->message[0];
    echo $message;
    
}
?>

