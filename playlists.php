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

$playlists_overview = "SELECT * FROM `playlist`";

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
					<div class="genres_overview">
						<?php foreach ($pdo->query($playlists_overview) as $playlist) { ?>
							<div class="genre_box">
								<div class="genre_box_inner">
									<a href="playlist_detail.php?playlist_id=<?php echo $playlist['playlist_id']; ?>"><h3><?php echo $playlist['playlist_name']; ?></h3></a>
								</div>
							</div>
						<?php } ?>
						<div class="cf"></div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
