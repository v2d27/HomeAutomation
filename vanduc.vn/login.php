<?php 
	include_once 'login_check.php';
	if (isset($_COOKIE["data"])) {
		if (login_check($_COOKIE["data"]) == "1") {
			header("Location: main.php");
		}	
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>IoT Sign up</title>
	<link rel="shortcut icon" href="image/homeiot.ico">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="/server/jssha256.js"></script>
</head>
<style>
.main {
    border: 3px solid #f1f1f1;
    margin-top: 150px;
    width: 300px;
    height: 400px;
	margin: 0 auto;
}

.cap
{
	font-size: 24px;
	color: blue;
	text-align: center;
	display: inline-block;
	margin-left: 125px;
}

input[type=text], input[type=password] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
    font-size: 14px;
}

button {
    background-color: rgba(14, 197, 147, 0.95);
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}

button:hover {
    /*opacity: 0.8;*/
}

.cancelbtn {
    width: auto;
    padding: 10px 18px;
    background-color: #f44336;
}

.imgcontainer {
    text-align: center;
    margin: 24px 0 12px 0;
}

img.avatar {
    width: 40%;
    border-radius: 50%;
}

.container {
    padding: 16px;
}

span.psw {
    float: right;
    padding-top: 16px;
}



</style>
<body >

<div class="main">
  <div class="imgcontainer">
    <img src="image/IoT-cloud.jpg" alt="Avatar" class="avatar" >
  </div>

  <div class="cap">Login</div>

  <div class="container">
    <label><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="uname" id="username" required>

    <label><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" id="password" required>
        
	<div id="error" style="color: red;"></div>
    <button type="submit" id="btn_submit">Sign up</button>
  </div>
</div>

</body>
</html>

<script type="text/javascript">
	$(document).keypress(function(e) {
	    if(e.which == 13) {
	        login();
	    }
	});
	$("#btn_submit").on("click", function login(){
		var username = $("#username").val();
		var password = $("#password").val();
		var error = $("#error");
		error.html("");
		if (username == "") {
			error.html("Username must not empty .");
			return false;
		}
		if (password == "") {
			error.html("Password must not empty .");
			return false;
		}

		var sha256 = HMAC_SHA256_MAC("xpoiwepoxmgq", username + " " + password);
		
		$.ajax({
		  url: "login_check.php",
		  method: "GET",
		  data: { data: sha256},
		  success : function(response){
		  	if (response == "1") {
				var d = new Date();
			 	d.setTime(d.getTime() + (1*24*60*60*1000));
			 	var expires = "expires=" + d.toUTCString();
			 	document.cookie = "user_id=" + username + "; " + expires;
			 	document.cookie = "data=" + sha256 + "; " + expires;
			 	window.location.replace("main.php");
		  	}
		  	else
		  	{
		  		console.log("response:" + response); 
		  		error.html("Username or password is wrong !");
		  	}
		  }
		});
 
	});
</script>