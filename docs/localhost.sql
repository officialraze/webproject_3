-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Erstellungszeit: 11. Okt 2019 um 23:55
-- Server-Version: 5.6.34-log
-- PHP-Version: 7.1.5

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

CREATE TABLE `album` (
  `album_id` int(11) NOT NULL,
  `album_name` varchar(255) NOT NULL,
  `album_year` int(4) NOT NULL,
  `artist_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `album`
--

INSERT INTO `album` (`album_id`, `album_name`, `album_year`, `artist_id`) VALUES
(1, 'Lost - Single', 2019, 1),
(2, 'Digital World', 2018, 1),
(3, 'We Could Be - Single', 2019, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `artist`
--

CREATE TABLE `artist` (
  `artist_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `artist_firstname` varchar(255) NOT NULL,
  `artist_lastname` varchar(255) NOT NULL,
  `biography` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `artist`
--

INSERT INTO `artist` (`artist_id`, `user_id`, `artist_firstname`, `artist_lastname`, `biography`) VALUES
(1, 1, 'raze.exe', '', 'raze.exe is a 19 year old swiss producer who started making music in 2012. Inspired from artists like Virtual Riot or Skrillex, he\'s now making similar EDM music. His main genre is Future Bass but is also known for his few Dubstep and Glitch Hop songs. His song \'Ocean\' starts to get known.');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `following_artist`
--

CREATE TABLE `following_artist` (
  `user_id_link` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `genre`
--

CREATE TABLE `genre` (
  `genre_id` int(11) NOT NULL,
  `genre_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `genre`
--

INSERT INTO `genre` (`genre_id`, `genre_name`) VALUES
(1, 'Future Bass');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `livestream`
--

CREATE TABLE `livestream` (
  `livestream_id` int(11) NOT NULL,
  `livestream_name` varchar(255) NOT NULL,
  `livestream_url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `playlist`
--

CREATE TABLE `playlist` (
  `playlist_id` int(11) NOT NULL,
  `playlist_name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `playlist_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `playlist_song` (
  `playlist_id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `playlist_song`
--

INSERT INTO `playlist_song` (`playlist_id`, `song_id`) VALUES
(1, 1),
(1, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `saved_songs`
--

CREATE TABLE `saved_songs` (
  `user_id_link` int(11) NOT NULL,
  `song_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `saved_songs`
--

INSERT INTO `saved_songs` (`user_id_link`, `song_id`) VALUES
(1, 1),
(1, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `song`
--

CREATE TABLE `song` (
  `song_id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `song_name` varchar(255) NOT NULL,
  `album_id` int(11) NOT NULL,
  `length` varchar(255) NOT NULL,
  `genre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `song`
--

INSERT INTO `song` (`song_id`, `artist_id`, `song_name`, `album_id`, `length`, `genre_id`) VALUES
(1, 1, 'Lost', 1, '03:18', 1),
(2, 1, 'Ocean', 2, '02:14', 1),
(5, 1, 'Ambient', 2, '02:37', 1),
(6, 1, 'Bells', 2, '02:18', 1),
(7, 1, 'We Could Be', 3, '02:07', 1),
(8, 1, 'Claws', 2, '02:48', 1),
(9, 1, 'Goodbye', 2, '01:50', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_token` varchar(255) NOT NULL,
  `is_artist` int(1) NOT NULL,
  `has_darkmode` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `firstname`, `lastname`, `password_hash`, `password_token`, `is_artist`, `has_darkmode`) VALUES
(1, 'molvin95', 'molvinlauber@gmail.com', 'Melvin', 'Lauber', '$2y$10$kTzuINN0JEYWwZCH2cJfHO4nbtXuYyp0VGROPtVMlgX/U/W1O0dpa', '1234', 1, 1);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`album_id`);

--
-- Indizes für die Tabelle `artist`
--
ALTER TABLE `artist`
  ADD PRIMARY KEY (`artist_id`),
  ADD KEY `artist_fk0` (`user_id`);

--
-- Indizes für die Tabelle `following_artist`
--
ALTER TABLE `following_artist`
  ADD KEY `following_artist_fk0` (`user_id_link`),
  ADD KEY `following_artist_fk1` (`artist_id`);

--
-- Indizes für die Tabelle `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`genre_id`);

--
-- Indizes für die Tabelle `livestream`
--
ALTER TABLE `livestream`
  ADD PRIMARY KEY (`livestream_id`);

--
-- Indizes für die Tabelle `playlist`
--
ALTER TABLE `playlist`
  ADD PRIMARY KEY (`playlist_id`),
  ADD KEY `playlist_fk0` (`user_id`);

--
-- Indizes für die Tabelle `playlist_song`
--
ALTER TABLE `playlist_song`
  ADD KEY `playlist_song_fk0` (`playlist_id`),
  ADD KEY `playlist_song_fk1` (`song_id`);

--
-- Indizes für die Tabelle `saved_songs`
--
ALTER TABLE `saved_songs`
  ADD KEY `saved_songs_fk0` (`user_id_link`),
  ADD KEY `saved_songs_fk1` (`song_id`);

--
-- Indizes für die Tabelle `song`
--
ALTER TABLE `song`
  ADD PRIMARY KEY (`song_id`),
  ADD KEY `song_fk0` (`artist_id`),
  ADD KEY `song_fk1` (`album_id`),
  ADD KEY `song_fk2` (`genre_id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `album`
--
ALTER TABLE `album`
  MODIFY `album_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT für Tabelle `artist`
--
ALTER TABLE `artist`
  MODIFY `artist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `genre`
--
ALTER TABLE `genre`
  MODIFY `genre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `livestream`
--
ALTER TABLE `livestream`
  MODIFY `livestream_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `playlist`
--
ALTER TABLE `playlist`
  MODIFY `playlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `song`
--
ALTER TABLE `song`
  MODIFY `song_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints der exportierten Tabellen
--

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
