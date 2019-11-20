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
$_SESSION['active'] 			= 'artists';
$_SESSION['active_meta_nav']	= 'discover';

$artist_id = $_SESSION['user']['id'];
$get_artist_id = $_GET['artist_id'];

// check if artist id is same -> if TRUE -> admin settings visible
if ($artist_id == $get_artist_id) {
	$artist_admin = 1;
}
else {
	$artist_admin = 0;
}

$artist_query = "SELECT * FROM `artist` artist
				WHERE `artist_id` = ".$get_artist_id;

$song_query = "SELECT * FROM `song`
				INNER JOIN `album` album ON album.album_id = song.album_id_link
				WHERE `artist_id_link` = ".$get_artist_id;

$album_query = "SELECT * FROM `album` album
				WHERE `artist_id` = ".$get_artist_id;

// check if user is following the artist
$statement_is_following = $pdo->prepare("SELECT * FROM `following_artist` WHERE (`user_id_link` = :user_id_link) AND (`artist_id` = :artist_id)");
$statement_is_following->execute(array(':user_id_link' => $artist_id, ':artist_id' => $get_artist_id));

if ($statement_is_following->rowCount() > 0) {
	$following_class 	= 'is_following';
	$follow_text 		= IS_FOLLOW;
}
else {
	$following_class = '';
	$follow_text 		= FOLLOW;
}

?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<title>Web Player | <?php echo ARTISTS; ?></title>

		<?php include 'includes/meta_data.php'; ?>
	</head>
	<body class="artist_detail <?php echo $body_class; ?>">
		<?php include 'includes/navigation_left.php'; ?>
		<?php include 'includes/playbar.php'; ?>
		<?php include 'includes/cookie_banner.php'; ?>

		<div class="main_content_wrapper">
			<div class="main_content_inner">
				<?php include 'includes/search_navi.php'; ?>

				<div id="artist_detail">
					<div class="artist_image">
						<?php
							foreach ($pdo->query($artist_query) as $artist_data) { ?>
								<img src="img/artists/artist_<?php echo $artist_data['artist_id']; ?>.jpg" alt="<?php echo $artist_data['artist_firstname'].' '.$artist_data['artist_lastname'] ?>">
						<?php } ?>
					</div>
					<div class="artist_content">
						<h1 class="artist_detail_title">
							<?php
							 	foreach ($pdo->query($artist_query) as $artist_data) {
							 		echo $artist_data['artist_firstname'].' '.$artist_data['artist_lastname'];
							 	}
							?>
						</h1>

						<?php
						if ($artist_admin == 1) { ?>
							<a data-artist="<?php echo $get_artist_id; ?>" class="follow_button change_follow_state <?php echo $following_class; ?>"><?php echo $follow_text; ?></a>
							<a href="add_new_album.php?artist_id=<?php echo $get_artist_id; ?>" class="follow_button"><?php echo ADD_NEW_ALBUM; ?></a>
							<a href="manage_songs?artist_id=<?php echo $get_artist_id; ?>" class="follow_button"><?php echo MANAGE_SONGS_ABLUMS; ?></a>
								<div class="upload-btn-wrapper" style="top: 15px; left: 10px;">
									<form class="" action="classes/class.artist.php" method="post" enctype="multipart/form-data">
										<input accept="image/*" name="artist_image" type="file" class="upload_artist_image" id="artist_image">
										<button class="btn with_icon"><img src="img/assets/image_upload.svg" class="music_icon svg" alt="<?php echo ALBUM_ADD_SONGS; ?>"></button>
										<input type="hidden" value="true" name="upload_artist_image_form"/>
										<input type="hidden" name="artist_id" value="<?php echo $artist_id; ?>">
								</div>
								<input class="submit-button" type="submit" value="<?php echo SAVE; ?>" name="submit" id="submit"/>
							</form>
						<?php }
						else { ?>
							<a href="#" class="follow_button <?php echo $following_class; ?>"><?php echo $follow_text; ?></a>
						<?php } ?>

						<div id="popular_wrapper">
							<h3 class="short_title popular_title"><?php echo POPULAR; ?></h3>

							<div class="left_wrapper">
								<?php
									$limit_left = 0;
									foreach ($pdo->query($song_query) as $song_data) {

										// check if song is liked
										$statement_song = $pdo->prepare("SELECT `song_id` FROM `saved_songs` WHERE `song_id` = :song_id");
										$statement_song->bindParam(':song_id', $song_data['song_id']);
										$statement_song->execute();

										if ($statement_song->rowCount() > 0) {
											$like_class = 'liked';
										}
										else {
											$like_class = '';
										}

										?>
										<div class="popular_song">
											<div class="popular_song_inner">
												<img src="img/assets/play.svg" alt="Play" class="svg play_song">
												<img src="img/covers/<?php echo $song_data['path_to_image']?>" class="cover_img" alt="Cover" width="49px">
												<div class="song_information">
													<h4 class="song_name"><?php echo $song_data['song_name'];?></h4>
													<h4 class="artist_name"><?php echo $artist_data['artist_firstname'].' '.$artist_data['artist_lastname']; ?></h4>
												</div>
												<div class="song_options">
													<span class="time"><?php echo $song_data['length']; ?></span>
													<span class="like_wrapper like_song <?php echo $like_class; ?>" data-song=<?php echo $song_data['song_id']; ?>><img src="img/assets/like.svg" alt="Like" class="svg"></span>
													<img src="img/assets/show_more.svg" alt="More" class="svg more_song">
												</div>
												<div class="cf"></div>
											</div>
										</div>
								<?php if (++$limit_left == 3) break; } ?>
							</div>
							<div class="right_wrapper">
								<?php
									$data = array();
									foreach ($pdo->query($song_query) as $song_data) {
										$data[] = $song_data;
									}
									$limit_right = 0;
									foreach (array_slice($data, 3) as $song_data) { ?>
										<div class="popular_song">
											<div class="popular_song_inner">
												<img src="img/assets/play.svg" alt="Play" class="svg play_song">
												<img src="img/covers/<?php echo $song_data['path_to_image']; ?>" class="cover_img" alt="Cover" width="49px">
												<div class="song_information">
													<h4 class="song_name"><?php echo $song_data['song_name'];?></h4>
													<h4 class="artist_name"><?php echo $artist_data['artist_firstname'].' '.$artist_data['artist_lastname']; ?></h4>
												</div>
												<div class="song_options">
													<span class="time"><?php echo $song_data['length']; ?></span>
													<img src="img/assets/like.svg" alt="Like" class="svg like_song">
													<img src="img/assets/show_more.svg" alt="More" class="svg more_song">
												</div>
												<div class="cf"></div>
											</div>
										</div>
								<?php if (++$limit_right == 3) break; } ?>
								<div class="cf"></div>
							</div>
							<div class="cf"></div>
						</div>

						<div id="albums_overview">
							<h3 class="short_title popular_title"><?php echo ALBUM; ?></h3>
							<a class="show_all"><?php echo SHOW_ALL; ?></a>
							<div class="album_wrapper">
								<?php
									$limit_album = 0;
									foreach ($pdo->query($album_query) as $album_data) { ?>
										<div class="album_item">
											<a href="album_overview.php?album_id=<?php echo $album_data['album_id']?>&artist_id=<?php echo $get_artist_id; ?>"><img src="img/covers/<?php echo $album_data['path_to_image']?>" alt="Album" width="175"></a>
										</div>
									<?php if (++$limit_album == 6) break; } ?>
							</div>
							<div class="cf"></div>
						</div>

						<div id="songs_overview">
							<h3 class="short_title popular_title"><?php echo SONGS; ?></h3>
							<a class="show_all"><?php echo SHOW_ALL; ?></a>
							<div class="songs_wrapper">
								<?php
									$limit_songs = 0;
									foreach ($pdo->query($song_query) as $song_data) { ?>
											<div class="song_item">
												<img src="img/covers/<?php echo $song_data['path_to_image']; ?>" alt="Album" width="175">
											</div>
									<?php if (++$limit_songs == 6) break; } ?>
							</div>
							<div class="cf"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			$("#submit").hide();
			$("#artist_image").on("change", function(){
				$("#submit").show();
			});
		</script>
	</body>
</html>
