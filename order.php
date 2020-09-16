<?php
	// start session to store session variables
	session_start();
	
	// if user is logged in and basket variable exists, proceed
	if( isset($_SESSION['user']) && isset($_SESSION['basket']) ) {
		// get currently logged in user to query database
		$user = $_SESSION['user'];
		// connect to database
		require_once('connect.php');
		// query database to get user info from currently logged in username
		$result = mysqli_query($db, "SELECT ID, Phone, Email FROM Account WHERE Username = '$user';");
		$row = mysqli_fetch_assoc($result);
		$id = $row['ID'];
		$phone = $row['Phone'];
		$email = $row['Email'];
		
		// loop through basket to add each item to purchase database table
		foreach($_SESSION['basket'] as $key=>$value) {
			// query database to get name and price for selected product
			$result = mysqli_query($db, "SELECT Name, Price FROM Product WHERE ID = $value;");
			$row = mysqli_fetch_assoc($result);
			$name = $row['Name'];
			$price = $row['Price'];
			
			// query database to insert all relevant information into purchase table
			$query = "INSERT INTO Purchase (Account_ID, Username, Phone, Email, Product_ID, Name, Price) VALUES " .
			"($id, '$user', '$phone', '$email', $value, '$name', $price);";
			$result = mysqli_query($db, $query);
		}
		
		// if there's a database error, empty basket
		if( empty( mysqli_error($db) ) ) {unset($_SESSION['basket']);}
		
		// clear database variables
		mysqli_free_result($result);
		mysqli_close($db);
	}
	// redirect user back to previous page
	header('Location: '.$_SERVER['HTTP_REFERER']);
?>