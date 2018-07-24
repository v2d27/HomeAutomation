<?php
    $servername = "localhost";
    $username = "id149650_dbuser";
    $password = "myhomedatabase";
    $database = "id149650_dbhome";
    $connection = mysqli_connect($servername, $username, $password, $database);
    if (!$connection) {
        echo "Unable to connect to DB: " . mysqli_error();
        exit;
    }

    /*
     * STT    role_id     on_time    off_time     active
     */

    if (!isset($_GET['esp8266'])) {
        echo "<h1>404 Not found!</h1><br><h2>Request no device.</h2>";
        exit;
    }

    $esp8266 = $_GET['esp8266'];
    if ($esp8266 == "1" || $esp8266 == "2") { 
        //trong nha
    }
    else
    {
        echo "<h1>404 Not found!</h1><br><h2>Can not find esp8266 device available!</h2>";
        exit;
    }

    $role_id = $_GET["role_id"];
    if ($esp8266 == "2") {
        $role_id += 20;
    }
    $on_time = $_GET['ontime'];
    $off_time = $_GET['offtime'];
    $status = $_GET['status'];


    //
    //add_items_proc: /server/alarm_update.php?esp8266=1&role_id=5&ontime=18:00&offtime=05:20&status=inactive
    //

    $checking_exist_state = 0;
    $sql = "SELECT role_id FROM alarm WHERE 1";
    if($result = mysqli_query($connection, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['role_id'] == $role_id) {
                $checking_exist_state = 1;
            }
        }
        mysqli_free_result($result);
    }
    else
    {
        echo "Can not query database. Error code:" . mysqli_error();
        exit;
    }

    if ($checking_exist_state) {
        $sql = "UPDATE alarm SET on_time='$on_time:00', off_time='$off_time:00', active=$status WHERE role_id=$role_id";
    }
    else
    {
        $sql = "INSERT INTO alarm (role_id, on_time, off_time, active) VALUES ($role_id, '$on_time:00', '$off_time:00', $status)";
    }
    //echo "checking_exist_state = ". $checking_exist_state;

    $result = mysqli_query($connection, $sql);
    if ($result) {
        if ($checking_exist_state) {
            echo "2";
        }
        else
        {
            echo "1";
        }
    }
    else
    {
        echo "<br>$sql";
        echo "<br>-> failed";
    }

    //close connection to database
    mysqli_close($connection);

?>