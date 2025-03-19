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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'ชื่อสินค้า',
  `image` varchar(255) NOT NULL COMMENT 'URL รูปภาพสินค้า',
  `description` text NOT NULL COMMENT 'คำอธิบายสินค้า',
  `price` decimal(10,2) NOT NULL COMMENT 'ราคาสินค้า (รองรับทศนิยม 2 ตำแหน่ง)',
  `stock` int(11) NOT NULL COMMENT 'จำนวนสต็อก',
  `sold` int(11) NOT NULL DEFAULT 0 COMMENT 'จำนวนที่ขายแล้ว',
  `note` varchar(500) NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `image`, `description`, `price`, `stock`, `sold`, `note`, `updated_at`) VALUES
(1, 'รหัส BK01 หนังสือสอนถักเชือกเทียน', 'images/book.jpg', 'หนังสือ ตำรารวมเทคนิคการถักเชือกเทียน', 850.00, 1966, 2072, '', NULL),
(2, 'รหัส A01 วัสดุอุปกรณ์ฝึกถักพื้นฐาน', 'images/acc.jpg', 'ชุดวัสดุอุปกรณ์ฝึกพื้นฐาน', 120.00, 2949, 1065, '', NULL),
(3, 'รหัส 903 เชือกเทียนเบอร์2 สีดำ', 'images/black.jpg', 'เชือกเทียนเบอร์ 2 สีดำ ม้วนใหญ่', 155.00, 59, 1246, '', NULL),
(4, 'รหัส 907 เชือกเทียนเบอร์2 สีน้ำตาลเข้ม', 'images/dark-brown.jpg', 'เชือกเทียนเบอร์ 2 สีน้ำตาลเข้ม ม้วนใหญ่', 155.00, 84, 1221, '', NULL),
(5, 'รหัส 902 เชือกเทียนเบอร์2 สีขาว', 'images/white.jpg', 'เชือกเทียนเบอร์ 2 สีขาว ม้วนใหญ่', 155.00, 26, 1213, '', NULL),
(6, 'รหัส 901 เชือกเทียนเบอร์2 สีดำ', 'images/black.jpg', 'เชือกเทียนเบอร์ 2 สีดำ', 155.00, 94, 1211, '', NULL),
(7, 'รหัส 901 เชือกเทียนเบอร์2 สีดำ', 'images/black.jpg', 'เชือกเทียนเบอร์ 2 สีดำ', 155.00, 100, 1205, '', NULL),
(8, 'รหัส 901 เชือกเทียนเบอร์2 สีดำ', 'images/black.jpg', 'เชือกเทียนเบอร์ 2 สีดำ', 155.00, 44, 1206, '', NULL),
(9, '909 เชือกเทียนสีฟ้า เบอร์2', 'images/blue_sky.jpg', 'เชือกเทียนสีฟ้า เบอร์ 2 ม้วนใหญ่', 155.00, 20, 10, '', NULL),
(10, '910 เชือกเทียนเบอร์2 สีเบจ', 'images/base.jpg', 'เชือกเทียนเบอร์2 สีเบจ ม้วนใหญ่', 155.00, 30, 0, '', NULL),
(11, '912 เชือกเทียนสีน้ำตาลแดง เบอร์2', 'images/red_brown.jpg', 'เชือกเทียนสีน้ำตาลแดง เบอร์2', 155.00, 8, 1, '', '2025-03-07 12:57:58'),
(12, '913 เชือกเทียนสีเหลือง เบอร์2', 'images/yellow.jpg', 'เชือกเทียนสีเหลือง เบอร์2 ม้วนใหญ่', 155.00, 9, 1, '', '2025-03-07 12:57:58'),
(13, '908 เชือกเทียนสีชมพู เบอร์2', 'images/pink.jpg', 'เชือกเทียนสีชมพู เบอร์2', 155.00, 12, 1, '', '2025-03-07 13:11:14'),
(14, '916 เชือกเทียนสีเขียวเข้ม เบอร์2', 'images/dark_green.jpg', 'เชือกเทียนสีเขียวเข้ม เบอร์2 ม้วนใหญ่', 155.00, 9, 1, '', '2025-03-07 12:57:58'),
(15, '914 เชือกเทียนสีม่วง เบอร์2', 'images/purple.jpg', 'เชือกเทียนสีม่วง เบอร์2 ม้วนใหญ่', 155.00, 13, 1, '', '2025-03-07 12:57:58'),
(16, 'รหัส 910 เชือกเทียนสีน้ำตาลอ่อน เบอร์2', 'images/soft_brown.jpg', 'เชือกเทียนสีน้ำตาลอ่อน เบอร์2 ม้วนใหญ่', 155.00, 9, 0, '', '2025-03-07 14:01:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
