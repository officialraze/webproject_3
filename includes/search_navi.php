<?php
/*
// --------------------------
// Webprojekt 3.0
// Copyright Melvin Lauber & David Clausen
// --------------------------
*/

// get active element from session
if(isset($_SESSION['active_meta_nav'])) {
	$active_class_meta = $_SESSION['active_meta_nav'];
}

?>
<div id="search_navigation_wrap">
	<div class="search">
		<form class="search_form" action="search.php" method="post">
			<input class="search_field" type="text" name="search" placeholder="Suchen nach Künstler, Songs oder Alben">
			<img class="search_icon" src="img/assets/search.svg" alt="Suchen">
		</form>
	</div>
	<div id="navigation">
		<ul>
			<li class="main_navigation_element <?php if($active_class_meta === 'discover') { echo 'active'; } ?>"><a href="index.php"><?php echo HOME; ?></a></li>
			<li class="main_navigation_element <?php if($active_class_meta === 'all_artists') { echo 'active'; } ?>"><a href="all_artists.php"><?php echo ALL_ARTISTS; ?></a></li>
			<li class="main_navigation_element <?php if($active_class_meta === 'genres') { echo 'active'; } ?>"><a href="genres.php"><?php echo GENRES; ?></a></li>
			<li class="main_navigation_element <?php if($active_class_meta === 'playlists') { echo 'active'; } ?>"><a href="playlists.php"><?php echo PLAYLISTS; ?></a></li>
		</ul>
	</div>
	<div class="cf"></div>
</div>
