-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Lun 18 Mai 2015 à 10:51
-- Version du serveur: 5.5.41-0ubuntu0.14.04.1
-- Version de PHP: 5.5.9-1ubuntu4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `tp_commun`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(64) COLLATE utf8_bin NOT NULL,
  `content` varchar(8192) COLLATE utf8_bin NOT NULL,
  `author_id` int(11) NOT NULL,
  `time_create` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `time_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `category` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) NOT NULL,
  `author-id` int(11) NOT NULL,
  `email` varchar(64) COLLATE utf8_bin NOT NULL,
  `content` varchar(512) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `guestbook`
--

CREATE TABLE IF NOT EXISTS `guestbook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(512) COLLATE utf8_bin NOT NULL,
  `author_id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `civility` varchar(4) COLLATE utf8_bin NOT NULL,
  `pseudo` varchar(32) COLLATE utf8_bin NOT NULL,
  `firstname` varchar(32) COLLATE utf8_bin NOT NULL,
  `lastname` varchar(32) COLLATE utf8_bin NOT NULL,
  `password` varchar(32) COLLATE utf8_bin NOT NULL,
  `email` varchar(64) COLLATE utf8_bin NOT NULL,
  `street` varchar(64) COLLATE utf8_bin NOT NULL,
  `zipcode` int(16) NOT NULL,
  `city` varchar(32) COLLATE utf8_bin NOT NULL,
  `country` varchar(32) COLLATE utf8_bin NOT NULL,
  `phone` int(20) NOT NULL,
  `time_register` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `time_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=9 ;

--
-- Contenu de la table `member`
--

INSERT INTO `member` (`id`, `civility`, `pseudo`, `firstname`, `lastname`, `password`, `email`, `street`, `zipcode`, `city`, `country`, `phone`, `time_register`, `time_update`) VALUES
(6, '', 'Plegis', 'Nicolas', 'Marchand', '123456', 'nicomar1@hotmail.fr', '15 a place Jean Macé', 67100, 'Strasbourg', 'France', 0, '2015-05-15 13:27:02', '2015-05-16 17:46:22'),
(7, '', 'PtitBiscuit', 'Petit', 'Biscuit', 'PainDepice', 'gateau@gouter.fr', '52 chemin du chocolat', 88230, 'Fraize', 'France', 0, '2015-05-18 11:27:42', '2015-05-21 08:13:08'),
(8, '', 'popo', 'Robert', 'Carlile', '007008009', 'agentdu67@grosmail.us', '2625th main street', 1264, 'New York', 'USA', 0, '2015-01-25 15:42:35', '2015-04-29 22:01:52');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
