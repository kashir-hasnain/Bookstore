-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2021 at 01:45 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `ISBN` int(255) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Author` varchar(255) NOT NULL,
  `Image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`ISBN`, `Title`, `Author`, `Image`) VALUES
(11, 'hello', 'Book', '1617199921958.jfif'),
(123, 'Hi', 'Hi', '1617199921958.jfif'),
(334, 'HI', 'Hi', '1617199921958.jfif');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int(20) NOT NULL,
  `rating_value` int(20) NOT NULL,
  `book_id` int(20) NOT NULL,
  `student_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`id`, `rating_value`, `book_id`, `student_id`) VALUES
(43, 6, 11, 1),
(47, 8, 334, 1),
(49, 3, 11, 9);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(9) NOT NULL,
  `s_email` varchar(255) CHARACTER SET latin1 NOT NULL,
  `s_password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `s_email`, `s_password`) VALUES
(1, 'ali@gmail.com', 'abcd1234'),
(9, 'a@gmail.com', 'e19d5cd5af0378da05f63f891c7467af');

-- --------------------------------------------------------

--
-- Stand-in structure for view `student_ratings_books`
-- (See below for the actual view)
--
CREATE TABLE `student_ratings_books` (
`ISBN` int(255)
,`student_id` int(9)
,`s_email` varchar(255)
,`rating_value` int(20)
);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teacher_id` varchar(9) NOT NULL,
  `t_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`teacher_id`, `t_password`) VALUES
('000000000', '4c93008615c2d041e33ebac605d14b5b');

-- --------------------------------------------------------

--
-- Structure for view `student_ratings_books`
--
DROP TABLE IF EXISTS `student_ratings_books`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `student_ratings_books`  AS SELECT `book`.`ISBN` AS `ISBN`, `students`.`student_id` AS `student_id`, `students`.`s_email` AS `s_email`, `rating`.`rating_value` AS `rating_value` FROM ((`rating` join `students` on(`students`.`student_id` = `rating`.`student_id`)) join `book` on(`book`.`ISBN` = `rating`.`book_id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`ISBN`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ukey` (`book_id`,`student_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `s_email` (`s_email`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`ISBN`),
  ADD CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
