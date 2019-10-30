<?php
/*
// --------------------------
// Webprojekt 3.0
// Copyright Melvin Lauber & David Clausen
// --------------------------
*/

// check if user is logged in, else redirect to login
if ($config['testing'] == FALSE) {
	if (empty($_SESSION['user'])) {
		header('Location: login.php');
	}
}

// get user id (for data)
if ($config['testing'] == TRUE) {
	$user_id = 1;
}
else {
	$_SESSION = $_SESSION; 
	$user_id = $_SESSION['user']['id'];
}
