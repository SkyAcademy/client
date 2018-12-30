<?php


    // *************************
    // *  CHANGE THESE VALUES  *
    // *************************
    
    $ip   = "127.0.0.1"; //MySQL Server IP
    $user = "root"; //MySQL user
    $pw   = "password"; //MySQL password
    $db   = "iConomy"; //Database

    $show_updates = 'true'; //Do you want to recive a message if a new update is available ? It's not recommended to disable this!

    // ************************************************************
    // *  DO NOT CHANGE ANYTHING IF YOU DO NOT KNOW WHAT YOU DO   *
    // ************************************************************

    echo "<html>";
    echo "<head>";
    echo "<link rel='stylesheet' type='text/css' href='style.css'>";
    echo "<title>iConomy - Money</title>";
    echo "</head>";
    echo "</body>";

    $con = mysqli_connect($ip, $user, $pw, $db);
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    echo "<div style=\"margin: 1% 2%;\">";
    if($show_updates == 'true') {
        echo file_get_contents('http://zombieland.eu/api/iConomy/update-1.3.php');    
    }
    echo "<div style=\"margin: 1% 2%;\">";
	echo "<p>Example search: 123_felix_321</p>";
    echo "<div class=\"suchfunktion\">";
    echo "<form action=\"\" method=\"POST\">";
    echo "<input type=\"text\" name=\"search\" placeholder=\"Enter playername ...\" > ";

    echo "<button type=\"submit\" class=\"ui blue button\">Search</button> ";

    if (isset($_POST['search']) AND !empty($_POST['search'])) {
        echo "<button type=\"submit\" class=\"ui blue button\">Back</button> ";
    }
    echo "</form>";
    echo "</div>";

    if (isset($_POST['search'])) {
        $search     = mysqli_escape_string($con, $_POST['search']);
        $page_query = mysqli_query($con, "SELECT * FROM `iConomy` WHERE `username` like '%$search%' ORDER BY `balance` DESC LIMIT 50");
        $page_nums  = mysqli_num_rows($page_query);
        if ($page_nums < 1) {
            echo "Player not found";
        }
    } else {
        $page_query = mysqli_query($con, "SELECT * FROM `iConomy` ORDER BY `balance` DESC LIMIT 0,50");
    }
    $page_nums = mysqli_num_rows($page_query);


    if ($page_nums >= 1) {
   
    
        echo "<table class=\"ui celled striped table\">";
        echo "<tr>";
        echo "    <td class='tbl tbr'><b>Username</b></td>";
        echo "    <td class='tbr tbt'><b>Balance</b></td>";
        echo "</tr>";
        
        while ($obj = mysqli_fetch_object($page_query)) {
            echo "<tr>";
            echo "<td class='tbr'>" . $obj->username . " </td>";
            echo "<td class='tbr'>" . $obj->balance . "</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
    echo "</div>";
    echo "</body>";
    echo "</html>";

?>

