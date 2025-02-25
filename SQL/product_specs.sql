-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2025-02-21 12:19:50
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
-- 資料表結構 `product_specs`
--

CREATE TABLE `product_specs` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `specName` varchar(50) NOT NULL,
  `specValue` varchar(50) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `sortOrder` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `product_specs`
--

INSERT INTO `product_specs` (`id`, `product_id`, `specName`, `specValue`, `createdAt`, `sortOrder`) VALUES
(1, 1, '尺寸', 'XS', '2025-02-21 02:51:23', 0),
(2, 1, '尺寸', 'S', '2025-02-21 02:51:23', 1),
(3, 1, '尺寸', 'M', '2025-02-21 02:51:23', 2),
(4, 1, '尺寸', 'L', '2025-02-21 02:51:23', 3),
(5, 1, '尺寸', 'XL', '2025-02-21 02:51:23', 4),
(6, 1, '尺寸', 'XXL', '2025-02-21 02:51:23', 5),
(7, 2, '尺寸', 'XS', '2025-02-21 02:51:23', 0),
(8, 2, '尺寸', 'S', '2025-02-21 02:51:23', 1),
(9, 2, '尺寸', 'M', '2025-02-21 02:51:23', 2),
(10, 2, '尺寸', 'L', '2025-02-21 02:51:23', 3),
(11, 2, '尺寸', 'XL', '2025-02-21 02:51:23', 4),
(12, 2, '尺寸', 'XXL', '2025-02-21 02:51:23', 5),
(13, 3, '尺寸', 'XS', '2025-02-21 02:51:23', 0),
(14, 3, '尺寸', 'S', '2025-02-21 02:51:23', 1),
(15, 3, '尺寸', 'M', '2025-02-21 02:51:23', 2),
(16, 3, '尺寸', 'L', '2025-02-21 02:51:23', 3),
(17, 3, '尺寸', 'XL', '2025-02-21 02:51:23', 4),
(18, 3, '尺寸', 'XXL', '2025-02-21 02:51:23', 5);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `product_specs`
--
ALTER TABLE `product_specs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product_specs`
--
ALTER TABLE `product_specs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `product_specs`
--
ALTER TABLE `product_specs`
  ADD CONSTRAINT `product_specs_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
