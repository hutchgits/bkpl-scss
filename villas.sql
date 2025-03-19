-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 19, 2025 at 10:21 PM
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
-- Table structure for table `villas`
--

CREATE TABLE `villas` (
  `id` int(11) NOT NULL,
  `villa_code` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `bedrooms` int(11) NOT NULL,
  `bathrooms` int(11) NOT NULL,
  `amenities` mediumtext DEFAULT NULL,
  `house_rules` mediumtext DEFAULT NULL,
  `extra_services` mediumtext DEFAULT NULL,
  `bedroom_details` mediumtext DEFAULT NULL,
  `booking_details` mediumtext DEFAULT NULL,
  `check_in_time` time DEFAULT NULL,
  `check_out_time` time DEFAULT NULL,
  `contact_info` varchar(255) DEFAULT NULL,
  `price` decimal(10,0) NOT NULL,
  `extra_service_price` decimal(10,0) DEFAULT 0,
  `discount` decimal(5,0) DEFAULT 0,
  `min_nights` int(11) DEFAULT 1,
  `price_details` mediumtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `capacity` int(11) NOT NULL,
  `max_guests` int(11) DEFAULT 0,
  `extra_guest_fee` decimal(10,2) DEFAULT 0.00,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `location` varchar(100) DEFAULT NULL,
  `pet_allowed` tinyint(1) DEFAULT 0,
  `status` enum('available','booked') NOT NULL DEFAULT 'available',
  `sea_proximity` enum('beachfront','near_sea','far_from_sea') DEFAULT 'far_from_sea',
  `google_sheets_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `villas`
--

INSERT INTO `villas` (`id`, `villa_code`, `title`, `description`, `bedrooms`, `bathrooms`, `amenities`, `house_rules`, `extra_services`, `bedroom_details`, `booking_details`, `check_in_time`, `check_out_time`, `contact_info`, `price`, `extra_service_price`, `discount`, `min_nights`, `price_details`, `image`, `capacity`, `max_guests`, `extra_guest_fee`, `created_at`, `updated_at`, `location`, `pet_allowed`, `status`, `sea_proximity`, `google_sheets_url`) VALUES
(1, 'PCS090', 'บ้านพักพูลวิลล่า', '⛵Pool Villa หรูติดทะเล บนเนื้อที่กว่า 300 ตารางวา บ้านพัก 2 ชั้นสไตล์โมเดิร์นสีขาวสบายตา พร้อมด้วยชายหาดส่วนตัว เหมาะสำหรับครอบครัวและผู้ที่ต้องการดื่มด่ำกับบรรยากาศสุดแสนพิเศษ?รองรับได้ 15-20 ท่าน', 5, 6, '✅รายละเอียดบ้านพัก\r\n✔5 ห้องนอน (sea view ทุกห้อง)\r\n✔6 ห้องน้ำ\r\n✔ผ้าเช็ดตัว ครีมอาบน้ำ แชมพู\r\n✔ไดร์เป่าผม\r\n✔Free Wifi\r\n✔คาราโอเกะ\r\n✔โต๊ะพูล\r\n✔อุปกรณ์ครัวครบครัน\r\n✔เตา BBQ\r\n✔สระว่ายน้ำ ขนาด 3*10 เมตร\r\n✔จอดรถในบ้านได้ 2 คัน หน้าบ้านได้อีก 2-3 คัน', '❗กฎระเบียบบ้านพัก\r\n-ห้ามสูบบุหรี่ภายในบริเวณบ้าน\r\n-งดส่งเสียงดังหลัง 24:00 น.\r\n-ห้ามเข้าพักเกินจำนวนที่ระบุ\r\n-ถ้ามีของสูญหาย/ชำรุดเสียหาย ภายในบริเวณบ้านพัก ผู้เช่าต้องรับผิดชอบ\r\n', '✅บริการพิเศษ ❗(ไม่มีค่าใช้จ่าย)\r\n✔SUB BOARD 2 ชุด\r\n✔ห่วงยางแฟนซี 2 ชิ้น\r\n✔ถ่าน 5 ถุง\r\n✔น้ำแข็ง 2 กระสอบ\r\n', '✅รายละเอียดห้องนอน\r\n▶ห้องนอนที่ 1 : เตียง 6 ฟุต 1 เตียง (2 ท่าน)\r\n▶ห้องนอนที่ 2 : เตียง 6 ฟุต 1 เตียง (2 ท่าน)\r\n▶ห้องนอนที่ 3 : เตียง 6 ฟุต 1 เตียง (2 ท่าน)\r\n▶ห้องนอนที่ 4 : เตียง 2 ชั้น 2 เตียง (4 ท่าน)\r\n▶ห้องนอนที่ 5 : เตียง 5 ฟุต 2 เตียง และเตียง 3.5 ฟุต 1 เตียง (5 ท่าน)', '✅โอนจองเต็มจำนวนหรือมัดจำขั้นต่ำ 50%\r\n✅โอนจองแล้ว งดยกเลิก งดคืนเงินทุกกรณี\r\n✅ค่าประกันบ้าน 10,000 บาท(คืนเต็มจำนวนวัน check out หลังตรวจเช็กแล้วไม่มีอะไรชำรุดเวียหาย)', '14:00:00', '11:00:00', 'สำรองบ้านพัก:Tel.098-462 2914 คุณเมย์ หรือ line id : chatiya2513', 25000, 0, 0, 1, '✅ราคาบ้านพัก❗\r\n❌HI SEASON ❌ ( 1 ต.ค. - 15 พ.ค. )\r\n❤อาทิตย์ - พฤหัส 25,000/15 ท่าน\r\n?วันศุกร์ 30,000/15 ท่าน\r\n?วันเสาร์ 39,000/15 ท่าน\r\n?หยุดยาว/นักขัตฯ 39,000/15 ท่าน\r\n?ปีใหม่/สงกรานต์ 45,000/15 ท่าน\r\n❌LOW SEASON❌ ( 16 พ.ค. - 30 ก.ย.)\r\n❤อาทิตย์ - พฤหัส 22,000/15 ท่าน\r\n?วันศุกร์ 30,000/15 ท่าน\r\n?วันเสาร์ 39,000/15 ท่าน\r\n?หยุดยาว/นักขัตฯ 39,000/15 ท่าน\r\n\r\n✅รองรับได้สูงสุด 20 ท่านเสริมท่านละ 500/คืน\r\n✅เด็กอายุต่ำกว่า 10 ขวบ พักฟรี 4 ท่าน (นอนกับผู้ปกครอง)', '/images/PCS090/pool-villa-luxury-Chaam.webp', 20, 0, 500.00, '2025-03-15 22:15:23', '2025-03-18 13:27:15', 'หาดปึกเตียน - ชะอำ', 0, 'available', 'beachfront', 'https://docs.google.com/spreadsheets/d/xxx1/edit'),
(2, 'PCS093', 'บ้านพักพูลวิลล่า', '?บ้านพูลวิลล่าติดทะเลหลังใหญ่สุดๆ มีทุกกิจกรรม ครบจบในหลังเดียว ไม่ว่าจะมากับเพื่อน มากับครอบครัว มากับบริษัท มากับแฟน บ้านของเราก็ตอบโจทย์สุดๆ', 7, 8, '✅รายละเอียดบ้านพัก\r\n?7 ห้องนอน\r\n?8 ห้องน้ำ\r\n?ผ้าเช็ดตัว ครีมอาบน้ำ แชมพู\r\n?ไดร์เป่าผม\r\n?Free Wifi\r\n?คาราโอเกะ\r\n?โต๊ะพูล 8 ฟุต\r\n?สระว่ายน้ำ ขนาด 7*8 เมตร\r\n?สไลเดอร์ 8 เมตร\r\n?โต๊ะปิงปอง\r\n?อุปกรณ์ครัวครบครัน\r\n?เตา BBQ\r\n?จอดรถในบ้านได้ 6-8 คัน', '❗กฎระเบียบบ้านพัก\r\n?ห้ามสูบบุหรี่ภายในบริเวณบ้าน\r\n?งดส่งเสียงดังหลัง 22:00 น.\r\n?ห้ามเข้าพักเกินจำนวนที่ระบุ\r\n?ถ้ามีของสูญหาย/ชำรุดเสียหาย ภายในบริเวณบ้านพัก ผู้เช่าต้องรับผิดชอบ', '?บริการพิเศษ?(ไม่มีค่าใช้จ่าย)\r\n▶SUP BOARD 1 ชุด\r\n▶เรือพายใส 1 ชุด\r\n▶ถ่านปิ้งย่าง\r\n▶น้ำแข็ง 1 กระสอบ/คืน\r\n▶น้ำเปล่า 1 แพค/คืน', '✅รายละเอียดห้องนอน\r\n?ชั้นล่าง\r\n▶ห้องนอนที่ 1 : เตียง 6 ฟุต 2 เตียง (4 ท่าน)\r\n▶ห้องนอนที่ 2 : เตียง 6 ฟุต 1 เตียง (2 ท่าน)\r\n▶ห้องนอนที่ 3 : เตียง 6 ฟุต 1 เตียง + เสริม 1(3 ท่าน)\r\n\r\n?ชั้นบน\r\n▶ห้องนอนที่ 4 : เตียง 6 ฟุต 1 เตียง +เสริม 2 (4 ท่าน)\r\n▶ห้องนอนที่ 5 : เตียง 5 ฟุต 2 เตียง (4 ท่าน)\r\n▶ห้องนอนที่ 6 : เตียง 5 ฟุต 3 เตียง +เสริม 2 (8 ท่าน)\r\n▶ห้องนอนที่ 7 : เตียง 5 ฟุต 2 เตียง (4 ท่าน)\r\n', '?รายละเอียดการจอง\r\n✅โอนจองเต็มจำนวนหรือมัดจำขั้นต่ำ 60%\r\n✅โอนจองแล้ว งดยกเลิก งดคืนเงินทุกกรณี\r\n✅ค่าประกันบ้านวันเข้าพัก 10,000 บาท (คืนเต็มจำนวนวัน check out หลังเช็กบ้านแล้วไม่มีความเสียหายใดๆ)\r\n', '14:30:00', '11:00:00', 'สำรองบ้านพัก: โทร.098-462-2914 คุณเมย์ หรือ line id : chatiya2513', 31900, 0, 0, 1, '✅ราคาที่พัก โปรเดือนมีนาคม\r\nอาทิตย์ - พฤหัส\r\nเปิด 6 ห้องนอน  31,900/20 ท่าน\r\nเปิด 7 ห้องนอน  35,900/25 ท่าน\r\n\r\nวันศุกร์\r\nเปิด 6 ห้องนอน  33,900/20 ท่าน\r\nเปิด 7 ห้องนอน  37,900/25 ท่าน\r\n\r\nวันเสาร์\r\nเปิด 7 ห้องนอน  45,900/25 ท่าน\r\n\r\n?หยุดยาว/นักขัตฯ\r\nเปิด 7 ห้องนอน  49,900/25 ท่าน\r\n\r\nปีใหม่/สงกรานต์\r\nเปิด 7 ห้องนอน  55,900/25 ท่าน\r\n\r\n✅เกินจำนวนที่ระบุเสริมท่านละ 700/คืน\r\n✅รองรับได้สูงสุด 30-35 ท่าน\r\n✅ฟรีเด็กอายุไม่เกิน 7 ขวบ 5 ท่าน (นอนกับผู้ปกครอง)\r\nรับสัตว์เลี้ยงพันธุ์เล็กตัวละ 500/คืน', '/images/PCS093/pool-villa-luxury-CHA-AM.webp', 35, 0, 700.00, '2025-03-16 00:54:40', '2025-03-18 13:27:15', 'หาดบางเกตุ - ชะอำ', 1, 'available', 'beachfront', 'https://docs.google.com/spreadsheets/d/xxx2/edit'),
(3, 'PCS051', 'บ้านพักพูลวิลล่า', '? บ้านพักหลังใหญ่สุดหรูริมทะเลชะอำ บนพื้นที่กว่า 1 ไร่ พื้นที่ใช้สอยกว่า 1,000 ตารางเมตร สำหรับการพักผ่อนที่เป็นส่วนตัวสุดๆ รองรับ 19-21 ท่าน\r\n', 6, 7, '..\r\n✔6 ห้องนอน \r\n✔7 ห้องน้ำ\r\n✔เครื่องทำน้ำอุ่นทุกห้อง\r\n✔ไดร์เป่าผม\r\n✔ห้องนั่งเล่นขนาดใหญ่\r\n✔Smart  TV จอขนาด 55-65 นิ้ว\r\n✔Free Wifi\r\n✔คาราโอเกะผ่านเครื่องเล่น เพลงใหม่ล่าสุด และยัง upload online เพิ่มได้ตามต้องการ\r\n✔ห้องครัวอุปกรณ์ครัวครบครัน(สามารถประกอบอาหารได้)\r\n✔เตาปิ้งย่างระบบแก๊ส\r\n✔โต๊ะพูลขนาดมาตรฐาน\r\n✔สระว่ายน้ำระบบเกลือ ขนาด 6*12 เมตร\r\n✔Pool bar ริมสระว่ายน้ำ \r\n✔นั่งชมวิวทะเลบนระเบียงบาร์ชั้น 2\r\n✔อ่างจากุชชี่ วิวทะเลบนบาร์ชั้น 2\r\n✔ระเบียงริมทะเล\r\n✔แม่บ้านทำความสะอาด ส่วนกลาง 2 เวลา หลังอาหารเช้าและเย็น', '❗ \r\n⛔สามารถเปลี่ยนวันล่วงหน้าได้ 30 วัน ก่อนวันเข้าพักเท่านั้น และต้องใช้สิทธิ์ภายใน 60 วัน นับจากวันจอง ในกรณีที่ลูกค้าต้องการเปลี่ยนวันเข้าพัก ไปในวันที่ราคาต่ำลง จากวันที่ลูกค้าจองไป ไม่สามารถคืนเงินลูกค้า ไม่ว่ากรณีใดๆ\r\n⛔ในกรณีที่ลูกค้าต้องการลดจำนวนวันที่เข้าพัก ไม่สามารถใช้เงินมัดจำเป็นค่าเข้าพักแทนได้ และไม่สามารถคืนเงินลูกค้าได้ไม่ว่ากรณีใดๆ\r\n❌ห้ามสูบบุหรี่ในบ้านพักโดยเด็ดขาด(ฝ่าฝืนปรับ 10,000 บาท)\r\n⛔เศษอาหาร อาเจียนในสระว่ายน้ำ ปรับ 10,000 บาท\r\n⛔อุปกรณ์เป่าลมแตกหรือเสียหาย ปรับ 400-2,000 บาท\r\n⛔ความเสียหายกับเฟอร์นิเจอร์ กระจก อุปกรณ์ต่างๆ ประเมินตามความเสียหาย\r\n⛔อุปกรณ์ครัว จาน ชาม แก้ว ของตกแต่ง 100 - 2,000 บาท/ชิ้น\r\n⛔จำนวนผู้เข้าพักเกินกว่าที่แจ้ง ปรับ 2,000 บาท/ท่าน\r\n❌งดรับสัตว์เลี้ยงทุกชนิด ไม่รับสัตว์เลี้ยงทุกชนิด(ฝ่าฝืนปรับ 10,000 บาท)', '-', '-', ' ..\r\n✅โอนจองเต็มจำนวนหรือมัดจำขั้นต่ำ 60% (โอนชำระส่วนที่เหลือวันเข้าพัก)\r\n✅โอนจองแล้ว งดยกเลิก งดคืนเงินทุกกรณี\r\n✅ค่าประกันบ้านวันเข้าพัก 20,000 บาท (คืนเต็มจำนวนวัน check out หลังตรวจเช็กบ้านแล้วไม่มีความเสียหายใดๆ)', '14:00:00', '11:00:00', 'สำรองบ้านพัก: โทร.098-462 2914 คุณเมย์ หรือ line id : chatiya2513', 38000, 0, 0, 1, '..\r\n⏩ อาทิตย์ - พฤหัส   38,000/19 ท่าน\r\n⏩ วันศุกร์                  40,000/19 ท่าน\r\n⏩ วันเสาร์                 42,000/19 ท่าน\r\n⏩ หยุดยาว/นักขัตฯ  45,000/19 ท่าน\r\n⏩ ปีใหม่/สงกรานต์   55,000/19 ท่าน\r\n** 19 ท่านนอนเตียงครบ\r\n\r\n✅เกินจำนวนที่ระบุเสริมท่านละ 1,000/คืน ไม่เกิน 2 ท่าน (ที่นอนเสริม)\r\n✅เด็กไม่เกิน 5 ขวบ ฟรี 2 ท่าน\r\n', '/images/PCS051/pool-villa-luxury-CHA-AM.jpg', 19, 0, 0.00, '2025-03-16 16:35:16', '2025-03-18 13:27:01', 'หาดปึกเตียน - ชะอำ', 0, 'available', 'beachfront', NULL),
(4, 'PCS105', 'บ้านพักพูลวิลล่า', ' บ้านพูลวิลล่าติดทะเล หาดส่วนตัว พร้อมสิ่งอำนวยความสะดวกครบครัน ', 6, 6, '✅รายละเอียดบ้านพัก\r\n✔6 ห้องนอน\r\n✔6 ห้องน้ำ\r\n✔ผ้าเช็ดตัว ครีมอาบน้ำ แชมพู\r\n✔ไดร์เป่าผม\r\n✔Free Wifi\r\n✔คาราโอเกะ\r\n✔สระว่ายน้ำ ขนาด 7*8 เมตร\r\n✔สไลเดอร์ 8 เมตร\r\n✔เตา BBQ\r\n✔โต๊ะพูล 8 ฟุต\r\n✔โต๊ะปิงปอง\r\n✔อุปกรณ์ครัวครบครัน\r\n✔จอดรถในบ้านได้ 8-10 คัน', '❗\r\n❌งดเสียงดังนอกบ้านหลังเวลา 22.00 น.\r\n❌ห้ามลูกค้าสูบบุหรี่ภายในบ้าน\r\n❌หากลูกค้าทำสิ่งของเกิดความเสียหาย ทางที่พักขอคิดค่าเสียหายตามจริง\r\n❌อนุญาตให้เข้าพักตามจำนวนที่แจ้งไว้เท่านั้น', '(ไม่มีค่าใช้จ่าย)\r\n✅ SUP BOARD 1 ชุด\r\n✅ เรือคายัค 1 ชุด\r\n✅ ถ่าน 5 ถุง\r\n✅ น้ำแข็ง 2 กระสอบ\r\n✅ น้ำเปล่า 2 แพค', '.\r\n? ชั้นล่าง (ห้องน้ำรวมกัน)\r\n☑️ ห้องนอนที่ 1 : เตียง 5 ฟุต 2 เตียง (4 ท่าน)\r\n☑️ ห้องนอนที่ 2 : เตียง 6 ฟุต 1 เตียง (2 ท่าน)\r\n**ชั้นล่างเหมาะสำหรับ ครอบครัวที่มีผู้สูงอายุมาด้วย\r\n\r\n?  ชั้นบน\r\n☑️ ห้องนอนที่ 3 : เตียง 6 ฟุต 2 เตียง (4 ท่าน)/sea view\r\n☑️ ห้องนอนที่ 4 : เตียง 6 ฟุต 1 เตียง (2 ท่าน)/sea view\r\n☑️ ห้องนอนที่ 5 : เตียง 6 ฟุต 2 เตียง (4 ท่าน)\r\n☑️ ห้องนอนที่ 6 : เตียง 5 ฟุต 2 เตียง 6 ฟุต 1 เตียง (6 ท่าน)\r\n**ทั้งหมด 22 ท่าน เสริมเตียง ในห้อง 3,5,6 ได้อีก 8 คน รวม 30 ท่าน', '.\r\n✅โอนจองเต็มจำนวนหรือมัดจำขั้นต่ำ 60% ส่วนที่เหลือชำระวันเข้าพัก\r\n✅โอนจองแล้ว งดยกเลิก งดคืนเงินทุกกรณี\r\n✅ค่าประกันบ้านวันเข้าพัก 10,000 บาท (คืนเต็มจำนวนวัน check out หลังเช็กบ้านแล้วไม่มีความเสียหายใดๆ)', '14:30:00', '11:00:00', 'สำรองบ้านพัก: โทร.098-462 2914 คุณเมย์ หรือ line id : chatiya2513', 29900, 0, 0, 1, '✅ราคาที่พักโปร มีนาคม\r\n⏩ อาทิตย์-พฤหัส     \r\nเปิด 5 ห้องนอน  29,900/20 ท่าน\r\nเปิด 6 ห้องนอน  31,900/26 ท่าน\r\n\r\n⏩ วันศุกร์\r\nเปิด 5 ห้องนอน  31,900/20 ท่าน\r\nเปิด 6 ห้องนอน  33,900/26 ท่าน\r\n\r\n⏩ วันเสาร์                 \r\nเปิด 6 ห้องนอน  41,900/26 ท่าน\r\n\r\n⏩ หยุดยาว/นักขัตฯ\r\nเปิด 6 ห้องนอน  45,900/26 ท่าน\r\n\r\n⏩ ปีใหม่/สงกรานต์\r\nเปิด 6 ห้องนอน  52,900/26 ท่าน\r\n\r\n✅เกินจำนวนที่ระบุเสริมท่านละ 700/คืน\r\n✅รองรับได้สูงสุด 30-35 ท่าน\r\n✅ฟรีเด็กอายุไม่เกิน 7 ปี 5 ท่าน (นอนกับผู้ปกครอง)\r\n?  รับสัตว์เลี้ยงพันธุ์เล็ก ตัวละ 500/คืน', '/images/PCS105/pool-villa-luxury-CHA-AM.webp', 35, 0, 0.00, '2025-03-16 18:34:33', '2025-03-18 13:27:01', 'หาดบางเกตุ - ชะอำ', 1, 'available', 'beachfront', NULL),
(5, 'PCS094', 'บ้านพักพูลวิลล่า', '??บ้านพูลวิลล่าติดทะเลครบจบในหลังเดียว ไม่ว่าจะมากับเพื่อน มากับครอบครัว มากับคนรู้ใจ บ้านของเราก็ตอบโจทย์สุดๆ รองรับ 16-25 ท่าน\r\n❗ความพิเศษ : ติดทะเล หาดส่วนตัว\r\n-------------------\r\n✅ใกล้ร้านอาหารชื่อดัง ครัวไข่มุก\r\n✅ใกล้สะพานปูชัก(แหล่งขายอาหารทะเล)\r\n✅Lotus จะอยู่ห่างจากบ้าน ประมาณ 3 ก.ม.\r\n✅มีร้านขายของชำ ใกล้บ้าน 1 ก.ม.\r\n', 5, 4, '✅รายละเอียดบ้าน\r\n✔5 ห้องนอน\r\n✔4 ห้องน้ำ พร้อมเครื่องทำน้ำอุ่น ครีมอาบน้ำ แชมพู ผ้าเช็ดตัว ไดร์เป่าผม\r\n✔1 Living room พร้อมเครื่องเสียงและคาราโอเกะ ไมค์ 2 ตัว\r\n✔สมาร์ททีวี 1 เครื่อง\r\n✔Free Wi-fi\r\n✔แอร์ 7 ตัว ทั้งบ้าน\r\n✔ห้องครัว ภายในบ้าน พร้อมอุปกรณ์ทำครัวครบครัน\r\n✔2 ห้องรับประทานอาหาร พร้อมโซนบาร์นั่งชิว\r\n✔สระว่ายน้ำ\r\n✔เตาปิ้ง BBQ และโซนนั่งเอ้าท์ดอร์\r\n✔วิวติดทะเล เสียงคลื่นดัง\r\n✔ที่จอดรถสะดวกสบาย ในบ้านจอดได้ 4 คัน หน้าบ้านได้อีก 2 -3 คัน', '❗การใช้บ้านพัก\r\n✅หลัง 22.00 เป็นต้นไป กรุณาลดเสียงตามสมควร\r\n✅รบกวนลูกค้าทุกท่านล้างจาน ชาม แก้ว หลังการใช้งานให้เรียบร้อย ก่อนเชคเอ้าครับ (เป็นกฎของบ้านพักพูลวิลล่าทุกหลังนะครับ)\r\n*หากไม่ล้างมีค่าบริการ 1,000 บาท\r\n✅เศษอาหารขยะใส่ถุงดำที่ทางบ้านพักได้เตรียมไว้ให้ค่ะ\r\n❌หากมีบุคคลเข้าพักเกินจากจำนวนที่ได้ทำการจองมา ต้องแจ้งให้ทราบก่อนการเข้าพัก อย่างน้อย1-2 วัน และไม่สามารถมาพักเกินจำนวนที่กำหนดสูงสุดได้\r\n❌ไม่อนุญาตให้นำบุคคลภายนอกเข้ามาในบริเวณบ้านพัก ถึงแม้ว่าจะไม่ได้ค้างคืนก็ตาม\r\n(นอกจากว่าได้แจ้งมาก่อนชำระเงิน แล้วทั้งสองฝ่ายมีการตกลงกันก่อนชำระเงิน) ในกรณีฝ่าฝืนหักจากเงินมัดจำ ท่านละ 1,000 บาท\r\n❌ห้ามรับประทานอาหารในสระว่ายน้ำ โดยเด็ดขาด ในกรณีฝ่าฝืนปรับ 2,000\r\n❌ห้ามสูบบุหรี่ในตัวบ้านพักฝ่าฝืน ปรับ 5,000\r\n❌ไม่อนุญาติให้ใช้เครื่องเสียงขนาดใหญ่ทุกชนิดบริเวณนอกตัวบ้าน หรือริมสระว่ายน้ำ (อนุญาตให้ใช้ลำโพงขนาดเล็กเปิดเพลงไม่ดังมากได้ครับ หลัง 22.00 เบาเสียงลง\r\n✅กรณีไฟฟ้าดับ เกิดจาก สาธารณะ ทางบ้านไม่มีส่วนรับผิดชอบใดๆ แต่ ทางเราจะประสานงานให้เร็วที่สุด', '✅บริการพิเศษ?(ไม่มีค่าใช้จ่าย)\r\n▶เรือคายัค 1 ชุด\r\n▶ถ่าน \r\n▶น้ำแข็ง 1 กระสอบ\r\n▶น้ำเปล่า 1 แพ๊ค\r\n---------------------------------------------------------------\r\n✅อุปกรณ์ครัวหรืออื่นๆ ที่ใช้แล้ว ลูกค้าไม่สะดวกล้าง คิดค่าบริการ 1,000 บาท\r\n', '✅รายละเอียดห้องนอน\r\n✅ชั้นบน\r\n▶ห้อง A นอน 4 ท่าน sea view\r\n▶ห้อง B นอน 2 ท่าน sea view\r\n(A+B ใช้ห้องน้ำ ร่วมกัน )\r\n▶ห้อง C นอน 3 ท่าน\r\n▶ห้อง D นอน 2 ท่าน sea view\r\n(C+D ใช้ห้องน้ำ ร่วมกัน)\r\n\r\n✅ชั้นล่าง\r\n▶ห้อง E นอน 4 ท่าน sea view\r\n(ห้องน้ำในตัว)\r\n\r\n**ชั้นล่าง : ห้องรับแขก + ห้องน้ำรวม ห้องครัว', '✅รายละเอียดการจอง\r\n✅โอนจองเต็มจำนวนหรือมัดจำขั้นต่ำ 60%\r\n✅โอนจองแล้ว งดยกเลิก งดคืนเงินทุกกรณี\r\n✅ค่าประกันบ้าน 5,000 บาท(คืนเต็มจำนวนวัน check out หลังเช็กบ้านแล้วไม่มีอะไรชำรุด เสียหาย)', '14:00:00', '11:00:00', 'สำรองบ้านพัก: โทร.098-462 2914 คุณเมย์ หรือ line id : chatiya2513', 19900, 0, 0, 1, '✅ราคาที่พัก \r\n✅วันอาทิตย์ - พฤหัส     \r\nเปิด 4 ห้องนอน  19,900/12 ท่าน\r\nเปิด 5 ห้องนอน  23,900/16 ท่าน\r\n\r\n✅วันศุกร์                \r\nเปิด 4 ห้องนอน  21,900/12 ท่าน\r\nเปิด 5 ห้องนอน  25,900/16 ท่าน\r\n\r\n✅วันเสาร์                 \r\nเปิด 5 ห้องนอน  32,900/16 ท่าน\r\n\r\n✅หยุดยาว/นักขัตฯ \r\nเปิด 5 ห้องนอน  35,900/16 ท่าน\r\n\r\n✅ปีใหม่/สงกรานต์ \r\nเปิด 5 ห้องนอน  39,900/16 ท่าน', '/images/PCS094/pool-villa-luxury-CHA-AM.webp', 25, 0, 0.00, '2025-03-17 01:45:11', '2025-03-18 13:27:01', 'หาดบางเกตุ-ชะอำ', 1, 'available', 'beachfront', NULL),
(6, 'PCS071', 'บ้านพักพูลวิลล่า', '?? บ้านพักพูลวิลล่าหรู ติดทะเลชะอำ พร้อม หาดส่วนตัว ให้คุณสัมผัสบรรยากาศทะเลแบบใกล้ชิด เล่นน้ำได้จริง ไม่มีถนนกั้น วิวสวยสุดสายตา พักผ่อนอย่างเป็นส่วนตัวกับบ้านพักดีไซน์หรู สิ่งอำนวยความสะดวกครบครัน เหมาะสำหรับครอบครัว กลุ่มเพื่อน หรือวันพักผ่อนสุดพิเศษของคุณ! ?✨', 7, 8, '✅รายละเอียดบ้านพัก\r\n✔7 ห้องนอน\r\n✔8 ห้องน้ำ\r\n✔ห้องน้ำในตัวทุกห้อง\r\n✔1 โถงคาราโอเกะ\r\n✔Free Wifi\r\n✔คาราโอเกะระบบยูทูฟ\r\n✔สระว่ายน้ำระบบเกลือ ขนาด 5x10 เมตร\r\n✔มีสไลเดอร์และบ่อทรายสำหรับคุณหนู\r\n✔โต๊ะพูล 7 ฟุต\r\n✔อุปกรณ์ครัวครบครัน\r\n✔เตา BBQ\r\n✔ผ้าเช็ดตัว ไดร์เป่าผม\r\n✔ครีมอาบน้ำ แชมพูสระผม\r\n✔จอดรถในบ้านได้ 10 คัน\r\n', '..\r\n❎งดส่งเสียงดังหลัง 22.00 น.\r\n❎ห้ามเข้าพักเกินจำนวนที่ระบุถ้ามาเพิ่มแล้วไม่แจ้ง ขอยึดเงินประกัน\r\n❎งดนำเครื่องเสียงเข้าบ้านพัก\r\n❎ห้ามเคลื่อนย้ายโต๊ะพูล เครื่องเสียงและอุปกรณ์ต่าง ๆ ภายในบ้าน\r\n❎ห้ามสูบบุหรี่ภายในตัวบ้าน\r\n❎ห้ามนำสิ่งเสพติดทุกชนิดเข้ามาในตัวบ้าน', '..\r\n?กิจกรรมทางน้ำ พายเรือคายัค ฟรี\r\n?เจ็ทสกี/บานาน่าโบ๊ท (มีค่าใช้จ่าย)\r\n✔รปภ.ดูแลตลอดคืน\r\n?รับสัตว์เลี้ยงพันธุ์เล็กตัวละ 500/คืน\r\n?อุปกรณ์ครัวที่ใช้แล้ว หากไม่สะดวกล้างมีค่าบริการครั้งละ 500-1000 บาท', '✅รายละเอียดห้องนอน\r\n?ชั้น 1\r\n▶ห้องนอน 1 : เตียง 6 ฟุต 1 เตียง (2 ท่าน) เสริมได้ 1 ท่าน\r\n▶ห้องนอน 2 : เตียง 6 ฟุต 1 เตียง (2 ท่าน) เสริมได้ 1 ท่าน\r\n▶ห้องนอน 3 : เตียง 6 ฟุต 2 เตียง (4 ท่าน) เสริมได้ 1 ท่าน\r\n▶ห้องนอน 4 : เตียง 6 ฟุต 2 เตียง (4 ท่าน) เสริมได้ 1 ท่าน\r\n\r\n?ชั้น 2\r\n▶ห้องนอน 5 : เตียง 6 ฟุต 2 เตียง มีอ่างอาบน้ำวิวทะเล (4 ท่าน) เสริมได้ 1 ท่าน\r\n▶ห้องนอน 6 : เตียง 6 ฟุต 1 เตียง มีอ่างอาบน้ำวิวทะเล (2 ท่าน) เสริมได้ 1 ท่าน\r\n▶ห้องนอน 7 : เตียง 6 ฟุต 1 เตียง+เตียง 3 ฟุต 1 เตียง (3 ท่าน)\r\n**ห้องนอน 6 และ 7 สามารถเปิดคอนเนคกันได้\r\n', '?รายละเอียดการจอง\r\n✅โอนจองเต็มจำนวน หรือมัดจำขั้นต่ำ 60% ส่วนที่เหลือชำระวันเข้าพัก\r\n✅โอนจองแล้ว งดยกเลิก งดคืนเงินทุกกรณี\r\n✅ค่าประกันบ้านวันเข้าพัก 6,000 บาท (คืนเต็มจำนวนวัน check out หลังเช็กบ้านแล้วไม่มีความเสียหายใดๆ)\r\n', '14:00:00', '11:00:00', 'สำรองบ้านพัก: โทร.098-462 2914 คุณเมย์ หรือ line id : chatiya2513', 19900, 0, 0, 1, '✅ราคาที่พัก ?โปร มี.ค?\r\n?อาทิตย์ - ศุกร์\r\nเปิด 5 ห้องนอน 19,900/16 ท่าน\r\nเปิด 6 ห้องนอน 21,900/18 ท่าน\r\nเปิด 7 ห้องนอน 23,900/20 ท่าน\r\n\r\n?วันเสาร์\r\nเปิด 7 ห้องนอน 30,900/20 ท่าน\r\n\r\n?หยุดยาว/นักขัตฯ\r\nเปิด 7 ห้องนอน 36,900/20 ท่าน\r\n\r\n?ปีใหม่/สงกรานต์\r\nเปิด 7 ห้องนอน 41,000/20 ท่าน\r\n\r\n✅เกินจำนวนที่ระบุเสริมท่านละ 800/คืน\r\n✅รองรับได้สูงสุด 26 ท่าน\r\n✅เด็กอายุต่ำกว่า 10 ขวบ ฟรี 3 ท่าน (นอนกับผู้ปกครอง)\r\n', '/images/PCS071/pool-villa-luxury-CHA-AM.webp', 26, 0, 0.00, '2025-03-17 12:21:49', '2025-03-18 13:27:01', 'ชะอำ', 1, 'available', 'beachfront', NULL),
(7, 'PCS056', 'บ้านพักพูลวิลล่า', '..\r\n✨ พูลวิลล่าติดทะเล  ลากูนธรรมชาติ ✨\r\n✨ เดินถึงทะเลแค่ 10 เมตร สัมผัสลมทะเลสุดสดชื่น \r\n✨หลังบ้านติดลากูน สนุกกับกิจกรรม กีฬาทางน้ำ  พายเรือคายัค \r\n✨2 ฟีลในหลังเดียว! หน้าบ้านวิวทะเล ✨ หลังบ้านวิวธรรมชาติสุดชิล  \r\n✨รองรับ 16-18 ท่าน เหมาะกับครอบครัว ✨  แก๊งเพื่อน!', 5, 4, '✅รายละเอียดบ้านพัก\r\n✔5 ห้อง 4 ห้องน้ำ\r\n✔เครื่องทำน้ำอุ่นทุกห้อง\r\n✔ผ้าเช็ดตัว ครีมอาบน้ำ แชมพู ไดร์เป่าผม\r\n✔ห้องนั่งเล่น\r\n✔สมาร์ท​ TV 65 นิ้ว\r\n✔คาราโอเกะ\r\n✔โต๊ะทานอาหารในบ้าน และหลังลากูน\r\n✔ครัวนอก และครัวใน\r\n✔อุปกรณ์​ครัวครบครัน\r\n✔เตาปิ้งย่าง BBQ\r\n✔น้ำแข็ง ถ่านปิ้งย่าง\r\n✔Sup board\r\n✔เรือคายัค\r\n✔ที่จอดรถในบ้าน 3 คัน และนอกบ้านได้อีก 3-4 คัน\r\n✔รปภ 24 ชม.', '.. การเข้าพักพูลวิลล่า\r\n⏩ ห้ามสูบบุหรี่ภายในบ้าน\r\nกรุณาสูบบุหรี่ในพื้นที่ที่กำหนดภายนอกบ้านเท่านั้น เพื่อป้องกันกลิ่นและอัคคีภัย\r\n\r\n⏩ ห้ามเสียงดังเกินไป\r\nกรุณาควบคุมระดับเสียงและหลีกเลี่ยงการทำกิจกรรมที่เสียงดังหลังเวลา 22:00 น. เพื่อความสงบเรียบร้อย\r\n\r\n⏩ ห้ามนำสัตว์เลี้ยงเข้ามาพัก\r\nหากต้องการนำสัตว์เลี้ยงมาพัก กรุณาแจ้งล่วงหน้า เนื่องจากมีค่าใช้จ่ายเพิ่มเติม\r\n\r\n⏩ เวลาเช็คอิน/เช็คเอ้าท์\r\nเช็คอิน: หลังเวลา 14:00 น.\r\nเช็คเอ้าท์: ก่อนเวลา 12:00 น. (กรุณาปฏิบัติตามเวลาที่กำหนด)\r\n\r\n⏩ ดูแลบ้านพักและสิ่งอำนวยความสะดวก\r\nผู้เข้าพักต้องดูแลรักษาบ้านพักและสิ่งอำนวยความสะดวกให้สะอาดและอยู่ในสภาพดี หากมีความเสียหายหรือสิ่งใดที่เสียหายจะต้องรับผิดชอบค่าใช้จ่าย โดยหักจากค่าประกัน\r\n\r\n⏩  การใช้สระว่ายน้ำและกิจกรรมต่าง ๆ\r\nกรุณาดูแลการใช้สระว่ายน้ำโดยเฉพาะกับเด็ก ๆ ให้มีผู้ปกครองดูแลตลอดเวลา และห้ามใช้สระว่ายน้ำในขณะเกิดฟ้าผ่า\r\n\r\n⏩  ค่าประกันบ้านพัก\r\nค่าประกันบ้านพักจำนวน 5,000 บาท จะได้รับคืนเมื่อเช็คเอ้าท์ หากไม่มีความเสียหายใด ๆ เกิดขึ้นภายในบ้าน\r\n\r\n⏩ ห้ามนำสิ่งของผิดกฎหมายหรืออันตรายเข้าไปในที่พัก\r\nห้ามนำสิ่งของผิดกฎหมาย เช่น อาวุธ, ยาเสพติด หรือสิ่งของอันตรายใด ๆ เข้ามาภายในบ้านพัก\r\n\r\n⏩ กรุณาปฏิบัติตามกฎระเบียบที่กล่าวมาเพื่อความปลอดภัยและความสุขของทุกท่าน ', '⏩ บริการเสริมพิเศษ (มีค่าใช้จ่าย)\r\n▶บานาน่าโบ้ท โซฟา ชั่วโมงละ 3,500 บาท\r\n▶เจ็ทสกี 2 ที่นั่ง ชั่วโมงละ 3,500 บาท\r\n▶นวดแผนไทย นวดน้ำมัน ชั่วโมงละ 500 บาท', '✅รายละเอียดห้องนอน\r\n ⏩ ห้องนอน 1 เตียง 5 ฟุต = 1 เตียง\r\n⏩ ห้องนอน 2 เตียง 5 ฟุต = 2 เตียง\r\n⏩ ห้องนอน 3 เตียง 5 ฟุต = 2 เตียง\r\n⏩ ห้องนอน 4 เตียง 5 ฟุต = 2 เตียง\r\n⏩ ห้องนอน 5 เตียง 5 ฟุต = 1 เตียง\r\n⏩ ห้องน้ำในตัวทุกห้อง\r\n⏩ ยกเว้นห้องนอน 2 และ 3 ใช้ห้องน้ำร่วมกัน', '✅ เข้าพักเกินจำนวนที่กำหนด คิดเพิ่ม 600 บาท/ท่าน/คืน\r\n✅ รองรับสูงสุด 18 ท่าน\r\n✅ เด็กอายุไม่เกิน 7 ปี พักฟรี 2 ท่าน (เมื่อนอนกับผู้ปกครอง)\r\n✅ การจอง: มัดจำขั้นต่ำ 60% หรือชำระเต็มจำนวน\r\n✅ เงื่อนไขการจอง: หลังโอน งดยกเลิก &amp;amp;amp;amp;amp;amp;amp;amp; ไม่คืนเงินทุกกรณี\r\n✅ ค่าประกันบ้านพัก: 5,000 บาท (ได้รับคืนภายใน 15:00 น. ของวันเช็คเอ้าท์)', '14:00:00', '11:00:00', 'สำรองที่พัก โทร.098 462 2914 คุณเมย์', 15900, 0, 0, 1, '✅ราคาบ้านพัก\r\n❤อาทิตย์ - พฤหัส       15,900/16 ท่าน\r\nวันศุกร์                      18,900/16 ท่าน\r\nวันเสาร์                     23,900/16 ท่าน\r\nหยุดยาว/นักขัตฯ      25,900/16 ท่าน\r\nปีใหม่/สงกรานต์       29,900/16 ท่าน\r\n\r\n✅เกินจำนวนที่ระบุเสริมท่านละ 600/คืน\r\n✅รองรับได้สูงสุด 18 ท่าน\r\n✅เด็กอายุไม่เกิน 7 ขวบพักฟรี 2 ท่าน (นอนกับผู้ปกครอง)', '/images/PCS056/pool-villa-luxury-CHA-AM.webp', 18, 0, 0.00, '2025-03-17 14:22:29', '2025-03-18 13:27:01', 'ชะอำ', 0, 'available', 'beachfront', NULL),
(8, 'PCS099', 'บ้านพักพูลวิลล่า', '✅ พูลวิลล่าติดทะเลสุดหรู ในทำเลยอดเยี่ยมระหว่าง ชะอำ-หัวหิน ตกแต่งในสไตล์ Modern ผสมผสานกับ Minimal ที่ลงตัว เหมาะสำหรับการพักผ่อนทั้งกับ ครอบครัว และ กลุ่มเพื่อน เพื่อสัมผัสบรรยากาศที่เงียบสงบและสดชื่น ✅\r\n\r\n✅ เพียงแค่ก้าวออกจากบ้าน คุณก็สามารถเดินลงไปยัง ทะเลส่วนตัว และสัมผัสกับ น้ำทะเลใสๆ ได้ทันที  พื้นที่นี้ถูกออกแบบให้มีความเป็นส่วนตัวสูง หน้าบ้านติดทะเล ส่วน หลังบ้านติดลากูนธรรมชาติ ที่คุณสามารถสนุกกับกิจกรรมทางน้ำอย่าง พายเรือคายัค หรือ ตกปลา ได้ตามใจชอบ ✅\r\n\r\n', 4, 3, '✅รายละเอียดบ้านพัก\r\n✔4 ห้องนอน(1 ห้องวิวทะเล)\r\n✔3 ห้องน้ำ\r\n✔1 ห้องนั่งเล่นขนาดใหญ่ วิวทะเล\r\n✔คาราโอเกะแบบ Smart Tv เซิทเพลงจาก Youtube\r\n✔อุปกรณ์ทำครัวครบครัน\r\n✔เตาปิ้งย่าง\r\n✔ห้องรับประทานอาหาร พร้อมวิวสระว่ายน้ำและวิวทะเล\r\n✔ที่จอดรถในบ้าน 1 คัน และจอดหน้าบ้านพักได้ 3 คัน\r\n✔สระว่ายน้ำ ขนาด 6x10 เมตร\r\n✔ใช้เสียงดังภายนอกได้ถึง 22.00 น. หลังจากนั้นลดเสียงตามสมควร\r\n✔ใช้สระว่ายน้ำได้ตลอดทั้งวันทั้งคืน\r\n✔ใช้เสียงภายในบ้านได้ตลอดแต่รบกวนปิดประตู-หน้าต่าง กันเสียงออกข้างนอก', '..บ้านพัก+\r\n✔ ใช้เสียงดังภายนอกได้ถึง 22.00 น. หลังจากนั้นลดเสียงตามสมควร \r\n✔ใช้เสียงภายในบ้านได้ตลอดแต่รบกวนปิดประตู-หน้าต่าง กันเสียงออกข้างนอก\r\n❌ ห้ามนำสัตว์เลี้ยงเข้ามาในบ้านพัก เนื่องจากบ้านพักไม่สามารถรองรับสัตว์เลี้ยงทุกชนิดได้\r\n❌ ห้ามสูบบุหรี่ภายในบ้าน เพื่อรักษาความสะอาดและบรรยากาศที่สดชื่นสำหรับผู้เข้าพักทุกท่าน\r\n❌ ห้ามเกินจำนวนผู้เข้าพักที่ระบุ ไม่มีบริการเตียงเสริม หรือการเพิ่มจำนวนที่นอน', '', '', '✅โอนจองเต็มจำนวนหรือมัดจำขั้นต่ำ 60%\r\n✅โอนจองแล้ว งดยกเลิก งดคืนเงินทุกกรณี\r\n✅ค่าประกันบ้าน 3,000 บาท (คืนเต็มจำนวนวัน check out หลังเช็กบ้านแล้วไม่มีอะไรชำรุดเสียหาย)', '14:00:00', '12:00:00', 'ติดต่อสอบถามสำรองที่พัก โทร.098-462-2914 คุณเมย์', 15900, 0, 0, 1, '✅ราคาที่พัก\r\n❤อาทิตย์–พฤหัส       15,900/10 ท่าน\r\n?ศุกร์/เสาร์                17,900/10 ท่าน\r\n?หยุดยาว/นักขัตฯ     19,900/10 ท่าน\r\n?ปีใหม่/สงกรานต์  21,900/10 ท่าน\r\n\r\n✅เกินจำนวนที่ระบุเสริมท่านละ 500/คืน\r\n✅รองรับได้สูงสุด 12 ท่านเท่านั้น(ที่นอนครบ)\r\n✅ฟรีเด็กอายุไม่เกิน 7 ขวบ 2 ท่าน(นอนกับผู้ปกครอง)', '/images/PCS099/pool-villa-luxury-CHA-AM.webp', 12, 0, 0.00, '2025-03-17 15:21:57', '2025-03-18 13:27:01', 'ชะอำ', 0, 'available', 'beachfront', NULL),
(9, 'PCS091', 'บ้านพักพูลวิลล่า', '? วิลล่าส่วนตัวริมหาดปึกเตียน ?\r\nหลีกหนีจากความวุ่นวายและสัมผัสความสงบในวิลล่าส่วนตัวที่ตั้งอยู่ริมหาดปึกเตียน วิลล่าที่ได้รับการตกแต่งในสไตล์ Tropical ที่เข้ากับบรรยากาศของธรรมชาติ ล้อมรอบด้วยต้นไม้และสวนเขียวขจี\r\nที่พักสามารถรองรับผู้เข้าพักได้ถึง 12-20 ท่าน เพื่อให้คุณได้พักผ่อนอย่างเต็มที่ในบรรยากาศที่เป็นส่วนตัวและเงียบสงบ\r\n✅ พิเศษ\r\nเรามี 2 หลังติดกัน ที่สามารถรองรับได้สูงสุด 24-40 ท่าน เหมาะสำหรับการรวมกลุ่มเพื่อนหรือครอบครัวขนาดใหญ่ที่จะมาพักผ่อนร่วมกัน\r\n\r\n', 4, 4, '✅รายละเอียดบ้าน\r\n✔4 ห้องนอน\r\n✔4 ห้องน้ำ (ห้องน้ำส่วนตัวทุกห้อง) รองรับ\r\n✔ทีวี 65 นิ้ว\r\n✔Free Wifi\r\n✔คาราโอเกะ\r\n✔ผ้าเช็ดตัว ครีมอาบน้ำ แชมพู\r\n✔ไดร์เป่าผม\r\n✔สระว่ายน้ำกระจกอะคิลิคใส 3.5*14 เมตร (โซนลึก) และ 2*5 เมตร (โซนตื้น)\r\n✔สไลเดอร์เกลียว 12 เมตร\r\n✔เตา BBQ\r\n✔โต๊ะพูล\r\n✔อุปกรณ์ครัวครบครัน', '.. ของที่พัก\r\nเวลาเช็คอินและเช็คเอาท์\r\nเช็คอินได้ตั้งแต่เวลา 14:00 น. เป็นต้นไป\r\nเช็คเอาท์ต้องทำก่อนเวลา 11:00 น. กรุณาตรงต่อเวลา\r\n\r\nการใช้ที่พัก\r\nห้ามเล่นการพนัน ที่ผิดกฎหมาย\r\nห้ามสูบบุหรี่ในห้องพักและในพื้นที่ที่ห้ามสูบบุหรี่ หรือ เสฟสิ่งเสพติดผิดกฎหมาย\r\nห้ามพกอาวุธ หรือวัตถุระเบิดเข้าที่พัก\r\nห้ามนำสัตว์เลี้ยงเข้าที่พัก (ยกเว้นกรณีที่อนุญาตเป็นพิเศษ)\r\n\r\nการรักษาความปลอดภัย\r\nกรุณาปิดประตูและหน้าต่างให้เรียบร้อยเมื่อไม่อยู่ในห้องพัก\r\nปฏิบัติตามคำแนะนำเกี่ยวกับการใช้เครื่องใช้ไฟฟ้าและอุปกรณ์ต่างๆ ภายในที่พัก\r\n\r\nการจอดรถ\r\nกรุณาจอดรถในพื้นที่ที่กำหนดและหลีกเลี่ยงการจอดขวางทางเข้าออก\r\n\r\nการรักษาความสะอาด\r\nกรุณาทิ้งขยะในถังขยะที่จัดเตรียมไว้\r\nรักษาความสะอาดภายในห้องพักและพื้นที่ส่วนกลาง\r\n\r\nการทำเสียงดัง\r\nห้ามทำเสียงดังในช่วงเวลา 22:00 - 08:00 น. เพื่อไม่รบกวนผู้อื่น\r\n\r\nการรับผิดชอบความเสียหาย\r\nผู้เข้าพักต้องรับผิดชอบในกรณีที่เกิดความเสียหายหรือการทำลายทรัพย์สินภายในที่พัก\r\n\r\nนโยบายการยกเลิกและคืนเงิน\r\nการยกเลิกการจองจะต้องทำตามเงื่อนไขที่กำหนดในนโยบายของที่พัก\r\nกรุณาตรวจสอบนโยบายการคืนเงินก่อนการจอง', '✅บริการพิเศษไม่มีค่าใช้จ่าย?\r\n✅SUB BOARD 2 ชุด\r\n✅ถ่าน 5 ถุง\r\n✅น้ำแข็ง 2 กระสอบ\r\n✅น้ำดื่ม 2 แพค', '✅รายละเอียดห้องนอน\r\nห้องนอนที่ 1 : เตียง 6 ฟุต 1 เตียง ( 2 ท่าน)\r\nห้องนอนที่ 2 : เตียง 5 ฟุต 2 เตียง (4 ท่าน)\r\nห้องนอนที่ 3 : เตียง 5 ฟุต 2 เตียง (4 ท่าน)\r\nห้องนอนที่ 4 : เตียง 6 ฟุต 1 เตียง ( 2 ท่าน)', '?เงื่อนไขการจอง\r\n✅โอนจองเต็มจำนานหรือมัดจำขั้นต่ำ 50%\r\n✅โอนจองแล้ว งดยกเลิก งดคืนเงินทุกกรณี\r\n✅ค่าประกันบ้าน 5,000 บาท(คืนเต็มจำนวนวัน check out หลังเช็กบ้านแล้วไม่มีความเสียหายใดๆ', '14:00:00', '11:00:00', 'สำรองที่พัก โทร.098-462-2914 คุณเมย์', 17900, 0, 0, 1, '✅ราคาที่พัก\r\n✅อาทิตย์-พฤหัส     17,900/12 ท่าน\r\n✅วันศุกร์                  19,900/12 ท่าน\r\n✅เสาร์/หยุดยาว      25,900/12 ท่าน\r\n✅ปีใหม่/สงกรานต์   35,900/12 ท่าน\r\n**เสริมได้อีก 8 ท่าน (ที่นอนฟูก)\r\n\r\n✅เกินจำนวนที่ระบุเสริมท่านละ 500/คืน\r\n✅รองรับได้สูงสุด 20 ท่าน\r\n✅เด็กอายุต่ำกว่า 10 ขวบ พักฟรี 4 ท่าน (นอนกับผู้ปกครอง)\r\n✅รับสัตว์เลี้ยงตัวละ 500/คืน', '/images/PCS091/pool-villa-luxury-CHA-AM.webp', 20, 0, 0.00, '2025-03-17 15:48:51', '2025-03-18 13:27:01', 'หาดปึกเตียน - ชะอำ', 1, 'available', 'beachfront', NULL),
(10, 'PCS088', 'บ้านพักพูลวิลล่า', '✅ บ้านพักสไตล์โมเดิร์นสีขาว 2 ชั้น ?⛵\r\nสัมผัสการพักผ่อนในบ้านพักสไตล์โมเดิร์นสีขาว 2 ชั้น บนพื้นที่กว้างเกือบ 1 ไร่ พร้อมห้องพักที่กว้างขวางและบรรยากาศที่เงียบสงบ บ้านพักตั้งอยู่ติดทะเล ทำให้คุณสามารถเพลิดเพลินกับวิวทะเลได้ตลอดทั้งวัน\r\n\r\n✅ ทำเลที่สะดวกสบาย\r\n✅ เดินทางง่าย ใกล้กรุงเทพฯ\r\n✅ ใกล้แหล่งอาหารทะเลสดใหม่\r\n✅ ใกล้ร้านสะดวกซื้อ\r\n✅ รองรับได้สูงสุด 24-40 ท่าน เหมาะสำหรับการพักผ่อนในกลุ่มใหญ่ ครอบครัว หรือเพื่อนฝูงที่ต้องการความเป็นส่วนตัวและความสะดวกสบาย\r\n\r\n✅Location : หาดคลองเทียน - ชะอำ\r\n✅ใกล้ร้านอาหารชื่อดัง ครัวไข่มุก\r\n✅ใกล้สะพานปูชัก(แหล่งขายอาหารทะเล)', 8, 9, '✅รายละเอียดบ้านพัก\r\n✔8 ห้องนอน\r\n✔9 ห้องน้ำ\r\n✔ผ้าเช็ดตัว ครีมอาบน้ำ แชมพู\r\n✔ไดร์เป่าผม\r\n✔ห้องรับแขกชั้น 2 วิวพาโนรามาแบบสุดๆ\r\n✔คาราโอเกะ\r\n✔Free Wifi\r\n✔โต๊ะพูล\r\n✔อุปกรณ์ครัวครบครัน\r\n✔เตา BBQ\r\n✔สระว่ายน้ำกระจกอะคลิลิคใส ขนาด 3*14 เมตร\r\n✔สไลเดอร์ ยาว 12 เมตร\r\n✔อ่างจากุซซี่ ดาดฟ้าแบบ sea view\r\n✔จอดรถในบ้านได้ 7-8 คัน\r\n✔ใกล้แหล่งอาหารทะเล สะพานปูชัก เพียงไม่กี่เมตร\r\n✔ใกล้ร้านอาหารชื่อดัง ครัวไข่มุก\r\n✔หาดทราย เล่นน้ำได้ น้ำขึ้นน้ำลงตามธรรมชาติ', '..ของที่พัก\r\n✅เวลาเช็คอินและเช็คเอาท์\r\nเช็คอินได้ตั้งแต่เวลา 14:00 น. เป็นต้นไป\r\nเช็คเอาท์ต้องทำก่อนเวลา 11:00 น.\r\n✅การใช้ที่พัก\r\nห้ามสูบบุหรี่ในห้องพักและในพื้นที่ที่ห้ามสูบบุหรี่\r\nห้ามนำสัตว์เลี้ยงเข้าที่พัก (ยกเว้นกรณีที่อนุญาตเป็นพิเศษ)\r\n✅การรักษาความปลอดภัย\r\nกรุณาปิดประตูและหน้าต่างให้เรียบร้อยเมื่อไม่อยู่ในห้องพัก\r\nปฏิบัติตามคำแนะนำเกี่ยวกับการใช้เครื่องใช้ไฟฟ้าและอุปกรณ์ต่างๆ ภายในที่พัก\r\n✅การจอดรถ\r\nกรุณาจอดรถในพื้นที่ที่กำหนดและหลีกเลี่ยงการจอดขวางทางเข้าออก\r\n✅การรักษาความสะอาด\r\nกรุณาทิ้งขยะในถังขยะที่จัดเตรียมไว้\r\nรักษาความสะอาดภายในห้องพักและพื้นที่ส่วนกลาง\r\n✅การทำเสียงดัง\r\nห้ามทำเสียงดังในช่วงเวลา 22:00 - 08:00 น. เพื่อไม่รบกวนผู้อื่น\r\n✅การรับผิดชอบความเสียหาย\r\nผู้เข้าพักต้องรับผิดชอบในกรณีที่เกิดความเสียหายหรือการทำลายทรัพย์สินภายในที่พัก\r\n✅นโยบายการยกเลิกและคืนเงิน\r\nการยกเลิกการจองจะต้องทำตามเงื่อนไขที่กำหนดในนโยบายของที่พัก\r\nกรุณาตรวจสอบนโยบายการคืนเงินก่อนการจอง', '✅บริการพิเศษ❗(ไม่มีค่าใช้จ่าย)\r\n✔SUB BOARD 2 ชุด\r\n✔เรือพาย 1 ชุด\r\n✔ห่วงยางแฟนซี 2 ชิ้น\r\n✔ถ่าน 5 ถุง\r\n✔น้ำแข็ง 2 กระสอบ\r\n✔น้ำเปล่า 2 แพ๊ค\r\n✔แม่บ้านบริการล้างจานให้ลูกค้าโดยไม่เสียค่าใช้จ่าย', '✅รายละเอียดห้องนอน\r\n▶ห้องนอนที่ 1 : เตียง 6 ฟุต 1 เตียง (2 ท่าน)\r\n▶ห้องนอนที่ 2 : เตียง 6 ฟุต 1 เตียง (2 ท่าน)\r\n▶ห้องนอนที่ 3 : เตียง 6 ฟุต 1 เตียง (2 ท่าน)\r\n▶ห้องนอนที่ 4 : เตียง 6 ฟุต 1 เตียง (2 ท่าน)\r\n▶ห้องนอนที่ 5 : เตียง 6 ฟุต 2 เตียง (4 ท่าน)\r\n▶ห้องนอนที่ 6 : เตียง 6 ฟุต 2 เตียง (4 ท่าน)\r\n▶ห้องนอนที่ 7 : เตียง 6 ฟุต 2 เตียง (4 ท่าน)\r\n▶ห้องนอนที่ 8 : เตียง 6 ฟุต 2 เตียง (4 ท่าน)', '✅โอนจองเต็มจำนวนหรือมัดจำขั้นต่ำ 60%\r\n✅โอนจองแล้ว งดยกเลิก งดคืนเงินทุกกรณี\r\n✅ค่าประกันบ้าน 10,000 บาท (คืนเต็มจำนวนวัน check out หลังตรวจเช็กแล้วไม่มีอะไรชำรุดเสียหาย)\r\n', '14:00:00', '11:00:00', 'สำรองที่พัก โทร.098-462-2914 คุณเมย์', 39000, 0, 0, 1, '✅ราคาที่พัก❗❗\r\n❌ HI SEASON ❌(1 ต.ค. - 15 พ.ค. )\r\n❤อาทิตย์ - พฤหัส 39,000/24 ท่าน\r\n?วันศุกร์ 50,000/24 ท่าน\r\n?เสาร์/หยุดยาว 55,000/24 ท่าน\r\n?ปีใหม่/สงกรานต์ 65,000/24 ท่าน\r\n\r\n❌ LOW SEASON❌(16 พ.ค. - 30 ก.ย. )\r\n❤อาทิตย์ - พฤหัส 36,000/24 ท่าน\r\n?วันศุกร์ 45,000/24 ท่าน\r\n?เสาร์/หยุดยาว 55,000/24 ท่าน\r\n?พัก 2 คืน ลดคืนละ 1,000 บาท?\r\n\r\n✅เกินจำนวนที่ระบุเสริมได้อีก 16 ท่านคิดท่านละ 500 บาท/คืน (มีฟูกเสริมให้)\r\n✅เด็กอายุต่ำกว่า 10 ขวบ พักฟรี 4 ท่าน (นอนกับผู้ปกครอง)\r\n✅รับสัตว์เลี้ยงตัวละ 500/คืน', '/images/PCS088/pool-villa-luxury-CHA-AM.jpg', 40, 0, 0.00, '2025-03-17 16:17:50', '2025-03-18 13:27:01', 'หาดคลองเทียน - ชะอำ', 1, 'available', 'beachfront', NULL),
(11, 'PCS087', 'บ้านพักพูลวิลล่า', '??⛵พูลวิลล่าหนึ่งเดียวที่อยู่หน้าหาดชะอำ สวยและมีเอกลักษณ์สไตล์คาเฟ่ สุดยอดแห่งความสะดวกสบาย ใกล้แหล่งอาหารทะเล และร้านสะดวกซื้อ รองรับได้สูงสุด 20-30 ท่าน\r\n?Location : หาดชะอำใต้ หาดทรายเล่นน้ำได้\r\n', 6, 6, '✅รายละเอียดบ้านพัก\r\n✔6 ห้องนอน\r\n✔6 ห้องน้ำ\r\n✔ผ้าเช็ดตัว ครีมอาบน้ำ แชมพู\r\n✔ไดร์เป่าผม\r\n✔ห้องรับแขกขนาดใหญ่\r\n✔คาราโอเกะ\r\n✔Free Wifi\r\n✔โต๊ะพูล\r\n✔อุปกรณ์ครัวครบครัน\r\n✔เตา BBQ\r\n✔สระว่ายน้ำกระจกอะคลิลิคใส ขนาด 3*12 เมตร+สระเด็ก\r\n✔สไลเดอร์ ยาวถึง 12 เมตร\r\n✔จอดรถในบ้านได้ 7-8 คัน\r\n✔หาดทราย เล่นน้ำได้ น้ำขึ้นน้ำลงตามธรรมชาติ\r\n✅บริการพิเศษ❗(ไม่มีค่าใช้จ่าย)\r\n✔ห่วงยางแฟนซี 2 ชิ้น\r\n✔ถ่าน 5 ถุง\r\n✔น้ำแข็ง 2 กระสอบ\r\n✔น้ำเปล่า 2 แพ๊ค\r\n✔แม่บ้านบริการล้างจานให้ลูกค้าโดยไม่เสียค่าใช้จ่าย', '', '', '✅รายละเอียดห้องนอน\r\n▶ห้องนอนที่ 1 : เตียง 6 ฟุต 1 เตียง (2 ท่าน)\r\n▶ห้องนอนที่ 2 : เตียง 6 ฟุต 1 เตียง (2 ท่าน)\r\n▶ห้องนอนที่ 3 : เตียง 5 ฟุต 2 เตียง (4 ท่าน)\r\n▶ห้องนอนที่ 4 : เตียง 5 ฟุต 2 เตียง (4 ท่าน)\r\n▶ห้องนอนที่ 5 : เตียง 5 ฟุต 2 เตียง (4 ท่าน)\r\n▶ห้องนอนที่ 6 : เตียง 5 ฟุต 2 เตียง (4 ท่าน)', '✅โอนจองเต็มจำนวนหรือมัดจำขั้นต่ำ 60%\r\n✅โอนจองแล้ว งดยกเลิก งดคืนเงินทุกกรณี\r\n✅ค่าประกันบ้าน 5,000 บาท(คืนเต็มจำนวนวัน check out หลังตรวจเช็กแล้วไม่มีอะไรชำรุดเสียหาย)', '11:00:00', '14:00:00', 'สำรองที่พัก โทร.098-462-2914 คุณเมย์', 25000, 0, 0, 1, '✅ราคาที่พัก❗❗\r\n❌ HI SEASON ❌(1 ต.ค. - 15 พ.ค. )\r\n❤อาทิตย์ - พฤหัส 25,000/20 ท่าน\r\n?วันศุกร์  30,000/20 ท่าน\r\n?เสาร์/หยุดยาว 39,000/20 ท่าน\r\n?ปีใหม่/สงกรานต์ 45,000/20 ท่าน\r\n\r\n❌ LOW SEASON❌(16 พ.ค. - 30 ก.ย. )\r\n❤อาทิตย์ - พฤหัส 19,900/20 ท่าน\r\n?วันศุกร์ 30,000/20 ท่าน\r\n?เสาร์/หยุดยาว 39,000/20 ท่าน\r\n?พัก 2 คืน ลดคืนละ 1,000 บาท?\r\n\r\n✅เกินจำนวนที่ระบุเสริมได้อีก 10 ท่านคิดท่านละ 500 บาท/คืน มีฟูกเสริมให้\r\n✅เด็กอายุต่ำกว่า 10 ขวบ พักฟรี 4 ท่าน (นอนกับผู้ปกครอง)\r\n✅รับสัตว์เลี้ยงตัวละ 500/คืน', '/images/PCS087/pool-villa-luxury-CHA-AM.webp', 30, 0, 0.00, '2025-03-17 23:50:41', '2025-03-18 13:27:01', 'ชะอำ', 1, 'available', 'beachfront', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `villas`
--
ALTER TABLE `villas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `villa_code` (`villa_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `villas`
--
ALTER TABLE `villas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
