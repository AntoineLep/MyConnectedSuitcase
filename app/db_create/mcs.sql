-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 06, 2016 at 01:43 PM
-- Server version: 5.7.11
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mcs`
--
DROP DATABASE `mcs`;
CREATE DATABASE IF NOT EXISTS `mcs` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `mcs`;

-- --------------------------------------------------------

--
-- Table structure for table `destination`
--

DROP TABLE IF EXISTS `destination`;
CREATE TABLE `destination` (
  `id` int(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `lat` varchar(30) NOT NULL,
  `lng` varchar(30) NOT NULL,
  `description` text,
  `startDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `id_transportation_type` int(10) NOT NULL,
  `id_trip` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `destination`
--

INSERT INTO `destination` (`id`, `name`, `lat`, `lng`, `description`, `startDate`, `endDate`, `id_transportation_type`, `id_trip`) VALUES
(1, 'Toulouse', '43.5937874', '1.4260094999999637', 'The pink city', '2016-08-26', '2016-08-31', 1, 2),
(2, 'Paris', '48.8606166', '2.312775399999964', 'City of lights', '2016-09-01', '2016-09-03', 1, 2),
(3, 'house', '43.61115840000001', '1.4211725000000115', 'The house', '2016-01-04', NULL, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

DROP TABLE IF EXISTS `image`;
CREATE TABLE `image` (
  `id` int(10) NOT NULL,
  `uri` varchar(250) NOT NULL,
  `description` text,
  `id_destination` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`id`, `uri`, `description`, `id_destination`) VALUES
(1, 'test/fake.jpg', NULL, 1),
(2, 'test/fake2.jpg', NULL, 1),
(3, 'test/fake3.jpg', 'This is a described fake :)', 2);

-- --------------------------------------------------------

--
-- Table structure for table `transportation_type`
--

DROP TABLE IF EXISTS `transportation_type`;
CREATE TABLE `transportation_type` (
  `id` int(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `img_folder` varchar(200) NOT NULL,
  `img_prefix` varchar(50) NOT NULL,
  `img_extension` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transportation_type`
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
-- Table structure for table `trip`
--

DROP TABLE IF EXISTS `trip`;
CREATE TABLE `trip` (
  `id` int(100) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text,
  `id_user` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trip`
--

INSERT INTO `trip` (`id`, `name`, `description`, `id_user`) VALUES
(2, 'Euro Tour', 'Europe tour with interrail pass', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `login` varchar(200) NOT NULL,
  `passwd` varchar(200) NOT NULL,
  `mail` varchar(250) NOT NULL,
  `registred_date` date NOT NULL,
  `activation_key` varchar(250) DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `login`, `passwd`, `mail`, `registred_date`, `activation_key`, `status`) VALUES
(1, 'AntoineLep', '$2y$10$ZykoOqQ7hkgFhzkEaPxRE.22vgjFsbNQI59/OfRu.9KP3bXsGJMaK', 'leprevost.antoine@gmail.com', '2016-09-06', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `destination`
--
ALTER TABLE `destination`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_transportation_type` (`id_transportation_type`),
  ADD KEY `id_trip` (`id_trip`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_destination` (`id_destination`);

--
-- Indexes for table `transportation_type`
--
ALTER TABLE `transportation_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trip`
--
ALTER TABLE `trip`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `destination`
--
ALTER TABLE `destination`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `transportation_type`
--
ALTER TABLE `transportation_type`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `trip`
--
ALTER TABLE `trip`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `destination`
--
ALTER TABLE `destination`
  ADD CONSTRAINT `destination_ibfk_1` FOREIGN KEY (`id_transportation_type`) REFERENCES `transportation_type` (`id`),
  ADD CONSTRAINT `destination_ibfk_2` FOREIGN KEY (`id_trip`) REFERENCES `trip` (`id`);

--
-- Constraints for table `trip`
--
ALTER TABLE `trip`
  ADD CONSTRAINT `trip_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
