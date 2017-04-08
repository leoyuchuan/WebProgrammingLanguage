<?php
session_start();
$status = $_SESSION['status'];
if ($status !== 'online') {
    echo '<script>window.location = "login.php"</script>';
    return;
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>TopSpaceHL:Home</title>

        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <style>
            body {
                padding-top: 70px;
                /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
            }
        </style>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="home.php">News</a>
                        </li>
                        <li>
                            <a href="scoreboard.php">Scoreboard</a>
                        </li>
                        <li>
                            <a href="subscribe.php">Subscribe Control</a>
                        </li>
                        <li>
                            <a href="team.php">Team</a>
                        </li>
                        <li>
                            <a href="./phpscript/logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>

        <!-- Page Content -->
        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    <?php
                        $tid = $_GET['tid'];
                        require_once 'HTTP/Request2.php';
                        if ($tid === null || $tid === "") {
                            session_start();
                            $region = $_SESSION['region'];

                            $memcached = new Memcached();
                            $memcached->addServer('localhost', 11211);
                            $key = "teamall" . $region;
                            $body = $memcached->get($key);
                            if ($body) {
                                $xml = simplexml_load_string($body);
                            } else {
                                $r = new Http_Request2('http://www.webserver' . rand(1, 2) . '.com/team.php');
                                $r->setMethod(HTTP_Request2::METHOD_POST);
                                $r->setHeader("Accept-Encoding:gzip,deflat");
                                $r->addPostParameter(array('o' => 'all', 'region' => $region));
                                try {
                                    $body = $r->send()->getBody();
                                    $memcached->set($key, $body, 10);
                                    $xml = simplexml_load_string($body);
                                } catch (Exception $ex) {
                                    echo $ex->getMessage();
                                }
                            }
                            echo "<table class='table'><caption><span class='label label-warning'>Sub Options</span></caption> 
                                  <thead><tr><th>Team</th><th>Sub</th><th>Unsub</th></tr><thead><tbody>
                                  ";
                            foreach ($xml->team as $team) {
                                $tid = $team->team_id;
                                $name = $team->name;
                                // echo "<a href='team.php?tid=$tid'>$name</a>";
                                // echo "  <a href='./phpscript/subprocess.php?tid=$tid'>subscribe</a>  ";
                                // echo "<a href='./phpscript/unsubyid.php?tid=$tid'>unsubscribe</a>";
                                // echo "<br/>";


        
                                echo "<tr><td><a href='team.php?tid=$tid'>$name</a></td>
                                  <td><a href='./phpscript/subprocess.php?tid=$tid'>Sub</a></td>
                                  <td><a href='./phpscript/unsubyid.php?tid=$tid'>Unsub</a></td></tr>";
                                
                            }
                            echo "</tbody><br/></table>";
                        } else {
                            session_start();
                            $region = $_SESSION['region'];

                            $memcached = new Memcached();
                            $memcached->addServer('localhost', 11211);
                            $key = "teamid" . $tid . $region;
                            $body = $memcached->get($key);
                            if ($body) {
                                $xml = simplexml_load_string($body);
                            } else {
                                $r = new Http_Request2('http://www.webserver' . rand(1, 2) . '.com/team.php');
                                $r->setMethod(HTTP_Request2::METHOD_POST);
                                $r->setHeader("Accept-Encoding:gzip,deflat");
                                $r->addPostParameter(array('o' => 'byid', 'team_id' => $tid, 'region' => $region));
                                try {
                                    $body = $r->send()->getBody();
                                    $memcached->set($key, $body, 10);
                                    $xml = simplexml_load_string($body);
                                } catch (Exception $ex) {
                                    echo $ex->getMessage();
                                }
                            }
                            echo "<table class='table'><caption><span class='label label-danger'>Sub Options</span></caption> 
                                  <thead><tr><th>Team</th><th>Sub</th><th>Unsub</th></tr><thead><tbody>
                                  ";
                            foreach ($xml->team as $team) {
                                $name = $team->name;
                                echo "<tr><td><a href='team.php?tid=$tid'>$name</a></td>
                                  <td><a href='./phpscript/subprocess.php?tid=$tid'>Sub</a></td>
                                  <td><a href='./phpscript/unsubyid.php?tid=$tid'>Unsub</a></td></tr>";
                            }
                                echo "</tbody><br/></table>";
                            $r = new Http_Request2('http://www.webserver' . rand(1, 2) . '.com/team.php');
                            $r->setMethod(HTTP_Request2::METHOD_POST);
                            $r->setHeader("Accept-Encoding:gzip,deflat");
                            $r->addPostParameter(array('o' => 'member', 'team_id' => $tid, 'region' => $region));
                            $memcached = new Memcached();
                            $memcached->addServer('localhost', 11211);
                            $key = "memberteamid" . $tid . $region;
                            $body = $memcached->get($key);
                            if ($body) {
                                $xml = simplexml_load_string($body);
                            } else {
                                try {
                                    $body = $r->send()->getBody();
                                    $memcached->set($key, $body, 10);
                                    $xml = simplexml_load_string($body);
                                } catch (Exception $ex) {
                                    echo $ex->getMessage();
                                }
                            }
                            echo "<table class='table'><caption><span class='label label-danger'>Members</span></caption> 
                                  <thead><tr><th>First Name</th><th>Last Name</th></tr><thead><tbody>
                                  ";
                            foreach ($xml->member as $member) {
                                $fn = $member->first_name;
                                $ln = $member->last_name;
                                // echo "$fn $ln<br/>";
                                echo "<tr><td>$fn</td><td>$ln</td></tr>";
                            }
                            echo "</tbody><br/></table>";
                        }
                        ?>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container -->

        <!-- jQuery Version 1.11.1 -->
        <script src="js/jquery.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>

    </body>

</html>
