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

// save song changes
if (isset($post['song_name_val']) && isset($post['genre_val']) && isset($post['song_id_val'])) {
	save_song_changes($post['song_name_val'], $post['genre_val'], $post['song_id_val']);
}

// save album changes
if (isset($post['album_name_val']) && isset($post['album_year_val']) && isset($post['album_id_val'])) {
	save_album_changes($post['album_name_val'], $post['album_year_val'], $post['album_id_val']);
}

// save event changes
if (isset($post['event_name_val']) && isset($post['place_val']) && isset($post['event_date_val']) && isset($post['event_id_val'])) {
	save_event_changes($post['event_name_val'], $post['place_val'], $post['event_date_val'], $post['event_id_val']);
}

// add event
if (isset($post['new_event_form']) && isset($post['new_event_name']) && isset($post['new_place']) && isset($post['new_event_date'])) {
	add_event($post['new_event_name'], $post['new_place'], $post['new_event_date']);
}

// delete from function
if (isset($post['delete_from_val']) && isset($post['delete_id_val'])) {
	delete_from($post['delete_from_val'], $post['delete_id_val']);
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
			header("Location: ../add_new_album.php?artist_id='.$artist.'&message=cover_not_uploaded");
		}
	}

	// album data
	if (!empty($album_name) && !empty($album_year) && !empty($artist) && $artist != 0 && !empty($path_to_image)) {
		$data_album = array($album_name, $album_year, $artist, $path_to_image);

		// insert data into db
		$statement = $pdo->prepare("INSERT INTO `album` (album_name, album_year, artist_id, path_to_image) VALUES (?, ?, ?, ?)");
		$statement->execute($data_album);
	}
	else {
		header("Location: ../add_new_album.php?artist_id='.$artist.'&message=empty_fields");
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
				$duration = substr($duration, 3);

				$old_path_music = $_FILES['song_file']['tmp_name'][$song];
				$ending = explode('.', strtolower($song_name));
				$ending = end($ending);

				if ($old_path_music) {
					$error['upload_song'] = '';

					$song_data = array($artist, ''.$post['song_title'][$song].'', $last_id, ''.$duration.'', $post['genre_selection'][$song]);
					$statement_music = $pdo->prepare("INSERT INTO `song` (artist_id_link, song_name, album_id_link, length, genre_id) VALUES (?, ?, ?, ?, ?)");
					$statement_music->execute($song_data);

					$stmt_song_id = $pdo->query("SELECT LAST_INSERT_ID()");
					$last_id_song = $stmt_song_id->fetchColumn();

					$new_path_music = '../music/song_'.$last_id_song.'.'.$ending;

					if ($statement_music && move_uploaded_file($old_path_music, $new_path_music)) {
						header("Location: ../artist_detail.php?artist_id=".$artist."&message=upload_successfull");
					}
					else {
						header("Location: ../add_new_album.php?artist_id='.$artist.'&message=song_not_uploaded");
					}
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



/**
 * save song changes // AJAX
 *
 * @param string $song_name
 * @param integer $genre_id
 * @param integer $song_id
*/
function save_song_changes($song_name, $genre_id, $song_id) {

	// includes
	include '../config.php';
	include '../includes/db.php';

	$statement = $pdo->prepare("UPDATE `song` SET song_name = :song_name, genre_id = :genre_id WHERE song_id = :song_id");
	$statement->execute(array('song_id' => $song_id, 'song_name' => $song_name, 'genre_id' => $genre_id));

}


/**
 * save album changes // AJAX
 *
 * @param string $album_name
 * @param integer $album_year
 * @param integer $album_id
*/
function save_album_changes($album_name, $album_year, $album_id) {

	// includes
	include '../config.php';
	include '../includes/db.php';

	$statement = $pdo->prepare("UPDATE `album` SET album_name = :album_name, album_year = :album_year WHERE album_id = :album_id");
	$statement->execute(array('album_id' => $album_id, 'album_name' => $album_name, 'album_year' => $album_year));

}



/**
 * save event changes // AJAX
 *
 * @param string $event_name
 * @param string $place
 * @param date $event_date
 * @param integer $event_id
*/
function save_event_changes($event_name, $place, $event_date, $event_id) {

	// includes
	include '../config.php';
	include '../includes/db.php';

	$statement = $pdo->prepare("UPDATE `events` SET event_name = :event_name, place = :place, event_date = :event_date WHERE id = :id");
	$statement->execute(array('id' => $event_id, 'event_name' => $event_name, 'place' => $place, 'event_date' => $event_date));

}



/**
 * save new event
 *
 * @param string $follow_unfollow
 * @param integer $artist
*/
function add_event($new_event_name, $new_place, $new_event_date) {

	// set artist id
	$artist = $_SESSION['user']['id'];

	// includes
	include '../config.php';
	include '../includes/db.php';

	// add new event
	$statement = $pdo->prepare("INSERT INTO `events` (artist_id_link, event_name, place, event_date) VALUES (?, ?, ?, ?)");
	$statement->execute(array($artist, $new_event_name, $new_place, $new_event_date));

	// redirect to events management
	header('Location: ../manage_events.php?artist_id='.$artist.'&message=true');

}



/**
 * delete entry out of db
 *
 * @param string $delete_from_table
 * @param integer $delete_id
*/
function delete_from($delete_from_table, $delete_id) {

	// includes
	include '../config.php';
	include '../includes/db.php';

	if ($delete_from_table == 'song') {
		// delete song
		$statement = $pdo->prepare("DELETE FROM `song` WHERE song_id = :song_id");
		$statement->execute(array('song_id' => $delete_id));
	}

	if ($delete_from_table == 'album') {
		// delete album
		$query = $pdo->prepare('DELETE FROM '.$delete_from_table.' WHERE album_id = :album_id');
		$query->bindValue(':album_id', $delete_id);
		$query->execute();
	}

}

?>
