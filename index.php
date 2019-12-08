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

$artist_query = "SELECT * FROM `artist` ORDER BY RAND() LIMIT 8";
$playlist_query_menu = "SELECT * FROM `playlist`";

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
		<?php include 'includes/cookie_banner.php'; ?>
		<div id="playbar_wrapper_loader"></div>

		<div class="main_content_wrapper">
			<div class="main_content_inner">
				<!-- search and main nav -->
				<?php include 'includes/search_navi.php'; ?>

				<div id="recently_listened">
					<h3 class="short_title"><?php echo RECENTLY_LISTENED; ?></h3>
					<div id="profile_wrapper">
						<div class="profile_recently">
						</div>
					</div>
				</div>

				<div id="artists_u_like_new_songs_wrapper">
					<div id="artists_u_like">
						<h3 class="short_title"><?php echo NEW_ARTISTS; ?></h3>
						<div class="artists_u_like_elements">
							<?php foreach ($pdo->query($artist_query) as $artist) { ?>
								<div class="artist_box">
									<a href="artist_detail.php?artist_id=<?php echo $artist['artist_id']; ?>"><img src="img/artists/artist_<?php echo $artist['artist_id']; ?>.jpg" alt="<?php echo $artist['artist_firstname'].' '.$artist['artist_lastname']; ?>"></a>
								</div>
							<?php } ?>
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
											<span class="play_song_wrapper play_song_class" data-cover=<?php echo $song_data['path_to_image']; ?> data-album_id=<?php echo $song_data['album_id_link']; ?> data-artist_id=<?php echo $song_data['artist_id_link']; ?> data-song=<?php echo $song_data['song_id']; ?> data-song_name="<?php echo $song_data['song_name'];?>" data-artist_name="<?php echo $song_data['artist_firstname'].' '.$song_data['artist_lastname']; ?>">
												 <img src="img/assets/play.svg" alt="Play" class="svg play_song">
											 </span>
											<img src="img/covers/<?php echo $song_data['path_to_image']?>" class="cover_img" alt="Cover" width="49px">
											<div class="song_information">
												<h4 class="song_name"><?php echo $song_data['song_name'];?></h4>
												<h4 class="artist_name"><?php echo $song_data['artist_firstname'].' '.$song_data['artist_lastname']; ?></h4>
											</div>
											<div class="song_options">
												<span class="time"><?php echo $song_data['length']; ?></span>
												<span class="like_wrapper like_song <?php echo $like_class; ?>" data-song=<?php echo $song_data['song_id']; ?>><img src="img/assets/like.svg" alt="Like" class="svg"></span>
												<div class="dropdown_show_more">
													<img src="img/assets/show_more.svg" class="svg_more_dropdown" alt="show_more">
														<div class="dropdown_show_more_content">
															<div class="dropdown_menu_delete">
																<form action="" method="post">
																<input type="hidden" name="delete" value="yes">
	  														<input type="hidden" name="row" value="<?php echo $playlist_songs_data['song_id']; ?>">
																<input class="dropdown" type="submit" name="delete" value="Lösche Song" <?php
																// function for deleting a specific, current row
																if (isset($_POST['delete']) && isset($_POST['row']))
																	{
																		$current_id = $_POST['row'];
																		$delete_song_playlist = "DELETE FROM playlist_song WHERE song_id = '$current_id'";

																		$execute_delete_song = $pdo->query($delete_song_playlist);
																	}
																?>></input></form>
															</div>
															<div class="dropdown_menu_add">
																<p class="add_to_playlist">zu Playlist hinzufügen</p>
																<div class="subnavi">


																	<!-- the playlists listed up -->
																	<?php foreach($pdo->query($playlist_query_menu) as $playlist) {

																		$statement_song = $pdo->prepare("SELECT `song_id` FROM `playlist_song` WHERE `song_id` = :song_id AND :playlist_id = :playlist_id");
																		$statement_song->bindParam(':song_id', $playlist_songs_data['song_id']);
																		$statement_song->bindParam(':playlist_id', $playlist['playlist_id']);
																		$statement_song->execute();

																		if ($statement_song->rowCount() > 0) {
																			$playlist_class = 'in_playlist';
																		}
																		else {
																			$playlist_class = 'not_in_playlist';
																		}

																		?>
																		<div class="playlist_list_box">
																			<div class="playlist_list_inner">
																				<a class="add_to_playlist_button <?php echo $playlist_class; ?>" data-playlist_checker=<?php echo $playlist_class; ?> data-song_id=<?php echo $playlist_songs_data['song_id']; ?> data-playlist_id=<?php echo $playlist['playlist_id']; ?> ><?php echo $playlist['playlist_name']; ?></a>
																			</div>
																		</div>
																	<?php } ?>


																	<form action="classes/class.playlist.php" method="post">
																		<input class="add_to_playlist_input" type="text" name="new_playlist" value="" placeholder="<?php echo ENTER_NAME ?>">
																		<input type="hidden" name="new_playlist_form" value="true">
																		<input type="submit" name="submit_new_playlist" value="<?php echo SAVE; ?>">
																	</form>
																</div>
															</div>
														</div>
												</div>
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
		<script type="text/javascript">
		// get last played artist id
		if ($.session.get('song_id')) {
			var artist_recently = $.session.get('artist_id');
			$('<img src="img/artists/artist_'+artist_recently+'.jpg">').appendTo('.profile_recently');
		}
		</script>
	</body>
</html>
