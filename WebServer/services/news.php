<?php
/*
Name: news.php
Description: Fetch news Information From Database. (Using Post)
Input: o(peration)={all, title, id, byid, team, player} ,region = {cn, us} , news_id, team_id, player_id
Output: XML File

if o == all
    <?xml version="1.0" encoding="UTF-8"?>
    <result>
        <news>
            <news_id>$news_id</news_id>
            <title>$title</title>
            <content>$content</content>
            <date>$date</date>
        </news>
        .
        .
        .
    </result>
if o == title
    <?xml version="1.0" encoding="UTF-8"?>
    <result>
        <news>
            <news_id>$news_id</news_id>
            <title>$title</title>
            <date>$date</date>
        </news>
        .
        .
        .
    </result>
if o == id
    <?xml version="1.0" encoding="UTF-8"?>
    <result>
        <news>
            <news_id>$news_id</news_id>
        </news>
        .
        .
        .
    </result>
if o == byid
    <?xml version="1.0" encoding="UTF-8"?>
    <result>
        <news>
            <news_id>$news_id</news_id>
            <title>$title</title>
            <content>$content</content>
            <date>$date</date>
        </news>
    </result>
*/	
header('Access-Control-Allow-Origin:*');
require_once '../vendor/autoload.php';
require_once '../generated-conf/config.php';
$xmlmessage = '<?xml version="1.0" encoding="UTF-8"?><result><message>%s</message></result>';
$xml = '<?xml version="1.0" encoding="UTF-8"?><result>%s</result>';
$xmlall = '<news><news_id>%d</news_id><title>%s</title><content>%s</content><date>%s</date></news>';
$xmltitle = '<news><news_id>%d</news_id><title>%s</title><date>%s</date></news>';
$xmlid = '<news><news_id>%d</news_id></news>';
$output = '';

/*
 * Fetch Input Data
 */
$operation = $_POST['o'];
$region = $_POST['region'];
$news_id = $_POST['news_id'];
$team_id = $_POST['team_id'];
$player_id = $_POST['player_id'];
//$team_id = $_GET['team_id'];
//$player_id = $_GET['player_id'];
//$operation = $_GET['o'];
//$region = $_GET['region'];
//$news_id = $_GET['news_id'];

/*
    Input Data Processing & Get Connection Base on Region
*/
$operation = strtolower($operation);
$region = strtolower($region);
if(preg_match("/^(all)|(title)|(id)|(byid)|(team)|(player)$/", $operation) !== 1){
    echo sprintf($xmlmessage, 'Wrong Operation');
    return;
}
if(preg_match("/^(cn)|(us)$/", $region) !== 1){
    echo sprintf($xmlmessage, 'Wrong Region');
    return;
}
if($operation==='byid'&&preg_match("/^[1-9][0-9]*$/", $news_id) !== 1){
    echo sprintf($xmlmessage, 'Wrong News ID');
    return;
}
if($operation==='team'&&preg_match("/^[1-9][0-9]*$/", $team_id) !== 1){
    echo sprintf($xmlmessage, 'Wrong Team ID');
    return;
}
if($operation==='player'&&preg_match("/^[1-9][0-9]*$/", $player_id) !== 1){
    echo sprintf($xmlmessage, 'Wrong Player ID');
    return;
}
$conn = Propel\Runtime\Propel::getConnection(strtolower(trim($region)).'_topspace');

/*
 * Fetching New From Database Based on Operation Request
 */
if($operation==="all"){
    $news = NewsQuery::create()->find($conn);
    if($news->count()===0){
        echo sprintf($xmlmessage, 'News Not Found');
        return;
    }
    foreach ($news as $new){
        $id = $new->getNewsId();
        $title = $new->getTitle();
        $content = $new->getContent();
        $date = $new->getDate()->format('Y-m-d H:i:s');
        $output.=sprintf($xmlall, $id, $title, $content, $date);
    }
    echo sprintf($xml,$output);
    return;
}

if($operation==="title"){
    $news = NewsQuery::create()->find($conn);
    if($news->count()===0){
        echo sprintf($xmlmessage, 'News Not Found');
        return;
    }
    foreach ($news as $new){
        $id = $new->getNewsId();
        $title = $new->getTitle();
        $date = $new->getDate()->format('Y-m-d H:i:s');
        $output.=sprintf($xmltitle, $id,$title,$date);
    }
    echo sprintf($xml,$output);
    return;
}
if($operation==="id"){
    $news = NewsQuery::create()->find($conn);
    if($news->count()===0){
        echo sprintf($xmlmessage, 'News Not Found');
        return;
    }
    foreach ($news as $new){
        $id = $new->getNewsId();
        $output.=sprintf($xmlid, $id);
    }
    echo sprintf($xml,$output);
    return;
}
if ($operation==="byid") {
    $news = NewsQuery::create()->findBy("NewsId",$news_id,$conn);
    if($news->count()===0){
        echo sprintf($xmlmessage, 'News Not Found');
        return;
    }
    if($news!==NULL){
        $id = $news->getFirst()->getNewsId();
        $title = $news->getFirst()->getTitle();
        $content = $news->getFirst()->getContent();
        $date = $news->getFirst()->getDate()->format('Y-m-d H:i:s');
        $output.=sprintf($xmlall, $id, $title, $content, $date);
        echo sprintf($xml,$output);
        return;
    }else{
        echo sprintf($xmlmessage,"News Not Found");
        return;
    }
}
if($operation === 'team'){
    $tins = TeamInNewsQuery::create()->filterBy('TeamId', $team_id)->orderBy('NewsId')->find($conn);
    if($tins->count()===0){
        echo sprintf($xmlmessage, 'News Not Found');
        return;
    }
    $NewsQuery = NewsQuery::create();
    foreach($tins as $tin){
        $NewsQuery->addOr('news_id', $tin->getNewsId(), '=');
    }
    $news = $NewsQuery->find($conn);
    if($news->count()===0){
        echo sprintf($xmlmessage, 'News Not Found');
        return;
    }
    foreach ($news as $new){
        $id = $new->getNewsId();
        $title = $new->getTitle();
        $content = $new->getContent();
        $date = $new->getDate()->format('Y-m-d H:i:s');
        $output.=sprintf($xmlall, $id, $title, $content, $date);
    }
    echo sprintf($xml,$output);
    return;
}

if($operation === 'player'){
    $pins = PlayerInNewsQuery::create()->filterBy('PlayerId', $player_id)->orderBy('NewsId')->find($conn);
    if($pins->count()===0){
        echo sprintf($xmlmessage, 'News Not Found');
        return;
    }
    $NewsQuery = NewsQuery::create();
    foreach($pins as $pin){
        $NewsQuery->addOr('news_id', $pin->getNewsId(), '=');
    }
    $news = $NewsQuery->find($conn);
    if($news->count()===0){
        echo sprintf($xmlmessage, 'News Not Found');
        return;
    }
    foreach ($news as $new){
        $id = $new->getNewsId();
        $title = $new->getTitle();
        $content = $new->getContent();
        $date = $new->getDate()->format('Y-m-d H:i:s');
        $output.=sprintf($xmlall, $id, $title, $content, $date);
    }
    echo sprintf($xml,$output);
    return;
}

?>