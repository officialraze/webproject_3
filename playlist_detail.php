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
$_SESSION['active_meta_nav']	= 'playlists';
$_SESSION['playlist']['id'] = $_GET['playlist_id'];

$playlist_song_query = "SELECT playlist_song.playlist_id, songs.*, artists.artist_firstname, artists.artist_lastname, album.path_to_image FROM `playlist_song` playlist_song
					INNER JOIN `song` songs ON songs.song_id = playlist_song.song_id
					INNER JOIN `album` album ON album.album_id = songs.album_id_link
					INNER JOIN `artist` artists ON artists.artist_id = songs.artist_id_link
					WHERE `playlist_id` = ".$_SESSION['playlist']['id'];

$playlist_query_menu = "SELECT * FROM `playlist`";

?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<title>Web Player | <?php echo PLAYLISTS; ?></title>

		<?php include 'includes/meta_data.php'; ?>
	</head>
	<body class="<?php echo $body_class; ?>">
		<?php include 'includes/navigation_left.php'; ?>
		<?php include 'includes/cookie_banner.php'; ?>
		<div id="playbar_wrapper_loader"></div>

		<div class="main_content_wrapper">
			<div class="main_content_inner">
				<?php include 'includes/search_navi.php'; ?>

				<div id="genres_wrapper">
					<h3 class="short_title"><?php echo PLAYLISTS; ?></h3>
					<!-- Show songs in playlist -->
					<table class="saved_songs_list">
						<tbody>
							<?php foreach ($pdo->query($playlist_song_query) as $playlist_songs_data) {

								// check if song is liked
								$statement_song = $pdo->prepare("SELECT `song_id` FROM `playlist_song` WHERE `song_id` = :song_id");
								$statement_song->bindParam(':song_id', $playlist_songs_data['song_id']);
								$statement_song->execute();

								if ($statement_song->rowCount() > 0) {
									$like_class = 'liked';
								}
								else {
									$like_class = '';
								}

								?>
								<tr>
									<td class="play"><span class="play_song_wrapper play_song_class" data-cover=<?php echo $playlist_songs_data['path_to_image']; ?> data-artist_id=<?php echo $playlist_songs_data['artist_id_link']; ?> data-album_id=<?php echo $playlist_songs_data['album_id_link']; ?> data-song=<?php echo $playlist_songs_data['song_id']; ?> data-song_name="<?php echo $playlist_songs_data['song_name'];?>" data-artist_name="<?php echo $playlist_songs_data['artist_firstname'].' '.$playlist_songs_data['artist_lastname']; ?>">
										 <img src="img/assets/play.svg" alt="Play" class="svg play_song">
									 </span></td>
									<td class="song_name"><?php echo $playlist_songs_data['song_name']; ?></td>
									<td class="artist_name"><a href="artist_detail.php?artist_id=<?php echo 1; ?>">
										<?php echo $playlist_songs_data['artist_firstname'].' '.$playlist_songs_data['artist_lastname']; ?></a></td>
									<td class="actions"><span class="like_wrapper like_song like <?php echo $like_class; ?>" data-song=<?php echo $playlist_songs_data['song_id']; ?>>
										<img src="img/assets/like.svg" alt="Like" class="svg"></span>
											<!-- more options for interaction with songs -->
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
									</td>
									<td class="length"><?php echo $playlist_songs_data['length']; ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>
