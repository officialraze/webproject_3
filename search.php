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


$search_query = "SELECT * FROM *";


// check if query is there and set new variable
if(isset($_POST['search'])) {
$search = $_POST['search'];
}

?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<title>Web Player | <?php echo PLAYLISTS; ?></title>

		<?php include 'includes/meta_data.php'; ?>
	</head>
	<body class="<?php echo $body_class; ?>">
		<?php include 'includes/navigation_left.php'; ?>
		<?php include 'includes/playbar.php'; ?>
		<?php include 'includes/cookie_banner.php'; ?>

		<div class="main_content_wrapper">
			<div class="main_content_inner">
				<?php include 'includes/search_navi.php'; ?>

				<div id="search_wrapper">
					<h3 class="short_title"><?php echo SEARCH; ?></h3>

          <?php
          // if search input has more than 3 letters
          if(strlen($search) >= 3) {
            // if variable is not empty, set query to search value in name and genre
            if(!empty($search) || isset($search)) {
              $sql = "SELECT FROM artist artists
              INNER JOIN description infos ON infos.artist_id = artists.id
              WHERE artist_name LIKE '%".$search."%' OR genre LIKE '%".$search."%'
              ";
          }
          // give out entries
          echo "<h3 class='search_title'>".SEARCH_ARTISTS."</h3>";
          foreach ($pdo->query($search_query) as $row) {
            if (is_array($row) && !empty($row)) {
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
            }
          }
          ?>
				</div>
			</div>
		</div>
	</body>
</html>
