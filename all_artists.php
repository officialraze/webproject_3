<?php
session_start();
/*
// --------------------------
// Webprojekt 3.0
// Copyright Melvin Lauber & David Clausen
// --------------------------
*/

include 'includes/start.php';
include 'includes/check_login.php';

// unset session and set new active element
unset($_SESSION['active']);
$_SESSION['active']				= 'discover';
$_SESSION['active_meta_nav']	= 'all_artists';

$all_artists = "SELECT * FROM `artist`";

?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<title>Web Player | <?php echo ALL_ARTISTS; ?></title>

		<?php include 'includes/meta_data.php'; ?>
	</head>

	<body class="<?php echo $body_class; ?>">
		<?php include 'includes/navigation_left.php'; ?>
		<?php include 'includes/cookie_banner.php'; ?>
		<div id="playbar_wrapper_loader"></div>

		<div class="main_content_wrapper">
			<div class="main_content_inner">
				<!-- search and main nav -->
				<?php include 'includes/search_navi.php'; ?>
				<h3 class="short_title"><?php echo ALL_ARTISTS; ?></h3>

				<div class="artists_overview">
						<?php foreach ($pdo->query($all_artists) as $artist) {
						?>
						<a href="artist_detail.php?artist_id=<?php echo $artist['artist_id']; ?>">
							<div class="artist_box">
								<img src="img/artists/artist_<?php echo $artist['artist_id'];?>.jpg">
								<h3 class="artist_name"><?php echo $artist['artist_firstname'].' '.$artist['artist_lastname']; ?></h3>
							</div>
						</a>
						<?php } ?>
			</div>
		</div>
	</body>
