<?php
/*
Name: viewcomment.php
Description: Fetch comments From Database By news_id. (Using Post)
Input: region = {cn, us} , news_id
Output: XML File

<?xml version="1.0" encoding="UTF-8"?>
<result>
    <comment>
        <news_id>$news_id</news_id>
        <comment_id>$title</comment_id>
        <content>$content</content>
        <date>$date</date>
        <username>$username</username>
    </comment>
    .
    .
    .
</result>
*/
header('Access-Control-Allow-Origin:*');
require_once '../vendor/autoload.php';
require_once '../generated-conf/config.php';
$xmlmessage = '<?xml version="1.0" encoding="UTF-8"?><result><message>%s</message></result>';
$xml = '<?xml version="1.0" encoding="UTF-8"?><result>%s</result>';
$xmlcomment = '<comment><news_id>%d</news_id><comment_id>%d</comment_id><content>%s</content><date>%s</date><username>%s</username></comment>';
$output = '';

/*
 * Fetch Input Data
 */
$region = $_POST['region'];
$news_id = $_POST['news_id'];
//$region = $_GET['region'];
//$news_id = $_GET['news_id'];

/*
 * Process Parameter and Validation & Get Connection Base on Region
*/
$news_id = strtolower($news_id);
$region = strtolower($region);
if(preg_match("/^(cn)|(us)$/", $region) !== 1){
        echo sprintf($xmlmessage, 'Wrong Region');
        return;
}
if(preg_match("/^[1-9][0-9]*$/", $news_id) !== 1){
        echo sprintf($xmlmessage, 'Wrong News');
        return;
}
$conn = Propel\Runtime\Propel::getConnection(strtolower(trim($region)).'_topspace');
/*
 * Fetch Comments From Database
 */
/*
 * Verify News Existance
 */
$hasNews = NewsQuery::create()->findBy('NewsId', $news_id, $conn)->count() > 0;
if(!$hasNews){
    echo sprintf($xmlmessage,'News Not Found');
    return;
}
/*
 * Fetch Comments
 */
$comments = CommentQuery::create()->findBy('NewsId', intval($news_id), $conn);
if($comments->count() === 0){
    echo sprintf($xmlmessage, 'No Comment Found');
    return;
}
foreach ($comments as $comment){
    $id = $comment->getNewsId();
    $com_id = $comment->getCommentId();
    $content = $comment->getContent();
    $date = $comment->getDate()->format('Y-m-d H:i:s');
    $username = $comment->getUsername();
    $output.=sprintf($xmlcomment,$id,$com_id,$content,$date,$username);
}
echo sprintf($xml,$output);
return;
?>