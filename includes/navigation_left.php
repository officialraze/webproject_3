<?php

// get active element from session
if(isset($_SESSION['active'])) {
	$active_class = $_SESSION['active'];
}

?>
<div class="navigation_left">
	<div class="navigation_wrapper">
		<div class="profile">
			<div class="profile_picture" style="background-image: url('img/profiles/melvin.jpg');background-position: center; background-size: 250%;" alt="Profil-Bild"></div>
			<h3 class="profile_name">Melvin Lauber</h3>
			<p class="profile_mail">molvinlauber@gmail.com</p>
			<a class="profile_settings" href="profile_settings.php?user_id=<?php echo 1; ?>"><img src="img/assets/settings.svg" alt="<?php echo SETTINGS; ?>"></a>
		</div>

		<div class="main_navigation">
			<ul>
				<li class="navigation_element <?php if($active_class === 'discover') { echo 'active'; } ?>"><a href="index.php"><img class="svg" src="img/assets/discover.svg" alt="<?php echo DISCOVER; ?>"><?php echo DISCOVER; ?></a></li>
				<li class="navigation_element <?php if($active_class === 'my_songs') { echo 'active'; } ?>"><a href="my_songs.php"><img class="svg" src="img/assets/my_songs.svg" alt="<?php echo MY_SONGS; ?>"><?php echo MY_SONGS; ?></a></li>
				<li class="navigation_element <?php if($active_class === 'artists') { echo 'active'; } ?>"><a href="artists.php"><img class="svg" src="img/assets/artists.svg" alt="<?php echo ARTISTS; ?>"><?php echo ARTISTS; ?></a></li>
				<li class="navigation_element <?php if($active_class === 'events') { echo 'active'; } ?>"><a href="events.php"><img class="svg" src="img/assets/events.svg" alt="<?php echo EVENTS; ?>"><?php echo EVENTS; ?></a></li>
				<li class="navigation_element <?php if($active_class === 'settings') { echo 'active'; } ?>"><a href="settings.php"><img class="svg" src="img/assets/settings_nav.svg" alt="<?php echo SETTINGS; ?>"><?php echo SETTINGS; ?></a></li>
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
