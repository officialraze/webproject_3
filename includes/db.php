<?php
/*
// --------------------------
// Webprojekt 3.0
// Copyright Melvin Lauber
// --------------------------
*/

// set up connection to db
if ($config['home'] == TRUE) {
	$pdo = new PDO('mysql:host=localhost;dbname=db_music_player', 'root', 'root');
}
else if ($config['school'] == TRUE) {
	$pdo = new PDO('mysql:host=localhost;dbname=db_music_player', 'dbadmin', 'db123');
}
else {
	$pdo = new PDO('mysql:host=localhost;dbname=db_music_player', 'root', '');
}

?>
