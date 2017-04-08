<?php
/*
Name: postcomment.php
Description: Insert Comments Into Database (Using Post)
Input: region = {cn, us} , news_id, content, username, password
Output: XML File

<?xml version="1.0" encoding="UTF-8"?>
<result>
        <message>$validation</message>
</result>
*/
header('Access-Control-Allow-Origin:*');
require_once '../vendor/autoload.php';
require_once '../generated-conf/config.php';
$xml = '<?xml version="1.0" encoding="UTF-8"?><result><message>%s</message></result>';
$region = $_POST['region'];
$news_id = $_POST['news_id'];
$content = $_POST['content'];
$username = $_POST['username'];
$password = $_POST['password'];
//$region = $_GET['region'];
//$news_id = $_GET['news_id'];
//$content = $_GET['content'];
//$username = $_GET['username'];
//$password = $_GET['password'];

/*
 * Process Parameter and Validation & Get Connection Base on Region
 */
$news_id = strtolower($news_id);
$region = strtolower($region);
if(preg_match("/^[a-zA-Z][a-zA-Z0-9]*$/", $username) !== 1){
        echo sprintf($xml, 'Wrong Username');
        return;
}
if(preg_match("/^[a-zA-Z][a-zA-Z0-9]*$/", $password) !== 1){
        echo sprintf($xml, 'Wrong Password');
        return;
}
if(preg_match("/^(cn)|(us)$/", $region) !== 1){
        echo sprintf($xml, 'Wrong Region');
        return;
}
if(preg_match("/^[1-9][0-9]*$/", $news_id) !== 1){
        echo sprintf($xml, 'Wrong News');
        return;
}
if(preg_match("/^.+$/", $content) !== 1){
        echo sprintf($xml, 'Empty Content');
        return;
}
$conn = Propel\Runtime\Propel::getConnection(strtolower(trim($region)).'_topspace');

/*
 * Verify Login Information
 */
$user = UserQuery::create()->findByArray(array('Username'=>$username, 'Password'=>$password), $conn);
if($user->count() === 0){
    echo sprintf($xml,"Wrong Pair");
    return;
}

/*
 * Post Comments
 */
/*
 * Checking Existance of News
 */
$hasNews = NewsQuery::create()->findBy('NewsId', $news_id, $conn)->count() > 0;
if(!$hasNews){
    echo sprintf($xml,'News Not Found');
    return;
}
/*
 * Generate Comment ID For Comment 
 */
$comments = CommentQuery::create()->orderByCommentId()->findBy('NewsId', $news_id, $conn);
$isKeyAssigned = false;
$tempCID = 1;
while(!$isKeyAssigned){
    foreach ($comments as $comment){
        if($comment->getCommentId()===$tempCID){
            $tempCID++;
        }
        else {
            $isKeyAssigned = true;
            break;
        }
    }
}
/*
 * Create Comment and Save to DB
 */
$comment = new Comment();
$comment->setNewsId($news_id);
$comment->setCommentId($tempCID);
$comment->setContent($content);
$comment->setDate(date('Y-m-d H:i:s',  time()));
$comment->setUsername($username);
try{
    $comment->save($conn);
}catch(Exception $e){
    echo sprint($xmlmessage, 'Fail');
    return;
}
echo sprintf($xml,'Success');
return;
?>