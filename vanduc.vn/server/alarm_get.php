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
    /*
$size = 10;
$p = 0;
$myarray = array();
while($p < $size) {
  $myarray[] = array("number" => $data[$p], "data" => $kkk[1], "status" => "A");
  $p++;
}
*/
    
    $sql = "SELECT * FROM alarm WHERE 1 ORDER BY role_id, active ASC";
    if($result = mysqli_query($connection, $sql)) {
        //$arrResponse = array("counts" => (string)mysqli_num_rows($result));
        $arrResponse = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $arrResponse[] = array("role_id" => $row['role_id'], "on_time" => $row['on_time'], "off_time" => $row['off_time'], "active" => $row['active']);
        }
        mysqli_free_result($result);
        echo json_encode($arrResponse);
    }
    else
    {
        echo "Can not query database. Error code:" . mysqli_error();
        exit;
    }


    //close connection to database
    mysqli_close($connection);

?>