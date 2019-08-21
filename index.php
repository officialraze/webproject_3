<?php
/*
// --------------------------
// Webprojekt 3.0
// Copyright Melvin Lauber
// --------------------------
*/

// includes
include 'language/de.php';
include 'config.php';

// check if user is logged in, else redirect to login
if($config['testing'] == FALSE) {
	if (!isset($_SESSION['user']['id']) || $_SESSION['user']['id'] = 0 || empty($_SESSION['user']['id'])) {
		header('Location: login.php');
		exit;
	}
}

?>

<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<title>Web Player | <?php echo HOME; ?></title>

		<!-- load all styles -->
		<link rel="stylesheet" href="css/styles.css">
		<?php // TODO: ADD THIS PLEASE IN FINAL VERSION FOR SHOWING THE CORRECT FONT --> LOCAL INSTALLED FONT LOADS FASTER :) ?>
		<!-- <link href="https://fonts.googleapis.com/css?family=DM+Sans:400,700&display=swap" rel="stylesheet"> -->
	</head>
	<body>
		<div class="navigation_left">
			<div class="navigation_wrapper">
				<div class="profile">
					<img src="img/profiles/melvin.jpg" alt="Profil-Bild">
					<h3 class="profile_name">Melvin Lauber</h3>
					<p class="profile_mail">molvinlauber@gmail.com</p>
					<a href=""><img src="" alt=""></a>
				</div>

				<div class="main_navigation">
					<ul>
						<li class="navigation_element active"><a href="#"><?php echo DISCOVER; ?></a></li>
						<li class="navigation_element"><a href="#"><?php echo MY_SONGS; ?></a></li>
						<li class="navigation_element"><a href="#"><?php echo ARTISTS; ?></a></li>
						<li class="navigation_element"><a href="#"><?php echo EVENTS; ?></a></li>
						<li class="navigation_element"><a href="#"><?php echo SETTINGS; ?></a></li>
					</ul>
				</div>

				<div class="playlist_wrapper">
					<h3 class="playlist_title"><?php echo MY_PLAYLISTS; ?></h3>
					<ul>
						<li class="playlist_element"><a href="#">Top 50 EDM Charts</a></li>
						<li class="playlist_element"><a href="#">Daily Chill</a></li>
					</ul>
					<a class="create_playlist" href=""></a>
				</div>
			</div>
		</div>

		<div class="main_content_wrapper">
			<div class="main_content_inner">
				<div id="search_navigation_wrap">
					<div class="search">
						<form class="search_form" action="" method="post">
							<input type="text" name="search" placeholder="Suchen nach Künstler, Songs oder Alben">
							<img src="img/assets/search.svg" alt="Suchen">
						</form>
					</div>
					<div id="navigation">
						<ul>
							<li class="main_navigation_element"><a href=""><?php echo HOME; ?></a></li>
							<li class="main_navigation_element"><a href=""><?php echo GENRES; ?></a></li>
							<li class="main_navigation_element"><a href=""><?php echo PLAYLISTS; ?></a></li>
							<li class="main_navigation_element"><a href=""><?php echo RADIO; ?></a></li>
						</ul>
					</div>
				</div>

				<div id="recently_listened">
					<h3><?php echo RECENTLY_LISTENED; ?></h3>
					<div id="profile_wrapper">
						<div class="profile_recently">
							<img src="img/artists/virtualriot.jpg" alt="Virtual Riot">
						</div>
					</div>
				</div>

				<div id="artists_u_like_new_songs_wrapper">
					<div id="artists_u_like">
						<h3><?php echo ARTISTS_U_MIGHT_LIKE; ?></h3>
						<div class="artists_u_like_element">
							<img src="img/artists/tokyomachine.jpg" alt="Tokyo Machine">
						</div>
					</div>

					<div id="new_songs">
						<h3><?php echo NEW_SONGS; ?></h3>
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
