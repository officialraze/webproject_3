<?php
/*
// --------------------------
// Webprojekt 3.0
// Copyright Melvin Lauber
// --------------------------
*/

session_start();

// includes
include 'language/de.php';
include 'config.php';

// check if user is logged in, else redirect to login
if($config['testing'] == FALSE) {
	if (!isset($_SESSION['user']['id']) || $_SESSION['user']['id'] = 0 || empty($_SESSION['user']['id'])) {
		header('Location: login.php');
		exit;
	}
}

?>
