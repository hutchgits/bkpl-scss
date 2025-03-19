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
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text NOT NULL,
  `phone` varchar(10) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `shipping` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `order_date` datetime NOT NULL,
  `pay_date` datetime NOT NULL,
  `ship_date` datetime NOT NULL,
  `tracking_no` varchar(50) NOT NULL,
  `note` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `email`, `address`, `phone`, `subtotal`, `shipping`, `total`, `order_date`, `pay_date`, `ship_date`, `tracking_no`, `note`) VALUES
(117, 'นายสุดติ่ง กระดิ่งแมวพันธ์', 'seekhin@gmail.com', '3/999 keangnatee village leabklongchonpatan Rd.', '0852912256', 970.00, 80.00, 1050.00, '2025-03-07 17:01:31', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(118, 'ธนกฤต เนียมหอม', 'seekhuahin@gmail.com', '3/168 หมู๋บ้านเคียงนที ต.หัวหิน อ.หัวหิน จ.ประจวบฯ 77112', '0852912508', 1160.00, 100.00, 1260.00, '2025-03-07 17:04:38', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(119, 'นางสาวชาติญา งามสอน', 'chatiya2513@gmail.com', '3/168 keangnatee village leabklongchonpatan Rd.', '0984622914', 1125.00, 100.00, 1225.00, '2025-03-07 18:11:20', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(120, 'Thanakit Niemhom', NULL, '3/168 keangnatee village leabklongchonpatan Rd.', '0852912575', 1090.00, 100.00, 1190.00, '2025-03-07 18:12:59', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(124, 'Thanakit Niemhom', NULL, '3/168 keangnatee village leabklongchonpatan Rd.', '0852912508', 970.00, 80.00, 1050.00, '2025-03-07 18:37:37', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(125, 'Thanakit Niemhom', NULL, '3/168 keangnatee village leabklongchonpatan Rd.', '0852912508', 970.00, 80.00, 1050.00, '2025-03-07 18:37:43', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(126, 'กหดหกด ดกหดหกดห', 'seekhuahin@gmail.com', 'เลียบคลองชลประทาน', '0852912508', 970.00, 80.00, 1050.00, '2025-03-07 18:44:43', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(127, 'กหดหกด ดกหดหกดห', 'seekhuahin@gmail.com', 'เลียบคลองชลประทาน', '0852912508', 970.00, 80.00, 1050.00, '2025-03-07 18:48:59', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(128, 'กหดหกด ดกหดหกดห', 'seekhuahin@gmail.com', 'เลียบคลองชลประทาน', '0852912508', 970.00, 80.00, 1050.00, '2025-03-07 18:49:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(129, 'กหดหกด ดกหดหกดห', 'seekhuahin@gmail.com', 'เลียบคลองชลประทาน', '0852912508', 970.00, 80.00, 1050.00, '2025-03-07 18:49:03', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(130, 'กหดหกด ดกหดหกดห', 'seekhuahin@gmail.com', 'เลียบคลองชลประทาน', '0852912508', 970.00, 80.00, 1050.00, '2025-03-07 18:49:05', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(131, 'กหดหกด ดกหดหกดห', 'seekhuahin@gmail.com', 'เลียบคลองชลประทาน', '0852912508', 970.00, 80.00, 1050.00, '2025-03-07 18:49:33', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(132, 'กหดหกด ดกหดหกดห', 'seekhuahin@gmail.com', 'เลียบคลองชลประทาน', '0852912508', 970.00, 80.00, 1050.00, '2025-03-07 18:49:35', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(133, 'ดำ เมืองชล', NULL, '235 ระยอง ชลบุรี', '0852999999', 2250.00, 130.00, 2380.00, '2025-03-07 19:10:36', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(134, 'ดำ เมืองชล', NULL, '235 ระยอง ชลบุรี', '0852999999', 2250.00, 130.00, 2380.00, '2025-03-07 19:18:17', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(135, 'ดำ เมืองชล', NULL, '235 ระยอง ชลบุรี', '0852999999', 2250.00, 130.00, 2380.00, '2025-03-07 19:23:29', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(136, 'ดำ เมืองชล', NULL, '235 ระยอง ชลบุรี', '0852999999', 2250.00, 130.00, 2380.00, '2025-03-07 19:36:24', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
