-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2023 at 12:56 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u21456552`
--

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `account_id` varchar(32) NOT NULL,
  `friend_id` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`account_id`, `friend_id`) VALUES
('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', '6004f995a3a0b738c19dede26d8e1025'),
('6004f995a3a0b738c19dede26d8e1025', 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA'),
('231a2b1295d7c9b8057f56b91bf99318', '6004f995a3a0b738c19dede26d8e1025'),
('6004f995a3a0b738c19dede26d8e1025', '231a2b1295d7c9b8057f56b91bf99318');

-- --------------------------------------------------------

--
-- Table structure for table `lists`
--

CREATE TABLE `lists` (
  `api_key` varchar(32) NOT NULL,
  `list` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`list`)),
  `name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profilegallery`
--

CREATE TABLE `profilegallery` (
  `api_key` varchar(32) NOT NULL,
  `image_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profilegallery`
--

INSERT INTO `profilegallery` (`api_key`, `image_name`) VALUES
('231a2b1295d7c9b8057f56b91bf99318', 'image_65398eb0514892.82858848.png'),
('6004f995a3a0b738c19dede26d8e1025', 'image_65398e7e237ef4.84971179.png'),
('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', 'image_653507a89adce0.69527388.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbarticles`
--

CREATE TABLE `tbarticles` (
  `article_id` int(11) NOT NULL,
  `api_key` varchar(32) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `author` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `body` text NOT NULL,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '{"tags": ["article"]}'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbarticles`
--

INSERT INTO `tbarticles` (`article_id`, `api_key`, `title`, `description`, `author`, `date`, `body`, `tags`) VALUES
(61, 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', 'Help', 'YES', 'MME', '2023-10-12', 'asfasfasfd', '{\"tags\": [\"home\", \"help\"]}'),
(62, 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', 'Another ', 'This is another article by test', 'Test', '2023-10-20', 'This is something I am doing', '{\"tags\": [\"article\"]}'),
(63, '6004f995a3a0b738c19dede26d8e1025', 'Mammello', 'Marsh', 'Ivan Horak', '2023-10-12', 'Marshelloes relate to bloons dont they', '{\"tags\": [\"article\"]}'),
(64, '231a2b1295d7c9b8057f56b91bf99318', 'My first article', 'This is my first article', 'Caprice', '2023-10-25', 'This is my first article I really hop you like it and how cool it is and that I wrote for really long it really is super cool and I dont know what I would do if I counldt write articles about all kinds of things.', '{\"tags\": [\"article\"]}'),
(65, '231a2b1295d7c9b8057f56b91bf99318', 'ANother', 'Herklpo', 'Caprice', '2023-10-18', 'aslfkjasdlfkjaslfjasdlkdfjalsdkdfjlaksdjflkasdjf', '{\"tags\": [\"article\"]}'),
(66, '6004f995a3a0b738c19dede26d8e1025', 'JSON test', 'testing json', 'ME', '2023-10-04', 'This is a test for the json file', '{\"tags\": [\"article\"]}'),
(67, '6004f995a3a0b738c19dede26d8e1025', 'asfd', 'asfasdf', 'asdfasdf', '2023-10-19', 'asdfasdfasfd', '{\"tags\": [\"article\"]}'),
(68, '6004f995a3a0b738c19dede26d8e1025', 'asfasf', 'asdfasfd', 'asdfasdf', '2023-10-03', 'asdfasdfasdf', '{\"tags\": [\"article\"]}'),
(69, '6004f995a3a0b738c19dede26d8e1025', 'asfasdf', 'asdfasfd', 'asdfasdf', '2023-10-09', 'asdfasdf', '{\"tags\": [\"article\"]}'),
(70, '6004f995a3a0b738c19dede26d8e1025', 'gndfbndf', 'sgdffgrg', 'zxcvcvb', '2023-10-09', 'sdfgdfgsdfgdfg', '{\"tags\": [\"article\"]}'),
(71, '6004f995a3a0b738c19dede26d8e1025', 'Another', 'YES PLEASE ', 'ONE', '2023-10-04', 'PLEASE WORK', '{\"tags\": [\"article\"]}'),
(72, '231a2b1295d7c9b8057f56b91bf99318', 'Another Tag test', 'Tag test', 'Caprice', '2023-10-10', 'This is a tag test', '{\"tags\": [\"article\"]}'),
(73, '231a2b1295d7c9b8057f56b91bf99318', 'TEST', 'ETST', 'TEST', '2023-10-18', 'TEST', '{\"tags\": [\"article\"]}'),
(79, '231a2b1295d7c9b8057f56b91bf99318', 'tester 4', 'tester', 'tester', '0000-00-00', 'tester tester tester', '{\"tags\":[\"test\"]}'),
(85, '6004f995a3a0b738c19dede26d8e1025', 'One more test', 'This is a test as to if the tags work', 'Ivan Horak', '2023-10-10', 'Every time I try this image it fails so I can not tell if this image is a blessing or a curse or if it is sent from hell', '{\"tags\":[\"hell\",\"test\",\"help\",\"home\",\"active\"]}'),
(87, '6004f995a3a0b738c19dede26d8e1025', 'One more test another', 'This is a test as to if the tags work', 'Ivan Horak', '2023-10-10', 'Every time I try this image it fails so I can not tell if this image is a blessing or a curse or if it is sent from hell', '{\"tags\":[\"hell\",\"test\",\"help\",\"home\",\"active\"]}');

-- --------------------------------------------------------

--
-- Table structure for table `tbgallery`
--

CREATE TABLE `tbgallery` (
  `image_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `image_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbgallery`
--

INSERT INTO `tbgallery` (`image_id`, `article_id`, `image_name`) VALUES
(51, 61, 'image_653507a89adce0.69527388.png'),
(52, 62, 'image_65364f324bb716.07165496.png'),
(53, 63, 'image_6536508a12f644.92399639.png'),
(54, 64, 'image_65366252f22ce6.04734527.png'),
(55, 65, 'image_6536837e602d86.54723140.png'),
(56, 66, 'image_65368a5ec44c68.00389660.png'),
(57, 67, 'image_6536974b9c0d23.68581235.png'),
(58, 68, 'image_65369778430685.76712591.png'),
(59, 69, 'image_65369798f11350.13731105.png'),
(60, 70, 'image_653697ee2dda49.43606482.png'),
(61, 71, 'image_65369894d33476.95488364.png'),
(62, 72, 'image_6536994464c6c9.37759557.png'),
(63, 73, 'image_653699741c33d3.93776563.png'),
(69, 79, 'image_6536b0b4336e90.82497510.png'),
(70, 80, 'image_6536bad2aaf517.14042485.png'),
(71, 80, 'image_6536bc17dc8233.72615990.png'),
(72, 80, 'image_6536bc381d2351.39918051.png'),
(73, 80, 'image_6536bc4c27b118.67031289.png'),
(74, 84, 'image_6536bdfde7ed46.11666019.png'),
(75, 84, 'image_6536bfc78ac099.22802314.png'),
(76, 85, 'image_6536c01b3d4b14.40788193.png'),
(77, 87, 'image_6536c039e7d4d7.44084232.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `first_name` varchar(64) NOT NULL,
  `last_name` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `api_key` varchar(32) NOT NULL,
  `birthday` date NOT NULL DEFAULT current_timestamp(),
  `relationship` varchar(32) NOT NULL,
  `job` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`first_name`, `last_name`, `email`, `password`, `api_key`, `birthday`, `relationship`, `job`) VALUES
('Caprice', 'Tsaf', 'caprice@tsaf.com', '12345678', '231a2b1295d7c9b8057f56b91bf99318', '2001-11-12', 'taken', 'Student'),
('Ivan', 'Horak', 'ivanhorak20@gmail.com', 'Ivan@horak1', '6004f995a3a0b738c19dede26d8e1025', '2023-10-23', '', ''),
('test', 'test', 'test@test.com', 'test1234', 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', '1999-06-23', 'taken', 'Software'),
('SOMEBODY', 'ONCETOLDME', 'IAINTTHESHARPEST@TOOL.SHED', '12345678', 'f0aefbfe96001cec68bc439bf374a8e2', '2023-10-26', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `profilegallery`
--
ALTER TABLE `profilegallery`
  ADD PRIMARY KEY (`api_key`);

--
-- Indexes for table `tbarticles`
--
ALTER TABLE `tbarticles`
  ADD PRIMARY KEY (`article_id`);

--
-- Indexes for table `tbgallery`
--
ALTER TABLE `tbgallery`
  ADD PRIMARY KEY (`image_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`api_key`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbarticles`
--
ALTER TABLE `tbarticles`
  MODIFY `article_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `tbgallery`
--
ALTER TABLE `tbgallery`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
