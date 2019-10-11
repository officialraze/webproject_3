<?php
/*
// --------------------------
// Webprojekt 3.0
// Copyright Melvin Lauber
// --------------------------
*/
session_start();

// includes
include '../config.php';
include '../includes/db.php';

// get post data
$post = $_POST;

// check if login form is sent
if (isset($post['login_form'])) {
	if (isset($post['username']) && !empty($post['username']) && isset($post['password']) && !empty($post['password'])) {
		$username_mail = $post['username'];
		$user_password = $post['password'];
		login_user($username_mail, $user_password);
	}
	else {
		echo 'false';
	}
}


function login_user($username, $password) {

	// includes
	include '../config.php';
	include '../includes/db.php';

	// check if user exists
	$statement = $pdo->prepare("SELECT * FROM `users` WHERE `username` = :username");
	$result = $statement->execute(array('username' => $username));
	$user = $statement->fetch();

	// check if password is correct
	if ($user !== false && password_verify($password, $user['password_hash'])) {
		$_SESSION['user'] = $user;
		header("Location: ../index.php");
		die();
	}
	else {
		$errorMessage = "E-Mail oder Passwort war ungültig<br>";
		header("Location: ../login.php");
		die();
	}
}

?>