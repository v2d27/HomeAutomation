<?php

	if (isset($_GET["data"])) {
		$username = $_GET["data"];
		echo login_check($username);
		exit();
	}

	function login_check($data = "")		
	{
		$username_db   = "06e9358c4cd9bda9871d7024ca061f985a1f36974b83fdf8963ef8dd2d8f6406"; //user: vuvanduc pass:123456
		$vutandat_db   = "a48ed18be0fd67021da0513cd5dc3a0bb24a4a53ecfdaf34731e13a7489e31c8"; //user: vutandat pass:123456
		$vuvanhoan_db  = "8df5804cd49affdc19b7bbf235a0d0dce9a3aa8a6847d08dd9e336de4c3e83bf"; //user: vuvanhoan pass:123456
		$hothihuong_db = "d0ede1f50b392a4faec9ba90ab4eac75abe47251b59d6fca44b846fa30383343"; //user: hothihuong pass:123456


		if ($data == $username_db) {
			return 1;
		}

		if ($data == $vutandat_db) {
			return 1;
		}

		if ($data == $vuvanhoan_db) {
			return 1;
		}

		if ($data == $hothihuong_db) {
			return 1;
		}

		return 0;
	}	
?>