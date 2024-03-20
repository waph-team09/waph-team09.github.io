<?php
	session_set_cookie_params(900,"/","127.0.0.1",TRUE,TRUE);
	session_start();    
	if(isset($_POST["username"]) and isset($_POST["password"])){
		debug_to_console($_POST["username"]);
		debug_to_console($_POST["password"]);
		if (checklogin_mysql($_POST["username"],$_POST["password"])) {

			session_destroy();
			session_set_cookie_params(900,"/","127.0.0.1",TRUE,TRUE);
			session_start();
			session_regenerate_id(true);
			$_SESSION["authenticated"] = TRUE;
			$_SESSION["username"] = $_POST["username"];
			$_SESSION['browser_metadata'] = $_SERVER['HTTP_USER_AGENT'];
			$_SESSION['ip_address'] = $_SERVER["REMOTE_ADDR"];

	
		}else{
			session_destroy();
			echo "<script>alert('Invalid username/password');window.location='form.php';</script>";
			die();

		}
	}
	if(!isset($_SESSION["authenticated"]) or $_SESSION["authenticated"] != TRUE) {
		session_destroy();
		echo "<script>alert('You are not authorised. Press Ok to LOGIN.');</script>";
		header("Refresh:0; url=form.php");
		die();
	}
	else{
		debug_to_console("Successful Login");
	}
	if($_SESSION['browser_metadata'] !== $_SERVER['HTTP_USER_AGENT'] or $_SESSION['ip_address'] != $_SERVER["REMOTE_ADDR"]){
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
			$mysqli = new mysqli('localhost',
									'alapatsj-lab3' /*Database username*/,
									'alapatsj' /*Database password*/,
									'lab3' /*Database name*/);
	
			if($mysqli->connect_errno){
				printf("Database Connection Failed %s\n",$mysqli->connect_error);
				exit();
			}
	
			$prepsql = "SELECT * FROM users WHERE username= ? AND password = md5(?);";
			$stmt = $mysqli->prepare($prepsql);
			$stmt->bind_param("ss",$username,$password);
			$stmt->execute();
			$result = $stmt->get_result();
	

			if ($result->num_rows ==1) 
			  return TRUE;
			else 
			  return FALSE;
				printf("Database Connection Failed %s\n",$mysqli->connect_error);
				exit();
			}

	
?>
<h2> Welcome <?php echo htmlentities($_SESSION['username']); ?> !</h2>
<a href = "logout.php">Logout</a>