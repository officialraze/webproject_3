-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 25. Sep 2019 um 16:23
-- Server-Version: 10.1.38-MariaDB
-- PHP-Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

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
  `artist_id` int(11) NOT NULL,
  `album_id` int(11) NOT NULL AUTO_INCREMENT,
  `album_name` varchar(255) NOT NULL,
  `album_year` int(4) NOT NULL,
  PRIMARY KEY (`album_id`),
  KEY `artist_id` (`artist_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `album`
--

INSERT INTO `album` (`artist_id`, `album_id`, `album_name`, `album_year`) VALUES
(1, 1, 'Lost - Single', 2019);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `artist`
--

INSERT INTO `artist` (`artist_id`, `user_id`, `artist_firstname`, `artist_lastname`, `biography`) VALUES
(1, 1, 'raze.exe', '', 'raze.exe is a 19 years old swiss producer.');

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

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `genre`
--

CREATE TABLE IF NOT EXISTS `genre` (
  `genre_id` int(11) NOT NULL AUTO_INCREMENT,
  `genre_name` varchar(255) NOT NULL,
  PRIMARY KEY (`genre_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `genre`
--

INSERT INTO `genre` (`genre_id`, `genre_name`) VALUES
(1, 'Future Bass');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `livestream`
--

CREATE TABLE IF NOT EXISTS `livestream` (
  `livestream_id` int(11) NOT NULL AUTO_INCREMENT,
  `livestream_name` varchar(255) NOT NULL,
  `livestream_url` text NOT NULL,
  PRIMARY KEY (`livestream_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `playlist`
--

INSERT INTO `playlist` (`playlist_id`, `playlist_name`, `user_id`, `playlist_description`) VALUES
(1, 'molvin', 1, 'songs of molvin');

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

--
-- Daten für Tabelle `playlist_song`
--

INSERT INTO `playlist_song` (`playlist_id`, `song_id`) VALUES
(1, 2);

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

--
-- Daten für Tabelle `saved_songs`
--

INSERT INTO `saved_songs` (`user_id_link`, `song_id`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `song`
--

CREATE TABLE IF NOT EXISTS `song` (
  `song_id` int(11) NOT NULL AUTO_INCREMENT,
  `artist_id` int(11) NOT NULL,
  `song_name` varchar(255) NOT NULL,
  `album_id` int(11) NOT NULL,
  `length` varchar(255) NOT NULL,
  `genre_id` int(11) NOT NULL,
  PRIMARY KEY (`song_id`),
  KEY `song_fk0` (`artist_id`),
  KEY `song_fk1` (`album_id`),
  KEY `song_fk2` (`genre_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `song`
--

INSERT INTO `song` (`song_id`, `artist_id`, `song_name`, `album_id`, `length`, `genre_id`) VALUES
(2, 1, 'Lost', 1, '03:17', 1);

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `firstname`, `lastname`, `password_hash`, `password_token`, `is_artist`) VALUES
(1, 'melvin.lauber', 'molvinlauber@gmail.com', 'Melvin', 'Lauber', '$2y$10$Mw4tBnzqEH4ME57esdBb.OBcVFQGZHY/RC/dQPz5Lrg.jGa3tDjUS', '1234', 1);

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `album_ibfk_1` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`artist_id`);

--
-- Constraints der Tabelle `artist`
--
ALTER TABLE `artist`
  ADD CONSTRAINT `artist_fk0` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

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
  ADD CONSTRAINT `playlist_song_fk1` FOREIGN KEY (`song_id`) REFERENCES `song` (`song_id`);

--
-- Constraints der Tabelle `saved_songs`
--
ALTER TABLE `saved_songs`
  ADD CONSTRAINT `saved_songs_fk0` FOREIGN KEY (`user_id_link`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `saved_songs_fk1` FOREIGN KEY (`song_id`) REFERENCES `song` (`song_id`);

--
-- Constraints der Tabelle `song`
--
ALTER TABLE `song`
  ADD CONSTRAINT `song_fk0` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`artist_id`),
  ADD CONSTRAINT `song_fk1` FOREIGN KEY (`album_id`) REFERENCES `album` (`album_id`),
  ADD CONSTRAINT `song_fk2` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`genre_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
