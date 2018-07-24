<?php

if (isset($_GET['option'])) {
	$request = $_GET['option'];
	if ($request == "getipaddress") {
		get_ip_address();
	}
	elseif ($request == "alarm_check") {
		if (!isset("ontime")) {
			echo "Error ontime input for alarm_check";
			exit;
		}
		if (!isset("offtime")) {
			echo "Error offtime input for alarm_check";
			exit;
		}
		alarm_check($_GET['time']);
	}
	else
	{
		echo "<p><B>404 Not found!</B></p> <p>You has not permission to access data base!!</p>";
	}
}

function alarm_check($ontime, $offtime)
{
	echo "";
}


function get_ip_address()
{
	$ip = getenv('HTTP_CLIENT_IP')?:
	getenv('HTTP_X_FORWARDED_FOR')?:
	getenv('HTTP_X_FORWARDED')?:
	getenv('HTTP_FORWARDED_FOR')?:
	getenv('HTTP_FORWARDED')?:
	getenv('REMOTE_ADDR');
	echo "$ip"; 
}

?>