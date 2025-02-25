-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2025-02-21 12:29:08
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
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `url`, `sortOrder`, `createdAt`) VALUES
(1, 1, './productImages/1/product.jfif', 0, '2025-02-21 03:23:51'),
(2, 1, './productImages/1/ProductPicture (1).jfif', 1, '2025-02-21 03:23:51'),
(3, 1, './productImages/1/ProductPicture (2).jfif', 2, '2025-02-21 03:23:51'),
(4, 1, './productImages/1/ProductPicture (3).jfif', 3, '2025-02-21 03:23:51'),
(5, 1, './productImages/1/ProductPicture (4).jfif', 4, '2025-02-21 03:23:51'),
(6, 2, './productImages/2/product.jfif', 0, '2025-02-21 03:23:51'),
(7, 2, './productImages/2/ProductPicture (1).jfif', 1, '2025-02-21 03:23:51'),
(8, 2, './productImages/2/ProductPicture (2).jfif', 2, '2025-02-21 03:23:51'),
(9, 2, './productImages/2/ProductPicture (3).jfif', 3, '2025-02-21 03:23:51'),
(10, 2, './productImages/2/ProductPicture (4).jfif', 4, '2025-02-21 03:23:51'),
(11, 3, './productImages/3/product.jfif', 0, '2025-02-21 03:49:11'),
(12, 3, './productImages/3/ProductPicture (1).jfif', 1, '2025-02-21 03:49:11'),
(13, 3, './productImages/3/ProductPicture (2).jfif', 2, '2025-02-21 03:49:11'),
(14, 3, './productImages/3/ProductPicture (3).jfif', 3, '2025-02-21 03:49:11'),
(15, 3, './productImages/3/ProductPicture (4).jfif', 4, '2025-02-21 03:49:11');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
