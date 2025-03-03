-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2025-02-27 17:55:51
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
-- 資料表結構 `language_coach`
--

CREATE TABLE `language_coach` (
  `id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `coach_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `language_coach`
--

INSERT INTO `language_coach` (`id`, `language_id`, `coach_id`) VALUES
(129, 2, 1),
(130, 1, 1),
(131, 3, 1),
(132, 6, 1),
(133, 2, 2),
(134, 1, 2),
(135, 5, 2),
(136, 6, 2),
(137, 2, 3),
(138, 1, 3),
(139, 2, 4),
(140, 1, 4),
(141, 3, 4),
(142, 2, 5),
(143, 1, 5),
(144, 3, 5),
(145, 2, 6),
(146, 2, 7),
(147, 1, 7),
(148, 6, 7),
(149, 1, 8),
(150, 2, 9),
(151, 6, 9),
(152, 2, 10),
(153, 1, 10),
(154, 2, 11),
(155, 1, 11),
(156, 3, 11),
(157, 2, 12),
(158, 1, 12),
(159, 2, 13),
(160, 2, 14),
(161, 1, 14),
(162, 3, 14),
(163, 2, 15),
(164, 1, 15),
(167, 2, 17),
(168, 1, 17),
(169, 5, 17),
(170, 2, 18),
(171, 2, 16),
(172, 1, 16),
(173, 2, 19),
(174, 1, 19),
(175, 2, 20),
(176, 2, 21),
(177, 2, 22),
(178, 2, 23),
(179, 1, 23),
(180, 5, 23),
(181, 2, 24),
(182, 1, 24),
(183, 2, 25),
(184, 1, 25),
(185, 2, 26),
(186, 2, 27),
(187, 1, 28),
(188, 2, 27),
(189, 2, 28),
(190, 1, 28),
(191, 2, 29),
(192, 3, 29),
(193, 2, 30),
(194, 1, 30);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `language_coach`
--
ALTER TABLE `language_coach`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `language_coach`
--
ALTER TABLE `language_coach`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
