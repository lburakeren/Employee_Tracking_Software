-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 16, 2023 at 09:38 PM
-- Server version: 10.6.12-MariaDB-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testDB`
--

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `id` int(11) NOT NULL,
  `card_id` varchar(10) NOT NULL,
  `employee_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`id`, `card_id`, `employee_id`) VALUES
(1, '0006267851', 825569),
(2, '0006234485', 450567),
(3, '0006201634', 571289);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `text` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `text`) VALUES
(1, 'Ofis Çalışanı'),
(2, 'Üretim Çalışanı');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `picture_name` varchar(30) NOT NULL DEFAULT 'defaultemployeephoto.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `employee_id`, `first_name`, `last_name`, `dept_id`, `picture_name`) VALUES
(1, 571289, 'Tacha', 'Serif', 1, 'asdf.jpg'),
(2, 825569, 'Burak', 'EREN', 2, 'burakeren.jpg'),
(3, 450567, 'Yavuz', 'SAYAR', 2, 'defaultemployeephoto.png'),
(4, 845123, 'Yiğitcan', 'Menengiç', 1, 'defaultemployeephoto.png'),
(72, 945123, 'Karl', 'Maxx', 2, 'defaultemployeephoto.png'),
(73, 324212, 'Adam', 'Lallana', 1, 'defaultemployeephoto.png'),
(74, 234234, 'Sadio', 'Mane', 2, 'defaultemployeephoto.png'),
(76, 547345, 'Lex', 'Lua', 1, 'defaultemployeephoto.png');

-- --------------------------------------------------------

--
-- Table structure for table `gates`
--

CREATE TABLE `gates` (
  `id` int(11) NOT NULL,
  `gate_id` int(11) NOT NULL,
  `gatepassword` varchar(30) DEFAULT NULL,
  `gate_name` varchar(30) NOT NULL,
  `gate_location` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gates`
--

INSERT INTO `gates` (`id`, `gate_id`, `gatepassword`, `gate_name`, `gate_location`) VALUES
(1, 123456, 'vyp6m7', 'Kayışdağı', 'İnönü Sk.'),
(2, 123457, 'c42fsad', 'Beykoz', 'Elma Sk.'),
(14, 123458, 'c42fsad', 'Beykoz', 'Elma Sk.');

-- --------------------------------------------------------

--
-- Table structure for table `movements`
--

CREATE TABLE `movements` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `gate_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `in_out` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movements`
--

INSERT INTO `movements` (`id`, `employee_id`, `gate_id`, `date`, `time`, `in_out`) VALUES
(74, 825569, 123456, '2023-09-01', '10:00:00', 'in'),
(75, 825569, 123456, '2023-09-01', '15:00:00', 'out'),
(76, 825569, 123456, '2023-09-02', '11:00:00', 'in'),
(77, 825569, 123456, '2023-09-02', '16:00:00', 'out'),
(78, 825569, 123456, '2023-09-03', '09:00:00', 'in'),
(79, 825569, 123456, '2023-09-03', '17:00:00', 'out'),
(80, 825569, 123456, '2023-09-04', '10:00:00', 'in'),
(81, 825569, 123456, '2023-09-04', '18:00:00', 'out'),
(82, 825569, 123456, '2023-09-05', '11:00:00', 'in'),
(83, 825569, 123456, '2023-09-05', '15:30:00', 'out'),
(84, 825569, 123456, '2023-09-06', '12:30:00', 'in'),
(85, 825569, 123456, '2023-09-06', '16:30:00', 'out'),
(86, 825569, 123456, '2023-09-20', '11:30:00', 'in'),
(87, 825569, 123456, '2023-09-20', '17:30:00', 'out'),
(88, 825569, 123456, '2023-09-21', '10:30:00', 'in'),
(89, 825569, 123456, '2023-09-21', '18:30:00', 'out'),
(90, 825569, 123456, '2023-09-22', '09:30:00', 'in'),
(91, 825569, 123456, '2023-09-22', '18:00:00', 'out'),
(92, 825569, 123456, '2023-09-22', '19:00:00', 'in'),
(93, 825569, 123456, '2023-09-23', '03:37:20', 'out'),
(94, 825569, 123456, '2023-09-21', '19:08:25', 'in'),
(95, 825569, 123456, '2023-09-21', '23:08:25', 'out'),
(97, 825569, 123456, '2023-09-25', '12:11:34', 'in'),
(98, 825569, 123456, '2023-09-26', '01:11:34', 'out');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `last_name`, `email`) VALUES
(1, 'manager', 'manager123', 'Steve', 'Jobs', 'stevejobs@gmail.com'),
(5, 'burakeren', '123456', 'Burak', 'EREN', 'buraak657@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `card_id` (`card_id`),
  ADD UNIQUE KEY `employee_id` (`employee_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_id` (`employee_id`),
  ADD KEY `dept_id_fk` (`dept_id`);

--
-- Indexes for table `gates`
--
ALTER TABLE `gates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gate_id` (`gate_id`);

--
-- Indexes for table `movements`
--
ALTER TABLE `movements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id_fk` (`employee_id`),
  ADD KEY `gate_id_fk` (`gate_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `password` (`password`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `gates`
--
ALTER TABLE `gates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `movements`
--
ALTER TABLE `movements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cards`
--
ALTER TABLE `cards`
  ADD CONSTRAINT `cards_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`) ON DELETE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`dept_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `movements`
--
ALTER TABLE `movements`
  ADD CONSTRAINT `movements_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movements_ibfk_2` FOREIGN KEY (`gate_id`) REFERENCES `gates` (`gate_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
