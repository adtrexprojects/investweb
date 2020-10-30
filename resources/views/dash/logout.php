<?php
	session_start(); // start session
		session_unset(); //remove all sessions
		session_destroy(); // destroy all sessions
		header("Location: login.php"); // Redirecting To Login Page
		
	
?>

