-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2025-02-21 12:29:47
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
-- 資料表結構 `coursevariants`
--

CREATE TABLE `coursevariants` (
  `id` int(11) NOT NULL COMMENT '課程 ID',
  `course_id` int(100) NOT NULL COMMENT '關聯到 Courses 的 id',
  `difficulty` enum('beginner','intermediate','advanced') NOT NULL COMMENT '難度級別',
  `duration` enum('3','4','5') NOT NULL COMMENT '課程時長（小時）',
  `price` decimal(10,2) NOT NULL COMMENT '課程價格',
  `location_id` int(11) NOT NULL COMMENT '地點 ID，參考 Locations 表',
  `coach_id` int(11) NOT NULL COMMENT '教練 ID，參考 Instructors 表',
  `max_participants` int(11) NOT NULL COMMENT '最大參與人數',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '建立時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='存儲課程資訊';

--
-- 傾印資料表的資料 `coursevariants`
--

INSERT INTO `coursevariants` (`id`, `course_id`, `difficulty`, `duration`, `price`, `location_id`, `coach_id`, `max_participants`, `created_at`) VALUES
(1, 1, 'beginner', '3', 4500.00, 1, 1, 10, '2025-02-21 03:43:13');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `coursevariants`
--
ALTER TABLE `coursevariants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `location_id` (`location_id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `coursevariants`
--
ALTER TABLE `coursevariants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '課程 ID', AUTO_INCREMENT=2;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `coursevariants`
--
ALTER TABLE `coursevariants`
  ADD CONSTRAINT `coursevariants_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
