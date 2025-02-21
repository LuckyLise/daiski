-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2025-02-21 12:29:33
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
-- 資料表結構 `course`
--

CREATE TABLE `course` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '課程 ID',
  `name` varchar(255) NOT NULL COMMENT '課程名稱',
  `description` text NOT NULL COMMENT '課程描述'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `course`
--

INSERT INTO `course` (`id`, `name`, `description`) VALUES
(1, '北海道富良野滑雪場一日滑雪體驗', '一日富良野滑雪度假村之旅，距離札幌僅2小時車程。這裡擁有頂級的粉雪和令人驚歎的風景，是您度過一天滑雪的完美選擇。富良野滑雪場擁有20多個多樣化的坡道，包括長達刺激的4,000米的史詩滑道，適合所有等級的滑雪愛好者。\r\n\r\n新手無需擔心！我們專業的華語SAJ滑雪教練將在小班環境中自信地引導您。我們為您準備好滑雪裝備，包括雪靴、滑雪板和滑雪杖。輕鬆享受從札幌來回的巴士接送。讓我們一同來感受滑雪樂趣，開啟屬於您的精彩冒險！');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `course`
--
ALTER TABLE `course`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '課程 ID', AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
