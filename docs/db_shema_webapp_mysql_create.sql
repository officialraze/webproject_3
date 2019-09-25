CREATE TABLE `users` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`username` varchar(255) NOT NULL UNIQUE,
	`email` varchar(255) NOT NULL UNIQUE,
	`firstname` varchar(255) NOT NULL,
	`lastname` varchar(255) NOT NULL,
	`password_hash` varchar(255) NOT NULL,
	`password_token` varchar(255) NOT NULL,
	`is_artist` int(1) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `song` (
	`song_id` int NOT NULL AUTO_INCREMENT,
	`artist_id` int NOT NULL,
	`song_name` varchar(255) NOT NULL,
	`album_id` int NOT NULL,
	`length` varchar(255) NOT NULL,
	`genre_id` int NOT NULL,
	PRIMARY KEY (`song_id`)
);

CREATE TABLE `artist` (
	`artist_id` int NOT NULL AUTO_INCREMENT,
	`user_id` int NOT NULL,
	`artist_firstname` varchar(255) NOT NULL,
	`artist_lastname` varchar(255) NOT NULL,
	`biography` TEXT NOT NULL,
	PRIMARY KEY (`artist_id`)
);

CREATE TABLE `album` (
	`album_id` int NOT NULL AUTO_INCREMENT,
	`album_name` varchar(255) NOT NULL,
	`album_year` int(4) NOT NULL,
	PRIMARY KEY (`album_id`)
);

CREATE TABLE `genre` (
	`genre_id` int NOT NULL AUTO_INCREMENT,
	`genre_name` varchar(255) NOT NULL,
	PRIMARY KEY (`genre_id`)
);

CREATE TABLE `livestream` (
	`livestream_id` int NOT NULL AUTO_INCREMENT,
	`livestream_name` varchar(255) NOT NULL,
	`livestream_url` TEXT NOT NULL,
	PRIMARY KEY (`livestream_id`)
);

CREATE TABLE `playlist` (
	`playlist_id` int NOT NULL AUTO_INCREMENT,
	`playlist_name` varchar(255) NOT NULL,
	`user_id` int NOT NULL,
	`playlist_description` TEXT NOT NULL,
	PRIMARY KEY (`playlist_id`)
);

CREATE TABLE `playlist_song` (
	`playlist_id` int NOT NULL,
	`song_id` int NOT NULL
);

CREATE TABLE `saved_songs` (
	`user_id_link` INT NOT NULL,
	`song_id` INT NOT NULL
);

CREATE TABLE `following_artist` (
	`user_id_link` INT NOT NULL,
	`artist_id` INT NOT NULL
);

ALTER TABLE `song` ADD CONSTRAINT `song_fk0` FOREIGN KEY (`artist_id`) REFERENCES `artist`(`artist_id`);

ALTER TABLE `song` ADD CONSTRAINT `song_fk1` FOREIGN KEY (`album_id`) REFERENCES `album`(`album_id`);

ALTER TABLE `song` ADD CONSTRAINT `song_fk2` FOREIGN KEY (`genre_id`) REFERENCES `genre`(`genre_id`);

ALTER TABLE `artist` ADD CONSTRAINT `artist_fk0` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`);

ALTER TABLE `playlist` ADD CONSTRAINT `playlist_fk0` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`);

ALTER TABLE `playlist_song` ADD CONSTRAINT `playlist_song_fk0` FOREIGN KEY (`playlist_id`) REFERENCES `playlist`(`playlist_id`);

ALTER TABLE `playlist_song` ADD CONSTRAINT `playlist_song_fk1` FOREIGN KEY (`song_id`) REFERENCES `song`(`song_id`);

ALTER TABLE `saved_songs` ADD CONSTRAINT `saved_songs_fk0` FOREIGN KEY (`user_id_link`) REFERENCES `users`(`id`);

ALTER TABLE `saved_songs` ADD CONSTRAINT `saved_songs_fk1` FOREIGN KEY (`song_id`) REFERENCES `song`(`song_id`);

ALTER TABLE `following_artist` ADD CONSTRAINT `following_artist_fk0` FOREIGN KEY (`user_id_link`) REFERENCES `users`(`id`);

ALTER TABLE `following_artist` ADD CONSTRAINT `following_artist_fk1` FOREIGN KEY (`artist_id`) REFERENCES `artist`(`artist_id`);
