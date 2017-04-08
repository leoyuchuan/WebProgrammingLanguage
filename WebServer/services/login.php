<?php

/*
  Name: login.php
  Description: Input User Information & Return validation information. (Using Post)
  Input: username, password, region = {cn, us} | o =fb, token
  Output: $validation = {verified, error_message}
  As following format

  <?xml version="1.0" encoding="UTF-8"?>
  <result>
  <message>$validation</message>
  </result>
 */
header('Access-Control-Allow-Origin:*');
require_once '../vendor/autoload.php';
require_once '../generated-conf/config.php';
$xml = '<?xml version="1.0" encoding="UTF-8"?><result><message>%s</message></result>';

/*
 * Fetch Input Data
 */
$username = $_POST['username'];
$password = $_POST['password'];
$region = $_POST['region'];
$token = $_POST['token'];
$operation = $_POST['o'];
//$token = $_GET['token'];
//$operation=$_GET['o'];
//$username = $_GET['username'];
//$password = $_GET['password'];
//$region = $_GET['region'];

/*
 *  Process Input Data & Get Connection Base on Region
 */
$region = strtolower($region);
if (preg_match("/^(cn)|(us)$/", $region) !== 1) {
    echo sprintf($xml, 'Wrong Region');
    return;
}
$conn = Propel\Runtime\Propel::getConnection(strtolower(trim($region)) . '_topspace');
if (trim($operation) === "fb") {
    $users = UserQuery::create()->findByArray(array('Token' => $token), $conn);
    if ($users->count() > 0) {
        $u = $users->getFirst();
        echo sprintf('<?xml version="1.0" encoding="UTF-8"?><result><username>%s</username><password>%s</password></result>', $u->getUsername(), $u->getPassword());
        return;
    } else {
        echo sprintf($xml, "NonExist");
        return;
    }
}


if (preg_match("/^[a-zA-Z][a-zA-Z0-9]*$/", $username) !== 1) {
    echo sprintf($xml, 'Wrong Username');
    return;
}
if (preg_match("/^[a-zA-Z][a-zA-Z0-9]*$/", $password) !== 1) {
    echo sprintf($xml, 'Wrong Password');
    return;
}


/*
 * Login Processing
 */
$user = UserQuery::create()->findByArray(array('Username' => $username, 'Password' => $password), $conn);
if ($user->count() > 0) {
    echo sprintf($xml, 'Verified');
    return;
} else {
    echo sprintf($xml, "Wrong Pair");
    return;
}
?>