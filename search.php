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
$_SESSION['active_meta_nav']	= 'discover';

// check if query is there and set new variable
if(isset($_POST['search'])) {
	$search = $_POST['search'];
}

?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<title>Web Player | <?php echo SEARCH; ?></title>

		<?php include 'includes/meta_data.php'; ?>
	</head>
	<body class="<?php echo $body_class; ?>">
		<?php include 'includes/navigation_left.php'; ?>
		<?php include 'includes/cookie_banner.php'; ?>
		<div id="playbar_wrapper_loader"></div>

		<div class="main_content_wrapper">
			<div class="main_content_inner">
				<?php include 'includes/search_navi.php'; ?>

				<div id="search_wrapper">
					<h3 class="short_title"><?php echo SEARCH.': '.$search; ?></h3>

          <?php
          // if search input has more than 3 letters
          if(strlen($search) >= 3) {
            // if variable is not empty, set query to search value in name and genre
            if(!empty($search) || isset($search)) {
							$search_query_artist = "SELECT * FROM `artist` WHERE artist_firstname LIKE '%".$search."%' OR artist_lastname LIKE '%".$search."%'";

							$search_query_songs = "SELECT * FROM `song` songs
												 INNER JOIN `artist` artists ON artists.artist_id = songs.artist_id_link
												 WHERE songs.song_name LIKE '%".$search."%'
												 OR artist_firstname LIKE '%".$search."%' OR artist_lastname LIKE '%".$search."%'";
												 // give out entries
												 echo "<div class='wrapper_search'>";
												 echo "<h3 class='search_title'>".SEARCH_ARTISTS."</h3>";
												 foreach ($pdo->query($search_query_artist) as $artist) {
													 if (is_array($artist) && !empty($artist)) {
														 // give out grid item / all artists
														 echo "<a href='artist_detail.php?artist_id=".$artist['artist_id']."'>";
														 echo "<div class='artist_box'>";
														 echo "<img src='img/artists/artist_".$artist['artist_id'].".jpg'>";
														 echo "<h3 class='artist_name'>".$artist['artist_firstname'].' '.$artist['artist_lastname']."</h3>";
														 echo "</div>";
														 echo "</a>";
													 }
													 else {
														 echo '<strong class="no_entries">Keine Ergebnisse gefunden</strong>';
													 }
													 echo "</div>";
												 }
												 echo "<div class='wrapper_search'>";
												 echo "<h3 class='search_title'>".SEARCH_SONGS."</h3>";
												 echo "<table class='saved_songs_list'>";
												 echo "<tbody>";
												 foreach ($pdo->query($search_query_songs) as $song) {
													 if (is_array($song) && !empty($song)) {
														 // give out grid item / all artists
														 echo "<tr>";
														 echo '<td class="play"><span class="play_song_wrapper play_song_class" data-artist_id='.$song['artist_id_link'].' data-album_id='.$song['album_id_link'].' data-song='.$song['song_id'].' data-song_name="'.$song['song_name'].'" data-artist_name="'.$artist['artist_firstname'].' '.$artist['artist_lastname'].'">
														 <img src="img/assets/play.svg" alt="Play" class="svg play_song">
														 </span></td>';
														 echo "<td class='song_name'>".$song['song_name']."<td>";
														 echo "<td class='artist_name'><a href='artist_detail.php?artist_id= 1;'>".$artist['artist_firstname'].' '.$artist['artist_lastname']."</a></td>";
														 echo "<td class='actions'><img src='img/assets/like.svg' class='svg like' alt='Like'><img src='img/assets/show_more.svg' class='svg more' alt='show_more'></td>";
														 echo "<td class='length'>".$song['length']."</td>";
														 echo "</tr>";
													 }
													 else {
														 echo '<strong class="no_entries">Keine Ergebnisse gefunden</strong>';
													 }
												 }
												 echo "</tbody>";
												 echo "</table>";
												 echo "</div>";
											 }
											 else {
							 					echo NO_DATA;
							 				}
				}
				else {
					echo MORE_THAN_3;
				}
          		?>
				</div>
			</div>
		</div>
	</body>
</html>
