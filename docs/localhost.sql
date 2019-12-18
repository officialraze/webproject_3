-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Erstellungszeit: 18. Dez 2019 um 15:00
-- Server-Version: 5.7.26
-- PHP-Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Datenbank: `db_music_player`
--
DROP DATABASE IF EXISTS `db_music_player`;
CREATE DATABASE IF NOT EXISTS `db_music_player` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `db_music_player`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `album`
--

CREATE TABLE IF NOT EXISTS `album` (
  `album_id` int(11) NOT NULL AUTO_INCREMENT,
  `album_name` varchar(255) NOT NULL,
  `album_year` int(4) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `path_to_image` varchar(255) NOT NULL,
  PRIMARY KEY (`album_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `album`
--

INSERT INTO `album` (`album_id`, `album_name`, `album_year`, `artist_id`, `path_to_image`) VALUES
(24, 'moonlight', 2020, 1, 'artist_1.jpg');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `artist`
--

CREATE TABLE IF NOT EXISTS `artist` (
  `artist_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `artist_firstname` varchar(255) NOT NULL,
  `artist_lastname` varchar(255) NOT NULL,
  `biography` text NOT NULL,
  PRIMARY KEY (`artist_id`),
  KEY `artist_fk0` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `artist`
--

INSERT INTO `artist` (`artist_id`, `user_id`, `artist_firstname`, `artist_lastname`, `biography`) VALUES
(1, 1, 'raze.exe', '', 'raze.exe is a 19 year old swiss producer who started making music in 2012. Inspired from artists like Virtual Riot or Skrillex, he\'s now making similar EDM music. His main genre is Future Bass but is also known for his few Dubstep and Glitch Hop songs. His song \'Ocean\' starts to get known.');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `artist_id_link` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `place` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `artist_id_link` (`artist_id_link`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `events`
--

INSERT INTO `events` (`id`, `artist_id_link`, `event_name`, `place`, `event_date`) VALUES
(3, 1, 'test', 'test', '2020-02-20');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `following_artist`
--

CREATE TABLE IF NOT EXISTS `following_artist` (
  `user_id_link` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL,
  KEY `following_artist_fk0` (`user_id_link`),
  KEY `following_artist_fk1` (`artist_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `following_artist`
--

INSERT INTO `following_artist` (`user_id_link`, `artist_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `playlist`
--

CREATE TABLE IF NOT EXISTS `playlist` (
  `playlist_id` int(11) NOT NULL AUTO_INCREMENT,
  `playlist_name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `playlist_description` text NOT NULL,
  PRIMARY KEY (`playlist_id`),
  KEY `playlist_fk0` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `playlist`
--

INSERT INTO `playlist` (`playlist_id`, `playlist_name`, `user_id`, `playlist_description`) VALUES
(1, 'newest of raze', 1, 'Always listen to the newest releases of raze.exe'),
(2, 'Top 50 EDM Charts', 1, 'Listen to the top 50 of EDM tracks.');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `playlist_song`
--

CREATE TABLE IF NOT EXISTS `playlist_song` (
  `playlist_id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL,
  KEY `playlist_song_fk0` (`playlist_id`),
  KEY `playlist_song_fk1` (`song_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `saved_songs`
--

CREATE TABLE IF NOT EXISTS `saved_songs` (
  `user_id_link` int(11) NOT NULL,
  `song_id` int(11) NOT NULL,
  KEY `saved_songs_fk0` (`user_id_link`),
  KEY `saved_songs_fk1` (`song_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `song`
--

CREATE TABLE IF NOT EXISTS `song` (
  `song_id` int(11) NOT NULL AUTO_INCREMENT,
  `artist_id_link` int(11) NOT NULL,
  `song_name` varchar(255) NOT NULL,
  `album_id_link` int(11) NOT NULL,
  `length` varchar(255) NOT NULL,
  `genre_id` int(11) NOT NULL,
  PRIMARY KEY (`song_id`),
  KEY `song_fk0` (`artist_id_link`),
  KEY `song_fk2` (`genre_id`),
  KEY `song_fk1` (`album_id_link`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `song`
--

INSERT INTO `song` (`song_id`, `artist_id_link`, `song_name`, `album_id_link`, `length`, `genre_id`) VALUES
(28, 1, 'moonlight', 24, '00:24', 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_token` varchar(255) NOT NULL,
  `is_artist` int(1) NOT NULL,
  `has_darkmode` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `firstname`, `lastname`, `password_hash`, `password_token`, `is_artist`, `has_darkmode`) VALUES
(1, 'molvin95', 'molvinlauber@gmail.com', 'Melvin', 'Lauber', '$2y$10$Ip2e0mRFuXsysKTpi2m7eutFtjE.y1JM9qChKTzQIaXFjl/2lfqjO', '89d2f609914bc2f24c26df162b361d08', 1, 0),
(2, 'david.clausen', 'davidclausen2@lernende.bfo-vs.ch', 'David', 'Clausen', '$2y$10$h51xi20m3d6MvY8O16Y1A.6FB5vOV5R1uq9e.OWQ4KIXX.PftMUEu', 'e8bac3df99be1fb31c13a79f7a5bea04', 0, 0);

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `artist`
--
ALTER TABLE `artist`
  ADD CONSTRAINT `artist_fk0` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints der Tabelle `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`artist_id_link`) REFERENCES `artist` (`artist_id`);

--
-- Constraints der Tabelle `following_artist`
--
ALTER TABLE `following_artist`
  ADD CONSTRAINT `following_artist_fk0` FOREIGN KEY (`user_id_link`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `following_artist_fk1` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`artist_id`);

--
-- Constraints der Tabelle `playlist`
--
ALTER TABLE `playlist`
  ADD CONSTRAINT `playlist_fk0` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints der Tabelle `playlist_song`
--
ALTER TABLE `playlist_song`
  ADD CONSTRAINT `playlist_song_fk0` FOREIGN KEY (`playlist_id`) REFERENCES `playlist` (`playlist_id`),
  ADD CONSTRAINT `playlist_song_fk1` FOREIGN KEY (`song_id`) REFERENCES `song` (`song_id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `saved_songs`
--
ALTER TABLE `saved_songs`
  ADD CONSTRAINT `saved_songs_fk0` FOREIGN KEY (`user_id_link`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `saved_songs_fk1` FOREIGN KEY (`song_id`) REFERENCES `song` (`song_id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `song`
--
ALTER TABLE `song`
  ADD CONSTRAINT `song_fk0` FOREIGN KEY (`artist_id_link`) REFERENCES `artist` (`artist_id`),
  ADD CONSTRAINT `song_fk1` FOREIGN KEY (`album_id_link`) REFERENCES `album` (`album_id`) ON DELETE CASCADE;
