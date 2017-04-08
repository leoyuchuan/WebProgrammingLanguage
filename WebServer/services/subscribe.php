<?php
/*
Name: subscribe.php
Description: Subscribe By Team Or By News; Get News By User Subscription; Unsubscribe By team_id or all. (Using Post)
Input: o(peration)={get, gets, subt, subn, un, unall} ,region = {cn, us} , news_id, team_id, username, password  //gets = get short version, subt = sub by team, subn = sub by news
Output: XML File

For subt(n), un, unall:
    <?xml version="1.0" encoding="UTF-8"?>
    <result>
        <message>$message</message>
    </result>
For get:
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
For gets:
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
*/	
header('Access-Control-Allow-Origin:*');
require_once '../vendor/autoload.php';
require_once '../generated-conf/config.php';
$xmlmessage = '<?xml version="1.0" encoding="UTF-8"?><result><message>%s</message></result>';
$xml = '<?xml version="1.0" encoding="UTF-8"?><result>%s</result>';
$xmlall = '<news><news_id>%d</news_id><title>%s</title><content>%s</content><date>%s</date></news>';
$xmlshort = '<news><news_id>%d</news_id><title>%s</title><date>%s</date></news>';
$output = '';

/*
 * Fetch Input Data
 */
$operation = $_POST['o'];
$region = $_POST['region'];
$username = $_POST['username'];
$password = $_POST['password'];
$team_id = $_POST['team_id'];
$news_id = $_POST['news_id'];
//$team_id = $_GET['team_id'];
//$news_id = $_GET['news_id'];
//$operation = $_GET['o'];
//$region = $_GET['region'];
//$username = $_GET['username'];
//$password = $_GET['password'];

/*
 * Process Input Data & Get Connection Base on Region
 */
$operation = strtolower($operation);
$region = strtolower($region);
if(preg_match("/^(subt)|(subn)|(un)|(unall)|(get)|(gets)$/", $operation) !== 1){
        echo sprintf($xmlmessage, 'wrong operation');
        return;
}
if(preg_match("/^(cn)|(us)$/", $region) !== 1){
        echo sprintf($xmlmessage, 'wrong region');
        return;
}
if(preg_match("/^[a-zA-Z][a-zA-Z0-9]*$/", $username) !== 1){
        echo sprintf($xml, 'wrong username');
        return;
}
if(preg_match("/^[a-zA-Z][a-zA-Z0-9]*$/", $password) !== 1){
        echo sprintf($xml, 'wrong password');
        return;
}
if($operation==='subt'&&preg_match("/^[1-9][0-9]*$/", $team_id)!==1){
    echo sprintf($xmlmessage, 'wrong team id');
    return;
}
if($operation==='un'&&preg_match("/^[1-9][0-9]*$/", $team_id)!==1){
    echo sprintf($xmlmessage, 'wrong team id');
    return;
}
if($operation==='subn'&&preg_match("/^[1-9][0-9]*$/", $news_id)!==1){
    echo sprintf($xmlmessage, 'wrong team id');
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
 * SubScribe By Team_id
 */
if($operation === 'subt'){
    $teams = TeamQuery::create()->findBy('TeamId', $team_id, $conn);
    if($teams->count()===0){
        echo sprintf($xmlmessage, 'Team Not Found');
        return;
    }
    $subs = new Subscribe();
    $subs->setUsername($username);
    $subs->setTeamId($team_id);
    try{
        $subs->save($conn);
    }catch(Exception $e){
        echo sprintf($xmlmessage, 'Fail');
        return;
    }
    echo sprintf($xmlmessage,'Success');
    return;
}

/* 
 * Subscribe By News_id
 */
if($operation === 'subn'){
    $tins = TeamInNewsQuery::create()->findBy('NewsId', $news_id, $conn);
    if($tins->count()===0){
        echo sprintf($xmlmessage, 'Nothing Subscribe');
        return;
    }
    foreach ($tins as $tin) {
        $subs = new Subscribe();
        $subs->setUsername($username);
        $subs->setTeamId($tin->getTeamId());
        try{
            $subs->save($conn);
        }catch(Exception $e){
        }
    }
    echo sprintf($xmlmessage, 'Success');
    return;
}

if($operation === 'un'){
    try{
        SubscribeQuery::create()->filterByArray(array('Username'=>$username,'TeamId'=>$team_id))
                ->delete($conn);
        echo sprintf($xmlmessage, 'Success');
        return;
    }catch(Exception $e){
        echo sprintf($xmlmessage, 'Fail');
        return;
    }
}
if($operation === 'unall'){
    try{
        SubscribeQuery::create()->filterByArray(array('Username'=>$username))
                ->delete($conn);
        echo sprintf($xmlmessage, 'success');
        return;
    }catch(Exception $e){
        echo sprintf($xmlmessage, 'Fail');
        return;
    }
}

if($operation === 'get'){
    $subs = SubscribeQuery::create()->findBy('Username', $username, $conn);
    if($subs->count()===0){
        echo sprintf($xmlmessage,'No Subscription Found');
        return;
    }
    $TINObj = TeamInNewsQuery::create();
    foreach($subs as $sub){
        $TINObj->addOr('team_id', $sub->getTeamId(), '=');
    }
    $tins = $TINObj->find($conn);
    if($tins->count()===0){
        echo sprintf($xmlmessage,'No News Found');
        return;
    }
    $NEWSObj = NewsQuery::create();
    foreach($tins as $tin){
        $NEWSObj->addOr('news_id',$tin->getNewsId(),'=');
    }
    $news = $NEWSObj->find($conn);
    if($news->count()===0){
        echo sprintf($xmlmessage,'No News Found');
        return;
    }
    foreach($news as $new){
        $id = $new->getNewsId();
        $title = $new->getTitle();
        $content = $new->getContent();
        $date = $new->getDate()->format('Y-m-d H:i:s');
        $output.=sprintf($xmlall, $id, $title, $content, $date);
    }
    echo sprintf($xml, $output);
    return;
}

if($operation === 'gets'){
    $subs = SubscribeQuery::create()->findBy('Username', $username, $conn);
    if($subs->count()===0){
        echo sprintf($xmlmessage,'No Subscription Found');
        return;
    }
    $TINObj = TeamInNewsQuery::create();
    foreach($subs as $sub){
        $TINObj->addOr('team_id', $sub->getTeamId(), '=');
    }
    $tins = $TINObj->find($conn);
    if($tins->count()===0){
        echo sprintf($xmlmessage,'No News Found');
        return;
    }
    $NEWSObj = NewsQuery::create();
    foreach($tins as $tin){
        $NEWSObj->addOr('news_id',$tin->getNewsId(),'=');
    }
    $news = $NEWSObj->find($conn);
    if($news->count()===0){
        echo sprintf($xmlmessage,'No News Found');
        return;
    }
    foreach($news as $new){
        $id = $new->getNewsId();
        $title = $new->getTitle();
        $date = $new->getDate()->format('Y-m-d H:i:s');
        $output.=sprintf($xmlshort, $id, $title, $date);
    }
    echo sprintf($xml, $output);
    return;
}

?>