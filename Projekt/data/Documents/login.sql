-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 24 okt 2014 kl 19:39
-- Serverversion: 5.6.15-log
-- PHP-version: 5.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `login`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `pictures`
--

CREATE TABLE IF NOT EXISTS `pictures` (
  `imgId` int(11) NOT NULL AUTO_INCREMENT,
  `imgName` varchar(255) NOT NULL,
  `Comment` varchar(500) NOT NULL,
  PRIMARY KEY (`imgId`),
  UNIQUE KEY `imgName` (`imgName`),
  KEY `imgName_2` (`imgName`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=183 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(111) NOT NULL,
  `autologin` varchar(111) NOT NULL,
  `AdminId` int(11) NOT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `username` (`username`),
  KEY `userId` (`userId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=194 ;

--
-- Dumpning av Data i tabell `user`
--

INSERT INTO `user` (`userId`, `username`, `password`, `autologin`, `AdminId`) VALUES
(174, 'Admin', '$2a$10$ttNDjFJKc5v997p57G1ULuyQj7Wbv0zzZUnza76JJ5dwMa/eiqt1C', '1416618026', 1),
(185, 'sahib', '$2a$10$/CrWY8a9C92s.zu7C5OjUeqy5/31/.LS31a0xbUw90OLsTOpoOhFa', '1416506150', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
