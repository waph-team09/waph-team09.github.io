<?php
	session_set_cookie_params(900,"/","waph-team09.minifacebook.com",TRUE,TRUE);
	session_start();    
	if(isset($_POST["username"]) and isset($_POST["password"])){
		debug_to_console($_POST["username"]);
		debug_to_console($_POST["password"]);
		if (checklogin_mysql($_POST["username"],$_POST["password"])) {
			debug_to_console("1");
			session_destroy();
			session_set_cookie_params(900,"/","waph-team09.minifacebook.com",TRUE,TRUE);
			session_start();
			session_regenerate_id(true);
			$_SESSION["authenticated"] = TRUE;
			$_SESSION["username"] = $_POST["username"];
			$_SESSION['browser_metadata'] = $_SERVER['HTTP_USER_AGENT'];
			$_SESSION['ip_address'] = $_SERVER["REMOTE_ADDR"];

	
		}else{
			debug_to_console("2");
			session_destroy();
			echo "<script>alert('Invalid username/password');window.location='form.php';</script>";
			die();

		}
	}
	if(!isset($_SESSION["authenticated"]) or $_SESSION["authenticated"] != TRUE) {
		debug_to_console("3");
		session_destroy();
		echo "<script>alert('You are not authorised. Press Ok to LOGIN.');</script>";
		header("Refresh:0; url=form.php");
		die();
	}
	else{
		debug_to_console("Successful Login");
	}
	if($_SESSION['browser_metadata'] !== $_SERVER['HTTP_USER_AGENT'] or $_SESSION['ip_address'] != $_SERVER["REMOTE_ADDR"]){
		debug_to_console("4");
		echo "<script>alert('Session Hijacking Detected');</script>";
		header("Refresh:0; url=form.php");
		die();

	}
	function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}
	    function checklogin_mysql($username, $password) {
			debug_to_console("ABC");
			$mysqli = new mysqli('localhost',
									'waph09' /*Database username*/,
									'alapatsj' /*Database password*/,
									'waphteam09' /*Database name*/);
									debug_to_console("DEF");
			if($mysqli->connect_errno){
				printf("Database Connection Failed %s\n",$mysqli->connect_error);
				exit();
			}
			
			debug_to_console("5");
			$prepsql = "SELECT * FROM users WHERE username= ? AND password = md5(?);";
			$stmt = $mysqli->prepare($prepsql);
			$stmt->bind_param("ss",$username,$password);
			$stmt->execute();
			$result = $stmt->get_result();
	

			if ($result->num_rows ==1) {
				debug_to_console("6");
			  	return TRUE;}
			else {
				debug_to_console("7");
			  	return FALSE;
				printf("Database Connection Failed %s\n",$mysqli->connect_error);
				exit();}
			}

	
?>
<h2> Welcome <?php echo htmlentities($_SESSION['username']); ?> !</h2>
<a href = "logout.php">Logout</a>