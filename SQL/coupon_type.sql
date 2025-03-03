-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2025-02-27 18:57:02
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
-- 資料表結構 `coupon_type`
--

CREATE TABLE `coupon_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `amount` int(11) NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `coupon_type`
--

INSERT INTO `coupon_type` (`id`, `amount`, `type`) VALUES
(1, 300, '現金'),
(2, 50, '百分比折扣'),
(3, 40, '百分比折扣'),
(4, 40, '百分比折扣'),
(5, 100, '現金'),
(6, 40, '百分比折扣'),
(7, 40, '百分比折扣'),
(8, 50, '百分比折扣'),
(9, 0, '現金'),
(10, 400, '現金'),
(11, 40, '百分比折扣'),
(12, 20, '百分比折扣'),
(13, 600, '現金'),
(14, 10, '百分比折扣'),
(15, 25, '百分比折扣'),
(16, 350, '現金'),
(17, 550, '現金'),
(18, 15, '百分比折扣'),
(19, 35, '百分比折扣'),
(20, 45, '百分比折扣'),
(21, 30, '百分比折扣'),
(22, 500, '現金'),
(23, 40, '現金'),
(24, 1233, '現金'),
(25, 40, '百分比折扣'),
(26, 40, '百分比折扣'),
(27, 50, '百分比折扣'),
(28, 50, '百分比折扣'),
(29, 150, '現金'),
(30, 500, '百分比折扣');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `coupon_type`
--
ALTER TABLE `coupon_type`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `coupon_type`
--
ALTER TABLE `coupon_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
