-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2025-02-21 13:17:41
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
-- 資料表結構 `article`
--

CREATE TABLE `article` (
  `id` int(10) UNSIGNED NOT NULL,
  `titile` varchar(50) NOT NULL,
  `content` varchar(1500) NOT NULL,
  `startDate` datetime NOT NULL,
  `endDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `article`
--

INSERT INTO `article` (`id`, `titile`, `content`, `startDate`, `endDate`) VALUES
(1, '滑雪場夏天也能去? 一覽石打丸山的夏日觀光特點！', '石打丸山夏季露臺\r\nThe VERANDA at Ishiuchi (石打丸山夏季露臺) 於2022年開始經營，搭乘約7分鐘的纜車，即可一覽南魚沼市的絕美景色欣賞壯麗夕陽景色與夢幻夜景\r\n石打丸山夏季展望露臺 將於2024年7月6日（星期六）至9月28日（星期六）間的每個星期六及特定日，共計22天，舉辦「夜間露台」營業活動。這段時間內，您可以在此欣賞南魚沼市壯麗的夕陽景色與夢幻般的夜景。 在夜間露台營業期間，營業時間將延長至晚上21:00，您可以欣賞到隨時間推移而漸漸被美麗的紅霞染紅的天空，夕陽照耀下閃閃發光的雄偉山脈，以及最終以南魚沼市燈火輝煌的夜景作為壓軸的壯麗自然大秀，這是一生只有一次、僅在暮光時刻才能欣賞到的大自然奇觀。 此外，場地內還設有特別照明的休息區，並在暑假期間舉辦適合兒童和成人參加的「夏日祭典」等活動。當夕陽西下，氣溫變得涼爽宜人時，不妨來到「石打丸山露臺」，創造一個特別的夏日回憶。夏季期間限定夜間露臺\r\n周末營業時間延長至21:00，感受獨特的夜景石打丸山超人氣鬆餅\r\n日本當地票選超人氣鬆餅，許多台日網美老饕特地前來享用南魚沼市壯麗美景\r\n有別於冬天特殊雪景，夏天的田園風景亦讓人流連忘返石打丸山 2024夏季營業資訊■營業期間\r\n＜常規＞ 2024年4月27日（星期六）～5月6日（星期一/節假日）、7月6日（星期六）～11月10日（星期日）\r\n＜夜間露台營業＞ 2024年7月6日（星期六）～9月28日（星期六）的每個週六、節日前夕及特定日期\r\n\r\n■ 營業時間\r\n\r\n＜常規＞10:30～17:30\r\n\r\n＜夜間露台營業＞11:30～21:00\r\n\r\n■ 費用\r\n\r\n＜纜車往返票＞ 成人2,800日圓，兒童（小學生）1,400日圓，學生2,000日圓，寵物500日圓\r\n\r\n※兒童為小學生以下，學生為中學生以上。 ※學生需在窗口出示學生證。\r\n\r\n※3歲以下免費。4歲以上的學齡前兒童在有一名成人陪同的情況下，每名成人可免費攜帶一名兒童。\r\n\r\n＜提前網上購票＞ 提前在網上購票更划算哦\r\n\r\n★https://www.kkday.com/ja/promo/ishiuchigreen', '2025-02-21 09:40:03', '2025-02-21 09:40:03');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `article`
--
ALTER TABLE `article`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
