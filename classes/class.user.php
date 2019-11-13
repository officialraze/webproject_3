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
		header("Location: login.php");
	}
}

// check if register form is sent
if (isset($post['register_form'])) {
	if (!empty($post['firstname']) && !empty($post['lastname']) && !empty($post['mail']) && !empty($post['username']) && !empty($post['password']) && !empty($post['retype_password'])) {
		register_save();
	}
	else {
		header("Location: ../register.php");
	}
}


// reset password function
if (isset($post['password_reset_form'])) {
	if(!empty($post['username']) && isset($post['username'])) {
		send_password_reset_link($post['username']);
	}
	else {
		header("Location: ../password_reset.php");
	}
}

// check if reset password form is filled out
if (isset($post['password_reset_form_validate'])) {
	if ($post['password1'] == $post['password2'] && !empty($post['password1']) && !empty($post['password2'])) {
		reset_password($post['password1'], $post['password_token']);
	}
	else {
		header("Location: ../password_reset_form.php?token=".post['password_token']);
	}
}

// check if darkmode is triggered
if (isset($post['switch'])) {
	switch_darkmode($post['switch']);
}

// check if darkmode is triggered
if (isset($post['save_song']) && isset($post['song_id'])) {
	like_song($post['save_song'], $post['song_id']);
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
 * save register user data
*/
function register_save() {

	// globalize post data
	global $post;

	include '../config.php';
	include '../includes/db.php';

	// check if username exists
	$statement_username = $pdo->prepare("SELECT `username` FROM `users` WHERE `username` = :name");
	$statement_username->bindParam(':name', $post['username']);
	$statement_username->execute();

	// check if mail exists
	$statement_username = $pdo->prepare("SELECT `email` FROM `users` WHERE `username` = :email");
	$statement_username->bindParam(':email', $post['mail']);
	$statement_username->execute();

	// if everything is ok -> insert into db
	if($statement_username->rowCount() > 0 && ($post['password'] == $post['retype_password'])) {
	    echo "exists! cannot insert";
	}
	else {

		// prepare data
		$username = $post['username'];
		$firstname = $post['firstname'];
		$lastname = $post['lastname'];
		$mail = $post['mail'];
		$password_hash = password_hash($post['password'], PASSWORD_DEFAULT);
		$password_token = md5(uniqid(rand(), true));

		// check if user has an artist account
		if (!isset($post['is_artist']) && empty($post['is_artist'])) {
			$is_artist = 0;
		}
		else {
			$is_artist = 1;
		}

		// insert user into db
		$statement = $pdo->prepare("INSERT INTO `users` (username, email, firstname, lastname, password_hash, password_token, is_artist, has_darkmode) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
		$statement->execute(array($username, $mail, $firstname, $lastname, $password_hash, $password_token, $is_artist, 0));

		if ($is_artist == 1) {

			// get artist firstname
			if (!empty($post['artist_firstname']) && isset($post['artist_firstname'])) {
				$artist_firstname = $post['artist_firstname'];
			}
			else {
				header("Location: ../register.php?message=register_not_successfull");
			}

			// get artist lastname
			$artist_lastname = '';
			if (!empty($post['artist_lastname']) && isset($post['artist_lastname'])) {
				$artist_lastname = $post['artist_lastname'];
			}

			// get artist biography
			$biography = '';
			if (!empty($post['biography']) && isset($post['biography'])) {
				$biography = $post['biography'];
			}

			// get last id (user_id)
			$stmt = $pdo->query("SELECT LAST_INSERT_ID()");
			$last_id = $stmt->fetchColumn();

			// create artist profile
			$statement_artist = $pdo->prepare("INSERT INTO `artist` (user_id, artist_firstname, artist_lastname, biography) VALUES (?, ?, ?, ?)");
			$statement_artist->execute(array($last_id, $artist_firstname, $artist_lastname, $biography));
		}

		header("Location: ../login.php?message=register_successfull");

	}


}



/**
 * set setting darkmode // AJAX
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
 * like songs (add/remove) // AJAX
 *
 * @param string $username
 * @param string $password
*/
function like_song($save_song, $song_id) {

	// includes
	include '../config.php';
	include '../includes/db.php';

	if ($save_song == 'like') {
		// add saved song
		$statement = $pdo->prepare("INSERT INTO saved_songs (user_id_link, song_id) VALUES (?, ?)");
		$statement->execute(array($_SESSION['user']['id'], $song_id));
	}
	else {
		// remove saved song
		$statement = $pdo->prepare("DELETE FROM saved_songs WHERE user_id_link = :user_id AND song_id = :song_id");
		$statement->execute(array('user_id' => $_SESSION['user']['id'], 'song_id' => $song_id));
	}

}



/**
 * reset password
 *
 * @param string $password1
 * @param string $password2
 * @param string $token
*/
function reset_password($password, $token) {

	// includes
	include '../config.php';
	include '../includes/db.php';

	// check if token exists
	$statement_token = $pdo->prepare("SELECT `password_token` FROM `users` WHERE `password_token` = :password_token");
	$statement_token->bindParam(':password_token', $token);
	$statement_token->execute();

	if ($statement_token->rowCount() > 0) {

		// set new password & new token
		$new_password = password_hash($password, PASSWORD_DEFAULT);
		$new_password_token = md5(uniqid(rand(), true));

		// update password & token
		$statement = $pdo->prepare("UPDATE users SET password_hash = ?, password_token = ? WHERE password_token = ?");
		$statement->execute(array($new_password, $new_password_token, $token));

		header("Location: ../login.php?message=reset_password_successfull");
	}
	else {
		header("Location: ../password_reset_form.php?token=".$token);
	}
	exit;


}



/**
 * send mail with password reset link
 *
 * @param string $username
*/
function send_password_reset_link($username) {

	// includes
	include '../config.php';
	include '../includes/db.php';

	// check if user exists
	$statement = $pdo->prepare("SELECT * FROM `users` WHERE `username` = :username");
	$result = $statement->execute(array('username' => $username));
	$user = $statement->fetch();


	// if user exists send mail with password reset form
	if ($user) {
		$mailto = $user['email'];
		$subject = RESET_PASSWORD;

		$message = sprintf($format, $user['firstname'], $user['lastname']);
		$message = $user['password_token'];

		// send mail
		mail($mailto, $subject, $message);

		header("Location: ../login.php?message=mail_sent");
	}

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
