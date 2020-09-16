<?php
	// check if username has been entered through registration form before proceeding
	if( isset($_POST['username']) ) {
		// connect to database
		require_once('connect.php');
		// get user-entered data and ensure they're safe for MySQL entry
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$phone = mysqli_real_escape_string($db, $_POST['phone']);
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$hashed_password = hash('sha512', $_POST['password']);
		$password = mysqli_real_escape_string($db, $hashed_password);
		
		// query database with user-entered data
		$result = mysqli_query($db, "INSERT INTO Account(Username, Phone, Email, Password) VALUES ('$username', '$phone', '$email', '$password');");
		
		// construct url for redirection back to main site
		$url = str_replace('&register', '', $_SERVER['HTTP_REFERER']);
		$url = str_replace('register', '', $url);
		$url = str_replace('&account_taken', '', $url);
		$url = str_replace('&database_error', '', $url);
		
		// if database query executed successfully, log user in and redirect back to site
		if( empty( mysqli_error($db) ) ) {
			session_start();
			$_SESSION['user'] = $username;
			header('Location: '.$url);
		}
		// otherwise, redirect back to registration form with error information
		else if( mysqli_errno($db) == 1062 && (substr(mysqli_error($db), -9) == 'Username\'' || substr(mysqli_error($db), -6) == 'Email\'') )
		{header('Location: '.$url.'&register&account_taken');}
		else {header('Location: '.$url.'&register&database_error');}
		
		// clear database variables
		mysqli_free_result($result);
		mysqli_close($db);
	}
	// if username hasn't been entered, redirect to homepage
	else {header('Location: index.php');}
?>