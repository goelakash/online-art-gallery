-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2015 at 05:11 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `webtech`
--
CREATE DATABASE IF NOT EXISTS `webtech` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `webtech`;

-- --------------------------------------------------------

--
-- Table structure for table `bids`
--

CREATE TABLE IF NOT EXISTS `bids` (
  `id` varchar(10) NOT NULL,
  `bid` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bids`
--

INSERT INTO `bids` (`id`, `bid`, `username`, `date`) VALUES
('Leomon5535', 40000, 'goel@gmail.com', '2015-04-22 00:00:00'),
('Akaben5537', 44000, 'goel@gmail.com', '0000-00-00 00:00:00'),
('Craisl5537', 30000, 'user@user.com', '0000-00-00 00:00:00'),
('Sanbea5537', 60000, 'user@user.com', '0000-00-00 00:00:00'),
('Ms.lan5537', 35000, 'admin@admin.com', '0000-00-00 00:00:00'),
('Akahor5537', 22000, 'admin@admin.com', '0000-00-00 00:00:00'),
('Bunmon5537', 51000, 'admin@admin.com', '0000-00-00 00:00:00'),
('Craisl5537', 31000, 'admin@admin.com', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `title` varchar(50) NOT NULL,
  `username` varchar(40) NOT NULL,
  `artist` varchar(50) NOT NULL,
  `sold` tinyint(1) NOT NULL,
  `path` varchar(50) NOT NULL,
  `min_bid` int(11) NOT NULL,
  `id` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`title`, `username`, `artist`, `sold`, `path`, `min_bid`, `id`) VALUES
('A walk in the park', 'admin@admin.com', 'Akash Goel', 0, 'images/admin@admin.com/bench.jpg', 30000, 'Akaben5537'),
('The wild steed', 'goel@gmail.com', 'Akash Goel', 0, 'images/goel@gmail.com/horse.jpg', 20000, 'Akahor5537'),
('Aunt Lisa looks like Mona Lisa', 'user@user.com', 'Bunty', 0, 'images/user@user.com/monalisa.jpg', 50000, 'Bunmon5537'),
('Anime island', 'goel@gmail.com', 'Crazy Ivan', 0, 'images/goel@gmail.com/island.jpg', 25000, 'Craisl5537'),
('Mona Lisa', 'admin@admin.com', 'Leonardo Da Vinci', 0, 'images/admin@admin.com/mona.jpg', 25000, 'Leomon5535'),
('Watermarked lane', 'user@user.com', 'Ms. Cherry', 0, 'images/user@user.com/lane.jpg', 30000, 'Ms.lan5537'),
('Evening Beach', 'admin@admin.com', 'Sandro', 0, 'images/admin@admin.com/beach.jpg', 25000, 'Sanbea5537'),
('Monastery', 'user@user.com', 'tao Wun', 0, 'images/user@user.com/monastery.jpg', 60000, 'taomon5537');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `dob` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `first_name`, `last_name`, `dob`) VALUES
('admin@admin.com', 'admin', 'Akash', 'Goel', '1993-09-18'),
('user@user.com', 'user', 'Anmol', 'Jaggi', '1994-11-05'),
('goel@gmail.com', 'goel123', 'Akash', 'Goel', '1993-04-04');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
