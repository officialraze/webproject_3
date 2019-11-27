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

// check if user isset in url
if (isset($_GET['artist_id']) && !empty($_GET['artist_id'])) {
	$artist = $_GET['artist_id'];
}
else {
	header('Location: idnex.php');
}

// check if user is the same as artist (security check)
if ($artist != $_SESSION['user']['id']) {
	header('Location: artist_detail.php?artist_id='.$artist.'&message=no_permission');
}
else {
	$edit_songs_query = "SELECT * FROM `song` WHERE `artist_id_link` = $artist";
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
						<div class="song_element">
							<input class="song_name" value="<?php echo $songs_to_edit['song_name']; ?>" name="song_id_<?php echo $songs_to_edit['song_id'];?>">
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</body>
</html>
