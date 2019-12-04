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

$_SESSION['playlist']['id'] = $_GET['playlist_id'];

if ($_SESSION['playlist']['id'] = TRUE) {
  $sql = "INSERT INTO playlist_song (playlist_id, song_id)
  VALUES ('John', 'Doe')";

  echo "Song erfolgreich abgespeichert";
}

?>
