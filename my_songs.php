<?php
include 'includes/start.php';

// unset session and set new active element
unset($_SESSION['active']);
$_SESSION['active'] = 'my_songs';

?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<title>Web Player | <?php echo HOME; ?></title>

		<!-- load all styles -->
		<link rel="stylesheet" href="css/styles.css">
		<script src="js/jquery.min.js" charset="utf-8"></script>
		<script src="js/functions.js" charset="utf-8"></script>
		<?php // TODO: ADD THIS PLEASE IN FINAL VERSION FOR SHOWING THE CORRECT FONT --> LOCAL INSTALLED FONT LOADS FASTER :) ?>
		<link href="https://fonts.googleapis.com/css?family=DM+Sans:400,700&display=swap" rel="stylesheet">
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
