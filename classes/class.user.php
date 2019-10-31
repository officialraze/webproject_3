<?php
session_start();
/*
// --------------------------
// Webprojekt 3.0
// Copyright Melvin Lauber
// --------------------------
*/

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

// check if darkmode is triggered
if (isset($post['switch'])) {
	switch_darkmode($post['switch']);
}

// check if darkmode is triggered
if (isset($post['basic_settings_save'])) {
	save_user_settings();
}



/**
 * login user
 *
 * @param string $username
 * @param string $password
*/
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



/**
 * set setting darkmode
 *
 * @param string $username
 * @param string $password
*/
function switch_darkmode($switch) {

	// includes
	include '../config.php';
	include '../includes/db.php';

	// update darkmode settings
	$statement = $pdo->prepare("UPDATE users SET has_darkmode = ? WHERE id = ?");
	$statement->execute(array($switch, $_SESSION['user']['id']));

}



/**
 * save user settings
 *
 * @param string $username
 * @param string $password
*/
function save_user_settings() {

	// globalize post data
	global $post;

	// includes
	include '../config.php';
	include '../includes/db.php';

	// TODO:
	// check if username or email already exists

	// get new username
	if (isset($post['change_username']) && !empty($post['change_username'])) {
		$username = $post['change_username'];
		$statement = $pdo->prepare("UPDATE `users` SET `username` = :username WHERE id = ".$_SESSION['user']['id']);
		$statement->execute(array('username' => $username));
	}

	// get new mail
	if (isset($post['change_username']) && !empty($post['change_mail'])) {
		$mail = $post['change_mail'];
		$statement = $pdo->prepare("UPDATE `users` SET `email` = :email WHERE id = ".$_SESSION['user']['id']);
		$statement->execute(array('email' => $mail));
	}

	// get new password
	if (isset($post['change_pw']) && !empty($post['change_pw'])) {
		$password = $post['change_pw'];
		$password_hash = password_hash($password, PASSWORD_DEFAULT);
		$statement = $pdo->prepare("UPDATE `users` SET password_hash = :password WHERE id = ".$_SESSION['user']['id']);
		$statement->execute(array('password' => $password_hash));
	}

	header("Location: ../settings.php");

}

?>
