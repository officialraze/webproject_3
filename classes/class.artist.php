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

// get post data
$post = $_POST;

// check if album information are set
if (isset($post['save_new_album']) && !empty($post['save_new_album'])) {
	save_new_album();
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

	echo "<pre>";print_r($album_name);echo "</pre>";
	echo "<pre>";print_r($album_year);echo "</pre>";
	exit;

	// upload cover
	$allow = array("jpg", "jpeg", "png");
	if ($_FILES['artwork']['tmp_name']) {

		// prepare data
		$info = explode('.', strtolower($_FILES['artwork']['name']));
		$old_path = $_FILES['artwork']['tmp_name'];
		$new_path = '../img/covers/'.$_FILES['artwork']['name'];

		if (in_array(end($info), $allow)) {
			if (move_uploaded_file($old_path, $new_path)) {
				$error['upload_artwork'] = '';
				$path_to_image = $_FILES['artwork']['name'];
			}
		}
		else {
			$error['upload_artwork'] = TRUE;
		}
	}

	// TODO: upload songs

	// album data
	if (!empty($album_name) && !empty($album_year) && !empty($artist) && $artist != 0 && !empty($path_to_image)) {
		$data_album = array($album_name, $album_year, $artist, $path_to_image);

		// insert data into db
		$statement = $pdo->prepare("INSERT INTO `album` (album_name, album_year, artist_id, path_to_image) VALUES (?, ?, ?, ?)");
		$statement->execute($data_album);
	}
}

?>
