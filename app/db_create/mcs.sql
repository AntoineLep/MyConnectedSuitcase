-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 12 Septembre 2016 à 01:59
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `mcs`
--
DROP DATABASE `mcs`;
CREATE DATABASE IF NOT EXISTS `mcs` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `mcs`;

-- --------------------------------------------------------

--
-- Structure de la table `destination`
--

DROP TABLE IF EXISTS `destination`;
CREATE TABLE IF NOT EXISTS `destination` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `lat` varchar(30) NOT NULL,
  `lng` varchar(30) NOT NULL,
  `description` text,
  `startDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `id_transportation_type` int(10) NOT NULL,
  `id_trip` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_transportation_type` (`id_transportation_type`),
  KEY `id_trip` (`id_trip`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `destination`
--

INSERT INTO `destination` (`id`, `name`, `lat`, `lng`, `description`, `startDate`, `endDate`, `id_transportation_type`, `id_trip`) VALUES
(1, 'Toulouse', '43.5937874', '1.4260094999999637', 'The pink city', '2016-08-26', '2016-08-31', 1, 2),
(2, 'Paris', '48.8606166', '2.312775399999964', 'City of lights', '2016-09-01', '2016-09-03', 2, 2),
(3, 'house', '43.61115840000001', '1.4211725000000115', 'The house', '2016-01-04', NULL, 2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

DROP TABLE IF EXISTS `image`;
CREATE TABLE IF NOT EXISTS `image` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `caption` varchar(200) DEFAULT NULL,
  `filename` varchar(250) NOT NULL,
  `description` text,
  `id_destination` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_destination` (`id_destination`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `image`
--

INSERT INTO `image` (`id`, `caption`, `filename`, `description`, `id_destination`) VALUES
(1, 'fishing in Egypt', 'fishing_egypte.jpg', NULL, 1),
(2, 'fishing at Sydney', 'PecheASydney.jpg', NULL, 1),
(3, '', 'test/fake3.jpg', 'This is a described fake :)', 2);

-- --------------------------------------------------------

--
-- Structure de la table `transportation_type`
--

DROP TABLE IF EXISTS `transportation_type`;
CREATE TABLE IF NOT EXISTS `transportation_type` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `img_folder` varchar(200) NOT NULL,
  `img_prefix` varchar(50) NOT NULL,
  `img_extension` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `transportation_type`
--

INSERT INTO `transportation_type` (`id`, `name`, `img_folder`, `img_prefix`, `img_extension`) VALUES
(1, 'Unspecified', '', '', ''),
(2, 'Car', '', '', ''),
(3, 'Plane', '', '', ''),
(4, 'Train', '', '', ''),
(5, 'Bike', '', '', ''),
(6, 'Boat', '', '', ''),
(7, 'Walk', '', '', ''),
(8, 'Motorbike', '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `trip`
--

DROP TABLE IF EXISTS `trip`;
CREATE TABLE IF NOT EXISTS `trip` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `description` text,
  `id_user` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `trip`
--

INSERT INTO `trip` (`id`, `name`, `description`, `id_user`) VALUES
(2, 'Euro Tour', 'Europe tour with interrail pass', 1),
(3, 'Last trip', 'My last trip', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(200) NOT NULL,
  `passwd` varchar(200) NOT NULL,
  `mail` varchar(250) NOT NULL,
  `registred_date` date NOT NULL,
  `activation_key` varchar(250) DEFAULT NULL,
  `image_folder` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `login`, `passwd`, `mail`, `registred_date`, `activation_key`, `image_folder`, `status`) VALUES
(1, 'AntoineLep', '$2y$10$ZykoOqQ7hkgFhzkEaPxRE.22vgjFsbNQI59/OfRu.9KP3bXsGJMaK', 'leprevost.antoine@gmail.com', '2016-09-06', NULL, 'AntoineLep', 1),
(2, 'test', 'test', 'test', '0000-00-00', NULL, '', 1);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `destination`
--
ALTER TABLE `destination`
  ADD CONSTRAINT `destination_ibfk_1` FOREIGN KEY (`id_transportation_type`) REFERENCES `transportation_type` (`id`),
  ADD CONSTRAINT `destination_ibfk_2` FOREIGN KEY (`id_trip`) REFERENCES `trip` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `image_ibfk_1` FOREIGN KEY (`id_destination`) REFERENCES `destination` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `trip`
--
ALTER TABLE `trip`
  ADD CONSTRAINT `trip_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
