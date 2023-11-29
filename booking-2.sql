-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2023 at 08:53 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `booking-2`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `user_id` int(50) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `bookedseat` varchar(255) DEFAULT NULL COMMENT '(movie_id,datetime,seats)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`user_id`, `user_name`, `user_email`, `user_password`, `bookedseat`) VALUES
(1, 'jatin', 'thejatinvaghela@gmail.com', '123', '(1,0,chacked_seats=>[G-0/G-1/]),');

-- --------------------------------------------------------

--
-- Table structure for table `movie_list`
--

CREATE TABLE `movie_list` (
  `movie_id` int(50) NOT NULL,
  `movie_name` varchar(255) DEFAULT NULL,
  `movie_tomato_rating` int(50) DEFAULT 0 COMMENT 'in %',
  `movie_box_office_rating` int(50) DEFAULT 0 COMMENT 'in %',
  `movie_img` varchar(255) NOT NULL DEFAULT 'assetsimagesmoviemovie01.jpg',
  `available` int(10) DEFAULT 1 COMMENT '0=not/1=yes',
  `dates` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movie_list`
--

INSERT INTO `movie_list` (`movie_id`, `movie_name`, `movie_tomato_rating`, `movie_box_office_rating`, `movie_img`, `available`, `dates`) VALUES
(1, 'alone', 80, 70, 'assets/images/movie/movie01.jpg', 1, '(2023-09-09 09:30:00/2023-09-10 12:30:00/)'),
(2, 'mars', 90, 90, 'assets/images/movie/movie02.jpg', 1, ''),
(3, 'venus', 56, 47, 'assets/images/movie/movie03.jpg', 1, ''),
(4, 'on watch', 78, 45, 'assets/images/movie/movie04.jpg', 1, ''),
(5, 'fury', 34, 8, 'assets/images/movie/movie05.jpg', 1, ''),
(6, 'trooper', 76, 74, 'assets/images/movie/movie06.jpg', 1, ''),
(7, 'horror night', 67, 34, 'assets/images/movie/movie07.jpg', 1, ''),
(8, 'the lost name', 67, 56, 'assets/images/movie/movie08.jpg', 1, ''),
(9, 'calm stedfast', 66, 69, 'assets/images/movie/movie09.jpg', 1, ''),
(10, 'criminal on party', 92, 93, 'assets/images/movie/movie10.jpg', 1, ''),
(11, 'halloween party', 97, 12, 'assets/images/movie/movie11.jpg', 1, ''),
(12, 'the most wanted', 20, 20, 'assets/images/movie/movie12.jpg', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `seats_id` int(50) NOT NULL,
  `seat` varchar(50) NOT NULL,
  `2023-09-09 09:30:00` int(10) DEFAULT 0 COMMENT '0=not/1=yes',
  `2023-09-10 12:30:00` int(10) NOT NULL DEFAULT 0 COMMENT '0=not/1=yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`seats_id`, `seat`, `2023-09-09 09:30:00`, `2023-09-10 12:30:00`) VALUES
(1, 'G-0', 1, 0),
(2, 'G-1', 1, 0),
(3, 'G-2', 0, 0),
(4, 'G-3', 0, 0),
(5, 'G-4', 0, 0),
(6, 'G-5', 0, 0),
(7, 'G-6', 0, 0),
(8, 'G-7', 0, 0),
(9, 'G-8', 0, 0),
(10, 'G-9', 0, 0),
(11, 'G-10', 0, 0),
(12, 'G-11', 0, 0),
(13, 'G-12', 0, 0),
(14, 'G-13', 0, 0),
(15, 'F-0', 0, 0),
(16, 'F-1', 0, 0),
(17, 'F-2', 0, 0),
(18, 'F-3', 0, 0),
(19, 'F-4', 0, 0),
(20, 'F-5', 0, 0),
(21, 'F-6', 0, 0),
(22, 'F-7', 0, 0),
(23, 'F-8', 0, 0),
(24, 'F-9', 0, 0),
(25, 'F-1', 0, 0),
(26, 'F-1', 0, 0),
(27, 'F-1', 0, 0),
(28, 'F-1', 0, 0),
(29, 'E-0', 0, 0),
(30, 'E-1', 0, 0),
(31, 'E-2', 0, 0),
(32, 'E-3', 0, 0),
(33, 'E-4', 0, 0),
(34, 'E-5', 0, 0),
(35, 'D-0', 0, 0),
(36, 'D-1', 0, 0),
(37, 'D-2', 0, 0),
(38, 'D-3', 0, 0),
(39, 'D-4', 0, 0),
(40, 'D-5', 0, 0),
(41, 'D-6', 0, 0),
(42, 'D-7', 0, 0),
(43, 'C-0', 0, 0),
(44, 'C-1', 0, 0),
(45, 'C-2', 0, 0),
(46, 'C-3', 0, 0),
(47, 'C-4', 0, 0),
(48, 'C-5', 0, 0),
(49, 'C-6', 0, 0),
(50, 'C-7', 0, 0),
(51, 'C-8', 0, 0),
(52, 'B-0', 0, 0),
(53, 'B-1', 0, 0),
(54, 'B-2', 0, 0),
(55, 'B-3', 0, 0),
(56, 'B-4', 0, 0),
(57, 'B-5', 0, 0),
(58, 'B-6', 0, 0),
(59, 'B-7', 0, 0),
(60, 'B-8', 0, 0),
(61, 'A-1', 0, 0),
(62, 'A-2', 0, 0),
(63, 'A-3', 0, 0),
(64, 'A-4', 0, 0),
(65, 'A-5', 0, 0),
(66, 'A-6', 0, 0),
(67, 'A-7', 0, 0),
(68, 'A-8', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- Indexes for table `movie_list`
--
ALTER TABLE `movie_list`
  ADD PRIMARY KEY (`movie_id`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`seats_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `user_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `movie_list`
--
ALTER TABLE `movie_list`
  MODIFY `movie_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `seats_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
