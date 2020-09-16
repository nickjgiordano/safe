<?php
	// start session to store session variables
	session_start();
	
	// if user pressed logout button, then destroy session
	if(isset($_POST['login_btn']) && $_POST['login_btn'] == "logout") {
		session_destroy();
		header('Location: '.$_SERVER['HTTP_REFERER']);
	// if user and password information has been entered, proceed
	} else if( isset($_POST['user']) && isset($_POST['pass']) ) {
		// get email entered by user
		$user = $_POST['user'];
		
		// get password entered by user and hash it
		$pass = hash('sha512', $_POST['pass']);
		
		// query database against user-entered username
		require_once('connect.php');
		$result = mysqli_query($db, "SELECT Username, Password FROM Account WHERE Username = '$user';");
		$row = mysqli_fetch_assoc($result);
		
		// clear database variables
		mysqli_free_result($result);
		mysqli_close($db);
		
		// if username and password both match, set user session variable
		if($user == $row['Username']) {
			if($pass == $row['Password']) {
				$_SESSION['user'] = $user;
			} else {session_destroy();} // wrong password, so destroy session
		} else {session_destroy();} // wrong username, so destroy session
		// redirect user back to previous page
		header('Location: '.$_SERVER['HTTP_REFERER']);
	}
	// if page was arrived at erroneously, redirect user back to homepage
	else {header('Location: index.php');}
?>