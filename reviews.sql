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
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `villa_id` int(11) DEFAULT NULL,
  `customer_name` varchar(100) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `comment` text DEFAULT NULL,
  `review_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `villa_id`, `customer_name`, `rating`, `comment`, `review_date`) VALUES
(1, NULL, 'สมชาย', 5, 'วิลล่าสวยมาก สระน้ำสะอาด บรรยากาศดีสุดๆ', '2025-03-07 23:34:06'),
(2, NULL, 'น้องน้ำ', 4, 'ห้องพักดี แต่wifi ช้านิดนึง', '2025-03-07 23:34:06'),
(3, NULL, 'ป้าทอง', 5, 'ประทับใจมาก มาพักอีกแน่นอน', '2025-03-07 23:34:06'),
(4, NULL, 'คุณหญิงโม', 5, 'อากาศดีมาก คุณเมย์ก็คุยเป็นกันเอง บริการให้ความสะดวกดีมาก ไว้ต้องไปอีกแน่นอนคะ ขอบคุณนะค่ะ', '2025-03-08 00:04:13'),
(5, NULL, 'แตงไทย', 5, 'อากาศดี สระสะอาด แอร์เย็น แม่บ้านน่ารักใจดีคะ อยากไปอีก', '2025-03-08 00:08:59'),
(6, NULL, 'แต๋ว', 5, 'อากาศดี สระสะอาด แอร์เย็น', '2025-03-08 00:27:09'),
(7, NULL, 'น้องผักกาด', 5, 'อากาศดีมาก ห้องใหม่ สะอาด บริการดีค่ะ ', '2025-03-08 00:31:06'),
(8, NULL, 'โนเน่ รสมะนาว', 5, 'สวย อากาศดีมากคะ ต้องไปอีกแน่ๆ ', '2025-03-15 01:19:56'),
(10, NULL, 'ธิดา', 4, 'บรรยากาศดีมาก พี่เมย์กันเองมาก แต่หัก 1 คะแนนแม่บ้านมา checkout ช้าไปนิด', '2025-03-15 01:29:28'),
(11, NULL, 'สมหญิง', 4, 'ฉันให้สี่คะแนน เพราะครัวเก่าไปนิด', '2025-03-15 01:30:16'),
(14, NULL, 'อนง', 4, 'สวย', '2025-03-15 09:07:26'),
(15, NULL, 'Prostokva__jiot', 5, 'Hello! I having a great day. Good luck :)', '2025-03-15 13:36:11'),
(16, 1, 'GeorgePot', 5, 'Hi, I wanted to go again. so nice.', '2025-03-16 15:31:59'),
(17, 2, 'ธนกฤต เนียมหอม', 4, 'ดีอะชอบมากๆ ไว้มาอีก แต่แม่บ้านมาช้าไปนิด', '2025-03-17 01:49:04'),
(19, 5, 'รถชา', 5, 'สวยบรรยากาศดีมากคะ ต้องไปอีกแน่แน่เลยค่ะ', '2025-03-17 02:14:17'),
(21, 4, 'Thank you for registering - it was incredible and pleasant all the best http://yandex.ru ladonna  cu', 3, '<a href=\"https://goo.com\"><img src=\"https://webref.ru/example/image/panda.png\" alt=\"\"></a>', '2025-03-19 19:09:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `villa_id` (`villa_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`villa_id`) REFERENCES `villas` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
