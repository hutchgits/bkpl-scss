-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 19, 2025 at 10:19 PM
-- Server version: 10.6.19-MariaDB-log
-- PHP Version: 8.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `greatpool_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `contact_date` datetime NOT NULL,
  `phone` varchar(20) NOT NULL,
  `note` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `message`, `contact_date`, `phone`, `note`) VALUES
(1, 'นางสาวชาติญา งามสอน', 'chatiya2513@gmail.com', 'ฉันต้องการสั่งหนังสือ และเชือกเทียนด้วยจะทำอย่างไร ต้องโอนเงินเลยหรือว่ามีระบบเก็บเงินปลายทาง', '2025-03-04 12:36:00', '', ''),
(2, 'นางสาวชาติญา งามสอน', 'chatiya2513@gmail.com', 'ฉันต้องการสั่งหนังสือ และเชือกเทียนด้วยจะทำอย่างไร ต้องโอนเงินเลยหรือว่ามีระบบเก็บเงินปลายทาง', '2025-03-04 12:40:44', '', ''),
(3, 'ธนกฤต เนียมหอม', 'seekhuahin@gmail.com', 'ฉันก็ต้องการหนังสือ', '2025-03-04 12:41:03', '', ''),
(4, 'ธนกฤต เนียมหอม', 'seekhuahin@gmail.com', 'ทดสอบ ทดสอบ Ticket', '2025-03-04 12:45:19', '', ''),
(5, 'ธนกฤต เนียมหอม', 'seekhuahin@gmail.com', 'ทดสอบ', '2025-03-04 15:09:24', '0852912508', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
