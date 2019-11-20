<?php
session_start();
/*
// --------------------------
// Webprojekt 3.0
// Copyright Melvin Lauber
// --------------------------
*/

// includes
include '../config.php';
include '../includes/db.php';
include 'class.music.php';

// get post data
$post = $_POST;

// check if album information are set
if (isset($post['save_new_album'])) {
	save_new_album();
}

// check if image upload form exists
if (isset($post['upload_artist_image_form'])) {
	upload_artist_image();
}

// check if follow / unfollow artist
if (isset($post['follow_unfollow']) && isset($post['artist'])) {
	follow_artist($post['follow_unfollow'], $post['artist']);
}

/**
 * Save new album into db
 *
 * @param string
 * @param string
*/
function save_new_album() {

	// globalize post data
	global $post;
	$error = array();
	$error['missing_fields'] = array();
	$artist = $post['artist_id'];

	// includes
	include '../config.php';
	include '../includes/db.php';

	// check form data
	if (isset($post['album_name']) && !empty($post['album_name'])) {
		$album_name = $post['album_name'];
	}
	else {
		$error['missing_fields'][] = 'album_name';
	}

	if (isset($post['album_year']) && !empty($post['album_year'])) {
		$album_year = $post['album_year'];
	}
	else {
		$error['missing_fields'][] = 'album_year';
	}


	// upload cover
	$allow_image = array("jpg", "jpeg", "png");
	if ($_FILES['artwork']['tmp_name']) {

		// prepare data
		$info = explode('.', strtolower($_FILES['artwork']['name']));
		$old_path = $_FILES['artwork']['tmp_name'];
		$new_path = '../img/covers/'.$_FILES['artwork']['name'];

		if (in_array(end($info), $allow_image)) {
			if (move_uploaded_file($old_path, $new_path)) {
				$error['upload_artwork'] = '';
				$path_to_image = $_FILES['artwork']['name'];
			}
		}
		else {
			$error['upload_artwork'] = TRUE;
		}
	}

	// album data
	if (!empty($album_name) && !empty($album_year) && !empty($artist) && $artist != 0 && !empty($path_to_image)) {
		$data_album = array($album_name, $album_year, $artist, $path_to_image);

		// insert data into db
		$statement = $pdo->prepare("INSERT INTO `album` (album_name, album_year, artist_id, path_to_image) VALUES (?, ?, ?, ?)");
		$statement->execute($data_album);
	}

	// get last id
	$stmt = $pdo->query("SELECT LAST_INSERT_ID()");
	$last_id = $stmt->fetchColumn();

	if ($_FILES['song_file']['name']) {
		// prepare data
		foreach ($_FILES['song_file']['name'] as $song => $song_name) {
			if (!empty($song_name)) {

				$mp3file = new MP3File($_FILES['song_file']['tmp_name'][$song]);
				$duration = $mp3file->getDurationEstimate();
				$duration = MP3File::formatTime($duration);

				$old_path_music = $_FILES['song_file']['tmp_name'][$song];
				$new_path_music = '../music/'.$song_name;

				if (move_uploaded_file($old_path_music, $new_path_music)) {
					$error['upload_song'] = '';

					$song_data = array($artist, ''.$post['song_title'][$song].'', $last_id, ''.$duration.'', $post['genre_selection'][$song]);

					$statement_music = $pdo->prepare("INSERT INTO `song` (artist_id_link, song_name, album_id_link, length, genre_id) VALUES (?, ?, ?, ?, ?)");
					$statement_music->execute($song_data);

					if ($statement_music) {
						header("Location: ../artist_detail.php?artist_id=".$artist."&message=upload_successfull");
					}
				}
				else {
					$error['upload_song'] = TRUE;
				}
			}
		}
	}
}



/**
 * Upload artist image
 *
 * @param string
 * @param string
*/
function upload_artist_image() {

	// globalize post data
	global $post;
	$error = array();
	$error['missing_fields'] = array();
	$artist = $post['artist_id'];

	// includes
	include '../config.php';
	include '../includes/db.php';

	$allow_image = array("jpg");
	if ($_FILES['artist_image']['tmp_name']) {

		// prepare data
		$info = explode('.', strtolower($_FILES['artist_image']['name']));
		$old_path = $_FILES['artist_image']['tmp_name'];
		$new_path = '../img/artists/artist_'.$artist.'.'.end($info);

		if (in_array(end($info), $allow_image)) {
			if (move_uploaded_file($old_path, $new_path)) {
				$error['upload_artist_image'] = '';
				header("Location: ../artist_detail.php?artist_id=".$artist."&message=upload_artist_image_successfull");
			}
			else {
				$error['upload_artist_image'] = TRUE;
			}
		}
		else {
			header("Location: ../artist_detail.php?artist_id=".$artist."&message=upload_artist_image_false_file_format");
		}
	}
}



/**
 * follow or unfollow artist // AJAX
 *
 * @param string $follow_unfollow
 * @param integer $artist
*/
function follow_artist($follow_unfollow, $artist) {

	// includes
	include '../config.php';
	include '../includes/db.php';

	if ($follow_unfollow == 'follow_artist') {
		// follow artist
		$statement = $pdo->prepare("INSERT INTO following_artist (user_id_link, artist_id) VALUES (?, ?)");
		$statement->execute(array($_SESSION['user']['id'], $artist));
	}
	else {
		// unfollow artist
		$statement = $pdo->prepare("DELETE FROM following_artist WHERE user_id_link = :user_id AND artist_id = :artist_id");
		$statement->execute(array('user_id' => $_SESSION['user']['id'], 'artist_id' => $artist));
	}

}

?>
