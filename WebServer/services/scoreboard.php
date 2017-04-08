<?php
/*
Name: news.php
Description: Fetch Game Information From Database. (Using Post)
Input: o(peration)={all, team, game} ,region = {cn, us} , team_id, game_id
Output: XML File

<?xml version="1.0" encoding="UTF-8"?>
<result>
    <game>
        <game_id>$game_id</game_id>
        <team1_id>$t1id</team1_id>
        <team2_id>$t2id</team2_id>
        <team1_score>$t1s</team1_score>
        <team2_score>$t2s</team2_score>
        <date>$date</date>
        <time>$time</time>
        <location>$loc</location>
    </game>
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
$xmlall = '<game><game_id>%d</game_id><team1_id>%d</team1_id><team2_id>%d</team2_id><team1_score>%d</team1_score><team2_score>%d</team2_score><date>%s</date><time>%s</time><location>%s</location></game>';
$output = '';

/*
 * Fetch Input Data
 */

$team_id = $_POST['team_id'];
$operation = $_POST['o'];
$region = $_POST['region'];
$game_id = $_POST['game_id'];
//$team_id = $_GET['team_id'];
//$operation = $_GET['o'];
//$region = $_GET['region'];
//$game_id = $_GET['game_id'];

/*
    Input Data Processing & Get Connection Base on Region
*/
$operation = strtolower($operation);
$region = strtolower($region);
if(preg_match("/^(all)|(team)|(game)$/", $operation) !== 1){
    echo sprintf($xmlmessage, 'Wrong Operation');
    return;
}
if(preg_match("/^(cn)|(us)$/", $region) !== 1){
    echo sprintf($xmlmessage, 'Wrong Region');
    return;
}
if($operation==='team'&&preg_match("/^[1-9][0-9]*$/", $team_id) !== 1){
    echo sprintf($xmlmessage, 'Wrong Team ID');
    return;
}
if($operation==='game'&&preg_match("/^[1-9][0-9]*$/", $game_id) !== 1){
    echo sprintf($xmlmessage, 'Wrong Game ID');
    return;
}
$conn = Propel\Runtime\Propel::getConnection(strtolower(trim($region)).'_topspace');

/*
 * Fetching New From Database Based on Operation Request
 */
if($operation==="all"){
    $games = GameQuery::create()->find($conn);
    if($games->count()===0){
        echo sprintf($xmlmessage, 'Game Not Found');
        return;
    }
    foreach ($games as $game){
        $gid = $game->getGameId();
        $t1id = $game->getTeam1Id();
        $t2id = $game->getTeam2Id();
        $t1s = $game->getTeam1Score();
        $t2s = $game->getTeam2Score();
        $date = $game->getDate()->format('Y-m-d');
        $time = $game->getTime()->format('H:i:s');
        $loc = $game->getLocation();
        $output.=sprintf($xmlall,$gid,$t1id,$t2id,$t1s,$t2s,$date,$time,$loc);
    }
    echo sprintf($xml,$output);
    return;
}

if($operation === 'team'){
    $gameQuery = GameQuery::create();
    $gameQuery->addOr('team1_id',$team_id,'=');
    $gameQuery->addOr('team2_id',$team_id,'=');
    $games = $gameQuery->find($conn);
    if($games->count()===0){
        echo sprintf($xmlmessage, 'Game Not Found');
        return;
    }
    foreach ($games as $game){
        $gid = $game->getGameId();
        $t1id = $game->getTeam1Id();
        $t2id = $game->getTeam2Id();
        $t1s = $game->getTeam1Score();
        $t2s = $game->getTeam2Score();
        $date = $game->getDate()->format('Y-m-d');
        $time = $game->getTime()->format('H:i:s');
        $loc = $game->getLocation();
        $output.=sprintf($xmlall,$gid,$t1id,$t2id,$t1s,$t2s,$date,$time,$loc);
    }
    echo sprintf($xml,$output);
    return;
}

if($operation === 'game'){
    $games = GameQuery::create()->findBy('GameId',$game_id,$conn);
    if($games->count()===0){
        echo sprintf($xmlmessage, 'Game Not Found');
        return;
    }
    foreach ($games as $game){
        $gid = $game->getGameId();
        $t1id = $game->getTeam1Id();
        $t2id = $game->getTeam2Id();
        $t1s = $game->getTeam1Score();
        $t2s = $game->getTeam2Score();
        $date = $game->getDate()->format('Y-m-d');
        $time = $game->getTime()->format('H:i:s');
        $loc = $game->getLocation();
        $output.=sprintf($xmlall,$gid,$t1id,$t2id,$t1s,$t2s,$date,$time,$loc);
    }
    echo sprintf($xml,$output);
    return;
}


?>