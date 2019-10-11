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

// set album id
if (isset($_GET['album_id']) && !empty($_GET['album_id']) && $_GET['album_id'] > 0) {
	$album_id = $_GET['album_id'];
}

$song_query = "SELECT * FROM `song` song
				WHERE `album_id` = ".$album_id;

$album_query = "SELECT * FROM `album` album
				INNER JOIN `artist` artist ON artist.artist_id = album.artist_id
				WHERE `album_id` = ".$album_id;

?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<title>Web Player | <?php echo OVERVIEW; ?></title>

		<?php include 'includes/meta_data.php'; ?>
	</head>
	<body class="<?php echo $body_class; ?>">
		<?php include 'includes/navigation_left.php'; ?>
		<?php include 'includes/playbar.php'; ?>

		<div class="main_content_wrapper">
			<div class="main_content_inner">
				<!-- search and main nav -->
				<?php include 'includes/search_navi.php'; ?>

				<div id="album_overview">
					<a class="back_link" href="javascript:history.back()"><?php echo BACK; ?></a>
					<h3 class="short_title"><?php echo OVERVIEW; ?></h3>
					<div id="album_informations">
						<?php foreach ($pdo->query($album_query) as $album_data) { ?>
							<img class="album" src="img/covers/album_<?php echo $album_data['album_id']; ?>.jpg" width="381" alt="Cover">
							<h2 class="album_title"><?php echo $album_data['album_name']; ?></h2>
							<ul class="album_details">
								<li><?php echo $album_data['artist_firstname'].' '.$album_data['artist_lastname']; ?></li>
								<li><?php echo $album_data['album_year']; ?></li>
								<div class="cf"></div>
							</ul>
						<?php } ?>
					</div>

					<div id="song_list">
						<h3 class="short_title"><?php echo SONGS; ?></h3>
						<?php
							foreach ($pdo->query($song_query) as $song_data) { ?>
								<div class="popular_song">
									<div class="popular_song_inner">
										<img src="img/assets/play.svg" alt="Play" class="svg play_song">
										<img src="img/covers/album_<?php echo $song_data['album_id']?>.jpg" class="cover_img" alt="Cover" width="49px">
										<div class="song_information">
											<h4 class="song_name"><?php echo $song_data['song_name'];?></h4>
											<h4 class="artist_name"><?php echo $album_data['artist_firstname'].' '.$album_data['artist_lastname']; ?></h4>
										</div>
										<div class="song_options">
											<span class="time"><?php echo $song_data['length']; ?></span>
											<img src="img/assets/like.svg" alt="Like" class="svg like_song">
											<img src="img/assets/show_more.svg" alt="More" class="svg more_song">
										</div>
										<div class="cf"></div>
									</div>
								</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
