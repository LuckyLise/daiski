-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2025-02-21 11:42:15
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
-- 資料表結構 `coach`
--

CREATE TABLE `coach` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(30) NOT NULL,
  `bio` text NOT NULL,
  `experience` text NOT NULL,
  `profilephoto` varchar(255) NOT NULL,
  `createdat` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `certification_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `coach`
--

INSERT INTO `coach` (`id`, `name`, `email`, `bio`, `experience`, `profilephoto`, `createdat`, `certification_id`, `language_id`) VALUES
(1, 'Lily', 'lily@test.com', '我是Lily，作為一位專業的滑雪教練，同時也是赭域室內設計公司的設計總監，曾經也有外拍模特的經驗。我深信安全、趣味和進步是學習滑雪的核心價值，並透過教學將這些理念傳達給學員。對我而言，滑雪不僅是一種運動，更是一種生活態度。除了享受滑雪帶來的樂趣，也應享受多姿多彩的生活。我致力於提供高品質的教學，同時將設計美學融入教學過程，希望學員在滑雪的同時留下美好的回憶。\r\n\r\n在滑雪教學領域，我擁有加拿大CASI Level 1 Snowboard單板指導員的專業資格，並在韓國、法國、日本、加拿大和台灣等地積累了豐富的滑雪經驗。作為室內設計總監，每年春夏秋季我全力以赴工作，冬季則專注於滑雪教學。我希望將我的熱愛帶給學生，讓他們在不同領域中找到生活的平衡和滿足。\r\n\r\n曾有外拍模特的經歷和設計總監的工作，讓我相信可以讓滑雪變得更有趣味性。比如，我經常在滑雪裝扮中搭配兔子耳朵裝飾，這也成為了我的標誌風格之一。我提供滑雪裝扮的建議，讓你在雪場中成為最抢眼的精靈。無論是顏色搭配還是款式選擇，我都能給予專業的建議，讓你在滑雪中閃耀夺目。', '我曾在全球多個知名滑雪勝地積累豐富的滑雪經驗。\r\n\r\n滑雪足跡遍佈亞洲、歐洲以及加拿大，包括韓國的龍平、平昌、法國的凡慕爾，以及日本眾多知名滑雪勝地如鹿島槍、野澤、白馬、妙高、斑尾、夏油高原、二世谷、留壽都、富良野、神居、札幌國際、ONZE、Kiroro、星野。\r\n\r\n這些豐富多樣的經歷不僅展現了我的熱情與專業，更代表了我對冬季風景探索的熱愛。滑雪對我而言不僅是極限挑戰，更是探索世界美麗風景的媒介。', 'lily.jpg', '2025-02-21 03:37:47', 1, 1),
(2, 'Lia', 'lia@test.com', '大家好我是Lia，在把空服員的工作辭掉之後，去日本讀書時開始接觸到了滑雪，約莫是從2015/16年至今，滑雪成為我無法割捨的一部分。後來當背包客期間也跑去澳洲滑了兩季的雪，滑過北海道的粉雪、東京近郊的人造雪、南半球的剉冰雪，一路走來對滑雪的熱愛使我成為了一名滑雪教練。', '我在全球多個知名滑雪勝地積累了豐富的滑雪經驗。滑雪足跡遍佈亞洲、澳洲及日本，包括澳洲的雪地滑行、日本的北海道粉雪、東京近郊的人造雪，以及南半球的剉冰雪。這些經歷讓我在不同雪況下磨練技術，積累了豐富的滑雪知識。\r\n\r\n這些多樣的滑雪經歷，不僅展現了我的熱情與專業，更代表了我對滑雪的深厚熱愛。滑雪對我來說，不僅是極限挑戰，更是探索世界美麗風景的媒介。這段旅程豐富了我的人生，也讓我堅定了成為滑雪教練的決心。', 'Lia.jpg', '2025-02-21 03:39:01', 1, 1);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `coach`
--
ALTER TABLE `coach`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `coach`
--
ALTER TABLE `coach`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
