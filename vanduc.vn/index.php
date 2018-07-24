<?php
	include_once 'login_check.php';
	
	if (!isset($_COOKIE["user_id"]) || !isset($_COOKIE["data"])) {
		header("Location: login.php");
		exit;
	}

	$user_id = $_COOKIE["user_id"];
	$data = $_COOKIE["data"];

	if ($user_id == "" || $data == "") {
		header("Location: login.php");
		exit;
	}

	if (login_check($data) == "1") {
		header("Location: main.php");
		exit;
	}

	header('Location: login.php');
?>