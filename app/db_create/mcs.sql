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

CREATE TABLE `mcs_destination` (
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

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `mcs_image` (
  `id` int(10) NOT NULL,
  `caption` varchar(200) DEFAULT NULL,
  `filename` varchar(250) NOT NULL,
  `description` text,
  `id_destination` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `transportation_type`
--

CREATE TABLE `mcs_transportation_type` (
  `id` int(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `img_folder` varchar(200) NOT NULL,
  `img_prefix` varchar(50) NOT NULL,
  `img_extension` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transportation_type`
--

INSERT INTO `mcs_transportation_type` (`id`, `name`, `img_folder`, `img_prefix`, `img_extension`) VALUES
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

CREATE TABLE `mcs_trip` (
  `id` int(100) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text,
  `id_user` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `mcs_user` (
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
-- Indexes for dumped tables
--

--
-- Indexes for table `destination`
--
ALTER TABLE `mcs_destination`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_transportation_type` (`id_transportation_type`),
  ADD KEY `id_trip` (`id_trip`);

--
-- Indexes for table `image`
--
ALTER TABLE `mcs_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_destination` (`id_destination`);

--
-- Indexes for table `transportation_type`
--
ALTER TABLE `mcs_transportation_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trip`
--
ALTER TABLE `mcs_trip`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `mcs_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mail` (`email`),
  ADD UNIQUE KEY `username` (`username`);


--
-- Constraints for table `destination`
--
ALTER TABLE `mcs_destination`
  ADD CONSTRAINT `mcs_destination_ibfk_1` FOREIGN KEY (`id_transportation_type`) REFERENCES `mcs_transportation_type` (`id`),
  ADD CONSTRAINT `mcs_destination_ibfk_2` FOREIGN KEY (`id_trip`) REFERENCES `mcs_trip` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `image`
--
ALTER TABLE `mcs_image`
  ADD CONSTRAINT `mcs_image_ibfk_1` FOREIGN KEY (`id_destination`) REFERENCES `mcs_destination` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `trip`
--
ALTER TABLE `mcs_trip`
  ADD CONSTRAINT `mcs_trip_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `mcs_user` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
