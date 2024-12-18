-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2024 at 07:45 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lovely`
--

-- --------------------------------------------------------

--
-- Table structure for table `archive`
--

CREATE TABLE `archive` (
  `id` int(9) NOT NULL,
  `subject` varchar(99) NOT NULL,
  `instructor` varchar(99) NOT NULL,
  `day` varchar(99) NOT NULL,
  `time` varchar(99) NOT NULL,
  `type` varchar(99) NOT NULL,
  `room` varchar(99) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `archive`
--

INSERT INTO `archive` (`id`, `subject`, `instructor`, `day`, `time`, `type`, `room`, `timestamp`) VALUES
(1, 'wqrwefs', 'sfsgasfsg', 'asfsag', '10', 'Exam', '101', '2023-12-11 21:32:08'),
(2, 'wqrwefs', 'sfsgasfsg', 'asfsag', '10', 'Exam', '101', '2023-12-11 21:32:08'),
(3, 'wqrwefs', 'sfsgasfsg', 'asfsag', '10', 'Exam', '101', '2023-12-11 21:32:08'),
(4, 'Database', 'Melody Abcede', 'monday', '10', 'Exam', 'avr', '2023-12-11 21:32:08'),
(5, 'Database', 'Melody Abcede', 'monday', '12', 'Regular', 'avr', '2023-12-11 21:32:08'),
(6, 'Database', 'Melody Abcede', 'monday', '12', 'Regular', 'avr', '2023-12-11 21:32:08'),
(7, 'a', 'a', 'a', '1', 'Exam', 'c', '2023-12-11 21:32:08'),
(8, 'a', 'a', 'a', 'a', 'Exam', 'a', '2023-12-11 21:32:08'),
(9, 'aa', 'aa', 'a', 'a', 'Regular', 'a', '2023-12-11 21:32:08'),
(10, 'math', 'ranan', 'thursday', '1:00 pm', 'Regular', '102', '2023-12-12 11:11:28'),
(11, 'Mobile Programming', 'John Rey Cagaanan', 'Saturday', '1:00PM - 6:00PM', 'Regular', 'ComLab 1', '2023-12-12 18:47:05');

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE `data` (
  `id` int(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `instructor` varchar(100) NOT NULL,
  `day` varchar(100) NOT NULL,
  `time` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `room` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data`
--

INSERT INTO `data` (`id`, `subject`, `instructor`, `day`, `time`, `type`, `room`) VALUES
(1, 'Networking 2', 'Jimvy Salisi', 'Monday', '8:00AM-10:00AM', 'Regular', 'ICT Office'),
(2, 'Information Assurance', 'Ms. Amor Quimson', 'Tuesday', '2:00PM- 5:00PM', 'Regular', 'E-Library'),
(5, 'Software Engineering', 'Mr. Jalanie Hadjimalic', 'Thursday', '7:00PM-9:00PM', 'Regular', 'Audio Visual Room');

-- --------------------------------------------------------

--
-- Table structure for table `schedinfo`
--

CREATE TABLE `schedinfo` (
  `id` int(11) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `instructor` varchar(100) NOT NULL,
  `room` varchar(50) NOT NULL,
  `day` varchar(20) NOT NULL,
  `time` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(255) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `instructor` varchar(100) NOT NULL,
  `day` varchar(50) NOT NULL,
  `time` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `room` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `subject`, `instructor`, `day`, `time`, `type`, `room`) VALUES
(5, 'networking 2', 'Jimve Salisi', 'Monday', '8:00-10:00 am', 'Regular', 'ICT Office'),
(6, ' Technopreneurship', ' Ms. Kareen Timario', ' Thursday', ' 4:00PM - 8:00PM', ' Regular', ' room 102'),
(8, 'information assurance', 'Ms. Amor Quimson', 'friday', '4:00 - 8:00 pm', 'Regular', 'avr'),
(11, 'Keyboarding', 'Joshua ambott Unsa apilyedo', 'sunday', '7:00-10:00am', 'Regular', 'comlab'),
(13, ' technopreneurship', ' Ms. Kareen Timario', ' thursday', ' 4:00 - 8:00 pm', ' Regular', ' AVR'),
(32, 'Database', 'Melody Abcede', 'monday', '12', 'Regular', 'Audio Visual Room'),
(38, 'Mobile Programming', 'John Rey Cagaanan', 'Saturday', '1:00PM - 6:00PM', 'Regular', 'ComLab 1');

-- --------------------------------------------------------

--
-- Table structure for table `thots`
--

CREATE TABLE `thots` (
  `id` int(9) NOT NULL,
  `stud_name` varchar(99) NOT NULL,
  `thot` varchar(99) NOT NULL,
  `anony` varchar(99) NOT NULL,
  `approved` varchar(99) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `thots`
--

INSERT INTO `thots` (`id`, `stud_name`, `thot`, `anony`, `approved`) VALUES
(3, 'tree', 'yowwwww', 'Yes', 'Yes'),
(6, 'tree', 'bleeeeeeeeeee', 'No', 'Yes'),
(9, 'tree', 'sdsdsdsdsd', 'No', 'Yes'),
(10, 'Cherrie Lyn Marfe', 'wdrqrtwy', 'No', 'Yes'),
(11, 'james shairo pahung', 'hi', 'No', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `courseandyear` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `courseandyear`, `email`, `password`, `image`, `role`) VALUES
(9, 'shairojames', '', 'iamshairojames@gmail.com', '$2y$10$IKq8LcLyiCClAQqLUJ.KqeGSiO0lP47LrFcM3cjqz0BhmPzP2Kyey', '', 'user'),
(10, 'shao shao', '', 'burairai25@gmail.com', '$2y$10$jF3.Uqls/XewVfY3NnGkweIUlBU/0hKEIAXTpUuko2PzwkAgD/Z1m', 'profile_pictures/istockphoto-1293678742-612x612.jpg', 'user'),
(11, 'cherie lyn', '', 'marfe@gmail.com', '$2y$10$0oXwa5K8YaA6kYQ52Si7QezXpBUTQNlLLUvUYkeNeARCblU/sGqpG', NULL, 'user'),
(16, 'Shairo James Pahunang', 'BSIT-3B', 'shaoshao0429@mail.com', 'd41d8cd98f00b204e9800998ecf8427e', '386833748_1373969523204661_302749676070980900_n.png', 'user'),
(17, 'lovely vanessa tomimbang', 'BSIT-3B', 'lavleey@gmail.com', '0363630808b64b0c9013c3300944346b', '1000_F_612385910_KvMIjrrkXRn7DDpO2FsOtIHjupJTYpZQ.jpg', 'user'),
(18, 'james shairo pahung', 'BSIT-3B', 'shairo@gmail.com', '48714cfa4736dcc894b9ff087b610775', 'dog.jpg', 'user'),
(20, 'tree', '1st BSIT', 'tree@gmail.com', 'd8578edf8458ce06fbc5bb76a58c5ca4', '396184043_341786018528312_1563382149032615297_n.jpg', 'user'),
(21, 'fort', '2nd BSIT', 'qwe@gmail.com', '7815696ecbf1c96e6894b779456d330e', '371541491_149035254945928_2982335099251288502_n.jpg', 'user'),
(22, 'James Shairo Pahunang', '', 'shairo@gmail.com', '48714cfa4736dcc894b9ff087b610775', '', 'admin'),
(23, 'Cherrie Lyn Marfe', '', 'marfecherry@gmail.com', 'b2a9b638cb26c55c24eb74e81b15102c', '', 'admin'),
(24, 'Liezel Beimen', '', 'zelda@gmail.com', '6006cd7b11193da30f24257bda8a2088', 'me.jpg', 'admin'),
(25, 'test', '', 'test@gmail.com', '098f6bcd4621d373cade4e832627b4f6', 'logo.png', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `user_sched`
--

CREATE TABLE `user_sched` (
  `num` int(9) NOT NULL,
  `user_id` int(9) NOT NULL,
  `id` int(99) NOT NULL,
  `subject` varchar(99) NOT NULL,
  `instructor` varchar(99) NOT NULL,
  `day` varchar(99) NOT NULL,
  `time` varchar(99) NOT NULL,
  `type` varchar(99) NOT NULL,
  `room` varchar(99) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_sched`
--

INSERT INTO `user_sched` (`num`, `user_id`, `id`, `subject`, `instructor`, `day`, `time`, `type`, `room`) VALUES
(1, 17, 8, 'Information Assurance', 'Ms. Amor Quimson', 'Friday', '4:00PM - 8:00PM', 'Regular', 'Audio Visual Room'),
(2, 17, 5, 'networking 2', 'Jimve Salisi', 'Monday', '8:00-10:00 am', 'Regular', 'ict office'),
(3, 17, 11, 'Keyboarding', 'Joshua ambott Unsa apilyedo', 'sunday', '7:00-10:00am', 'Regular', 'comlab'),
(4, 17, 6, 'technopreneurship', 'Ms. Kareen Timario', 'thursday', '4:00 - 8:00 pm', 'Regular', 'room 102'),
(5, 20, 5, 'networking 2', 'Jimve Salisi', 'Monday', '8:00-10:00 am', 'Regular', 'ict office'),
(6, 20, 11, 'Keyboarding', 'Joshua ambott Unsa apilyedo', 'sunday', '7:00-10:00am', 'Regular', 'comlab'),
(7, 20, 6, 'technopreneurship', 'Ms. Kareen Timario', 'thursday', '4:00 - 8:00 pm', 'Regular', 'room 102'),
(8, 18, 5, 'networking 2', 'Jimve Salisi', 'Monday', '8:00-10:00 am', 'Regular', 'ICT Office'),
(9, 18, 6, ' Technopreneurship', ' Ms. Kareen Timario', ' Thursday', ' 4:00PM - 8:00PM', ' Regular', ' room 102'),
(10, 18, 8, 'information assurance', 'Ms. Amor Quimson', 'friday', '4:00 - 8:00 pm', 'Regular', 'avr'),
(11, 18, 11, 'Keyboarding', 'Joshua ambott Unsa apilyedo', 'sunday', '7:00-10:00am', 'Regular', 'comlab');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `archive`
--
ALTER TABLE `archive`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedinfo`
--
ALTER TABLE `schedinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `thots`
--
ALTER TABLE `thots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sched`
--
ALTER TABLE `user_sched`
  ADD PRIMARY KEY (`num`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `archive`
--
ALTER TABLE `archive`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `data`
--
ALTER TABLE `data`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `schedinfo`
--
ALTER TABLE `schedinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `thots`
--
ALTER TABLE `thots`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `user_sched`
--
ALTER TABLE `user_sched`
  MODIFY `num` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
