-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2025-02-27 17:55:57
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
-- 資料表結構 `license`
--

CREATE TABLE `license` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `license`
--

INSERT INTO `license` (`id`, `name`) VALUES
(1, '加拿大CASI Level 1 Snowboard 單板指導員'),
(2, '加拿大CASI Level 1 Ski 雙板指導員'),
(3, '體適能健身c級指導'),
(4, '國民體適能指導員'),
(5, '加拿大ISIA LV3 ski 雙板指導員'),
(6, '加拿大CASI Level 2 Ski 雙板指導員'),
(7, '紐西蘭SBINZ  單板二級指導員'),
(8, '紐西蘭NZSIA  雙板一級指導員'),
(9, 'BLSI急救證'),
(10, '工具式筋膜放鬆術'),
(11, '中華民國外語領隊人員- 英語，華語'),
(12, '加拿大CASI Level 2 Snowboard 單板指導員'),
(13, 'APSI Level 1'),
(14, '加拿大CSIA Level 2 Ski 雙板指導員'),
(15, '日本 SAJ 單板滑行檢定2級'),
(16, '日本 SAJ 單板滑行檢定1級'),
(17, '美國 PSIA 雙板 Lv1'),
(18, '加拿大CSIA Level 1 Ski 雙板指導員'),
(19, '加拿大 CASI 單板 Lv1');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `license`
--
ALTER TABLE `license`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `license`
--
ALTER TABLE `license`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
