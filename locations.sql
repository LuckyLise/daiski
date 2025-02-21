-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2025-02-21 12:29:53
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
-- 資料表結構 `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL COMMENT '地點 ID',
  `name` varchar(255) NOT NULL COMMENT '地點名稱',
  `address` varchar(255) NOT NULL COMMENT '地址',
  `city` varchar(100) NOT NULL COMMENT '城市',
  `country` varchar(100) NOT NULL COMMENT '國家',
  `latitude` decimal(20,17) NOT NULL COMMENT '緯度',
  `longitude` decimal(20,17) NOT NULL COMMENT '經度',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '建立時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='存儲滑雪課程的上課地點資訊';

--
-- 傾印資料表的資料 `locations`
--

INSERT INTO `locations` (`id`, `name`, `address`, `city`, `country`, `latitude`, `longitude`, `created_at`) VALUES
(1, '富良野滑雪場', '076-8511北海道富良野市中御料', '北海道', '日本', 43.32513289734520000, 142.35330272587458000, '2025-02-21 04:25:12');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '地點 ID', AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
