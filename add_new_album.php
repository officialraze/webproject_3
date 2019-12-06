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

$artist = $_SESSION['user']['id'];

// get artist id
if (isset($_GET['artist_id']) && !empty($_GET['artist_id'])) {
	$artist_id = $_GET['artist_id'];
}

$statement_is_artist = $pdo->prepare("SELECT * FROM `artist` WHERE (`user_id` = :user_id) AND (`artist_id` = :artist_id)");
$statement_is_artist->execute(array(':user_id' => $artist, ':artist_id' => $artist_id));

// check if user is the same as artist (security check)
if ($statement_is_artist->rowCount() <= 0) {
	header('Location: artist_detail.php?artist_id='.$artist_id.'&message=no_permission');
}

?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<title>Web Player | <?php echo ADD_NEW_ALBUM; ?></title>

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

				<a class="back_link" href="artist_detail.php?artist_id=<?php echo $artist_id; ?>"><?php echo BACK; ?></a>

				<div id="add_new_album_wrapper">
					<h3 class="short_title popular_title"><?php echo ADD_NEW_ALBUM; ?></h3>

					<form class="add_new_album_form" action="classes/class.artist.php" method="post" enctype="multipart/form-data">
						<fieldset>
							<h2 class="form_subtitle"><?php echo ALBUM_PROPERTIES; ?></h2>

							<div class="form_element">
								<input type="text" name="album_name" placeholder="<?php echo ALBUM_NAME; ?>">
							</div>

							<div class="form_element">
								<input type="number" name="album_year" maxlength = "4" placeholder="<?php echo ALBUM_YEAR; ?>">
							</div>

							<div class="artwork_uploader">
								<div class="form_element">
									<div class="upload-btn-wrapper">
										<input accept="image/*" name="artwork" type="file" class="upload_cover">
										<button class="btn"><?php echo ALBUM_UPLOAD_COVER; ?></button>
									</div>
								</div>
							</div>

						</fieldset>

						<fieldset>
							<h2 class="form_subtitle"><?php echo ALBUM_ADD_SONGS; ?></h2>
							<span class="max_song_upload"><?php echo MAX_SONGS_UPLOAD; ?>: <strong><?php echo $config['limit_upload_songs']; ?></strong></span>

							<!-- limit song upload -->
							<?php
							for ($song_counter = 1; $song_counter <= $config['limit_upload_songs']; $song_counter++) { ?>

								<div class="song_upload_element form_element">
									<input class="song_name_field" type="text" name="song_title[]" placeholder="<?php echo ALBUM_SONG_NAME; ?>">
									<div class="upload_absolute_wrap">
										<div class="upload-btn-wrapper">
											<input accept=".mp3" name="song_file[]" type="file" class="upload_song_field">
											<button class="btn with_icon"><img src="img/assets/music_upload.svg" class="music_icon svg" alt="<?php echo ALBUM_ADD_SONGS; ?>"></button>
										</div>
									</div>
									<select class="genre_selection_field" name="genre_selection[]">
										<option value="0" selected><?php echo PLEASE_CHOOSE; ?></option>
										<?php foreach ($config['genres'] as $genre_id => $genre) { ?>
											<option value="<?php echo $genre_id; ?>"><?php echo $genre; ?></option>
										<?php } ?>
									</select>
								</div>

							<?php } ?>
							<input type="hidden" name="artist_id" value="<?php echo $artist_id; ?>">
							<input class="submit-button" type="submit" name="save_new_album" value="Speichern" style="margin-top: 30px;">
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
