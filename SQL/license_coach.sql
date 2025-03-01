-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2025-02-27 17:56:01
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
-- 資料表結構 `license_coach`
--

CREATE TABLE `license_coach` (
  `id` int(11) NOT NULL,
  `license_id` int(11) NOT NULL,
  `coach_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `license_coach`
--

INSERT INTO `license_coach` (`id`, `license_id`, `coach_id`) VALUES
(107, 1, 1),
(108, 6, 1),
(109, 6, 2),
(110, 12, 2),
(111, 2, 3),
(112, 1, 3),
(113, 6, 4),
(114, 1, 5),
(115, 2, 5),
(116, 6, 6),
(117, 1, 6),
(118, 2, 7),
(119, 1, 7),
(120, 5, 8),
(121, 1, 9),
(122, 2, 9),
(123, 8, 10),
(124, 7, 10),
(125, 8, 11),
(126, 2, 12),
(127, 6, 12),
(128, 6, 13),
(129, 2, 13),
(130, 7, 14),
(131, 8, 14),
(132, 1, 15),
(133, 2, 15),
(136, 2, 17),
(137, 1, 17),
(138, 2, 18),
(139, 7, 18),
(140, 7, 16),
(141, 8, 16),
(142, 13, 19),
(143, 14, 20),
(144, 14, 21),
(145, 14, 22),
(146, 15, 23),
(147, 16, 23),
(148, 14, 24),
(149, 7, 24),
(150, 17, 25),
(151, 14, 25),
(152, 18, 25),
(153, 7, 26),
(154, 14, 26),
(155, 7, 27),
(156, 19, 27),
(157, 7, 27),
(158, 8, 27),
(159, 7, 28),
(160, 14, 29),
(161, 18, 29),
(162, 14, 30);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `license_coach`
--
ALTER TABLE `license_coach`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `license_coach`
--
ALTER TABLE `license_coach`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
