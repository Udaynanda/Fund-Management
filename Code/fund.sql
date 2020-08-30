-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Feb 26, 2020 at 10:04 AM
-- Server version: 8.0.18
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fund`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` varchar(30) NOT NULL,
  `name` varchar(15) NOT NULL,
  `password` varchar(15) NOT NULL,
  `contact` varchar(10) NOT NULL,
  `office` varchar(12) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `password`, `contact`, `office`) VALUES
('kunal@gmail.com', 'Kunal', '1234567', '6205264003', 'Pod 1A-302');

-- --------------------------------------------------------

--
-- Table structure for table `balance`
--

DROP TABLE IF EXISTS `balance`;
CREATE TABLE IF NOT EXISTS `balance` (
  `user_id` varchar(30) NOT NULL,
  `trans_id` int(30) NOT NULL,
  PRIMARY KEY (`user_id`,`trans_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `balance`
--

INSERT INTO `balance` (`user_id`, `trans_id`) VALUES
('', 20),
('', 21),
('jay@hotmail.com', 1),
('jay@hotmail.com', 2),
('jay@hotmail.com', 3),
('jay@hotmail.com', 4),
('jay@hotmail.com', 5),
('jay@hotmail.com', 6),
('jay@hotmail.com', 7),
('jay@hotmail.com', 8),
('jay@hotmail.com', 9),
('jay@hotmail.com', 10),
('jay@hotmail.com', 11),
('jay@hotmail.com', 12),
('jay@hotmail.com', 17),
('jay@hotmail.com', 18),
('jay@hotmail.com', 19);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `trans_id` int(30) NOT NULL,
  `type` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `amount` int(15) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`trans_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`trans_id`, `type`, `amount`, `date`) VALUES
(0, 'c', 0, '2020-02-07'),
(1, 'Debit', 190000, '2020-02-07'),
(2, 'Credit', 93, '2020-02-07'),
(3, 'Credit', 500, '2020-02-07'),
(4, 'Credit', 12, '2020-02-07'),
(5, 'Credit', 500, '2020-02-07'),
(6, 'Credit', 500, '2020-02-07'),
(7, 'Credit', 500, '2020-02-08'),
(8, 'Credit', 12, '2020-02-08'),
(9, 'Credit', 12, '2020-02-08'),
(10, 'Credit', 12, '2020-02-08'),
(15, 'Debit', 500, '2020-02-11'),
(14, 'Debit', 500, '2020-02-11'),
(13, 'Debit', 500, '2020-02-11'),
(12, 'Debit', 500, '2020-02-11'),
(11, 'Debit', 500, '2020-02-11'),
(21, 'Debit', 500, '2020-02-11'),
(20, 'Debit', 500, '2020-02-11'),
(19, 'Debit', 500, '2020-02-11'),
(18, 'Credit', 500, '2020-02-11'),
(17, 'Credit', 500, '2020-02-11'),
(16, 'Debit', 500, '2020-02-11');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` varchar(30) NOT NULL,
  `email_id` varchar(30) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `contact` varchar(10) NOT NULL,
  `office` varchar(12) NOT NULL,
  `add_date` date NOT NULL,
  `left_balance` int(15) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email_id`, `name`, `password`, `contact`, `office`, `add_date`, `left_balance`) VALUES
('jay@hotmail.com', 'email@jay', 'Jay', '12345', '99999999', 'Pod 1A-411', '2020-01-25', 10000),
('uday@yahoo.com', '', 'Uday', '123456', '9969822578', 'Pod 1A-412', '2020-01-26', 400),
('cse180001027', 'user@user123', 'user123', '1234567', '9934984456', 'IITINDORE', '2020-02-03', 14000),
('user@user1', 'cse18000@user', 'user123', '12345', '9934984456', 'iit', '2020-02-03', 1300);

-- --------------------------------------------------------

--
-- Table structure for table `work`
--

DROP TABLE IF EXISTS `work`;
CREATE TABLE IF NOT EXISTS `work` (
  `user_id` varchar(30) NOT NULL,
  `admin_id` varchar(30) NOT NULL,
  PRIMARY KEY (`user_id`,`admin_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `work`
--

INSERT INTO `work` (`user_id`, `admin_id`) VALUES
('jay@hotmail.com', 'kunal@gmail.com'),
('uday@yahoo.com', 'kunal@gmail.com');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
