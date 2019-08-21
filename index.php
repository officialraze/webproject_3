<?php

// includes
include 'language/de.php';
include 'config.php';

?>

<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<title>Webprojekt 3.0 | Web Player</title>
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

			</div>
		</div>
	</body>
</html>
