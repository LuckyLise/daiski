-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2025-02-27 15:54:49
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
  `course_id` int(11) UNSIGNED NOT NULL COMMENT '關聯到 Courses 的 id',
  `type` enum('單板','雙板') NOT NULL,
  `difficulty` enum('初級','中級','高級') NOT NULL COMMENT '難度級別',
  `duration` enum('3','4','5') NOT NULL COMMENT '課程時長（小時）',
  `price` int(10) NOT NULL COMMENT '課程價格',
  `location_id` int(11) NOT NULL COMMENT '地點 ID，參考 Locations 表',
  `coach_id` int(11) UNSIGNED DEFAULT NULL COMMENT '教練 ID，參考 Instructors 表',
  `max_participants` int(11) NOT NULL COMMENT '最大參與人數',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '建立時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='存儲課程資訊';

--
-- 傾印資料表的資料 `coursevariants`
--

INSERT INTO `coursevariants` (`id`, `course_id`, `type`, `difficulty`, `duration`, `price`, `location_id`, `coach_id`, `max_participants`, `created_at`) VALUES
(1, 1, '雙板', '初級', '3', 12000, 1, NULL, 10, '2025-02-25 02:26:31'),
(2, 2, '雙板', '初級', '4', 24433, 34, NULL, 10, '2025-02-25 02:26:31'),
(27, 3, '雙板', '初級', '3', 30000000, 1, NULL, 0, '2025-02-25 02:37:07'),
(28, 4, '雙板', '中級', '3', 20000, 5, NULL, 0, '2025-02-25 02:42:13'),
(29, 5, '雙板', '中級', '4', 18979, 32, 1, 0, '2025-02-25 02:48:00'),
(30, 6, '雙板', '中級', '3', 24332, 6, NULL, 0, '2025-02-25 02:51:13'),
(31, 7, '單板', '初級', '3', 8000, 1, NULL, 0, '2025-02-25 03:03:12'),
(32, 8, '', '中級', '3', 14000, 8, NULL, 0, '2025-02-25 03:24:57'),
(36, 12, '雙板', '初級', '3', 15000, 10, NULL, 0, '2025-02-25 07:15:49'),
(37, 13, '雙板', '中級', '3', 36000, 19, NULL, 0, '2025-02-25 07:16:45'),
(38, 14, '單板', '高級', '3', 2500000, 32, NULL, 0, '2025-02-26 08:17:58'),
(39, 15, '雙板', '中級', '3', 19000, 21, NULL, 0, '2025-02-27 05:35:13'),
(40, 16, '單板', '中級', '4', 26000, 27, NULL, 0, '2025-02-27 05:37:53'),
(41, 17, '單板', '中級', '3', 12333, 7, 1, 0, '2025-02-27 05:38:55'),
(42, 18, '雙板', '初級', '3', 125000, 13, 1, 0, '2025-02-27 05:41:42'),
(43, 19, '單板', '中級', '3', 30000, 22, NULL, 0, '2025-02-27 05:44:55'),
(44, 20, '單板', '中級', '3', 125790, 9, NULL, 0, '2025-02-27 05:47:48'),
(45, 21, '單板', '中級', '4', 50000, 25, NULL, 0, '2025-02-27 06:03:15'),
(46, 22, '單板', '中級', '5', 80000, 24, NULL, 0, '2025-02-27 06:06:32'),
(47, 23, '單板', '初級', '3', 12312314, 18, 1, 0, '2025-02-27 06:13:01'),
(48, 24, '單板', '中級', '5', 95279, 33, NULL, 0, '2025-02-27 06:16:32'),
(49, 25, '雙板', '初級', '4', 14000, 1, NULL, 0, '2025-02-27 06:20:01'),
(50, 26, '單板', '中級', '4', 55200, 23, NULL, 0, '2025-02-27 06:22:04'),
(51, 27, '單板', '中級', '4', 15790, 11, 1, 0, '2025-02-27 06:22:46'),
(52, 28, '單板', '中級', '4', 13579, 18, NULL, 0, '2025-02-27 06:32:23'),
(53, 29, '單板', '中級', '4', 97531, 29, NULL, 0, '2025-02-27 06:32:57'),
(54, 30, '單板', '中級', '4', 88550, 29, NULL, 0, '2025-02-27 06:34:29'),
(55, 31, '單板', '中級', '4', 13699, 14, 1, 0, '2025-02-27 06:36:05'),
(56, 32, '雙板', '中級', '4', 136978, 10, NULL, 0, '2025-02-27 06:47:32'),
(57, 33, '單板', '中級', '4', 26888, 15, NULL, 0, '2025-02-27 06:49:44'),
(58, 34, '雙板', '初級', '4', 60000, 20, 2, 0, '2025-02-27 06:54:02'),
(59, 35, '雙板', '中級', '4', 23450, 30, NULL, 0, '2025-02-27 06:55:27'),
(60, 36, '雙板', '中級', '4', 28000, 7, NULL, 0, '2025-02-27 06:56:16'),
(61, 37, '雙板', '初級', '4', 45600, 30, NULL, 0, '2025-02-27 06:57:57'),
(62, 38, '雙板', '初級', '3', 95270, 1, NULL, 0, '2025-02-27 07:09:44'),
(63, 39, '雙板', '初級', '3', 12345, 19, NULL, 0, '2025-02-27 07:14:54'),
(64, 40, '雙板', '中級', '4', 36000, 24, NULL, 0, '2025-02-27 07:17:23'),
(65, 41, '雙板', '中級', '4', 51040, 16, 2, 0, '2025-02-27 07:18:00'),
(66, 42, '雙板', '中級', '3', 78900, 18, NULL, 0, '2025-02-27 07:35:42'),
(67, 43, '雙板', '中級', '4', 69696, 5, NULL, 0, '2025-02-27 07:37:54'),
(68, 44, '單板', '高級', '4', 100000, 31, NULL, 0, '2025-02-27 07:39:17'),
(69, 45, '單板', '高級', '4', 128000, 30, NULL, 0, '2025-02-27 07:39:47'),
(70, 46, '單板', '高級', '5', 98600, 2, NULL, 0, '2025-02-27 07:41:08'),
(71, 47, '雙板', '初級', '3', 36000, 13, NULL, 0, '2025-02-27 07:41:54'),
(72, 48, '單板', '高級', '4', 95000, 16, NULL, 0, '2025-02-27 07:42:23'),
(73, 49, '雙板', '高級', '3', 73000, 29, 1, 0, '2025-02-27 07:43:07'),
(74, 50, '雙板', '高級', '4', 150000, 31, NULL, 0, '2025-02-27 07:45:49'),
(75, 51, '雙板', '初級', '5', 39000, 20, 1, 0, '2025-02-27 07:46:23'),
(76, 52, '雙板', '高級', '3', 79000, 30, NULL, 0, '2025-02-27 07:48:06'),
(77, 53, '雙板', '高級', '3', 96555, 1, NULL, 0, '2025-02-27 07:48:36');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `coursevariants`
--
ALTER TABLE `coursevariants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `location_id` (`location_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `coach_id` (`coach_id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `coursevariants`
--
ALTER TABLE `coursevariants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '課程 ID', AUTO_INCREMENT=78;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `coursevariants`
--
ALTER TABLE `coursevariants`
  ADD CONSTRAINT `coursevariants_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`),
  ADD CONSTRAINT `coursevariants_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coursevariants_ibfk_3` FOREIGN KEY (`coach_id`) REFERENCES `coach` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
