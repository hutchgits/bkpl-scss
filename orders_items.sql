-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 19, 2025 at 10:20 PM
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
-- Table structure for table `orders_items`
--

CREATE TABLE `orders_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `note` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `orders_items`
--

INSERT INTO `orders_items` (`id`, `order_id`, `product_id`, `product_name`, `price`, `quantity`, `note`) VALUES
(88, 117, 1, 'รหัส BK01 หนังสือสอนถักเชือกเทียน', 850.00, 1, ''),
(89, 117, 2, 'รหัส A01 วัสดุอุปกรณ์ฝึกถักพื้นฐาน', 120.00, 1, ''),
(90, 118, 1, 'รหัส BK01 หนังสือสอนถักเชือกเทียน', 850.00, 1, ''),
(91, 118, 3, 'รหัส 903 เชือกเทียนเบอร์2 สีดำ', 155.00, 1, ''),
(92, 118, 4, 'รหัส 907 เชือกเทียนเบอร์2 สีน้ำตาลเข้ม', 155.00, 1, ''),
(93, 119, 1, 'รหัส BK01 หนังสือสอนถักเชือกเทียน', 850.00, 1, ''),
(94, 119, 2, 'รหัส A01 วัสดุอุปกรณ์ฝึกถักพื้นฐาน', 120.00, 1, ''),
(95, 119, 3, 'รหัส 903 เชือกเทียนเบอร์2 สีดำ', 155.00, 1, ''),
(96, 120, 1, 'รหัส BK01 หนังสือสอนถักเชือกเทียน', 850.00, 1, ''),
(97, 120, 2, 'รหัส A01 วัสดุอุปกรณ์ฝึกถักพื้นฐาน', 120.00, 2, ''),
(113, 124, 1, 'รหัส BK01 หนังสือสอนถักเชือกเทียน', 850.00, 1, ''),
(114, 124, 2, 'รหัส A01 วัสดุอุปกรณ์ฝึกถักพื้นฐาน', 120.00, 1, ''),
(115, 125, 1, 'รหัส BK01 หนังสือสอนถักเชือกเทียน', 850.00, 1, ''),
(116, 125, 2, 'รหัส A01 วัสดุอุปกรณ์ฝึกถักพื้นฐาน', 120.00, 1, ''),
(117, 126, 1, 'รหัส BK01 หนังสือสอนถักเชือกเทียน', 850.00, 1, ''),
(118, 126, 2, 'รหัส A01 วัสดุอุปกรณ์ฝึกถักพื้นฐาน', 120.00, 1, ''),
(119, 127, 1, 'รหัส BK01 หนังสือสอนถักเชือกเทียน', 850.00, 1, ''),
(120, 127, 2, 'รหัส A01 วัสดุอุปกรณ์ฝึกถักพื้นฐาน', 120.00, 1, ''),
(121, 128, 1, 'รหัส BK01 หนังสือสอนถักเชือกเทียน', 850.00, 1, ''),
(122, 128, 2, 'รหัส A01 วัสดุอุปกรณ์ฝึกถักพื้นฐาน', 120.00, 1, ''),
(123, 129, 1, 'รหัส BK01 หนังสือสอนถักเชือกเทียน', 850.00, 1, ''),
(124, 129, 2, 'รหัส A01 วัสดุอุปกรณ์ฝึกถักพื้นฐาน', 120.00, 1, ''),
(125, 130, 1, 'รหัส BK01 หนังสือสอนถักเชือกเทียน', 850.00, 1, ''),
(126, 130, 2, 'รหัส A01 วัสดุอุปกรณ์ฝึกถักพื้นฐาน', 120.00, 1, ''),
(127, 131, 1, 'รหัส BK01 หนังสือสอนถักเชือกเทียน', 850.00, 1, ''),
(128, 131, 2, 'รหัส A01 วัสดุอุปกรณ์ฝึกถักพื้นฐาน', 120.00, 1, ''),
(129, 132, 1, 'รหัส BK01 หนังสือสอนถักเชือกเทียน', 850.00, 1, ''),
(130, 132, 2, 'รหัส A01 วัสดุอุปกรณ์ฝึกถักพื้นฐาน', 120.00, 1, ''),
(131, 133, 1, 'รหัส BK01 หนังสือสอนถักเชือกเทียน', 850.00, 2, ''),
(132, 133, 2, 'รหัส A01 วัสดุอุปกรณ์ฝึกถักพื้นฐาน', 120.00, 2, ''),
(133, 133, 3, 'รหัส 903 เชือกเทียนเบอร์2 สีดำ', 155.00, 2, ''),
(134, 134, 1, 'รหัส BK01 หนังสือสอนถักเชือกเทียน', 850.00, 2, ''),
(135, 134, 2, 'รหัส A01 วัสดุอุปกรณ์ฝึกถักพื้นฐาน', 120.00, 2, ''),
(136, 134, 3, 'รหัส 903 เชือกเทียนเบอร์2 สีดำ', 155.00, 2, ''),
(137, 135, 1, 'รหัส BK01 หนังสือสอนถักเชือกเทียน', 850.00, 2, ''),
(138, 135, 2, 'รหัส A01 วัสดุอุปกรณ์ฝึกถักพื้นฐาน', 120.00, 2, ''),
(139, 135, 3, 'รหัส 903 เชือกเทียนเบอร์2 สีดำ', 155.00, 2, ''),
(140, 136, 1, 'รหัส BK01 หนังสือสอนถักเชือกเทียน', 850.00, 2, ''),
(141, 136, 2, 'รหัส A01 วัสดุอุปกรณ์ฝึกถักพื้นฐาน', 120.00, 2, ''),
(142, 136, 3, 'รหัส 903 เชือกเทียนเบอร์2 สีดำ', 155.00, 2, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders_items`
--
ALTER TABLE `orders_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders_items`
--
ALTER TABLE `orders_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders_items`
--
ALTER TABLE `orders_items`
  ADD CONSTRAINT `orders_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
