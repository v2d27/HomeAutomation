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
    
    echo "alarm_check: " . alarm_check(1);


function alarm_check($role_id)
{
    $sql = "SELECT on_time, off_time FROM alarm WHERE role_id=$role_id AND active=1";
    if($result = mysqli_query($GLOBALS['connection'], $sql)) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $on_time = $row['on_time'];
            $off_time = $row['off_time'];
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
            else
            {
                return 0;
            }
        }
        else
        {
            //Not suitable items found in Alarm Database
            return 0;
        }
        mysqli_free_result($result);
    }
    else
    {
        echo "Can not query Alarm database. Error code:" . mysqli_error();
        return 0;
    }
}

?>