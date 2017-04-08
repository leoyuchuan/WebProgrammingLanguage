<?php
session_start();
    $status = $_SESSION['status'];
    if($status !== 'online'){
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
                        require_once 'HTTP/Request2.php';
                        session_start();
                        $region = $_SESSION['region'];
                        $username = $_SESSION['username'];
                        $password = $_SESSION['password'];
                        $memcached = new Memcached();
                        $memcached->addServer('localhost', 11211);
                        $key = "subshortuser".$username."pass".$password.$region;
                        $body = $memcached->get($key);
                        if ($body) {
                            $xml = simplexml_load_string($body);
                        } else {
                            $r = new Http_Request2('http://www.webserver' . rand(1, 2) . '.com/subscribe.php');
                            $r->setMethod(HTTP_Request2::METHOD_POST);
                            $r->setHeader("Accept-Encoding:gzip,deflat");
                            $r->addPostParameter(array('o' => 'gets', 'username' => $username, 'password' => $password, 'region' => $region));
                            try {
                                $body = $r->send()->getBody();
                                $memcached->set($key, $body, 10);
                                $xml = simplexml_load_string($body);
                            } catch (Exception $ex) {
                                echo $ex->getMessage();
                            }
                        }
                        if ($xml->news->count() === 0) {
                            echo "No Subscription!";
                        }
                        echo "<table class='table'><caption><span class='label label-info'>Sub List</span></caption> 
                                  <thead><tr><th>ID</th><th>Title</th><th>Date</th></tr><thead><tbody>
                                  ";
                        foreach ($xml->news as $new) {
                            $id = $new->news_id;
                            $date = $new->date;
                            $title = $new->title;
//                            echo "<div><span>$id</span><span>$title</span><span>$date</span></div>";
                            // echo "<a href='news.php?nid=$id'>id:$id | title:$title | date:$date </a>";
                            // echo "<br/>";


                            echo "<tr><td>$id</td><td><a href='news.php?nid=$id'>$title</a></td><td>$date</td></tr>";

                        }
                            echo "</tbody><br/></table>";
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
