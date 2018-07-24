<?php
    /* ESP8266 v12
     * Module ket hop voi arduino UNO R3
     * Su dung o ngoai quan
     * Role: 8 cai
     * dia chi database: ["STT = 1"]
     */
    
    /*
    //Bao tri dich vu
    $arr = array('entry_id' => (string)414,
                'sleep' => (string)0,
                'role1' => (string)0, 
                'role2' => (string)1, 
                'role3' => (string)0, 
                'role4' => (string)0,
                'role5' => (string)0, 
                'role6' => (string)0, 
                'role7' => (string)0, 
                'role8' => (string)0);
    echo json_encode($arr);
    //Update field last_get_time from esp8266
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $times = date('d/m/Y H:i:s');
    mysqli_query($connection, "UPDATE role SET last_get_times = '$times GMT+7' WHERE STT = 1");
    exit;
    */







    $servername = "localhost";
    $username = "id149650_dbuser";
    $password = "myhomedatabase";
    $database = "id149650_dbhome";

    $connection = mysqli_connect($servername, $username, $password, $database);
    if (!$connection) {
        die("Connection to database failed: " . mysqli_connect_error());
        exit;
    }

    // get database and compare it with Value sent to server
    $sql = "SELECT * FROM role WHERE STT = 1";
    $result = mysqli_query($connection, $sql);
    if (!$result || mysqli_num_rows($result) == 0) {
        echo "DB Error, could not query the database\n";
        echo 'MySQL Error: ' . mysqli_error();
        exit;
    }
    $row = mysqli_fetch_assoc($result); //fetch entry_id and state role from database
    $db_entry_id = $row['NUM']; //entry_id is NUM in database
    $db_role1    = $row['role1'];
    $db_role2    = $row['role2'];
    $db_role3    = $row['role3'];
    $db_role4    = $row['role4'];
    $db_role5    = $row['role5'];
    $db_role6    = $row['role6'];
    $db_role7    = $row['role7'];
    $db_role8    = $row['role8'];
    $db_sleep    = $row['sleep'];
    $db_on       = $row[ 'on'  ];
    $db_off      = $row[ 'off' ];
    $db_temp_ok  = $row['temp_ok'];

    //Value is sent to server
    $entry_id = isset($_GET['entry_id']) ? intval($_GET['entry_id']) : 0;
    $role1    = isset($_GET['role1'])    ? intval($_GET['role1']) : 0;
    $role2    = isset($_GET['role2'])    ? intval($_GET['role2']) : 0;
    $role3    = isset($_GET['role3'])    ? intval($_GET['role3']) : 0;
    $role4    = isset($_GET['role4'])    ? intval($_GET['role4']) : 0;
    $role5    = isset($_GET['role5'])    ? intval($_GET['role5']) : 0;
    $role6    = isset($_GET['role6'])    ? intval($_GET['role6']) : 0;
    $role7    = isset($_GET['role7'])    ? intval($_GET['role7']) : 0;
    $role8    = isset($_GET['role8'])    ? intval($_GET['role8']) : 0;

    if ($entry_id >= $db_entry_id) {
        if ($db_role1 == $role1 && $db_role2 == $role2 && $db_role3 == $role3 && $db_role4 == $role4 && $db_role5 == $role5 && $db_role6 == $role6 && $db_role7 == $role7 && $db_role8 == $role8) {
            $entry_id = $entry_id;
        }
        else {
            $entry_id = intval($db_entry_id)+1;
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $times = date('d/m/Y H:i:s');

            //update to database
            $sql = "UPDATE role SET role1 = $role1, 
                            role2 = $role2, 
                            role3 = $role3, 
                            role4 = $role4,
                            role5 = $role5,
                            role6 = $role6,    
                            role7 = $role7,
                            role8 = $role8,
                            NUM = $entry_id,
                            times = '$times GMT+7' 
                    WHERE STT = 1";
            mysqli_query($connection, $sql);
        }
        $db_entry_id = (string)$entry_id;
        $db_role1 = (string)$role1;
        $db_role2 = (string)$role2;
        $db_role3 = (string)$role3;
        $db_role5 = (string)$role5;
        $db_role6 = (string)$role6;
        $db_role7 = (string)$role7;
        $db_role8 = (string)$role8; 
    }

    //Update field last_get_time from esp8266
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $times = date('d/m/Y H:i:s');
    mysqli_query($connection, "UPDATE role SET last_get_times = '$times GMT+7' WHERE STT = 1");

    //response back from db to client
    $arr = array('entry_id' => $db_entry_id,
                'sleep' => $db_sleep,
                'role1' => $db_role1, 
                'role2' => $db_role2, 
                'role3' => $db_role3, 
                'role4' => $db_role4,
                'role5' => $db_role5, 
                'role6' => $db_role6, 
                'role7' => $db_role7, 
                'role8' => $db_role8);
    //alarm function
    $sql = "SELECT STT, on_time, off_time, role_id FROM alarm WHERE active=1 ORDER BY role_id ASC";
    if($result = mysqli_query($connection, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $role_id = $row['role_id'];
            if(intval($role_id) < 10)
            {
                $role_str = "role" . strval($role_id);
                if (alarm_check($row['on_time'], $row['off_time'])) {
                    if ($arr[$role_str] == "0") {
                        $arr[$role_str] = "1";
                        mysqli_query($connection, "UPDATE role SET role$role_id=1 WHERE STT = 1");
                    }
                    if ($row['STT'] == "0") {
                        mysqli_query($connection, "UPDATE alarm SET STT=1 WHERE role_id=$role_id");
                    }
                }
                else
                {
                    if ($arr[$role_str] == "1") {
                        if($row['STT'] == "1")
                        {
                            $arr[$role_str] = "0";
                            mysqli_query($connection, "UPDATE role SET role$role_id=0 WHERE STT = 1");
                            mysqli_query($connection, "UPDATE alarm SET STT=0 WHERE role_id=$role_id");
                        }
                    }
                }
            }
        }
        mysqli_free_result($result);
    }

    echo json_encode($arr);
    mysqli_close($connection);


    function alarm_check($on_time, $off_time)
    {
        $on_secs = intval(substr($on_time, 0, 2))*60*60+intval(substr($on_time, 3, 2))*60;
        $off_secs = intval(substr($off_time, 0, 2))*60*60+intval(substr($off_time, 3, 2))*60;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $times = date('H:i:s');
        $current_secs = intval(substr($times, 0, 2))*60*60+intval(substr($times, 3, 2))*60;

        if ($off_secs <= $on_secs) {
            if($current_secs < $off_secs)
            {
                $current_secs += 24*60*60;
            }
            $off_secs += 24*60*60;                
        }

        if ($on_secs <= $current_secs && $off_secs >= $current_secs) {
           return 1;
        }
        return 0;
    }
?>