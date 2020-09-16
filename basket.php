<?php
	// start session to store session variables
	session_start();
	
	// if user is logged in and product id has been selected, proceed
	if( isset($_SESSION['user']) && isset($_GET['id']) ) {
		// if user has chosen to delete item from basket, proceed
		if( isset($_GET['delete']) ) {
			// reverse array to delete newest item that matches key
			$key = array_search ( $_GET['id'], array_reverse($_SESSION['basket'], true) );
			unset($_SESSION['basket'][$key]);
			// if basket contains no items, unset entire variable
			if(sizeof($_SESSION['basket']) == 0) {unset($_SESSION['basket']);}
		// if user hasn't chosen to delete item, proceed
		} else {
			// if basket variable doesn't already exist, create it
			if( empty($_SESSION['basket']) ) {$_SESSION['basket'] = array();}
			// add user-selected id onto basket
			array_push($_SESSION['basket'], $_GET['id']);
		}
	}
	// set session variable to keep basket expanded on page
	$_SESSION['expand'] = 1;
	// redirect user back to previous page
	header('Location: '.$_SERVER['HTTP_REFERER']);
?>