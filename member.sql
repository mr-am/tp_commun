-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mer 20 Mai 2015 à 10:32
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=24 ;

--
-- Contenu de la table `member`
--

INSERT INTO `member` (`id`, `civility`, `pseudo`, `firstname`, `lastname`, `password`, `email`, `street`, `zipcode`, `city`, `country`, `phone`, `time_register`, `time_update`) VALUES
(9, 'M', 'moi', 'myfirstname', 'mylastname', 'monmdp', '', 'mystreet', 10000, 'strasbourg', 'france', 102030405, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'M', 'moioiuouy', 'myfirstname', 'mylastname', 'monmdp', '', 'mystreet', 10000, 'strasbourg', 'france', 102030405, '2015-05-18 13:37:28', '0000-00-00 00:00:00'),
(11, 'non', 'admin', 'fr''iu', 'patrick', 'admin', '', 'wvbxbfx', 65201, 'vcbxcvxb', 'xcvbcbcb', 102030405, '2015-05-18 13:45:16', '0000-00-00 00:00:00'),
(12, '', 'admin', 'fr''iu', 'patrick', 'admin', '', 'wvbxbfx', 65201, 'vcbxcvxb', 'xcvbcbcb', 102030405, '2015-05-18 13:48:03', '0000-00-00 00:00:00'),
(13, '', 'admin', 'fr''iu', 'patrick', 'admin', '', 'wvbxbfx', 65201, 'vcbxcvxb', 'xcvbcbcb', 102030405, '2015-05-18 13:48:30', '0000-00-00 00:00:00'),
(14, '', 'admin', 'fr''iu', 'patrick', 'admin', '', 'wvbxbfx', 65201, 'vcbxcvxb', 'xcvbcbcb', 102030405, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, '', 'admin', 'fr''iu', 'patrick', 'admin', '', 'wvbxbfx', 65201, 'vcbxcvxb', 'xcvbcbcb', 102030405, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, '', 'admin', 'fr''iu', 'patrick', 'admin', '', 'wvbxbfx', 65201, 'vcbxcvxb', 'xcvbcbcb', 102030405, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, '', 'admin', 'fr''iu', 'patrick', 'admin', '', 'wvbxbfx', 65201, 'vcbxcvxb', 'xcvbcbcb', 102030405, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 'non', 'root', 'neff', 'patrick', 'root', '', 'wvbxbfx', 65201, 'vcbxcvxb', 'xcvbcbcb', 102030405, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 'Mme', 'hgfhgfh', 'neff', 'xcvbxcvb', ';,nb;', '', 'wvbxbfx', 65201, 'vcbxcvxb', 'xcvbcbcb', 102030405, '2015-05-19 10:02:28', '0000-00-00 00:00:00'),
(20, '', 'dfghgf', '', '', 'dfghgfd', '', '', 0, '', '', 0, '2015-05-19 11:46:10', '0000-00-00 00:00:00'),
(21, '', 'moi', '', '', 'monmdp', '', '', 0, '', '', 0, '2015-05-19 11:50:51', '0000-00-00 00:00:00'),
(22, '', 'moi', '', '', 'hfhgfhjgf', '', '', 0, '', '', 0, '2015-05-19 11:51:20', '0000-00-00 00:00:00'),
(23, 'Mme', 'gfdsdf', 'dgfh', 'gfhfdh', 'e0f6ea3214a164637daac7db409b0753', '', 'wvbxbfx', 65201, 'vcbxcvxb', 'xcvbcbcb', 102030405, '2015-05-20 08:07:53', '0000-00-00 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
