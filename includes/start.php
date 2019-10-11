<?php
/*
// --------------------------
// Webprojekt 3.0
// Copyright Melvin Lauber & David Clausen
// --------------------------
*/

// includes
include 'language/de.php';
include 'config.php';
include 'db.php';


// check if user exists
if (isset($_SESSION['user']['id']) && !empty($_SESSION['user']['id'])) {
	$statement = $pdo->prepare("SELECT * FROM `users` WHERE `id` = :id");
	$result = $statement->execute(array('id' => $_SESSION['user']['id']));
	$user = $statement->fetch();
	$_SESSION['user'] = $user;
}



// set class for body (darkmode)
if (isset($_SESSION['user']['has_darkmode']) && $_SESSION['user']['has_darkmode'] == 1) {
	$body_class = 'dark';
}
else {
	$body_class = '';
}

?>
