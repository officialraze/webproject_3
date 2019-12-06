<?php
session_start();
/*
// --------------------------
// Webprojekt 3.0
// Copyright Melvin Lauber is doof
// --------------------------
*/

// includes
include '../config.php';
include '../includes/db.php';

// get post data
$post = $_POST;

// add song to playlist
if (isset($post['playlist_id_link']) && isset($post['song_id'])) {
	add_song_playlist($post['playlist_id_link'], $post['song_id'], $post['playlist_checker_val']);
}



/**
 * add song to playlist
 *
 * @param integer $playlist_id_link
 * @param integer $song_id
*/
function add_song_playlist($playlist_id_link, $song_id, $playlist_checker) {

	// globalize post data
	global $post;

	include '../config.php';
	include '../includes/db.php';

	if ($playlist_checker == 'in_playlist') {
		$statement = $pdo->prepare("DELETE FROM playlist_song WHERE playlist_id = :playlist_id AND song_id = :song_id");
		$statement->execute(array('playlist_id' => $playlist_id_link, 'song_id' => $song_id));
	}
	else {
		$statement = $pdo->prepare("INSERT INTO playlist_song (playlist_id, song_id) VALUES (?, ?)");
		$statement->execute(array($playlist_id_link, $song_id));
	}


}



?>
