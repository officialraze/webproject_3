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
$_SESSION['active'] 			= 'artists';
$_SESSION['active_meta_nav']	= 'discover';

// set album id
if (isset($_GET['album_id']) && !empty($_GET['album_id']) && $_GET['album_id'] > 0 && isset($_GET['artist_id']) && !empty($_GET['artist_id']) && $_GET['artist_id'] > 0) {
	$album_id = $_GET['album_id'];
	$artist_id = $_GET['artist_id'];
}

$song_query = "SELECT * FROM `song` song
				INNER JOIN `album` album ON album.album_id = song.album_id_link
				WHERE `album_id_link` = ".$album_id;

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
		<?php include 'includes/cookie_banner.php'; ?>
		<div id="playbar_wrapper_loader"></div>

		<div class="main_content_wrapper">
			<div class="main_content_inner">
				<!-- search and main nav -->
				<?php include 'includes/search_navi.php'; ?>

				<div id="album_overview">
					<a class="back_link" href="javascript:history.back()"><?php echo BACK; ?></a>
					<h3 class="short_title"><?php echo OVERVIEW; ?></h3>
					<div id="album_informations">
						<?php foreach ($pdo->query($album_query) as $album_data) { ?>
							<img class="album" src="img/covers/<?php echo $album_data['path_to_image']; ?>" width="381" alt="Cover">
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
							foreach ($pdo->query($song_query) as $song_data) {

								// check if song is liked
								$statement_song = $pdo->prepare("SELECT `song_id` FROM `saved_songs` WHERE `song_id` = :song_id");
								$statement_song->bindParam(':song_id', $song_data['song_id']);
								$statement_song->execute();

								if ($statement_song->rowCount() > 0) {
									$like_class = 'liked';
								}
								else {
									$like_class = '';
								}

								?>
								<div class="popular_song">
									<div class="popular_song_inner">
										<span class="play_song_wrapper play_song_class" data-cover=<?php echo $song_data['path_to_image']; ?> data-artist_id=<?php echo $song_data['artist_id_link']; ?> data-album_id=<?php echo $song_data['album_id_link']; ?> data-song=<?php echo $song_data['song_id']; ?> data-song_name="<?php echo $song_data['song_name'];?>" data-artist_name="<?php echo $album_data['artist_firstname'].' '.$album_data['artist_lastname']; ?>">
											 <img src="img/assets/play.svg" alt="Play" class="svg play_song">
										 </span>
										<img src="img/covers/<?php echo $album_data['path_to_image']; ?>" class="cover_img" alt="Cover" width="49px">
										<div class="song_information">
											<h4 class="song_name"><?php echo $song_data['song_name'];?></h4>
											<h4 class="artist_name"><?php echo $album_data['artist_firstname'].' '.$album_data['artist_lastname']; ?></h4>
										</div>
										<div class="song_options">
											<span class="time"><?php echo $song_data['length']; ?></span>
											<span class="like_wrapper like_song <?php echo $like_class; ?>" data-song=<?php echo $song_data['song_id']; ?>><img src="img/assets/like.svg" alt="Like" class="svg"></span>
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
