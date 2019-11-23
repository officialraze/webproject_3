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
$_SESSION['active_meta_nav']	= 'genres';

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
		<?php include 'includes/cookie_banner.php'; ?>
		<div id="playbar_wrapper_loader"></div>

		<div class="main_content_wrapper">
			<div class="main_content_inner">
				<?php include 'includes/search_navi.php'; ?>
				<div id="genres_wrapper">
					<h3 class="short_title"><?php echo GENRES; ?></h3>
					<div class="genres_overview">
						<?php foreach ($config['genres'] as $genre_key => $genre) { ?>
							<div class="genre_box">
								<div class="genre_box_inner">
									<a href="genre_detail.php?genre_id=<?php echo $genre_key; ?>"><h3><?php echo $genre; ?></h3></a>
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
