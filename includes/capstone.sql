-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 21, 2021 at 10:35 PM
-- Server version: 10.1.48-MariaDB-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `capstone`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `name` varchar(120) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(128) NOT NULL,
  `caregiver` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`name`, `username`, `email`, `password`, `caregiver`) VALUES
('admin', 'admin', 'admin@email.com', '$2y$10$g5gxzSJIV41fl.d2wAQ6Nuc1s3wh6TBSYkp3UBMSHjmcMFpyHMZp.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `medicine`
--

CREATE TABLE `medicine` (
  `NAME` varchar(32) DEFAULT NULL,
  `DAY-COUNT` varchar(4) DEFAULT NULL,
  `AMOUNT` varchar(2) DEFAULT NULL,
  `TIME` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `medicine`
--

INSERT INTO `medicine` (`NAME`, `DAY-COUNT`, `AMOUNT`, `TIME`) VALUES
('', '1-1', '', ''),
('', '1-2', '', ''),
(NULL, '2-1', NULL, NULL),
(NULL, '2-2', NULL, NULL),
('', '3-1', '', ''),
('', '3-2', '', ''),
(NULL, '4-1', NULL, NULL),
(NULL, '4-2', NULL, NULL),
('skittles', '5-1', '2', '05:30'),
(NULL, '5-2', NULL, NULL),
(NULL, '6-1', NULL, NULL),
(NULL, '6-2', NULL, NULL),
(NULL, '7-1', NULL, NULL),
(NULL, '7-2', NULL, NULL),
(NULL, '8-1', NULL, NULL),
(NULL, '8-2', NULL, NULL),
(NULL, '9-1', NULL, NULL),
('', '9-2', '', ''),
(NULL, '10-1', NULL, NULL),
(NULL, '10-2', NULL, NULL),
(NULL, '11-1', NULL, NULL),
('', '11-2', '', ''),
(NULL, '12-1', NULL, NULL),
(NULL, '12-2', NULL, NULL),
(NULL, '13-1', NULL, NULL),
(NULL, '13-2', NULL, NULL),
(NULL, '14-1', NULL, NULL),
(NULL, '14-2', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD UNIQUE KEY `username` (`username`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
