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
$_SESSION['active'] = 'artists';

$artist_id = $_SESSION['user']['id'];
$get_artist_id = $_GET['artist_id'];

// check if artist id is same -> if TRUE -> admin settings visible
if ($artist_id == $get_artist_id) {
	$artist_admin = 1;
}
else {
	$artist_admin = 0;
}

$artist_query = "SELECT * FROM `artist` artist
				WHERE `artist_id` = ".$get_artist_id;

$song_query = "SELECT * FROM `song` song
				WHERE `artist_id` = ".$get_artist_id;

$album_query = "SELECT * FROM `album` album
				WHERE `artist_id` = ".$get_artist_id;

?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<title>Web Player | <?php echo ARTISTS; ?></title>

		<?php include 'includes/meta_data.php'; ?>
	</head>
	<body class="artist_detail <?php echo $body_class; ?>">
		<?php include 'includes/navigation_left.php'; ?>
		<?php include 'includes/playbar.php'; ?>

		<div class="main_content_wrapper">
			<div class="main_content_inner">
				<!-- search and main nav -->
				<?php include 'includes/search_navi.php'; ?>

				<div id="artist_detail">
					<div class="artist_image">
						<?php
							foreach ($pdo->query($artist_query) as $artist_data) { ?>
								<img src="img/artists/artist_<?php echo $artist_data['artist_id']; ?>.jpg" alt="<?php echo $artist_data['artist_firstname'].' '.$artist_data['artist_lastname'] ?>">
						<?php } ?>
					</div>
					<div class="artist_content">
						<h1 class="artist_detail_title">
							<?php
							 	foreach ($pdo->query($artist_query) as $artist_data) {
							 		echo $artist_data['artist_firstname'].' '.$artist_data['artist_lastname'];
							 	}
							?>
						</h1>

						<?php
						if ($artist_admin == 1) { ?>
							<a href="#" class="follow_button"><?php echo ADD_NEW_ALBUM; ?></a>
							<a href="#" class="follow_button"><?php echo MANAGE_SONGS_ABLUMS; ?></a>
						<?php }
						else { ?>
							<a href="#" class="follow_button is_following"><?php echo IS_FOLLOW; ?></a>
						<?php } ?>

						<div id="popular_wrapper">
							<h3 class="short_title popular_title"><?php echo POPULAR; ?></h3>

							<div class="left_wrapper">
								<?php
									$limit_left = 0;
									foreach ($pdo->query($song_query) as $song_data) { ?>
										<div class="popular_song">
											<div class="popular_song_inner">
												<img src="img/assets/play.svg" alt="Play" class="svg play_song">
												<img src="img/covers/album_<?php echo $song_data['album_id']?>.jpg" class="cover_img" alt="Cover" width="49px">
												<div class="song_information">
													<h4 class="song_name"><?php echo $song_data['song_name'];?></h4>
													<h4 class="artist_name"><?php echo $artist_data['artist_firstname'].' '.$artist_data['artist_lastname']; ?></h4>
												</div>
												<div class="song_options">
													<span class="time"><?php echo $song_data['length']; ?></span>
													<img src="img/assets/like.svg" alt="Like" class="svg like_song">
													<img src="img/assets/show_more.svg" alt="More" class="svg more_song">
												</div>
												<div class="cf"></div>
											</div>
										</div>
								<?php if (++$limit_left == 3) break; } ?>
							</div>
							<div class="right_wrapper">
								<?php
									$data = array();
									foreach ($pdo->query($song_query) as $song_data) {
										$data[] = $song_data;
									}
									$limit_right = 0;
									foreach (array_slice($data, 3) as $song_data) { ?>
										<div class="popular_song">
											<div class="popular_song_inner">
												<img src="img/assets/play.svg" alt="Play" class="svg play_song">
												<img src="img/covers/album_<?php echo $song_data['album_id']?>.jpg" class="cover_img" alt="Cover" width="49px">
												<div class="song_information">
													<h4 class="song_name"><?php echo $song_data['song_name'];?></h4>
													<h4 class="artist_name"><?php echo $artist_data['artist_firstname'].' '.$artist_data['artist_lastname']; ?></h4>
												</div>
												<div class="song_options">
													<span class="time"><?php echo $song_data['length']; ?></span>
													<img src="img/assets/like.svg" alt="Like" class="svg like_song">
													<img src="img/assets/show_more.svg" alt="More" class="svg more_song">
												</div>
												<div class="cf"></div>
											</div>
										</div>
								<?php if (++$limit_right == 3) break; } ?>
								<div class="cf"></div>
							</div>
							<div class="cf"></div>
						</div>

						<div id="albums_overview">
							<h3 class="short_title popular_title"><?php echo ALBUM; ?></h3>
							<a class="show_all"><?php echo SHOW_ALL; ?></a>
							<div class="album_wrapper">
								<?php
									$limit_album = 0;
									foreach ($pdo->query($album_query) as $album_data) { ?>
										<div class="album_item">
											<a href="album_overview.php?album_id=<?php echo $album_data['album_id']?>"><img src="img/covers/album_<?php echo $album_data['album_id']?>.jpg" alt="Album" width="175"></a>
										</div>
									<?php if (++$limit_album == 6) break; } ?>
							</div>
							<div class="cf"></div>
						</div>


						<div id="songs_overview">
							<h3 class="short_title popular_title"><?php echo SONGS; ?></h3>
							<a class="show_all"><?php echo SHOW_ALL; ?></a>
							<div class="songs_wrapper">
								<?php
									$limit_songs = 0;
									foreach ($pdo->query($song_query) as $song_data) { ?>
											<div class="song_item">
												<img src="img/covers/album_<?php echo $song_data['album_id']?>.jpg" alt="Album" width="175">
											</div>
									<?php if (++$limit_songs == 6) break; } ?>
							</div>
							<div class="cf"></div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</body>
</html>
