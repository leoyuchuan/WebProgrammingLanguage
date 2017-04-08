<?php
/*
Name: team.php
Description: Fetch team Information From Database. (Using Post)
Input: o(peration)={all, byid, member} ,region = {cn, us} , team_id
Output: XML File

if o == all
    <?xml version="1.0" encoding="UTF-8"?>
    <result>
        <team>
            <team_id>$news_id</team_id>
            <name>$title</name>
        </team>
        .
        .
        .
    </result>
if o == byid
    <?xml version="1.0" encoding="UTF-8"?>
    <result>
        <team>
            <team_id>$news_id</team_id>
            <name>$title</name>
        </team>
    </result>
if o == member
    <?xml version="1.0" encoding="UTF-8"?>
    <result>
        <member>
            <player_id>$pid</player_id>
            <first_name>$fn</first_name>
            <last_name>$ln</last_name>
            <gender>$gender</gender>
            <weight>$weight</weight>
            <height>$height</height>
            <born_date>$bd</born_date>
            <born_place>$bp</born_place>
            <college>$college</college>
            <team_id>$tid</team_id>
        </member>
    </result>
*/	
header('Access-Control-Allow-Origin:*');
require_once '../vendor/autoload.php';
require_once '../generated-conf/config.php';
$xmlmessage = '<?xml version="1.0" encoding="UTF-8"?><result><message>%s</message></result>';
$xml = '<?xml version="1.0" encoding="UTF-8"?><result>%s</result>';
$xmlall = '<team><team_id>%d</team_id><name>%s</name></team>';
$xmlmember = '<member><player_id>%d</player_id><first_name>%s</first_name><last_name>%s</last_name><gender>%s</gender><weight>%d</weight><height>%d</height><born_date>%s</born_date><born_place>%s</born_place><college>%s</college><team_id>%d</team_id></member>';
$output = '';

/*
 * Fetch Input Data
 */
$operation = $_POST['o'];
$region = $_POST['region'];
$team_id = $_POST['team_id'];
//$operation = $_GET['o'];
//$region = $_GET['region'];
//$team_id = $_GET['team_id'];

/*
 * Input Data Processing & Get Connection Base on Region
 */
$operation = trim(strtolower($operation));
$region = trim(strtolower($region));
if(preg_match("/^(all)|(byid)|(member)$/", $operation) !== 1){
    echo sprintf($xmlmessage, 'Wrong Operation');
    return;
}
if(preg_match("/^(cn)|(us)$/", $region) !== 1){
    echo sprintf($xmlmessage, 'Wrong Region');
    return;
}
if($operation==='byid'&&preg_match("/^[1-9][0-9]*$/", $team_id)!==1){
    echo sprintf($xmlmessage, 'Wrong Team ID');
    return;
}
if($operation==='member'&&preg_match("/^[1-9][0-9]*$/", $team_id)!==1){
    echo sprintf($xmlmessage, 'Wrong Team ID');
    return;
}
$conn = Propel\Runtime\Propel::getConnection(strtolower(trim($region)).'_topspace');
/*
 * Fetching New From Database Based on Operation Request
 */
if($operation==='all'){
    $teams = TeamQuery::create()->find($conn);
    if($teams->count()===0){
        echo sprintf($xmlmessage, 'Team Not Found');
        return;
    }
    foreach($teams as $team){
        $id = $team->getTeamId();
        $name = $team->getName();
        $output.=sprintf($xmlall, $id, $name);
    }
    echo sprintf($xml,$output);
    return;
}
if($operation==='byid'){
    $teams = TeamQuery::create()->findBy('TeamId', $team_id, $conn);
    if($teams->count()===0){
        echo sprintf($xmlmessage, 'Team Not Found');
        return;
    }
    $team = $teams->getFirst();
    $id = $team->getTeamId();
    $name = $team->getName();
    $output.=sprintf($xmlall, $id, $name);
    echo sprintf($xml,$output);
    return;
}
if($operation=='member'){
    $members = RoasterQuery::create()->filterBy('TeamId', $team_id)->find($conn);
    if($members->count()===0){
        echo sprintf($xmlmessage, 'Member Not Found');
        return;
    }
    foreach ($members as $member){
        $pid = $member->getPlayerId();
        $fn = $member->getFirstName();
        $ln = $member->getLastName();
        $gender = $member->getGender();
        $weight = $member->getWeight();
        $height = $member->getHeight();
        $bd = $member->getBornDate();
        $bp = $member->getBornPlace();
        $college = $member->getCollege();
        $tid = $member->getTeamId();
        $output.=sprintf($xmlmember,$pid,$fn,$ln,$gender,$weight,$height,$bd,$bp,$college,$tid);
    }
    echo sprintf($xml,$output);
    return;
}
?>