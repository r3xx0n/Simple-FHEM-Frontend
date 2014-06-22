-- phpMyAdmin SQL Dump
-- version 4.2.2deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 22. Jun 2014 um 17:20
-- Server Version: 5.5.37-1
-- PHP-Version: 5.6.0beta3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Datenbank: `cms`
--
CREATE DATABASE IF NOT EXISTS `cms` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `cms`;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `cms`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
`id` int(10) unsigned NOT NULL COMMENT 'Fortlaufende Nummer',
  `menu` varchar(32) NOT NULL COMMENT 'Titel, der im Menü auftaucht',
  `link` varchar(32) NOT NULL COMMENT 'Name der php Datei, welche später verlinkt werden soll.',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Sortierreihenfolge',
  `active` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Seite sichtbar oder nicht.'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Seiten des CMS werden hier für das Menü definiert' AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `pages`
--

INSERT INTO `pages` (`id`, `menu`, `link`, `sort`, `active`) VALUES
(1, 'Home', 'home', 1, 1),
(2, 'Rooms', 'rooms', 2, 1),
(3, 'Timer', 'timer', 3, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(10) unsigned NOT NULL,
  `username` varchar(32) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `email` varchar(128) NOT NULL,
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `username`, `hash`, `email`, `disabled`) VALUES
(1, 'fhem', '$2y$10$RCLkLOGYidcB8lnZkyUiUOMKyx7L3laa/J8UUEvZYTN2vuz9f/lPG', '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`,`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Fortlaufende Nummer',AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
