<?php
include 'includes/start.php';

// unset session and set new active element
unset($_SESSION['active']);
$_SESSION['active'] = 'artists';

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
	<body class="artist_detail">
		<?php include 'includes/navigation_left.php'; ?>

		<div class="main_content_wrapper">
			<div class="main_content_inner">
				<!-- search and main nav -->
				<?php include 'includes/search_navi.php'; ?>

				<div id="artist_detail">
					<div class="artist_image">
						<img src="img/artists/virtualriot.jpg" alt="Virtual Riot">
					</div>
					<div class="artist_content">
						<!-- todo: artist icon next to name -->
						<h1 class="artist_detail_title">Virtual Riot</h1>
						<a href="#" class="follow_button is_following"><?php echo IS_FOLLOW; ?></a>
						<div id="popular_wrapper">
							<h3 class="short_title popular_title"><?php echo POPULAR; ?></h3>
							<div class="popular_song">
								<div class="popular_song_inner">
									<img src="img/assets/play.svg" alt="Play" class="svg play_song">
									<img src="img/covers/preset-junkies.jpg" class="cover_img" alt="Cover" width="49px">
									<div class="song_information">
										<h4 class="song_name">One Two</h4>
										<h4 class="artist_name">Virtual Riot</h4>
									</div>
									<div class="song_options">
										<span class="time">04:35</span>
										<img src="img/assets/like.svg" alt="Like" class="svg like_song">
										<img src="img/assets/show_more.svg" alt="More" class="svg more_song">
									</div>
									<div class="cf"></div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</body>
</html>
