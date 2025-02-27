-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2025-02-27 15:54:43
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
-- 資料表結構 `courseimages`
--

CREATE TABLE `courseimages` (
  `id` int(255) UNSIGNED NOT NULL,
  `course_id` int(11) UNSIGNED NOT NULL COMMENT '關聯到 Courses 的 id',
  `image_url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `courseimages`
--

INSERT INTO `courseimages` (`id`, `course_id`, `image_url`, `created_at`) VALUES
(1, 1, './courseImages/1/image_0.jpg', '2025-02-25 02:22:30'),
(2, 1, './courseImages/1/image_1.jpg', '2025-02-25 02:22:30'),
(4, 2, './courseImages/1740447898_1ae0c480.jpg', '2025-02-25 02:29:42'),
(6, 2, './courseImages/1740447898_fdbfdc43.jpg', '2025-02-25 02:29:42'),
(9, 3, './courseImages/rogerpepsi.jpg', '2025-02-25 02:37:07'),
(10, 4, './courseImages/1740451333_1be1df0f.jpg', '2025-02-25 02:42:13'),
(11, 4, './courseImages/1740451333_839d8990.jpg', '2025-02-25 02:42:13'),
(12, 4, './courseImages/1740451333_dfa2dbd0.jpg', '2025-02-25 02:42:13'),
(13, 4, './courseImages/1740451333_954ac5af.jpg', '2025-02-25 02:42:13'),
(14, 5, './courseImages/1740451680_a1f6719e.jpg', '2025-02-25 02:48:00'),
(15, 5, './courseImages/1740451680_dedfbdda.jpg', '2025-02-25 02:48:00'),
(16, 5, './courseImages/1740451680_e6d6d3ca.jpg', '2025-02-25 02:48:00'),
(17, 5, './courseImages/1740451680_7e6db88e.jpg', '2025-02-25 02:48:00'),
(18, 6, './courseImages/1740451873_fb0f8055.jpg', '2025-02-25 02:51:13'),
(19, 6, './courseImages/1740451873_34455012.jpg', '2025-02-25 02:51:13'),
(20, 6, './courseImages/1740451873_4dc6b0e8.jpg', '2025-02-25 02:51:13'),
(21, 7, './courseImages/1740452592_2a2680a8.jpg', '2025-02-25 03:03:12'),
(22, 8, './courseImages/1740453897_0f72d731.jpg', '2025-02-25 03:24:57'),
(23, 12, './courseImages/1740467749_61e328dd.jpg', '2025-02-25 07:15:49'),
(25, 13, './courseImages/1740470780_e9265a16.jpg', '2025-02-25 08:06:20'),
(26, 3, './courseImages/1740554210_bd395c6e.jpg', '2025-02-26 07:16:50'),
(27, 14, './courseImages/1740557878_08ff5165.jpg', '2025-02-26 08:17:58'),
(28, 15, './courseImages/1740634513_a6c9bee4.jpg', '2025-02-27 05:35:13'),
(29, 16, './courseImages/1740634673_ea18860e.webp', '2025-02-27 05:37:53'),
(30, 17, './courseImages/1740634735_ac43aa4b.jfif', '2025-02-27 05:38:55'),
(31, 18, './courseImages/1740634902_9e4c5efe.webp', '2025-02-27 05:41:42'),
(32, 19, './courseImages/1740635095_3d4b09ac.png', '2025-02-27 05:44:55'),
(33, 20, './courseImages/1740635268_6cb2e5fd.png', '2025-02-27 05:47:48'),
(34, 21, './courseImages/1740636195_f056ea8e.webp', '2025-02-27 06:03:15'),
(35, 22, './courseImages/1740636392_e774fdbb.jpg', '2025-02-27 06:06:32'),
(36, 23, './courseImages/1740636781_a720b87c.jpg', '2025-02-27 06:13:01'),
(37, 24, './courseImages/1740636992_484b7be3.webp', '2025-02-27 06:16:32'),
(38, 25, './courseImages/1740637201_90fd64d1.jpg', '2025-02-27 06:20:01'),
(39, 26, './courseImages/1740637324_e8652d9e.png', '2025-02-27 06:22:04'),
(40, 27, './courseImages/1740637366_0703594e.jfif', '2025-02-27 06:22:46'),
(41, 28, './courseImages/1740637943_748ad16c.jpg', '2025-02-27 06:32:23'),
(42, 29, './courseImages/1740637977_602871b6.webp', '2025-02-27 06:32:57'),
(43, 30, './courseImages/1740638069_4fcf5bcf.jpg', '2025-02-27 06:34:29'),
(44, 31, './courseImages/1740638165_af03f81a.jpg', '2025-02-27 06:36:05'),
(45, 32, './courseImages/1740638852_ec85dd29.jpg', '2025-02-27 06:47:32'),
(46, 33, './courseImages/1740638984_68028291.jfif', '2025-02-27 06:49:44'),
(47, 34, './courseImages/1740639242_75a3fc63.jpg', '2025-02-27 06:54:02'),
(48, 35, './courseImages/1740639327_db3eb533.jfif', '2025-02-27 06:55:27'),
(49, 36, './courseImages/1740639376_09ba3093.jpg', '2025-02-27 06:56:16'),
(50, 37, './courseImages/1740639487_8a9d0f7e.jpg', '2025-02-27 06:58:07'),
(51, 38, './courseImages/1740640184_bc0c028a.jpg', '2025-02-27 07:09:44'),
(52, 39, './courseImages/1740640518_5c801ebb.jpg', '2025-02-27 07:15:18'),
(53, 40, './courseImages/1740640643_b0c22419.png', '2025-02-27 07:17:23'),
(54, 41, './courseImages/1740640680_8f53c99f.jpg', '2025-02-27 07:18:00'),
(55, 42, './courseImages/1740641742_7c63e4f9.png', '2025-02-27 07:35:42'),
(56, 43, './courseImages/1740641874_c219269b.png', '2025-02-27 07:37:54'),
(57, 44, './courseImages/1740641957_aa543051.jpg', '2025-02-27 07:39:17'),
(58, 45, './courseImages/1740641987_230902bc.jpg', '2025-02-27 07:39:47'),
(59, 46, './courseImages/1740642068_0ee1114a.webp', '2025-02-27 07:41:08'),
(60, 47, './courseImages/1740642114_df681069.jpg', '2025-02-27 07:41:54'),
(61, 48, './courseImages/1740642143_f43f46a8.jpg', '2025-02-27 07:42:23'),
(62, 49, './courseImages/1740642187_a26ee732.png', '2025-02-27 07:43:07'),
(63, 50, './courseImages/1740642349_7a9bf854.png', '2025-02-27 07:45:49'),
(64, 51, './courseImages/1740642383_3d37be24.png', '2025-02-27 07:46:23'),
(65, 52, './courseImages/1740642486_ce99e208.png', '2025-02-27 07:48:06'),
(66, 53, './courseImages/1740642516_58f5fcd4.jpg', '2025-02-27 07:48:36'),
(67, 53, './courseImages/1740642516_2ab5dc2e.jpg', '2025-02-27 07:48:36'),
(68, 53, './courseImages/1740642516_fdea00b6.png', '2025-02-27 07:48:36');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `courseimages`
--
ALTER TABLE `courseimages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `courseimages`
--
ALTER TABLE `courseimages`
  MODIFY `id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `courseimages`
--
ALTER TABLE `courseimages`
  ADD CONSTRAINT `courseimages_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
