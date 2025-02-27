-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2025-02-27 15:45:26
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
-- 資料表結構 `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `parentId` int(11) DEFAULT NULL,
  `valid` tinyint(4) DEFAULT 1,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `gender` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `categories`
--

INSERT INTO `categories` (`id`, `name`, `parentId`, `valid`, `createdAt`, `gender`) VALUES
(1, '滑雪用品', NULL, 1, '2025-02-21 02:08:02', 0),
(2, '毛帽', 1, 1, '2025-02-21 02:09:57', 0),
(3, '滑雪外套', 1, 1, '2025-02-21 02:11:06', 0),
(4, '滑雪外套-男生款', 3, 1, '2025-02-21 02:12:54', 1),
(5, '滑雪外套-女生款', 3, 1, '2025-02-21 02:13:16', 2),
(6, '滑雪褲', 1, 1, '2025-02-21 02:14:01', 0),
(7, '滑雪褲-男生款', 6, 1, '2025-02-21 02:14:20', 1),
(8, '滑雪褲-女生款', 6, 1, '2025-02-21 02:14:28', 2),
(9, '雪鞋', 1, 1, '2025-02-21 02:15:23', 0),
(10, '雪鞋-男款', 9, 1, '2025-02-21 02:18:24', 1),
(11, '雪鞋-女款', 9, 1, '2025-02-21 02:18:39', 2),
(12, '雪板', 1, 1, '2025-02-21 02:20:46', 0),
(13, '雪板-單板', 12, 1, '2025-02-21 02:21:12', 0),
(14, '雪板-雙板', 12, 1, '2025-02-21 02:21:17', 0),
(15, '雪板-單板-男板', 13, 1, '2025-02-21 02:21:51', 1),
(16, '雪板-單板-女板', 13, 1, '2025-02-21 02:21:55', 2),
(17, '滑雪外套-男女通用款', 3, 1, '2025-02-23 13:16:37', 3),
(18, '滑雪褲-男女通用款', 6, 1, '2025-02-23 13:17:08', 3),
(19, '雪鞋-男女通用款', 9, 1, '2025-02-23 13:18:49', 3),
(20, '雪板-單板-男女通用款', 13, 1, '2025-02-23 13:19:29', 3);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parentId`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`parentId`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
