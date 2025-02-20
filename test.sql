-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2025-02-20 16:02:53
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
-- 資料庫： `my_test_db`
--

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `id` int(6) UNSIGNED NOT NULL,
  `account` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `creat_at` datetime NOT NULL,
  `valid` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `users`
--

INSERT INTO `users` (`id`, `account`, `password`, `name`, `phone`, `email`, `creat_at`, `valid`) VALUES
(1, 'Tom', '09', 'Tom', '0912345678', 'tom@gmail.com', '2025-02-07 09:59:49', 1),
(2, 'may', '012', 'may', '09123456', 'may@example.com', '2025-02-07 10:35:55', 1),
(3, 'maytest', '123', 'maytest', '091234567', 'may@exaple.com', '2025-02-07 10:39:50', 1),
(4, 'maytes', '456', 'maytes', '0912345677', 'may@exape.com', '2025-02-07 10:44:36', 1),
(5, 'mayte', '789', 'mayte', '091234999', 'may@exape.om', '2025-02-07 10:45:14', 0),
(6, 'samme', '147', 'samme', '91238889', 'samme@example.com', '2025-02-07 10:55:36', 1),
(7, 'suee', '258', 'Suee', '0900000000', 'sue@example.com', '2025-02-07 10:55:36', 1),
(8, 'lucyy', '369', 'Lucyy', '0900000000', 'lucy@example.com', '2025-02-07 10:55:36', 1),
(9, '12345', '4567', 'h', NULL, NULL, '2025-02-10 15:51:11', 1),
(10, '123456', '4567', 'a', NULL, NULL, '2025-02-10 15:52:09', 1),
(11, 'jay12345', '123456', 'c', NULL, NULL, '2025-02-10 16:18:17', 1),
(12, 'maytes1', '74b87337454200d4d33f80c4663dc5e5', NULL, NULL, NULL, '2025-02-17 16:34:57', 1),
(13, '1234', '2475c20d9e9a1aaee80dcbc4e6316157', NULL, NULL, NULL, '2025-02-19 09:35:06', 1),
(14, '123474', '6562c5c1f33db6e05a082a88cddab5ea', NULL, NULL, NULL, '2025-02-19 09:38:12', 1),
(15, 'hihi', '827ccb0eea8a706c4c34a16891f84e7b', NULL, NULL, NULL, '2025-02-19 09:57:50', 1),
(16, 'testhihi', '83cdcec08fbf90370fcf53bdd56604ff', NULL, NULL, NULL, '2025-02-19 09:58:06', 1),
(17, 'hihitest', '83cdcec08fbf90370fcf53bdd56604ff', NULL, NULL, NULL, '2025-02-19 09:58:19', 1),
(18, 'may12345', '827ccb0eea8a706c4c34a16891f84e7b', 'Andy', NULL, 'may12345@test.com', '0000-00-00 00:00:00', 0),
(19, 'may123415', '827ccb0eea8a706c4c34a16891f84e7b', 'Andy', NULL, 'may123415@test.com', '0000-00-00 00:00:00', 0);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `userName` (`name`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `users`
--
ALTER TABLE `users`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
