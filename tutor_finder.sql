-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 02, 2023 at 05:00 AM
-- Server version: 8.0.27
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tutor_finder`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

DROP TABLE IF EXISTS `fees`;
CREATE TABLE IF NOT EXISTS `fees` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` text NOT NULL,
  `fees` bigint NOT NULL,
  `date` date NOT NULL,
  `status` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `firebase_results`
--

DROP TABLE IF EXISTS `firebase_results`;
CREATE TABLE IF NOT EXISTS `firebase_results` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fcm_multicast_id` bigint DEFAULT NULL,
  `fcm_success` varchar(200) DEFAULT NULL,
  `fcm_failure` varchar(200) DEFAULT NULL,
  `fcm_error` varchar(200) DEFAULT NULL,
  `fcm_type` varchar(200) NOT NULL,
  `fcm_send_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `hours_availability`
--

DROP TABLE IF EXISTS `hours_availability`;
CREATE TABLE IF NOT EXISTS `hours_availability` (
  `id` int NOT NULL AUTO_INCREMENT,
  `hours` text NOT NULL,
  `session` text NOT NULL COMMENT 'AM/PM',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

INSERT INTO `hours_availability` (`hours`, `session`) VALUES
('09:00', 'AM'),
('10:00', 'AM'),
('11:00', 'AM'),
('12:00', 'PM'),
('01:00', 'PM'),
('02:00', 'PM'),
('03:00', 'PM'),
('04:00', 'PM'),
('05:00', 'PM'),
('06:00', 'PM'),
('07:00', 'PM');


-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `message` longtext NOT NULL,
  `user_id` text NOT NULL,
  `type` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `payment_transaction`
--

DROP TABLE IF EXISTS `payment_transaction`;
CREATE TABLE IF NOT EXISTS `payment_transaction` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tutor_email` text NOT NULL,
  `student_email` text NOT NULL,
  `amount` double NOT NULL,
  `sub_fees` text NOT NULL,
  `transaction_id` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

DROP TABLE IF EXISTS `ratings`;
CREATE TABLE IF NOT EXISTS `ratings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` text NOT NULL,
  `tutor_email` text NOT NULL,
  `rate` float NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `request`
--

DROP TABLE IF EXISTS `request`;
CREATE TABLE IF NOT EXISTS `request` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tutor_email` text NOT NULL,
  `student_email` text NOT NULL,
  `subject` text NOT NULL,
  `fees` text NOT NULL,
  `status` text,
  `m_hours` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `a_hours` text NOT NULL,
  `tuition_type` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

DROP TABLE IF EXISTS `setting`;
CREATE TABLE IF NOT EXISTS `setting` (
  `id` int NOT NULL AUTO_INCREMENT,
  `notification_status` varchar(10) NOT NULL DEFAULT 'true',
  `about` longtext NOT NULL,
  `privacy_policy` longtext NOT NULL,
  `distance` int NOT NULL,
  `stripe_client_key` text NOT NULL,
  `stripe_public_key` text NOT NULL,
  `percentage` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `notification_status`, `about`, `privacy_policy`, `distance`, `stripe_client_key`, `stripe_public_key`) VALUES
(2, 'true', '<p>This page is about of tutor finder app.</p>', '<p>&nbsp;This page is Privacy Policy of tutor finder app.</p>', 5, 'sk_test_C2CqMfoav2GD8UdMjLDvdghx00PwrJibHL', 'pk_test_kfsr3luyMDMdh8xNwDmxNJNS00CIROHuDs','5');

-- --------------------------------------------------------

--
-- Table structure for table `standard`
--

DROP TABLE IF EXISTS `standard`;
CREATE TABLE IF NOT EXISTS `standard` (
  `id` int NOT NULL AUTO_INCREMENT,
  `std` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;


INSERT INTO `standard` (`std`)
VALUES
  ('standard 5'),
  ('standard 6'),
  ('standard 7'),
  ('standard 8'),
  ('standard 9'),
  ('standard 10'),
  ('class 11'),
  ('class 12');

-- --------------------------------------------------------

--
-- Table structure for table `student_registration`
--

DROP TABLE IF EXISTS `student_registration`;
CREATE TABLE IF NOT EXISTS `student_registration` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` text NOT NULL,
  `standard` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `subject` text NOT NULL,
  `location` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `mobile_no` bigint DEFAULT NULL,
  `latitude` text NOT NULL,
  `longitude` text NOT NULL,
  `tuition_type` int NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

DROP TABLE IF EXISTS `subject`;
CREATE TABLE IF NOT EXISTS `subject` (
  `id` int NOT NULL AUTO_INCREMENT,
  `subject_name` varchar(100) NOT NULL,
  `image` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;


INSERT INTO `subject` (`subject_name`, `image`)
VALUES
  ('Maths', 'path/to/maths_image.jpg'),
  ('Physics', 'path/to/physics_image.jpg'),
  ('Chemistry', 'path/to/chemistry_image.jpg');
-- --------------------------------------------------------

--
-- Table structure for table `tutor_registration`
--

DROP TABLE IF EXISTS `tutor_registration`;
CREATE TABLE IF NOT EXISTS `tutor_registration` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` text NOT NULL,
  `standard` text NOT NULL,
  `subject` text NOT NULL,
  `monthly_fees` text NOT NULL,
  `university` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `location` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `year_of_experience` int DEFAULT NULL,
  `mobile_no` bigint DEFAULT NULL,
  `latitude` text NOT NULL,
  `longitude` text NOT NULL,
  `tuition_type` int NOT NULL,
  `m_hours` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `a_hours` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `email` varchar(250) NOT NULL,
  `image` text,
  `firebase_id` varchar(300) DEFAULT NULL,
  `fcm_token` varchar(300) DEFAULT NULL,
  `reg_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_type` varchar(250) NOT NULL,
  `type` text NOT NULL,
  `password` text,
  `facebook_user_id` text,
  `forgot_pass_token` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
