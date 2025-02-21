-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2025-02-21 12:19:44
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
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `categories`
--

INSERT INTO `categories` (`id`, `name`, `parentId`, `valid`, `createdAt`) VALUES
(1, '滑雪用品', NULL, 1, '2025-02-21 02:08:02'),
(2, '毛帽', 1, 1, '2025-02-21 02:09:57'),
(3, '滑雪外套', 1, 1, '2025-02-21 02:11:06'),
(4, '男生款', 3, 1, '2025-02-21 02:12:54'),
(5, '女生款', 3, 1, '2025-02-21 02:13:16'),
(6, '滑雪褲', 1, 1, '2025-02-21 02:14:01'),
(7, '男生款', 6, 1, '2025-02-21 02:14:20'),
(8, '女生款', 6, 1, '2025-02-21 02:14:28'),
(9, '雪鞋', 1, 1, '2025-02-21 02:15:23'),
(10, '男款雪鞋', 9, 1, '2025-02-21 02:18:24'),
(11, '女款雪鞋', 9, 1, '2025-02-21 02:18:39'),
(12, '雪板', 1, 1, '2025-02-21 02:20:46'),
(13, '單板', 12, 1, '2025-02-21 02:21:12'),
(14, '雙板', 12, 1, '2025-02-21 02:21:17'),
(15, '男板', 13, 1, '2025-02-21 02:21:51'),
(16, '女板', 13, 1, '2025-02-21 02:21:55');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
