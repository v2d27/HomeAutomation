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
    
    if (!isset($_GET['role_id'])) {
        echo "<h1>404 Not Found!</h1><br><h3>Request not found</h3>";
        exit;
    }
    $role_id = $_GET['role_id'];
    $sql = "DELETE FROM alarm WHERE role_id=$role_id";
    if($result = mysqli_query($connection, $sql)) {
        echo "1";
    }
    else
    {
        echo "Can not query database. Error code:" . mysqli_error();
        exit;
    }


    //close connection to database
    mysqli_close($connection);

?>