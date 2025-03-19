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
-- Table structure for table `villas_images`
--

CREATE TABLE `villas_images` (
  `id` int(11) NOT NULL,
  `villa_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `villas_images`
--

INSERT INTO `villas_images` (`id`, `villa_id`, `image`, `caption`, `type`) VALUES
(1, 1, '/images/PCS090/interior/pool-villa-luxury-pcs090-in-01.webp', '', 'interior'),
(2, 1, '/images/PCS090/interior/pool-villa-luxury-pcs090-in-02.webp', '', 'interior'),
(3, 1, '/images/PCS090/interior/pool-villa-luxury-pcs090-in-03.webp', '', 'interior'),
(4, 1, '/images/PCS090/interior/pool-villa-luxury-pcs090-in-04.webp', '', 'interior'),
(5, 1, '/images/PCS090/interior/pool-villa-luxury-pcs090-in-05.webp', '', 'interior'),
(6, 1, '/images/PCS090/interior/pool-villa-luxury-pcs090-in-06.webp', '', 'interior'),
(7, 1, '/images/PCS090/interior/pool-villa-luxury-pcs090-in-07.webp', '', 'interior'),
(8, 1, '/images/PCS090/interior/pool-villa-luxury-pcs090-in-08.webp', '', 'interior'),
(16, 1, '/images/PCS090/exterior/pool-villa-luxury-pcs090-ex-01.webp', '', 'exterior'),
(17, 1, '/images/PCS090/exterior/pool-villa-luxury-pcs090-ex-02.webp', '', 'exterior'),
(18, 1, '/images/PCS090/exterior/pool-villa-luxury-pcs090-ex-03.webp', '', 'exterior'),
(19, 1, '/images/PCS090/exterior/pool-villa-luxury-pcs090-ex-04.webp', '', 'exterior'),
(20, 2, '/images/PCS093/interior/pool-villa-luxury-pcs093-in-01.webp', '', 'interior'),
(21, 2, '/images/PCS093/interior/pool-villa-luxury-pcs093-in-02.webp', '', 'interior'),
(22, 2, '/images/PCS093/interior/pool-villa-luxury-pcs093-in-03.webp', '', 'interior'),
(23, 2, '/images/PCS093/interior/pool-villa-luxury-pcs093-in-04.webp', '', 'interior'),
(24, 2, '/images/PCS093/interior/pool-villa-luxury-pcs093-in-05.webp', '', 'interior'),
(25, 2, '/images/PCS093/interior/pool-villa-luxury-pcs093-in-06.webp', '', 'interior'),
(26, 2, '/images/PCS093/interior/pool-villa-luxury-pcs093-in-07.webp', '', 'interior'),
(27, 2, '/images/PCS093/interior/pool-villa-luxury-pcs093-in-08.webp', '', 'interior'),
(28, 2, '/images/PCS093/interior/pool-villa-luxury-pcs093-in-09.webp', '', 'interior'),
(29, 2, '/images/PCS093/interior/pool-villa-luxury-pcs093-in-10.webp', '', 'interior'),
(30, 2, '/images/PCS093/interior/pool-villa-luxury-pcs093-in-11.webp', '', 'interior'),
(31, 2, '/images/PCS093/interior/pool-villa-luxury-pcs093-in-12.webp', '', 'interior'),
(32, 2, '/images/PCS093/interior/pool-villa-luxury-pcs093-in-13.webp', '', 'interior'),
(33, 2, '/images/PCS093/interior/pool-villa-luxury-pcs093-in-14.webp', '', 'interior'),
(34, 2, '/images/PCS093/interior/pool-villa-luxury-pcs093-in-15.webp', '', 'interior'),
(35, 2, '/images/PCS093/interior/pool-villa-luxury-pcs093-in-16.webp', '', 'interior'),
(36, 2, '/images/PCS093/interior/pool-villa-luxury-pcs093-in-17.webp', '', 'interior'),
(37, 2, '/images/PCS093/interior/pool-villa-luxury-pcs093-in-18.webp', '', 'interior'),
(40, 2, '/images/PCS093/exterior/pool-villa-luxury-pcs093-ex-02.webp', '', 'exterior'),
(41, 2, '/images/PCS093/exterior/pool-villa-luxury-pcs093-ex-03.webp', '', 'exterior'),
(42, 2, '/images/PCS093/exterior/pool-villa-luxury-pcs093-ex-04.webp', '', 'exterior'),
(44, 2, '/images/PCS093/exterior/pool-villa-luxury-pcs093-ex-06.webp', '', 'exterior'),
(45, 2, '/images/PCS093/exterior/pool-villa-luxury-pcs093-ex-07.webp', '', 'exterior'),
(46, 2, '/images/PCS093/exterior/pool-villa-luxury-pcs093-ex-08.webp', '', 'exterior'),
(48, 2, '/images/PCS093/exterior/pool-villa-luxury-pcs093-ex-10.webp', '', 'exterior'),
(49, 2, '/images/PCS093/exterior/pool-villa-luxury-pcs093-ex-11.webp', '', 'exterior'),
(50, 2, '/images/PCS093/exterior/pool-villa-luxury-pcs093-ex-12.webp', '', 'exterior'),
(52, 2, '/images/PCS093/exterior/pool-villa-luxury-pcs093-ex-14.webp', '', 'exterior'),
(54, 2, '/images/PCS093/exterior/pool-villa-luxury-pcs093-ex-16.webp', '', 'exterior'),
(56, 2, '/images/PCS093/exterior/pool-villa-luxury-pcs093-ex-18.webp', '', 'exterior'),
(57, 2, '/images/PCS093/exterior/pool-villa-luxury-pcs093-ex-19.webp', '', 'exterior'),
(58, 2, '/images/PCS093/exterior/pool-villa-luxury-pcs093-ex-20.webp', '', 'exterior'),
(59, 3, '/images/PCS051/interior/pool-villa-luxury-CHA-AM-01.jpg', '', 'interior'),
(60, 3, '/images/PCS051/interior/pool-villa-luxury-CHA-AM-02.jpg', '', 'interior'),
(61, 3, '/images/PCS051/interior/pool-villa-luxury-CHA-AM-03.jpg', '', 'interior'),
(62, 3, '/images/PCS051/interior/pool-villa-luxury-CHA-AM-04.jpg', '', 'interior'),
(63, 3, '/images/PCS051/interior/pool-villa-luxury-CHA-AM-05.jpg', '', 'interior'),
(64, 3, '/images/PCS051/interior/pool-villa-luxury-CHA-AM-06.jpg', '', 'interior'),
(65, 3, '/images/PCS051/interior/pool-villa-luxury-CHA-AM-07.jpg', '', 'interior'),
(66, 3, '/images/PCS051/interior/pool-villa-luxury-CHA-AM-08.jpg', '', 'interior'),
(67, 3, '/images/PCS051/interior/pool-villa-luxury-CHA-AM-09.jpg', '', 'interior'),
(68, 3, '/images/PCS051/interior/pool-villa-luxury-CHA-AM-10.jpg', '', 'interior'),
(69, 3, '/images/PCS051/interior/pool-villa-luxury-CHA-AM-11.jpg', '', 'interior'),
(70, 3, '/images/PCS051/interior/pool-villa-luxury-CHA-AM-12.jpg', '', 'interior'),
(71, 3, '/images/PCS051/interior/pool-villa-luxury-CHA-AM-13.jpg', '', 'interior'),
(72, 3, '/images/PCS051/exterior/pool-villa-luxury-CHA-AM-01.jpg', '', 'exterior'),
(73, 3, '/images/PCS051/exterior/pool-villa-luxury-CHA-AM-02.jpg', '', 'exterior'),
(74, 3, '/images/PCS051/exterior/pool-villa-luxury-CHA-AM-03.jpg', '', 'exterior'),
(75, 3, '/images/PCS051/exterior/pool-villa-luxury-CHA-AM-04.jpg', '', 'exterior'),
(76, 3, '/images/PCS051/exterior/pool-villa-luxury-CHA-AM-05.jpg', '', 'exterior'),
(77, 3, '/images/PCS051/exterior/pool-villa-luxury-CHA-AM-06.jpg', '', 'exterior'),
(78, 4, '/images/PCS105/interior/pool-villa-luxury-CHA-AM-01.webp', '', 'interior'),
(79, 4, '/images/PCS105/interior/pool-villa-luxury-CHA-AM-02.webp', '', 'interior'),
(80, 4, '/images/PCS105/interior/pool-villa-luxury-CHA-AM-03.webp', '', 'interior'),
(81, 4, '/images/PCS105/interior/pool-villa-luxury-CHA-AM-04.webp', '', 'interior'),
(82, 4, '/images/PCS105/interior/pool-villa-luxury-CHA-AM-05.webp', '', 'interior'),
(83, 4, '/images/PCS105/interior/pool-villa-luxury-CHA-AM-06.webp', '', 'interior'),
(84, 4, '/images/PCS105/interior/pool-villa-luxury-CHA-AM-07.webp', '', 'interior'),
(85, 4, '/images/PCS105/interior/pool-villa-luxury-CHA-AM-08.webp', '', 'interior'),
(86, 4, '/images/PCS105/interior/pool-villa-luxury-CHA-AM-09.webp', '', 'interior'),
(87, 4, '/images/PCS105/interior/pool-villa-luxury-CHA-AM-10.webp', '', 'interior'),
(88, 4, '/images/PCS105/interior/pool-villa-luxury-CHA-AM-11.webp', '', 'interior'),
(89, 4, '/images/PCS105/interior/pool-villa-luxury-CHA-AM-12.webp', '', 'interior'),
(90, 4, '/images/PCS105/exterior/pool-villa-luxury-CHA-AM-01.webp', '', 'exterior'),
(91, 4, '/images/PCS105/exterior/pool-villa-luxury-CHA-AM-02.webp', '', 'exterior'),
(92, 4, '/images/PCS105/exterior/pool-villa-luxury-CHA-AM-03.webp', '', 'exterior'),
(93, 4, '/images/PCS105/exterior/pool-villa-luxury-CHA-AM-04.webp', '', 'exterior'),
(94, 4, '/images/PCS105/exterior/pool-villa-luxury-CHA-AM-05.webp', '', 'exterior'),
(95, 4, '/images/PCS105/exterior/pool-villa-luxury-CHA-AM-06.webp', '', 'exterior'),
(96, 4, '/images/PCS105/exterior/pool-villa-luxury-CHA-AM-07.webp', '', 'exterior'),
(97, 5, '/images/PCS094/interior/pool-villa-luxury-CHA-AM-01.webp', '', 'interior'),
(98, 5, '/images/PCS094/interior/pool-villa-luxury-CHA-AM-02.webp', '', 'interior'),
(99, 5, '/images/PCS094/interior/pool-villa-luxury-CHA-AM-03.webp', '', 'interior'),
(100, 5, '/images/PCS094/interior/pool-villa-luxury-CHA-AM-04.webp', '', 'interior'),
(101, 5, '/images/PCS094/interior/pool-villa-luxury-CHA-AM-05.webp', '', 'interior'),
(102, 5, '/images/PCS094/interior/pool-villa-luxury-CHA-AM-06.webp', '', 'interior'),
(103, 5, '/images/PCS094/interior/pool-villa-luxury-CHA-AM-07.webp', '', 'interior'),
(104, 5, '/images/PCS094/interior/pool-villa-luxury-CHA-AM-08.webp', '', 'interior'),
(105, 5, '/images/PCS094/interior/pool-villa-luxury-CHA-AM-09.webp', '', 'interior'),
(106, 5, '/images/PCS094/interior/pool-villa-luxury-CHA-AM-10.webp', '', 'interior'),
(107, 5, '/images/PCS094/interior/pool-villa-luxury-CHA-AM-11.webp', '', 'interior'),
(108, 5, '/images/PCS094/interior/pool-villa-luxury-CHA-AM-12.webp', '', 'interior'),
(109, 5, '/images/PCS094/interior/pool-villa-luxury-CHA-AM-13.webp', '', 'interior'),
(110, 5, '/images/PCS094/interior/pool-villa-luxury-CHA-AM-14.webp', '', 'interior'),
(111, 5, '/images/PCS094/interior/pool-villa-luxury-CHA-AM-15.webp', '', 'interior'),
(112, 5, '/images/PCS094/interior/pool-villa-luxury-CHA-AM-16.webp', '', 'interior'),
(113, 5, '/images/PCS094/interior/pool-villa-luxury-CHA-AM-17.webp', '', 'interior'),
(114, 5, '/images/PCS094/interior/pool-villa-luxury-CHA-AM-18.webp', '', 'interior'),
(117, 5, '/images/PCS094/exterior/pool-villa-luxury-CHA-AM-02.webp', '', 'exterior'),
(118, 5, '/images/PCS094/exterior/pool-villa-luxury-CHA-AM-03.webp', '', 'exterior'),
(119, 5, '/images/PCS094/exterior/pool-villa-luxury-CHA-AM-04.webp', '', 'exterior'),
(120, 5, '/images/PCS094/exterior/pool-villa-luxury-CHA-AM-05.webp', '', 'exterior'),
(121, 5, '/images/PCS094/exterior/pool-villa-luxury-CHA-AM-06.webp', '', 'exterior'),
(122, 5, '/images/PCS094/exterior/pool-villa-luxury-CHA-AM-07.webp', '', 'exterior'),
(123, 5, '/images/PCS094/exterior/pool-villa-luxury-CHA-AM-08.webp', '', 'exterior'),
(124, 5, '/images/PCS094/exterior/pool-villa-luxury-CHA-AM-09.webp', '', 'exterior'),
(125, 5, '/images/PCS094/exterior/pool-villa-luxury-CHA-AM-10.webp', '', 'exterior'),
(126, 5, '/images/PCS094/exterior/pool-villa-luxury-CHA-AM-11.webp', '', 'exterior'),
(127, 5, '/images/PCS094/exterior/pool-villa-luxury-CHA-AM-12.webp', '', 'exterior'),
(128, 5, '/images/PCS094/exterior/pool-villa-luxury-CHA-AM-13.webp', '', 'exterior'),
(129, 5, '/images/PCS094/exterior/pool-villa-luxury-CHA-AM-14.webp', '', 'exterior'),
(130, 5, '/images/PCS094/exterior/pool-villa-luxury-CHA-AM-15.webp', '', 'exterior'),
(131, 6, '/images/PCS071/interior/pool-villa-luxury-CHA-AM-01.webp', '', 'interior'),
(132, 6, '/images/PCS071/interior/pool-villa-luxury-CHA-AM-02.webp', '', 'interior'),
(133, 6, '/images/PCS071/interior/pool-villa-luxury-CHA-AM-03.webp', '', 'interior'),
(134, 6, '/images/PCS071/interior/pool-villa-luxury-CHA-AM-04.webp', '', 'interior'),
(135, 6, '/images/PCS071/interior/pool-villa-luxury-CHA-AM-05.webp', '', 'interior'),
(136, 6, '/images/PCS071/interior/pool-villa-luxury-CHA-AM-06.webp', '', 'interior'),
(137, 6, '/images/PCS071/interior/pool-villa-luxury-CHA-AM-07.webp', '', 'interior'),
(138, 6, '/images/PCS071/interior/pool-villa-luxury-CHA-AM-08.webp', '', 'interior'),
(139, 6, '/images/PCS071/interior/pool-villa-luxury-CHA-AM-09.webp', '', 'interior'),
(140, 6, '/images/PCS071/interior/pool-villa-luxury-CHA-AM-10.webp', '', 'interior'),
(141, 6, '/images/PCS071/interior/pool-villa-luxury-CHA-AM-11.webp', '', 'interior'),
(142, 6, '/images/PCS071/interior/pool-villa-luxury-CHA-AM-12.webp', '', 'interior'),
(143, 6, '/images/PCS071/interior/pool-villa-luxury-CHA-AM-13.webp', '', 'interior'),
(144, 6, '/images/PCS071/interior/pool-villa-luxury-CHA-AM-14.webp', '', 'interior'),
(145, 6, '/images/PCS071/interior/pool-villa-luxury-CHA-AM-15.webp', '', 'interior'),
(146, 6, '/images/PCS071/interior/pool-villa-luxury-CHA-AM-16.webp', '', 'interior'),
(147, 6, '/images/PCS071/interior/pool-villa-luxury-CHA-AM-17.webp', '', 'interior'),
(148, 6, '/images/PCS071/exterior/pool-villa-luxury-CHA-AM-1.webp', '', 'exterior'),
(149, 6, '/images/PCS071/exterior/pool-villa-luxury-CHA-AM-2.webp', '', 'exterior'),
(150, 7, '/images/PCS056/interior/pool-villa-luxury-CHA-AM-01.webp', '', 'interior'),
(151, 7, '/images/PCS056/interior/pool-villa-luxury-CHA-AM-02.webp', '', 'interior'),
(152, 7, '/images/PCS056/interior/pool-villa-luxury-CHA-AM-03.webp', '', 'interior'),
(153, 7, '/images/PCS056/interior/pool-villa-luxury-CHA-AM-04.webp', '', 'interior'),
(154, 7, '/images/PCS056/interior/pool-villa-luxury-CHA-AM-05.webp', '', 'interior'),
(155, 7, '/images/PCS056/interior/pool-villa-luxury-CHA-AM-06.webp', '', 'interior'),
(156, 7, '/images/PCS056/interior/pool-villa-luxury-CHA-AM-07.webp', '', 'interior'),
(157, 7, '/images/PCS056/interior/pool-villa-luxury-CHA-AM-08.webp', '', 'interior'),
(158, 7, '/images/PCS056/interior/pool-villa-luxury-CHA-AM-09.webp', '', 'interior'),
(159, 7, '/images/PCS056/interior/pool-villa-luxury-CHA-AM-10.webp', '', 'interior'),
(160, 7, '/images/PCS056/interior/pool-villa-luxury-CHA-AM-11.webp', '', 'interior'),
(169, 7, '/images/PCS056/exterior/pool-villa-luxury-CHA-AM-01.webp', '', 'exterior'),
(171, 7, '/images/PCS056/exterior/pool-villa-luxury-CHA-AM-03.webp', '', 'exterior'),
(172, 7, '/images/PCS056/exterior/pool-villa-luxury-CHA-AM-04.webp', '', 'exterior'),
(173, 7, '/images/PCS056/exterior/pool-villa-luxury-CHA-AM-05.webp', '', 'exterior'),
(176, 7, '/images/PCS056/exterior/pool-villa-luxury-CHA-AM-08.webp', '', 'exterior'),
(177, 7, '/images/PCS056/exterior/pool-villa-luxury-CHA-AM-09.webp', '', 'exterior'),
(179, 7, '/images/PCS056/exterior/pool-villa-luxury-CHA-AM-11.webp', '', 'exterior'),
(180, 7, '/images/PCS056/exterior/pool-villa-luxury-CHA-AM-12.webp', '', 'exterior'),
(181, 7, '/images/PCS056/exterior/pool-villa-luxury-CHA-AM-13.webp', '', 'exterior'),
(183, 7, '/images/PCS056/exterior/pool-villa-luxury-CHA-AM-15.webp', '', 'exterior'),
(184, 7, '/images/PCS056/exterior/pool-villa-luxury-CHA-AM-16.webp', '', 'exterior'),
(185, 7, '/images/PCS056/exterior/pool-villa-luxury-CHA-AM-17.webp', '', 'exterior'),
(187, 8, '/images/PCS099/interior/pool-villa-luxury-CHA-AM-01.webp', '', 'interior'),
(188, 8, '/images/PCS099/interior/pool-villa-luxury-CHA-AM-02.webp', '', 'interior'),
(189, 8, '/images/PCS099/interior/pool-villa-luxury-CHA-AM-03.webp', '', 'interior'),
(191, 8, '/images/PCS099/interior/pool-villa-luxury-CHA-AM-05.webp', '', 'interior'),
(192, 8, '/images/PCS099/interior/pool-villa-luxury-CHA-AM-06.webp', '', 'interior'),
(193, 8, '/images/PCS099/interior/pool-villa-luxury-CHA-AM-07.webp', '', 'interior'),
(194, 8, '/images/PCS099/interior/pool-villa-luxury-CHA-AM-08.webp', '', 'interior'),
(195, 8, '/images/PCS099/interior/pool-villa-luxury-CHA-AM-09.webp', '', 'interior'),
(196, 8, '/images/PCS099/interior/pool-villa-luxury-CHA-AM-10.webp', '', 'interior'),
(197, 8, '/images/PCS099/interior/pool-villa-luxury-CHA-AM-11.webp', '', 'interior'),
(198, 8, '/images/PCS099/interior/pool-villa-luxury-CHA-AM-12.webp', '', 'interior'),
(199, 8, '/images/PCS099/interior/pool-villa-luxury-CHA-AM-13.webp', '', 'interior'),
(200, 8, '/images/PCS099/interior/pool-villa-luxury-CHA-AM-14.webp', '', 'interior'),
(201, 8, '/images/PCS099/interior/pool-villa-luxury-CHA-AM-15.webp', '', 'interior'),
(205, 8, '/images/PCS099/exterior/ 20-099 beachfront.webp', '', 'exterior'),
(206, 8, '/images/PCS099/exterior/ 02-099 beachfront.webp', '', 'exterior'),
(207, 8, '/images/PCS099/exterior/ 03-099 beachfront.webp', '', 'exterior'),
(208, 8, '/images/PCS099/exterior/ 04-099 beachfront.webp', '', 'exterior'),
(210, 8, '/images/PCS099/exterior/ 21-099 beachfront.webp', '', 'exterior'),
(211, 8, '/images/PCS099/exterior/ 22-099 beachfront.webp', '', 'exterior'),
(212, 8, '/images/PCS099/exterior/ 23-099 beachfront.webp', '', 'exterior'),
(213, 8, '/images/PCS099/exterior/ 24-099 beachfront.webp', '', 'exterior'),
(214, 8, '/images/PCS099/exterior/ 28-099 beachfront.webp', '', 'exterior'),
(215, 8, '/images/PCS099/exterior/ 29-099 beachfront.webp', '', 'exterior'),
(216, 9, '/images/PCS091/interior/pool-villa-luxury-CHA-AM-01.webp', '', 'interior'),
(217, 9, '/images/PCS091/interior/pool-villa-luxury-CHA-AM-02.webp', '', 'interior'),
(218, 9, '/images/PCS091/interior/pool-villa-luxury-CHA-AM-03.webp', '', 'interior'),
(219, 9, '/images/PCS091/interior/pool-villa-luxury-CHA-AM-04.webp', '', 'interior'),
(220, 9, '/images/PCS091/interior/pool-villa-luxury-CHA-AM-05.webp', '', 'interior'),
(221, 9, '/images/PCS091/interior/pool-villa-luxury-CHA-AM-06.webp', '', 'interior'),
(222, 9, '/images/PCS091/interior/pool-villa-luxury-CHA-AM-07.webp', '', 'interior'),
(223, 9, '/images/PCS091/interior/pool-villa-luxury-CHA-AM-08.webp', '', 'interior'),
(224, 9, '/images/PCS091/interior/pool-villa-luxury-CHA-AM-09.webp', '', 'interior'),
(225, 9, '/images/PCS091/interior/pool-villa-luxury-CHA-AM-10.webp', '', 'interior'),
(226, 9, '/images/PCS091/interior/pool-villa-luxury-CHA-AM-11.webp', '', 'interior'),
(227, 9, '/images/PCS091/interior/pool-villa-luxury-CHA-AM-12.webp', '', 'interior'),
(228, 9, '/images/PCS091/interior/pool-villa-luxury-CHA-AM-13.webp', '', 'interior'),
(229, 9, '/images/PCS091/interior/pool-villa-luxury-CHA-AM-14.webp', '', 'interior'),
(235, 9, '/images/PCS091/exterior/pool-villa-luxury-CHA-AM-01.webp', '', 'exterior'),
(236, 9, '/images/PCS091/exterior/pool-villa-luxury-CHA-AM-02.webp', '', 'exterior'),
(237, 9, '/images/PCS091/exterior/pool-villa-luxury-CHA-AM-03.webp', '', 'exterior'),
(238, 9, '/images/PCS091/exterior/pool-villa-luxury-CHA-AM-04.webp', '', 'exterior'),
(239, 9, '/images/PCS091/exterior/pool-villa-luxury-CHA-AM-05.webp', '', 'exterior'),
(240, 9, '/images/PCS091/exterior/pool-villa-luxury-CHA-AM-06.webp', '', 'exterior'),
(241, 9, '/images/PCS091/exterior/pool-villa-luxury-CHA-AM-07.webp', '', 'exterior'),
(242, 9, '/images/PCS091/exterior/pool-villa-luxury-CHA-AM-08.webp', '', 'exterior'),
(243, 9, '/images/PCS091/exterior/pool-villa-luxury-CHA-AM-09.webp', '', 'exterior'),
(244, 9, '/images/PCS091/exterior/pool-villa-luxury-CHA-AM-10.webp', '', 'exterior'),
(245, 10, '/images/PCS088/interior/pool-villa-luxury-CHA-AM-01.webp', '', 'interior'),
(246, 10, '/images/PCS088/interior/pool-villa-luxury-CHA-AM-02.webp', '', 'interior'),
(247, 10, '/images/PCS088/interior/pool-villa-luxury-CHA-AM-03.webp', '', 'interior'),
(248, 10, '/images/PCS088/interior/pool-villa-luxury-CHA-AM-04.webp', '', 'interior'),
(249, 10, '/images/PCS088/interior/pool-villa-luxury-CHA-AM-05.webp', '', 'interior'),
(250, 10, '/images/PCS088/interior/pool-villa-luxury-CHA-AM-06.webp', '', 'interior'),
(251, 10, '/images/PCS088/interior/pool-villa-luxury-CHA-AM-07.webp', '', 'interior'),
(252, 10, '/images/PCS088/interior/pool-villa-luxury-CHA-AM-08.webp', '', 'interior'),
(253, 10, '/images/PCS088/interior/pool-villa-luxury-CHA-AM-09.webp', '', 'interior'),
(254, 10, '/images/PCS088/interior/pool-villa-luxury-CHA-AM-10.webp', '', 'interior'),
(255, 10, '/images/PCS088/interior/pool-villa-luxury-CHA-AM-11.webp', '', 'interior'),
(256, 10, '/images/PCS088/interior/pool-villa-luxury-CHA-AM-12.webp', '', 'interior'),
(257, 10, '/images/PCS088/interior/pool-villa-luxury-CHA-AM-13.webp', '', 'interior'),
(258, 10, '/images/PCS088/interior/pool-villa-luxury-CHA-AM-14.webp', '', 'interior'),
(259, 10, '/images/PCS088/interior/pool-villa-luxury-CHA-AM-15.webp', '', 'interior'),
(260, 10, '/images/PCS088/interior/pool-villa-luxury-CHA-AM-16.webp', '', 'interior'),
(261, 10, '/images/PCS088/interior/pool-villa-luxury-CHA-AM-17.webp', '', 'interior'),
(265, 10, '/images/PCS088/exterior/pool-villa-luxury-CHA-AM-01.webp', '', 'exterior'),
(266, 10, '/images/PCS088/exterior/pool-villa-luxury-CHA-AM-02.webp', '', 'exterior'),
(267, 10, '/images/PCS088/exterior/pool-villa-luxury-CHA-AM-03.webp', '', 'exterior'),
(268, 10, '/images/PCS088/exterior/pool-villa-luxury-CHA-AM-04.webp', '', 'exterior'),
(269, 10, '/images/PCS088/exterior/pool-villa-luxury-CHA-AM-05.webp', '', 'exterior'),
(270, 10, '/images/PCS088/exterior/pool-villa-luxury-CHA-AM-06.webp', '', 'exterior'),
(271, 10, '/images/PCS088/exterior/pool-villa-luxury-CHA-AM-07.webp', '', 'exterior'),
(272, 10, '/images/PCS088/exterior/pool-villa-luxury-CHA-AM-08.webp', '', 'exterior'),
(273, 10, '/images/PCS088/exterior/pool-villa-luxury-CHA-AM-09.webp', '', 'exterior'),
(274, 10, '/images/PCS088/exterior/pool-villa-luxury-CHA-AM-10.webp', '', 'exterior'),
(275, 10, '/images/PCS088/exterior/pool-villa-luxury-CHA-AM-11.webp', '', 'exterior'),
(276, 10, '/images/PCS088/exterior/pool-villa-luxury-CHA-AM-12.webp', '', 'exterior'),
(277, 10, '/images/PCS088/exterior/pool-villa-luxury-CHA-AM-13.webp', '', 'exterior'),
(278, 10, '/images/PCS088/exterior/pool-villa-luxury-CHA-AM-14.webp', '', 'exterior'),
(279, 10, '/images/PCS088/exterior/pool-villa-luxury-CHA-AM-15.webp', '', 'exterior'),
(280, 10, '/images/PCS088/exterior/pool-villa-luxury-CHA-AM-16.webp', '', 'exterior'),
(281, 10, '/images/PCS088/exterior/pool-villa-luxury-CHA-AM-17.webp', '', 'exterior'),
(282, 11, '/images/PCS087/interior/pool-villa-luxury-CHA-AM-01.webp', '', 'interior'),
(283, 11, '/images/PCS087/interior/pool-villa-luxury-CHA-AM-02.webp', '', 'interior'),
(284, 11, '/images/PCS087/interior/pool-villa-luxury-CHA-AM-03.webp', '', 'interior'),
(285, 11, '/images/PCS087/interior/pool-villa-luxury-CHA-AM-04.webp', '', 'interior'),
(286, 11, '/images/PCS087/interior/pool-villa-luxury-CHA-AM-05.webp', '', 'interior'),
(287, 11, '/images/PCS087/interior/pool-villa-luxury-CHA-AM-06.webp', '', 'interior'),
(288, 11, '/images/PCS087/interior/pool-villa-luxury-CHA-AM-07.webp', '', 'interior'),
(289, 11, '/images/PCS087/interior/pool-villa-luxury-CHA-AM-08.webp', '', 'interior'),
(290, 11, '/images/PCS087/interior/pool-villa-luxury-CHA-AM-09.webp', '', 'interior'),
(291, 11, '/images/PCS087/interior/pool-villa-luxury-CHA-AM-10.webp', '', 'interior'),
(292, 11, '/images/PCS087/interior/pool-villa-luxury-CHA-AM-11.webp', '', 'interior'),
(293, 11, '/images/PCS087/interior/pool-villa-luxury-CHA-AM-12.webp', '', 'interior'),
(294, 11, '/images/PCS087/interior/pool-villa-luxury-CHA-AM-13.webp', '', 'interior'),
(295, 11, '/images/PCS087/interior/pool-villa-luxury-CHA-AM-14.webp', '', 'interior'),
(296, 11, '/images/PCS087/interior/pool-villa-luxury-CHA-AM-15.webp', '', 'interior'),
(297, 11, '/images/PCS087/interior/pool-villa-luxury-CHA-AM-16.webp', '', 'interior'),
(298, 11, '/images/PCS087/interior/pool-villa-luxury-CHA-AM-17.webp', '', 'interior'),
(299, 11, '/images/PCS087/interior/pool-villa-luxury-CHA-AM-18.webp', '', 'interior'),
(300, 11, '/images/PCS087/interior/pool-villa-luxury-CHA-AM-19.webp', '', 'interior'),
(301, 11, '/images/PCS087/exterior/pool-villa-luxury-CHA-AM-01.webp', '', 'exterior'),
(302, 11, '/images/PCS087/exterior/pool-villa-luxury-CHA-AM-02.webp', '', 'exterior'),
(303, 11, '/images/PCS087/exterior/pool-villa-luxury-CHA-AM-03.webp', '', 'exterior'),
(304, 11, '/images/PCS087/exterior/pool-villa-luxury-CHA-AM-04.webp', '', 'exterior'),
(305, 11, '/images/PCS087/exterior/pool-villa-luxury-CHA-AM-05.webp', '', 'exterior'),
(306, 11, '/images/PCS087/exterior/pool-villa-luxury-CHA-AM-06.webp', '', 'exterior'),
(307, 11, '/images/PCS087/exterior/pool-villa-luxury-CHA-AM-07.webp', '', 'exterior'),
(308, 11, '/images/PCS087/exterior/pool-villa-luxury-CHA-AM-08.webp', '', 'exterior'),
(309, 11, '/images/PCS087/exterior/pool-villa-luxury-CHA-AM-09.webp', '', 'exterior'),
(310, 11, '/images/PCS087/exterior/pool-villa-luxury-CHA-AM-10.webp', '', 'exterior'),
(311, 11, '/images/PCS087/exterior/pool-villa-luxury-CHA-AM-11.webp', '', 'exterior'),
(312, 11, '/images/PCS087/exterior/pool-villa-luxury-CHA-AM-12.webp', '', 'exterior'),
(313, 11, '/images/PCS087/exterior/pool-villa-luxury-CHA-AM-13.webp', '', 'exterior'),
(314, 11, '/images/PCS087/exterior/pool-villa-luxury-CHA-AM-14.webp', '', 'exterior'),
(315, 11, '/images/PCS087/exterior/pool-villa-luxury-CHA-AM-15.webp', '', 'exterior'),
(316, 11, '/images/PCS087/exterior/pool-villa-luxury-CHA-AM-16.webp', '', 'exterior'),
(317, 11, '/images/PCS087/exterior/pool-villa-luxury-CHA-AM-17.webp', '', 'exterior'),
(318, 11, '/images/PCS087/exterior/pool-villa-luxury-CHA-AM-18.webp', '', 'exterior'),
(319, 11, '/images/PCS087/exterior/pool-villa-luxury-CHA-AM-19.webp', '', 'exterior'),
(320, 11, '/images/PCS087/exterior/pool-villa-luxury-CHA-AM-20.webp', '', 'exterior');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `villas_images`
--
ALTER TABLE `villas_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `villa_id` (`villa_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `villas_images`
--
ALTER TABLE `villas_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=321;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `villas_images`
--
ALTER TABLE `villas_images`
  ADD CONSTRAINT `fk_villas_images_villas` FOREIGN KEY (`villa_id`) REFERENCES `villas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
