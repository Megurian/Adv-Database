-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2024 at 09:15 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `antique_db`
--
CREATE DATABASE IF NOT EXISTS `antique_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `antique_db`;

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `firstname` varchar(55) NOT NULL,
  `lastname` varchar(55) NOT NULL,
  `email` varchar(55) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `firstname`, `lastname`, `email`, `password`) VALUES
(1, 'sadad', 'adasd', 'okiller244@gmail.com', '$argon2id$v=19$m=2048,t=4,p=2$MEZROFI4LllIVnd2R0FGVw$A7RjxOXVWjqJs5CdfOXRzyTciNdhe5sSXxSLUVI7Gwo');

-- --------------------------------------------------------

--
-- Table structure for table `antique`
--

CREATE TABLE `antique` (
  `id` int(11) NOT NULL,
  `antique_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `year` int(4) NOT NULL,
  `value` int(11) NOT NULL,
  `street` varchar(55) NOT NULL,
  `barangay` varchar(55) NOT NULL,
  `city` varchar(55) NOT NULL,
  `postal_code` int(11) NOT NULL,
  `img_location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `antique`
--

INSERT INTO `antique` (`id`, `antique_name`, `description`, `category_id`, `year`, `value`, `street`, `barangay`, `city`, `postal_code`, `img_location`) VALUES
(8, 'Clock of Harmony', 'A vintage clock used by my ancestors.', 8, 1900, 10000, 'Calle Libertad', 'Lunzuran', 'Zamboanga City', 7000, '');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Furniture'),
(2, 'Jewelry'),
(3, 'Art'),
(4, 'Collectibles'),
(5, 'Porcelain and Ceremics'),
(6, 'Textiles'),
(7, 'Books and Manuscripts'),
(8, 'Metalware'),
(9, 'Glassware'),
(10, 'Toys and Games');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `antique`
--
ALTER TABLE `antique`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `antique`
--
ALTER TABLE `antique`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `antique`
--
ALTER TABLE `antique`
  ADD CONSTRAINT `antique_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
