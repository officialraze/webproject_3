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
$_SESSION['active_meta_nav']	= 'all_artists';

$all_artists = "SELECT * FROM `artist`";

?>
<h3 class="short_title"><?php echo ALL_ARTISTS; ?></h3>
<div class="artists_overview">
		<?php foreach ($pdo->query($all_artists) as $artist) {
		?>
		<a href="artist_detail.php?artist_id=<?php echo $artist['artist_id']; ?>">
			<div class="artist_box">
				<img src="img/artists/artist_<?php echo $artist['artist_id'];?>.jpg">
				<h3 class="artist_name"><?php echo $artist['artist_firstname'].' '.$artist['artist_lastname']; ?></h3>
			</div>
		</a>
		<?php } ?>
</div>
