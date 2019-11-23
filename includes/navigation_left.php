<?php
/*
// --------------------------
// Webprojekt 3.0
// Copyright Melvin Lauber & David Clausen
// --------------------------
*/

// get active element from session
if(isset($_SESSION['active'])) {
	$active_class = $_SESSION['active'];
}

$query = "SELECT * FROM `users` WHERE `id` = ".$_SESSION['user']['id'];
$playlist_query = "SELECT * FROM `playlist` WHERE `user_id` = ".$_SESSION['user']['id'];

?>
<div class="navigation_left">
	<div class="navigation_wrapper">
		<div class="profile">
			<?php if (file_exists('img/profiles/user_'.$_SESSION['user']['id'].'.jpg')) { ?>
			<div class="profile_picture" style="background-image: url('img/profiles/user_<?php echo $_SESSION['user']['id']; ?>.jpg');background-position: center; background-size: 140%;" alt="user_image"></div>
			<?php } else { ?>
			<div class="profile_picture" style="background-image: url('img/profiles/no_user_image.png');background-position: center; background-size: 140%;" alt="user_image"></div>
			<?php } ?>
			<h3 class="profile_name">
				<?php foreach ($pdo->query($query) as $user_data) {
					echo $user_data['firstname'].' '.$user_data['lastname'];
				} ?>
			</h3>
			<p class="profile_mail">
				<?php foreach ($pdo->query($query) as $user_data) {
					echo $user_data['email'];
				} ?>
			</p>
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
				<?php foreach ($pdo->query($playlist_query) as $playlist_data) { ?>
					<li class="playlist_element"><a href="playlist_detail.php?playlist_id=<?php echo $playlist_data['playlist_id']; ?>"><?php echo $playlist_data['playlist_name']; ?></a></li>
				<?php } ?>
			</ul>
			<a class="create_playlist" href=""></a>
		</div>
	</div>
</div>
