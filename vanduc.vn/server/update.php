<?php
    $servername = "localhost";
    $username = "id149650_dbuser";
    $password = "myhomedatabase";
    $database = "id149650_dbhome";

    $connection = mysqli_connect($servername, $username, $password, $database);

    if (!isset($_GET['esp8266'])) {
        echo "<h1>404 Not found!</h1><br><h2>Request no device.</h2>";
        exit;
    }

    $esp8266 = $_GET['esp8266'];
    if ($esp8266 == "1") { //trong nha
        $esp8266 = "2";
    }
    else if ($esp8266 == "12") { // ngoai quan
        $esp8266 = "1";
    }
    else
    {
        echo "<h1>404 Not found!</h1><br><h2>Can not find esp8266 device available!</h2>";
        exit;
    }

    $sql = "SELECT * FROM role WHERE STT = $esp8266";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);    // Update entry_id
    $NUM = $row['NUM'];

    $update_role_sql = "";
    if (isset($_GET['role1'])) {
        $update_role_sql .= "role1 = " . $_GET['role1'] . ",";
        $NUM += 1;
    }
    if (isset($_GET['role2'])) {
        $update_role_sql .= "role2 = " . $_GET['role2'] . ",";
        $NUM += 1;
    }
    if (isset($_GET['role3'])) {
        $update_role_sql .= "role3 = " . $_GET['role3'] . ",";
        $NUM += 1;
    }
    if (isset($_GET['role4'])) {
        $update_role_sql .= "role4 = " . $_GET['role4'] . ",";
        $NUM += 1;
    }
    if (isset($_GET['role5'])) {
        $update_role_sql .= "role5 = " . $_GET['role5'] . ",";
        $NUM += 1;
    }
    if (isset($_GET['role6'])) {
        $update_role_sql .= "role6 = " . $_GET['role6'] . ",";
        $NUM += 1;
    }
    if (isset($_GET['role7'])) {
        $update_role_sql .= "role7 = " . $_GET['role7'] . ",";
        $NUM += 1;
    }
    if (isset($_GET['role8'])) {
        $update_role_sql .= "role8 = " . $_GET['role8'] . ",";
        $NUM += 1;
    }

    if (strlen($update_role_sql) <= 0) {
        echo "<h2>Empty request!</h2>";
        exit;
    }

    // Update last_update_times
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $times = date('d/m/Y H:i:s');

    //update to database
    $sql = "UPDATE role SET " . $update_role_sql . " NUM = " . $NUM . ", times = '" . $times . " GMT+7' WHERE STT = " . $esp8266;
    //echo "$sql";

    $result = mysqli_query($connection, $sql);
    if (!$result) {
        $arr = array('entry_id' => -1);
        echo json_encode($arr);
        exit;
    }

    //export entry_id if sucessfully
    $arr = array('entry_id' => (string)$NUM);
    echo json_encode($arr);
    //close connection to database
    mysqli_close($connection);

?>