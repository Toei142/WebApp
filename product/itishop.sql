-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 22, 2021 at 06:43 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `itishop`
--
CREATE DATABASE IF NOT EXISTS `itishop` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `itishop`;

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

DROP TABLE IF EXISTS `orderdetails`;
CREATE TABLE IF NOT EXISTS `orderdetails` (
  `orderID` int(10) NOT NULL,
  `productId` int(10) NOT NULL,
  `number` int(10) NOT NULL,
  UNIQUE KEY `orderID` (`orderID`,`productId`),
  KEY `productId` (`productId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `orderdetails`
--

TRUNCATE TABLE `orderdetails`;
--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`orderID`, `productId`, `number`) VALUES
(6, 1, 0),
(7, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `orderID` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`orderID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `orders`
--

TRUNCATE TABLE `orders`;
--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderID`, `date`) VALUES
(6, '2021-03-22 17:40:19'),
(7, '2021-03-22 17:40:20');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `productID` int(10) NOT NULL AUTO_INCREMENT,
  `image` mediumtext NOT NULL,
  `name` varchar(50) NOT NULL,
  `number` int(10) NOT NULL,
  `price` int(10) NOT NULL,
  PRIMARY KEY (`productID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `product`
--

TRUNCATE TABLE `product`;
--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productID`, `image`, `name`, `number`, `price`) VALUES
(1, '', 'ปากกา', 10, 10),
(2, '', 'ดินสอ', 10, 10);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
