-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2016 at 02:21 PM
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
(2, 'Paris', '48.8606166', '2.312775399999964', 'City of lights', '2016-09-01', '2016-09-03', 2, 2),
(3, 'house', '43.61115840000001', '1.4211725000000115', 'The house', '2016-01-04', NULL, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `id` int(10) NOT NULL,
  `caption` varchar(200) DEFAULT NULL,
  `filename` varchar(250) NOT NULL,
  `description` text,
  `id_destination` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`id`, `caption`, `filename`, `description`, `id_destination`) VALUES
(1, 'fishing pont neuf', '1b730a3ea99908aca1fc0edad029e434f349c59714e848183601b72a05b4e1b5.jpg', '', 1),
(2, 'fishing canal du midi', 'd2d95580bcf1be0cbabe1468887b83067a1ed17816d00f22cec0d6f5d34747f7.jpg', '', 1),
(3, 'Paris best site seing', '7a49c6e68f2de8c1912c79856428f14d80ed8f3ad8ef8fc3d8eed4b0241122b2.png', 'This is a described fake :)', 2);

-- --------------------------------------------------------

--
-- Table structure for table `transportation_type`
--

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
(2, 'Euro Tour', 'Europe tour with interrail pass', 1),
(3, 'Last trip', 'My last trip', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `email` varchar(250) NOT NULL,
  `registred_date` date NOT NULL,
  `activation_key` varchar(250) DEFAULT NULL,
  `image_folder` varchar(200) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `registred_date`, `activation_key`, `image_folder`, `status`) VALUES
(1, 'AntoineLep', '$2y$10$ZykoOqQ7hkgFhzkEaPxRE.22vgjFsbNQI59/OfRu.9KP3bXsGJMaK', 'leprevost.antoine@gmail.com', '2016-09-06', '325622335218f97f9b94c4705ea624bd', 'AntoineLep', 1),
(6, 'AntoinelLep', '$2y$10$J4vCtR1v.8JNHeNTa0IlfeKYrb3hn/c10sAUM83VKEr28ipuc8cz6', 'leprevost.antoinel@gmail.com', '2016-09-22', 'fa4f647018dd1da3536d1ec95296429e', '25347784939fe92c27d9fe4277b94373', 1);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mail` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `destination`
--
ALTER TABLE `destination`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `transportation_type`
--
ALTER TABLE `transportation_type`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `trip`
--
ALTER TABLE `trip`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `destination`
--
ALTER TABLE `destination`
  ADD CONSTRAINT `destination_ibfk_1` FOREIGN KEY (`id_transportation_type`) REFERENCES `transportation_type` (`id`),
  ADD CONSTRAINT `destination_ibfk_2` FOREIGN KEY (`id_trip`) REFERENCES `trip` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `image_ibfk_1` FOREIGN KEY (`id_destination`) REFERENCES `destination` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `trip`
--
ALTER TABLE `trip`
  ADD CONSTRAINT `trip_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
