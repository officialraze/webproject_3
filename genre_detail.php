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
$_SESSION['active'] = 'my_songs';

if (isset($_GET['genre_id']) && $_GET['genre_id'] != 0) {
	$genre_id = $_GET['genre_id'];
}

$genre_song_query = "SELECT * FROM `song` songs
					INNER JOIN `artist` artists ON artists.artist_id = songs.artist_id_link
					WHERE `genre_id` = ".$genre_id;

?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<title>Web Player | <?php echo GENRES; ?></title>

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

				<a class="back_link" href="javascript:history.back()"><?php echo BACK; ?></a>

				<h3 class="short_title"><?php echo $config['genres'][$genre_id]; ?></h3>

				<table class="saved_songs_list">
					<tbody>
						<?php
						$no_data = TRUE;
						foreach ($pdo->query($genre_song_query) as $genre_songs_data) {
							if (!empty($genre_songs_data)) { ?>
								<tr>
									<td class="play"><img src="img/assets/play.svg" class="svg" alt="play"></td>
									<td class="song_name"><?php echo $genre_songs_data['song_name']; ?></td>
									<td class="artist_name"><a href="artist_detail.php?artist_id=<?php echo $genre_songs_data['artist_id']; ?>"><?php echo $genre_songs_data['artist_firstname'].' '.$genre_songs_data['artist_lastname']; ?></a></td>
									<td class="actions"><img src="img/assets/like.svg" class="svg like" alt="Like"><img src="img/assets/show_more.svg" class="svg more" alt="show_more"></td>
									<td class="length"><?php echo $genre_songs_data['length']; ?></td>
								</tr>
						<?php
							}
							$no_data = FALSE;
						} ?>

					</tbody>
				</table>
				<?php
					if ($no_data == TRUE) {
						echo NO_DATA;
					}
				?>
			</div>
		</div>
	</body>
