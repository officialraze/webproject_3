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

$artist_id = $_SESSION['user']['id'];

// check if user isset in url
if (isset($_GET['artist_id']) && !empty($_GET['artist_id'])) {
	$artist = $_GET['artist_id'];
}
else {
	header('Location: index.php');
}

$statement_is_artist = $pdo->prepare("SELECT * FROM `artist` WHERE (`user_id` = :user_id) AND (`artist_id` = :artist_id)");
$statement_is_artist->execute(array(':user_id' => $artist_id, ':artist_id' => $artist));

// check if user is the same as artist (security check)
if ($statement_is_artist->rowCount() <= 0) {
	header('Location: artist_detail.php?artist_id='.$artist.'&message=no_permission');
}
else {
	$edit_songs_query = "SELECT * FROM `song` WHERE `artist_id_link` = $artist";
	$edit_albums_query = "SELECT * FROM `album` WHERE `artist_id` = $artist";
}

?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<title>Web Player | <?php echo MANAGE_SONGS_ABLUMS; ?></title>

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
				<a class="back_link" href="artist_detail.php?artist_id=<?php echo $artist; ?>"><?php echo BACK; ?></a>
				<h3 class="short_title"><?php echo MANAGE_SONGS_ABLUMS; ?></h3>


				<div class="manage_songs_wrap">
					<h4><?php echo SONGS; ?></h4>
					<?php foreach ($pdo->query($edit_songs_query) as $songs_to_edit) { ?>
						<div class="song_element event_element">
							<input class="song_name triplet" type="text" value="<?php echo htmlspecialchars_decode($songs_to_edit['song_name']); ?>" name="song_name">
							<select class="genre_selection_field" name="genre_selection">
								<option value="0" selected><?php echo PLEASE_CHOOSE; ?></option>
								<?php foreach ($config['genres'] as $genre_id => $genre) { ?>
									<option <?php if ($genre_id == $songs_to_edit['genre_id']) { echo "selected"; } ?> value="<?php echo $genre_id; ?>"><?php echo $genre; ?></option>
								<?php } ?>
							</select>
							<input class="song_id" type="hidden" value="<?php echo $songs_to_edit['song_id']; ?>" name="hidden_song_id">
							<a class="follow_button save_song"><?php echo SAVE; ?></a>
							<a class="follow_button delete_song error_button"><?php echo DELETE; ?></a>
							<div class="cf"></div>
						</div>
					<?php } ?>
				</div>
				<br />
				<div class="manage_albums_wrap">
					<h4><?php echo ALBUM; ?></h4>
					<?php foreach ($pdo->query($edit_albums_query) as $albums_to_edit) { ?>
						<div class="song_element event_element">
							<input class="album_name triplet" type="text" value="<?php echo htmlspecialchars_decode($albums_to_edit['album_name']); ?>" name="album_name">
							<input class="album_year triplet" type="number" value="<?php echo htmlspecialchars_decode($albums_to_edit['album_year']); ?>" name="album_year">
							<input class="album_id" type="hidden" value="<?php echo $albums_to_edit['album_id']; ?>" name="hidden_album_id">
							<a class="follow_button save_album"><?php echo SAVE; ?></a>
							<a class="follow_button delete_album error_button"><?php echo DELETE; ?></a>
							<div class="cf"></div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>

		<script type="text/javascript">

			// save song on save button click
			$('.save_song').click(function() {

				// set vars
				var button = $(this);
				var song_name = $(button).parent().find('.song_name').val();
				var genre = $(button).parent().find('.genre_selection_field').val();
				var song_id = $(button).parent().find('.song_id').val();

				$.ajax({
					url: 'classes/class.artist.php',
					type: "POST",
					data: {
						song_name_val: song_name,
						genre_val: genre,
						song_id_val: song_id
					},
					success: function(response) {
						// add message
						$('<div class="message true">Änderungen erfolgreich gespeichert!</div>').prependTo('body');

						// add for smoothing
						setTimeout(function(){
							$('.message').addClass('visible');
						}, 300);

						// remove message after certain time
						setTimeout(function(){
							$('.message').removeClass('visible');
						}, 4000);
					}
				});
			});


			// save album on save button click
			$('.save_album').click(function() {

				// set vars
				var button = $(this);
				var album_name = $(button).parent().find('.album_name').val();
				var album_year = $(button).parent().find('.album_year').val();
				var album_id = $(button).parent().find('.album_id').val();

				$.ajax({
					url: 'classes/class.artist.php',
					type: "POST",
					data: {
						album_name_val: album_name,
						album_year_val: album_year,
						album_id_val: album_id
					},
					success: function(response) {
						// add message
						$('<div class="message true">Änderungen erfolgreich gespeichert!</div>').prependTo('body');

						// add for smoothing
						setTimeout(function(){
							$('.message').addClass('visible');
						}, 300);

						// remove message after certain time
						setTimeout(function(){
							$('.message').removeClass('visible');
						}, 4000);
					}
				});
			});


			// delete song
			$('.delete_song').click(function() {
				// set vars
				var button = $(this);
				var delete_from = 'song';
				var delete_id = $(button).parent().find('.song_id').val();

				$.ajax({
					url: 'classes/class.artist.php',
					type: "POST",
					data: {
						delete_from_val: delete_from,
						delete_id_val: delete_id
					},
					success: function(response) {
						// add message
						$('<div class="message true">Song erfolgreich gelöscht!</div>').prependTo('body');

						// add for smoothing
						setTimeout(function(){
							$('.message').addClass('visible');
						}, 300);

						// remove message after certain time
						setTimeout(function(){
							$('.message').removeClass('visible');
						}, 4000);
					}
				});
			});


			// delete album
			$('.delete_album').click(function() {
				// set vars
				var button = $(this);
				var delete_from = 'album';
				var delete_id = $(button).parent().find('.album_id').val();

				$.ajax({
					url: 'classes/class.artist.php',
					type: "POST",
					data: {
						delete_from_val: delete_from,
						delete_id_val: delete_id
					},
					success: function(response) {
						// add message
						$('<div class="message true">Album erfolgreich gelöscht!</div>').prependTo('body');

						// add for smoothing
						setTimeout(function(){
							$('.message').addClass('visible');
						}, 300);

						// remove message after certain time
						setTimeout(function(){
							$('.message').removeClass('visible');
						}, 4000);
					}
				});
			});

		</script>
	</body>
</html>
