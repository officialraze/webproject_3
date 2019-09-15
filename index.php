<?php
include 'includes/start.php';

// unset session and set new active element
unset($_SESSION['active']);
$_SESSION['active'] = 'discover';

?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<title>Web Player | <?php echo HOME; ?></title>

		<!-- load all styles -->
		<link rel="stylesheet" href="css/styles.css">
		<script src="js/jquery.min.js" charset="utf-8"></script>
		<script src="js/functions.js" charset="utf-8"></script>
		<?php // TODO: ADD THIS PLEASE IN FINAL VERSION FOR SHOWING THE CORRECT FONT --> LOCAL INSTALLED FONT LOADS FASTER :) ?>
		<link href="https://fonts.googleapis.com/css?family=DM+Sans:400,700&display=swap" rel="stylesheet">
	</head>
	<body>
		<?php include 'includes/navigation_left.php'; ?>

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
						<div class="artists_u_like_element">
							<img src="img/artists/tokyomachine.jpg" alt="Tokyo Machine">
						</div>
					</div>

					<div id="new_songs">
						<h3 class="short_title"><?php echo NEW_SONGS; ?></h3>
						<div class="new_song_element">
							<img class="play_button" src="img/assets/play.svg" alt="Abspielen">
							<img class="cover" src="img/covers/breakitdown.jpg" alt="Album-Cover">
							<div class="song_information">
								<h4 class="song_title">Break It Down</h4>
								<h5 class="new_song_artist_name">Ray Volpe</h5>
							</div>
							<span class="length">04:35</span>
							<img class="like_button" src="img/assets/like.svg" alt="Liken">
							<img class="show_more" src="img/assets/show_more.svg" alt="Mehr">
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
