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
-- Table structure for table `threads`
--

CREATE TABLE `threads` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `threads`
--

INSERT INTO `threads` (`id`, `user_id`, `title`, `category`, `created_at`, `ip_address`, `content`) VALUES
(20, 1, 'เชือกเทียนที่ดีควรเป็นอย่างไร', 'rope', '2025-03-06 13:16:15', '184.22.14.182', 'คุณสมบัติของเชือกเทียนที่ดี – ถักสนุก งานออกมาสวย!\r\nถ้าคุณกำลังสนใจงานถักเชือก หรืออยากลองเป็นช่างถักฝีมือเยี่ยม รู้ไหมว่า… เชือกเทียนที่ดีมีผลต่อชิ้นงานมาก! เชือกที่ดีจะช่วยให้ถักง่าย งานออกมาสวย และไม่เสียอารมณ์ระหว่างทำ มาเช็กกันว่าต้องเลือกเชือกแบบไหน!\r\n\r\n1. เส้นเชือกต้องแน่น เรียบ และสม่ำเสมอ\r\nถักแล้วไม่สะดุด ไม่มีจุดบางหรือหนาเกินไป\r\nงานออกมาสวย ไม่บิดเบี้ยว\r\n2. ลนไฟแล้วหลอมติดง่าย\r\nเชือกเทียนแท้ต้องลนไฟแล้วติดกันเรียบ ไม่แตกเป็นขุย\r\nไม่มีกลิ่นฉุนแรงเกินไป\r\n3. สีสด ติดทนนาน\r\nสีไม่ซีด ไม่ตกเวลาโดนน้ำหรือเหงื่อ\r\nมีสีให้เลือกเยอะ ทำให้สร้างงานได้หลากหลาย\r\n4. เหนียว ทน ไม่ขาดง่าย\r\nดึงแรง ๆ แล้วไม่ขาด ถักได้แน่น งานแข็งแรง\r\nไม่เปื่อย ไม่ยุ่ยง่าย\r\n5. ผิวลื่น ไม่ฝืดมือ\r\nถักแล้วลื่นมือ ไม่ติด ไม่สะดุด\r\nงานออกมาเนี๊ยบ ไม่เป็นขุย\r\n6. ยืดหยุ่นได้ แต่ไม่ย้วย\r\nมีความยืดหยุ่นกำลังดี ทำให้ถักง่าย\r\nไม่เสียทรงเวลาถักแน่น ๆ\r\nเมื่อได้เชือกดี งานก็ออกมาดี!\r\nลองจินตนาการดู… กำไลถักที่เรียบเนียน แหวนเชือกที่แน่นเป๊ะ หรือพวงกุญแจที่สีสวยสดใส งานแฮนด์เมดที่ทำจากใจ ถ้าใช้เชือกดี ๆ ก็ช่วยให้สนุกกับการถักมากขึ้น\r\n\r\nอยากลองเป็น ช่างถัก ดูไหม?');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `threads`
--
ALTER TABLE `threads`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `threads`
--
ALTER TABLE `threads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
