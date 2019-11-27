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

$playlist_song_query = "SELECT playlist_song.playlist_id, songs.*, artists.artist_firstname, artists.artist_lastname FROM `playlist_song` playlist_song
					INNER JOIN `song` songs ON songs.song_id = playlist_song.song_id
					LEFT JOIN `artist` artists ON artists.artist_id = songs.artist_id_link
					WHERE `playlist_id` = ".$_SESSION['playlist']['id'];

$interact_with_songs_query = "SELECT playlist_song.playlist_id, playlist_song.song_id, songs.* FROM `playlist_song` playlist_song
					INNER JOIN `song` songs ON songs.song_id = playlist_song.song_id";

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
		<?php include 'includes/playbar.php'; ?>
		<?php include 'includes/cookie_banner.php'; ?>

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
									<td class="play"><img src="img/assets/play.svg" class="svg" alt="play"></td>
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
																<?php // TODO: foreach playlists ?>
																<a href="classes/class.playlist.php?playlist_id=1&song_id=1">Top 50 EDM</a>

																<form action="classes/class.playlist.php" method="post">
																	<input class="add_to_playlist_input" type="text" name="new_playlist" value="" placeholder="Bitte Namen eingeben">
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
