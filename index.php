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
$_SESSION['active']				= 'discover';
$_SESSION['active_meta_nav']	= 'discover';

$song_query = "SELECT * FROM `song`
				INNER JOIN `album` album ON album.album_id = song.album_id_link
				INNER JOIN `artist` artist ON artist.artist_id = album.artist_id
				ORDER BY `song_id` DESC LIMIT 3";

?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<title>Web Player | <?php echo HOME; ?></title>

		<?php include 'includes/meta_data.php'; ?>
	</head>
	<body class="<?php echo $body_class; ?>">
		<?php include 'includes/navigation_left.php'; ?>
		<?php include 'includes/playbar.php'; ?>
		<?php include 'includes/cookie_banner.php'; ?>

		<div class="main_content_wrapper">
			<div class="main_content_inner">
				<!-- search and main nav -->
				<?php include 'includes/search_navi.php'; ?>

				<div id="recently_listened">
					<h3 class="short_title"><?php echo RECENTLY_LISTENED; ?></h3>
					<div id="profile_wrapper">
						<div class="profile_recently">
							<img src="img/artists/virtualriot.jpg" alt="Virtual Riot">
						</div>
					</div>
				</div>

				<div id="artists_u_like_new_songs_wrapper">
					<div id="artists_u_like">
						<h3 class="short_title"><?php echo ARTISTS_U_MIGHT_LIKE; ?></h3>
						<div class="artists_u_like_elements">
							<div class="artist_box">
								<img src="img/artists/tokyomachine.jpg" alt="Tokyo Machine">
							</div>
							<div class="cf"></div>
						</div>
					</div>

					<div id="new_songs">
						<h3 class="short_title"><?php echo NEW_SONGS; ?></h3>
						<div class="new_songs_wrapper">
							<?php
								$limit_left = 0;
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
											<img src="img/assets/play.svg" alt="Play" class="svg play_song">
											<img src="img/covers/<?php echo $song_data['path_to_image']?>" class="cover_img" alt="Cover" width="49px">
											<div class="song_information">
												<h4 class="song_name"><?php echo $song_data['song_name'];?></h4>
												<h4 class="artist_name"><?php echo $song_data['artist_firstname'].' '.$song_data['artist_lastname']; ?></h4>
											</div>
											<div class="song_options">
												<span class="time"><?php echo $song_data['length']; ?></span>
												<span class="like_wrapper like_song <?php echo $like_class; ?>" data-song=<?php echo $song_data['song_id']; ?>><img src="img/assets/like.svg" alt="Like" class="svg"></span>
												<img src="img/assets/show_more.svg" alt="More" class="svg more_song">
											</div>
											<div class="cf"></div>
										</div>
									</div>
							<?php if (++$limit_left == 3) break; } ?>
						</div>
					</div>
					<div class="cf"></div>
				</div>
			</div>
		</div>
	</body>
</html>
