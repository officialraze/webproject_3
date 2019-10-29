<?php
session_start();
/*
// --------------------------
// Webprojekt 3.0
// Copyright Melvin Lauber & David Clausen
// --------------------------
*/

include 'includes/start.php';

// unset session and set new active element
unset($_SESSION['active']);
$_SESSION['active'] = 'artists';

$following_artists = "SELECT artists.* FROM `following_artist` following_artist
						LEFT JOIN `artist` artists ON artists.artist_id = following_artist.artist_id
						WHERE `user_id_link` = ".$_SESSION['user']['id'];

?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<title>Web Player | <?php echo ARTISTS; ?></title>

		<?php include 'includes/meta_data.php'; ?>
	</head>

	<body class="<?php echo $body_class; ?>">
		<!-- navigation left -->
		<?php include 'includes/navigation_left.php'; ?>
		<?php include 'includes/playbar.php'; ?>

		<div class="main_content_wrapper">
			<div class="main_content_inner">
				<!-- search and main nav -->
				<?php include 'includes/search_navi.php'; ?>
				<h3 class="short_title"><?php echo ARTISTS; ?></h3>

				<div class="artists_overview">
						<?php foreach ($pdo->query($following_artists) as $artist) {
						?>
						<div class="artist">
							<div class="artist_image_overview">
								<img src="img/artists/artist_<?php echo $artist['artist_id'];?>.jpg">
							</div>
							<div class="artist_content_overview">
								<h3><?php echo $artist['artist_firstname'].' '.$artist['artist_lastname']; ?></h3>
							</div>
						</div>
						<?php } ?>
			</div>
		</div>
	</body>
