-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Gegenereerd op: 20 mrt 2017 om 11:46
-- Serverversie: 10.1.16-MariaDB
-- PHP-versie: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `forum`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `comments`
--

CREATE TABLE `comments` (
  `id` int(4) NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `score` int(5) NOT NULL,
  `status` int(1) NOT NULL,
  `class` int(3) DEFAULT NULL,
  `date` date NOT NULL,
  `user_id` int(4) NOT NULL,
  `upper_level_id` int(4) NOT NULL,
  `user_level_req_vieuw` int(3) NOT NULL,
  `user_level_req_edit` int(3) NOT NULL,
  `banned_by_user_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `main_topics`
--

CREATE TABLE `main_topics` (
  `id` int(4) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` text,
  `status` int(1) DEFAULT '0',
  `user_level_req_vieuw` int(11) NOT NULL,
  `user_level_req_edit` int(11) NOT NULL,
  `banned_by_user_id` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `posts`
--

CREATE TABLE `posts` (
  `id` int(4) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `user_id` int(4) NOT NULL,
  `content` text NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `rating` int(5) NOT NULL DEFAULT '0',
  `upper_level_id` int(4) NOT NULL,
  `date` date NOT NULL,
  `user_level_req_vieuw` int(3) NOT NULL,
  `user_level_req_edit` int(3) NOT NULL,
  `banned_by_user_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `sub_topics`
--

CREATE TABLE `sub_topics` (
  `id` int(5) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(50) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `user_level_req_vieuw` int(1) NOT NULL,
  `user_level_req_edit` int(1) NOT NULL,
  `user_id` int(4) NOT NULL,
  `upper_level_id` int(4) NOT NULL,
  `banned_by_user_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(4) NOT NULL,
  `login_name` varchar(50) NOT NULL,
  `display_name` varchar(20) NOT NULL,
  `level` int(1) NOT NULL DEFAULT '8',
  `png` varchar(255) DEFAULT NULL,
  `bio` text,
  `info` text,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `comment_footer` text,
  `class` varchar(255) DEFAULT NULL,
  `popularity_rank` int(1) DEFAULT '0',
  `status` varchar(50) DEFAULT NULL,
  `banned_by_user_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `main_topics`
--
ALTER TABLE `main_topics`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `sub_topics`
--
ALTER TABLE `sub_topics`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login_name` (`login_name`),
  ADD UNIQUE KEY `display_name` (`display_name`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT voor een tabel `main_topics`
--
ALTER TABLE `main_topics`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT voor een tabel `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT voor een tabel `sub_topics`
--
ALTER TABLE `sub_topics`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
