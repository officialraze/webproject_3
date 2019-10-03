<?php
/*
// --------------------------
// Webprojekt 3.0
// Copyright Melvin Lauber & David Clausen
// --------------------------
*/

session_start();

// includes
include 'language/de.php';
include 'config.php';

// set up connection to db
if ($config['home'] == TRUE) {
	$pdo = new PDO('mysql:host=localhost;dbname=db_music_player', 'root', 'root');
}
else if ($config['school'] == TRUE) {
	$pdo = new PDO('mysql:host=localhost;dbname=db_music_player', 'dbadmin', 'db123');
}
else {
	$pdo = new PDO('mysql:host=localhost;dbname=db_music_player', 'root', '');
}

// check if user is logged in, else redirect to login
if ($config['testing'] == FALSE) {
	if (!isset($_SESSION['user']['id']) || $_SESSION['user']['id'] = 0 || empty($_SESSION['user']['id'])) {
		header('Location: login.php');
		exit;
	}
}

// get user id (for data)
if ($config['testing'] == TRUE) {
	$user_id = 1;
}
else {
	$user_id = $_SESSION['user']['id'];
}

// set class for body (darkmode)
if (isset($_SESSION['darkmode']) && $_SESSION['darkmode'] == 1) {
	$body_class = 'dark';
}
else {
	$body_class = '';
}

?>
