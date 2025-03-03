-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2025-02-27 15:45:35
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `daiski_db`
--

-- --------------------------------------------------------

--
-- 資料表結構 `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `sortOrder` int(11) DEFAULT 0,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `valid` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `url`, `sortOrder`, `createdAt`, `valid`) VALUES
(1, 1, './productImages/1/ProductPicture.jfif', 0, '2025-02-21 03:23:51', 1),
(2, 1, './productImages/1/ProductPicture (1).jfif', 2, '2025-02-21 03:23:51', 1),
(3, 1, './productImages/1/ProductPicture (2).jfif', 1, '2025-02-21 03:23:51', 1),
(4, 1, './productImages/1/ProductPicture (3).jfif', 3, '2025-02-21 03:23:51', 1),
(5, 1, './productImages/1/ProductPicture (4).jfif', 4, '2025-02-21 03:23:51', 1),
(6, 2, './productImages/2/ProductPicture.jfif', 0, '2025-02-21 03:23:51', 1),
(7, 2, './productImages/2/ProductPicture (1).jfif', 1, '2025-02-21 03:23:51', 1),
(8, 2, './productImages/2/ProductPicture (2).jfif', 2, '2025-02-21 03:23:51', 1),
(9, 2, './productImages/2/ProductPicture (3).jfif', 3, '2025-02-21 03:23:51', 1),
(10, 2, './productImages/2/ProductPicture (4).jfif', 4, '2025-02-21 03:23:51', 1),
(11, 3, './productImages/3/ProductPicture.jfif', 0, '2025-02-21 03:49:11', 1),
(12, 3, './productImages/3/ProductPicture (1).jfif', 1, '2025-02-21 03:49:11', 1),
(13, 3, './productImages/3/ProductPicture (2).jfif', 2, '2025-02-21 03:49:11', 1),
(14, 3, './productImages/3/ProductPicture (3).jfif', 3, '2025-02-21 03:49:11', 1),
(15, 3, './productImages/3/ProductPicture (4).jfif', 4, '2025-02-21 03:49:11', 1),
(16, 4, './productImages/4/ProductPicture.jfif', 0, '2025-02-23 05:16:25', 1),
(17, 4, './productImages/4/ProductPicture (1).jfif', 1, '2025-02-23 05:16:25', 1),
(18, 4, './productImages/4/ProductPicture (2).jfif', 2, '2025-02-23 05:16:25', 1),
(19, 4, './productImages/4/ProductPicture (3).jfif', 3, '2025-02-23 05:16:25', 1),
(20, 4, './productImages/4/ProductPicture (4).jfif', 4, '2025-02-23 05:16:25', 1),
(21, 5, './productImages/5/ProductPicture.jfif', 0, '2025-02-23 05:21:07', 1),
(22, 5, './productImages/5/ProductPicture (1).jfif', 1, '2025-02-23 05:21:07', 1),
(23, 5, './productImages/5/ProductPicture (2).jfif', 2, '2025-02-23 05:21:07', 1),
(24, 5, './productImages/5/ProductPicture (3).jfif', 3, '2025-02-23 05:21:07', 1),
(25, 5, './productImages/5/ProductPicture (4).jfif', 4, '2025-02-23 05:21:07', 1),
(26, 6, './productImages/6/ProductPicture.jfif', 0, '2025-02-23 05:25:25', 1),
(27, 6, './productImages/6/ProductPicture (1).jfif', 1, '2025-02-23 05:25:25', 1),
(28, 6, './productImages/6/ProductPicture (2).jfif', 2, '2025-02-23 05:25:25', 1),
(29, 6, './productImages/6/ProductPicture (3).jfif', 3, '2025-02-23 05:25:25', 1),
(30, 6, './productImages/6/ProductPicture (4).jfif', 4, '2025-02-23 05:25:25', 1),
(31, 7, './productImages/7/ProductPicture.jfif', 0, '2025-02-23 05:33:55', 1),
(32, 7, './productImages/7/ProductPicture (1).jfif', 1, '2025-02-23 05:33:55', 1),
(33, 7, './productImages/7/ProductPicture (2).jfif', 2, '2025-02-23 05:33:55', 1),
(34, 7, './productImages/7/ProductPicture (3).jfif', 3, '2025-02-23 05:33:55', 1),
(35, 7, './productImages/7/ProductPicture (4).jfif', 4, '2025-02-23 05:33:55', 1),
(36, 8, './productImages/8/ProductPicture.jfif', 0, '2025-02-23 05:36:53', 1),
(37, 8, './productImages/8/ProductPicture (1).jfif', 1, '2025-02-23 05:36:53', 1),
(38, 8, './productImages/8/ProductPicture (2).jfif', 2, '2025-02-23 05:36:53', 1),
(39, 8, './productImages/8/ProductPicture (3).jfif', 3, '2025-02-23 05:36:53', 1),
(40, 8, './productImages/8/ProductPicture (4).jfif', 4, '2025-02-23 05:36:53', 1),
(41, 9, './productImages/9/ProductPicture.jfif', 0, '2025-02-23 05:40:21', 1),
(42, 9, './productImages/9/ProductPicture (1).jfif', 1, '2025-02-23 05:40:21', 1),
(43, 9, './productImages/9/ProductPicture (2).jfif', 2, '2025-02-23 05:40:21', 1),
(44, 9, './productImages/9/ProductPicture (3).jfif', 3, '2025-02-23 05:40:21', 1),
(45, 9, './productImages/9/ProductPicture (4).jfif', 4, '2025-02-23 05:40:21', 1),
(46, 10, './productImages/10/ProductPicture.jfif', 0, '2025-02-23 05:46:01', 1),
(47, 10, './productImages/10/ProductPicture (1).jfif', 1, '2025-02-23 05:46:01', 1),
(48, 10, './productImages/10/ProductPicture (2).jfif', 2, '2025-02-23 05:46:01', 1),
(49, 10, './productImages/10/ProductPicture (3).jfif', 3, '2025-02-23 05:46:01', 1),
(50, 10, './productImages/10/ProductPicture (4).jfif', 4, '2025-02-23 05:46:01', 1),
(51, 11, './productImages/11/ProductPicture.jfif', 0, '2025-02-23 05:48:52', 1),
(52, 11, './productImages/11/ProductPicture (1).jfif', 1, '2025-02-23 05:48:52', 1),
(53, 11, './productImages/11/ProductPicture (2).jfif', 2, '2025-02-23 05:48:52', 1),
(54, 11, './productImages/11/ProductPicture (3).jfif', 3, '2025-02-23 05:48:52', 1),
(55, 11, './productImages/11/ProductPicture (4).jfif', 4, '2025-02-23 05:48:52', 1),
(56, 12, './productImages/12/ProductPicture.jfif', 0, '2025-02-23 05:59:08', 1),
(57, 12, './productImages/12/ProductPicture (1).jfif', 1, '2025-02-23 05:59:08', 1),
(58, 12, './productImages/12/ProductPicture (2).jfif', 2, '2025-02-23 05:59:08', 1),
(59, 12, './productImages/12/ProductPicture (3).jfif', 3, '2025-02-23 05:59:08', 1),
(60, 12, './productImages/12/ProductPicture (4).jfif', 4, '2025-02-23 05:59:08', 1),
(61, 13, './productImages/13/ProductPicture.jfif', 0, '2025-02-23 06:03:22', 1),
(62, 13, './productImages/13/ProductPicture (1).jfif', 1, '2025-02-23 06:03:22', 1),
(63, 13, './productImages/13/ProductPicture (2).jfif', 2, '2025-02-23 06:03:22', 1),
(64, 13, './productImages/13/ProductPicture (3).jfif', 3, '2025-02-23 06:03:22', 1),
(65, 13, './productImages/13/ProductPicture (4).jfif', 4, '2025-02-23 06:03:22', 1),
(66, 14, './productImages/14/ProductPicture.jfif', 0, '2025-02-23 06:06:43', 1),
(67, 14, './productImages/14/ProductPicture (1).jfif', 1, '2025-02-23 06:06:43', 1),
(68, 14, './productImages/14/ProductPicture (2).jfif', 2, '2025-02-23 06:06:43', 1),
(69, 14, './productImages/14/ProductPicture (3).jfif', 3, '2025-02-23 06:06:43', 1),
(70, 14, './productImages/14/ProductPicture (4).jfif', 4, '2025-02-23 06:06:43', 1),
(71, 15, './productImages/15/ProductPicture.jfif', 0, '2025-02-23 06:09:10', 1),
(72, 15, './productImages/15/ProductPicture (1).jfif', 1, '2025-02-23 06:09:10', 1),
(73, 15, './productImages/15/ProductPicture (2).jfif', 2, '2025-02-23 06:09:10', 1),
(74, 15, './productImages/15/ProductPicture (3).jfif', 3, '2025-02-23 06:09:10', 1),
(75, 15, './productImages/15/ProductPicture (4).jfif', 4, '2025-02-23 06:09:10', 1),
(76, 16, './productImages/16/ProductPicture.jfif', 0, '2025-02-23 06:11:53', 1),
(77, 16, './productImages/16/ProductPicture (1).jfif', 1, '2025-02-23 06:11:53', 1),
(78, 16, './productImages/16/ProductPicture (2).jfif', 2, '2025-02-23 06:11:53', 1),
(79, 16, './productImages/16/ProductPicture (3).jfif', 3, '2025-02-23 06:11:53', 1),
(80, 16, './productImages/16/ProductPicture (4).jfif', 4, '2025-02-23 06:11:53', 1),
(81, 17, './productImages/17/ProductPicture.jfif', 0, '2025-02-23 06:14:36', 1),
(82, 17, './productImages/17/ProductPicture (1).jfif', 1, '2025-02-23 06:14:36', 1),
(83, 17, './productImages/17/ProductPicture (2).jfif', 2, '2025-02-23 06:14:36', 1),
(84, 17, './productImages/17/ProductPicture (3).jfif', 3, '2025-02-23 06:14:36', 1),
(85, 17, './productImages/17/ProductPicture (4).jfif', 4, '2025-02-23 06:14:36', 1),
(86, 18, './productImages/18/ProductPicture.jfif', 0, '2025-02-23 06:17:16', 1),
(87, 18, './productImages/18/ProductPicture (1).jfif', 1, '2025-02-23 06:17:16', 1),
(88, 18, './productImages/18/ProductPicture (2).jfif', 2, '2025-02-23 06:17:16', 1),
(89, 18, './productImages/18/ProductPicture (3).jfif', 3, '2025-02-23 06:17:16', 1),
(90, 18, './productImages/18/ProductPicture (4).jfif', 4, '2025-02-23 06:17:16', 1),
(91, 19, './productImages/19/ProductPicture.jfif', 0, '2025-02-23 06:24:36', 1),
(92, 19, './productImages/19/ProductPicture (1).jfif', 1, '2025-02-23 06:24:36', 1),
(93, 19, './productImages/19/ProductPicture (2).jfif', 2, '2025-02-23 06:24:36', 1),
(94, 20, './productImages/20/ProductPicture.jfif', 0, '2025-02-23 06:26:58', 1),
(95, 20, './productImages/20/ProductPicture (1).jfif', 1, '2025-02-23 06:26:58', 1),
(96, 20, './productImages/20/ProductPicture (2).jfif', 2, '2025-02-23 06:26:58', 1),
(97, 21, './productImages/21/ProductPicture.jfif', 0, '2025-02-23 06:28:32', 1),
(98, 21, './productImages/21/ProductPicture (1).jfif', 1, '2025-02-23 06:28:32', 1),
(99, 21, './productImages/21/ProductPicture (2).jfif', 2, '2025-02-23 06:28:32', 1),
(100, 22, './productImages/22/ProductPicture.jfif', 0, '2025-02-23 06:29:54', 1),
(101, 22, './productImages/22/ProductPicture (1).jfif', 1, '2025-02-23 06:29:54', 1),
(102, 22, './productImages/22/ProductPicture (2).jfif', 2, '2025-02-23 06:29:54', 1),
(103, 23, './productImages/23/ProductPicture.jfif', 0, '2025-02-23 06:31:46', 1),
(104, 24, './productImages/24/ProductPicture.jfif', 0, '2025-02-23 06:33:36', 1),
(105, 25, './productImages/25/ProductPicture.jfif', 0, '2025-02-23 06:35:05', 1),
(106, 25, './productImages/25/ProductPicture (1).jfif', 1, '2025-02-23 06:35:05', 1),
(107, 25, './productImages/25/ProductPicture (2).jfif', 2, '2025-02-23 06:35:05', 1),
(108, 26, './productImages/26/ProductPicture.jfif', 0, '2025-02-23 06:37:25', 1),
(109, 26, './productImages/26/ProductPicture (1).jfif', 1, '2025-02-23 06:35:05', 1),
(110, 26, './productImages/26/ProductPicture (2).jfif', 2, '2025-02-23 06:37:25', 1),
(111, 27, './productImages/27/ProductPicture.jfif', 0, '2025-02-23 06:38:52', 1),
(112, 27, './productImages/27/ProductPicture (1).jfif', 1, '2025-02-23 06:38:52', 1),
(113, 27, './productImages/27/ProductPicture (2).jfif', 2, '2025-02-23 06:38:52', 1),
(114, 28, './productImages/28/ProductPicture.jfif', 0, '2025-02-23 06:44:22', 1),
(115, 28, './productImages/28/ProductPicture (1).jfif', 1, '2025-02-23 06:44:22', 1),
(116, 28, './productImages/28/ProductPicture (2).jfif', 2, '2025-02-23 06:44:22', 1),
(117, 28, './productImages/28/ProductPicture (3).jfif', 3, '2025-02-23 06:44:22', 1),
(118, 28, './productImages/28/ProductPicture (4).jfif', 4, '2025-02-23 06:44:22', 1),
(119, 29, './productImages/29/ProductPicture.jfif', 0, '2025-02-23 06:52:08', 1),
(120, 29, './productImages/29/ProductPicture (1).jfif', 1, '2025-02-23 06:52:08', 1),
(121, 29, './productImages/29/ProductPicture (2).jfif', 2, '2025-02-23 06:52:08', 1),
(122, 29, './productImages/29/ProductPicture (3).jfif', 3, '2025-02-23 06:52:08', 1),
(123, 29, './productImages/29/ProductPicture (4).jfif', 4, '2025-02-23 06:52:08', 1),
(124, 30, './productImages/30/ProductPicture.jfif', 0, '2025-02-23 06:55:49', 1),
(125, 30, './productImages/30/ProductPicture (1).jfif', 1, '2025-02-23 06:55:49', 1),
(126, 30, './productImages/30/ProductPicture (2).jfif', 2, '2025-02-23 06:55:49', 1),
(127, 30, './productImages/30/ProductPicture (3).jfif', 3, '2025-02-23 06:55:49', 1),
(128, 30, './productImages/30/ProductPicture (4).jfif', 4, '2025-02-23 06:55:49', 1),
(129, 31, './productImages/31/ProductPicture.jfif', 0, '2025-02-23 06:59:37', 1),
(130, 31, './productImages/31/ProductPicture (1).jfif', 1, '2025-02-23 06:59:37', 1),
(131, 31, './productImages/31/ProductPicture (2).jfif', 2, '2025-02-23 06:59:37', 1),
(132, 31, './productImages/31/ProductPicture (3).jfif', 3, '2025-02-23 06:59:37', 1),
(133, 31, './productImages/31/ProductPicture (4).jfif', 4, '2025-02-23 06:59:37', 1),
(134, 32, './productImages/32/ProductPicture.jfif', 0, '2025-02-23 07:03:10', 1),
(135, 32, './productImages/32/ProductPicture (1).jfif', 1, '2025-02-23 07:03:10', 1),
(136, 32, './productImages/32/ProductPicture (2).jfif', 2, '2025-02-23 07:03:10', 1),
(137, 32, './productImages/32/ProductPicture (3).jfif', 3, '2025-02-23 07:03:10', 1),
(138, 32, './productImages/32/ProductPicture (4).jfif', 4, '2025-02-23 07:03:10', 1),
(139, 33, './productImages/33/ProductPicture.jfif', 0, '2025-02-23 07:09:43', 1),
(140, 33, './productImages/33/ProductPicture (1).jfif', 1, '2025-02-23 07:09:43', 1),
(141, 33, './productImages/33/ProductPicture (2).jfif', 2, '2025-02-23 07:09:43', 1),
(142, 33, './productImages/33/ProductPicture (3).jfif', 3, '2025-02-23 07:09:43', 1),
(143, 33, './productImages/33/ProductPicture (4).jfif', 4, '2025-02-23 07:09:43', 1),
(144, 34, './productImages/34/ProductPicture.jfif', 0, '2025-02-23 07:13:06', 1),
(145, 34, './productImages/34/ProductPicture (1).jfif', 1, '2025-02-23 07:13:06', 1),
(146, 34, './productImages/34/ProductPicture (2).jfif', 2, '2025-02-23 07:13:06', 1),
(147, 34, './productImages/34/ProductPicture (3).jfif', 3, '2025-02-23 07:13:06', 1),
(148, 34, './productImages/34/ProductPicture (4).jfif', 4, '2025-02-23 07:13:06', 1),
(149, 35, './productImages/35/ProductPicture.jfif', 0, '2025-02-23 07:16:38', 1),
(150, 35, './productImages/35/ProductPicture (1).jfif', 1, '2025-02-23 07:16:38', 1),
(151, 35, './productImages/35/ProductPicture (2).jfif', 2, '2025-02-23 07:16:38', 1),
(152, 35, './productImages/35/ProductPicture (3).jfif', 3, '2025-02-23 07:16:38', 1),
(153, 35, './productImages/35/ProductPicture (4).jfif', 4, '2025-02-23 07:16:38', 1),
(154, 36, './productImages/36/ProductPicture.jfif', 0, '2025-02-23 07:19:20', 1),
(155, 36, './productImages/36/ProductPicture (1).jfif', 1, '2025-02-23 07:19:20', 1),
(156, 36, './productImages/36/ProductPicture (2).jfif', 2, '2025-02-23 07:19:20', 1),
(157, 36, './productImages/36/ProductPicture (3).jfif', 3, '2025-02-23 07:19:20', 1),
(158, 36, './productImages/36/ProductPicture (4).jfif', 4, '2025-02-23 07:19:20', 1),
(159, 37, './productImages/37/ProductPicture.jfif', 0, '2025-02-23 07:23:20', 1),
(160, 37, './productImages/37/ProductPicture (1).jfif', 1, '2025-02-23 07:23:20', 1),
(161, 37, './productImages/37/ProductPicture (2).jfif', 2, '2025-02-23 07:19:20', 1),
(162, 37, './productImages/37/ProductPicture (3).jfif', 3, '2025-02-23 07:23:20', 1),
(163, 37, './productImages/37/ProductPicture (4).jfif', 4, '2025-02-23 07:23:20', 1),
(164, 38, './productImages/38/ProductPicture.jfif', 0, '2025-02-23 07:47:09', 1),
(165, 38, './productImages/38/ProductPicture (1).jfif', 1, '2025-02-23 07:47:09', 1),
(166, 38, './productImages/38/ProductPicture (2).jfif', 2, '2025-02-23 07:47:09', 1),
(167, 38, './productImages/38/ProductPicture (3).jfif', 3, '2025-02-23 07:47:09', 1),
(168, 38, './productImages/38/ProductPicture (4).jfif', 4, '2025-02-23 07:47:09', 1),
(169, 39, './productImages/39/ProductPicture.jfif', 0, '2025-02-23 07:50:59', 1),
(170, 39, './productImages/39/ProductPicture (1).jfif', 1, '2025-02-23 07:50:59', 1),
(171, 39, './productImages/39/ProductPicture (2).jfif', 2, '2025-02-23 07:50:59', 1),
(172, 39, './productImages/39/ProductPicture (3).jfif', 3, '2025-02-23 07:50:59', 1),
(173, 39, './productImages/39/ProductPicture (4).jfif', 4, '2025-02-23 07:50:59', 1),
(174, 40, './productImages/40/ProductPicture.jfif', 0, '2025-02-23 07:57:21', 1),
(175, 40, './productImages/40/ProductPicture (1).jfif', 1, '2025-02-23 07:57:21', 1),
(176, 40, './productImages/40/ProductPicture (2).jfif', 2, '2025-02-23 07:57:21', 1),
(177, 40, './productImages/40/ProductPicture (3).jfif', 3, '2025-02-23 07:57:21', 1),
(178, 40, './productImages/40/ProductPicture (4).jfif', 4, '2025-02-23 07:57:21', 1),
(179, 41, './productImages/41/ProductPicture.jfif', 0, '2025-02-23 08:01:08', 1),
(180, 41, './productImages/41/ProductPicture (1).jfif', 1, '2025-02-23 08:01:08', 1),
(181, 41, './productImages/41/ProductPicture (2).jfif', 2, '2025-02-23 08:01:08', 1),
(182, 41, './productImages/41/ProductPicture (3).jfif', 3, '2025-02-23 08:01:08', 1),
(183, 41, './productImages/41/ProductPicture (4).jfif', 4, '2025-02-23 08:01:08', 1),
(184, 42, './productImages/42/ProductPicture.jfif', 0, '2025-02-23 08:05:10', 1),
(185, 42, './productImages/42/ProductPicture (1).jfif', 1, '2025-02-23 08:05:10', 1),
(186, 42, './productImages/42/ProductPicture (2).jfif', 2, '2025-02-23 08:05:10', 1),
(187, 42, './productImages/42/ProductPicture (3).jfif', 3, '2025-02-23 08:05:10', 1),
(188, 42, './productImages/42/ProductPicture (4).jfif', 4, '2025-02-23 08:05:10', 1),
(189, 43, './productImages/43/ProductPicture.jfif', 0, '2025-02-23 08:09:10', 1),
(190, 43, './productImages/43/ProductPicture (1).jfif', 1, '2025-02-23 08:09:10', 1),
(191, 43, './productImages/43/ProductPicture (2).jfif', 2, '2025-02-23 08:09:10', 1),
(192, 43, './productImages/43/ProductPicture (3).jfif', 3, '2025-02-23 08:09:10', 1),
(193, 43, './productImages/43/ProductPicture (4).jfif', 4, '2025-02-23 08:09:10', 1),
(194, 44, './productImages/44/ProductPicture.jfif', 0, '2025-02-23 11:40:31', 1),
(195, 44, './productImages/44/ProductPicture (1).jfif', 1, '2025-02-23 11:40:31', 1),
(196, 44, './productImages/44/ProductPicture (2).jfif', 2, '2025-02-23 11:40:31', 1),
(197, 44, './productImages/44/ProductPicture (3).jfif', 3, '2025-02-23 11:40:31', 1),
(198, 44, './productImages/44/ProductPicture (4).jfif', 4, '2025-02-23 11:40:31', 1),
(199, 45, './productImages/45/ProductPicture.jfif', 0, '2025-02-23 11:46:46', 1),
(200, 45, './productImages/45/ProductPicture (1).jfif', 1, '2025-02-23 11:46:46', 1),
(201, 45, './productImages/45/ProductPicture (2).jfif', 2, '2025-02-23 11:46:46', 1),
(202, 45, './productImages/45/ProductPicture (3).jfif', 3, '2025-02-23 11:46:46', 1),
(203, 45, './productImages/45/ProductPicture (4).jfif', 4, '2025-02-23 11:46:46', 1),
(204, 46, './productImages/46/ProductPicture.jfif', 0, '2025-02-23 11:50:11', 1),
(205, 46, './productImages/46/ProductPicture (1).jfif', 1, '2025-02-23 11:50:11', 1),
(206, 46, './productImages/46/ProductPicture (2).jfif', 2, '2025-02-23 11:50:11', 1),
(207, 46, './productImages/46/ProductPicture (3).jfif', 3, '2025-02-23 11:50:11', 1),
(208, 46, './productImages/46/ProductPicture (4).jfif', 4, '2025-02-23 11:50:11', 1),
(209, 47, './productImages/47/ProductPicture.jfif', 0, '2025-02-23 11:54:11', 1),
(210, 47, './productImages/47/ProductPicture (1).jfif', 1, '2025-02-23 11:54:11', 1),
(211, 1, './productImages/1/67bd6cf3657e4.png', 5, '2025-02-25 07:10:43', 1),
(212, 1, './productImages/1/67bd6cf366114.png', 6, '2025-02-25 07:10:43', 1),
(213, 1, './productImages/1/67bd6cf366d5f.png', 7, '2025-02-25 07:10:43', 1),
(214, 1, './productImages/1/67bd6cf3675d5.png', 8, '2025-02-25 07:10:43', 1),
(222, 48, './productImages/48/67bd9ab27f206.jfif', 0, '2025-02-25 10:25:54', 1),
(223, 48, './productImages/48/67bd9ab27f49d.jfif', 1, '2025-02-25 10:25:54', 1),
(224, 50, './productImages/50/67beae356d1a9.webp', 1, '2025-02-26 06:01:25', 1),
(225, 50, './productImages/50/67beae356d4e6.webp', 0, '2025-02-26 06:01:25', 1),
(226, 51, './productImages/51/67bff92994878.jfif', 0, '2025-02-27 05:33:29', 1),
(227, 51, './productImages/51/67bff92994b68.jfif', 1, '2025-02-27 05:33:29', 1),
(228, 51, './productImages/51/67bff92994d96.jfif', 2, '2025-02-27 05:33:29', 1),
(229, 51, './productImages/51/67bff9299505a.jfif', 3, '2025-02-27 05:33:29', 1),
(230, 51, './productImages/51/67bff929952ab.jfif', 4, '2025-02-27 05:33:29', 1);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
