<?php
    $servername = "localhost";
    $username = "id149650_dbuser";
    $password = "myhomedatabase";
    $database = "id149650_dbhome";
    $connection = mysqli_connect($servername, $username, $password, $database);

    $sql = "SELECT * FROM role WHERE STT = 1";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);

    $sql = "SELECT * FROM role WHERE STT = 2";
    $result2 = mysqli_query($connection, $sql);
    $row2 = mysqli_fetch_assoc($result2);

    $arr = array(
        'entry_id' => $row['NUM'], 
        'last_update_times' => $row["times"], 
        'last_get_times' => $row["last_get_times"], 
        'on' => $row['on'],
        'off' => $row['off'],
        'sleep' => $row['sleep'],
        'role1' => $row["role1"], 
        'role2' => $row["role2"], 
        'role3' => $row["role3"], 
        'role4' => $row["role4"],
        'role5' => $row["role5"], 
        'role6' => $row["role6"], 
        'role7' => $row["role7"], 
        'role8' => $row["role8"],
        'entry_id2' => $row2['NUM'], 
        'last_update_times2' => $row2["times"], 
        'last_get_times2' => $row2["last_get_times"], 
        'on2' => $row2['on'],
        'off2' => $row2['off'],
        'sleep2' => $row2['sleep'],
        'role21' => $row2["role1"], 
        'role22' => $row2["role2"], 
        'role23' => $row2["role3"], 
        'role24' => $row2["role4"],
        'role25' => $row2["role5"], 
        'role26' => $row2["role6"], 
        'role27' => $row2["role7"], 
        'role28' => $row2["role8"]
        );
    echo json_encode($arr);

    mysqli_free_result($result);
    mysqli_close($connection);
?>