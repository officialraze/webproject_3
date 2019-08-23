<?php
/*
// --------------------------
// Webprojekt 3.0
// Copyright Melvin Lauber
// --------------------------
*/

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

<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<title>Web Player | <?php echo HOME; ?></title>

		<!-- load all styles -->
		<link rel="stylesheet" href="css/styles.css">
		<?php // TODO: ADD THIS PLEASE IN FINAL VERSION FOR SHOWING THE CORRECT FONT --> LOCAL INSTALLED FONT LOADS FASTER :) ?>
		<!-- <link href="https://fonts.googleapis.com/css?family=DM+Sans:400,700&display=swap" rel="stylesheet"> -->
	</head>

	<body>
		<!-- navigation left -->
		<?php include 'includes/navigation_left.php'; ?>

		<div class="main_content_wrapper">
			<div class="main_content_inner">
				<!-- search and main nav -->
				<?php include 'includes/search_navi.php'; ?>
			</div>
		</div>
	</body>
