-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2025-02-21 12:19:39
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
-- 資料表結構 `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `gender` tinyint(4) NOT NULL DEFAULT 0,
  `introduction` text DEFAULT NULL,
  `specIntroduction` text DEFAULT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `publishAt` datetime DEFAULT NULL,
  `unpublishAt` datetime DEFAULT NULL,
  `deleteAt` datetime DEFAULT NULL
) ;

--
-- 傾印資料表的資料 `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `category_id`, `gender`, `introduction`, `specIntroduction`, `createdAt`, `publishAt`, `unpublishAt`, `deleteAt`) VALUES
(1, 'Dimito VTX OG Temp Jacket 智能加熱滑雪外套 - Black', 15400, 3, 3, 'Waterproof : 20K / Breathability : 15K\nDitex 布料具有一流的抗水性和防水/透氣性能\n溫度控制系統（TCS），可透過輔助電池供電在內部產生熱量 ( 外套背部與胸部處設有加熱區 )\n用於連接口袋內 USB TYPE-C 型行動電池的傳輸線\n採用 Primaloft 科技羽絨保暖材質，具有高耐寒性與保暖，超輕量材質\n寬鬆版型，寬鬆舒適\nYKK® 防水拉鍊\n拉鍊插手口袋及中央對角拉鍊雙向設計\n領口處氣孔設計，呼吸舒適\n手臂處通行證口袋\n內部雪鏡網袋及內部拉鍊手機置物口袋\n腋下拉鍊透氣孔\n風帽及下擺有抽繩設計調整鬆緊\n可拆卸式雪裙可防止滑行時粉雪侵入\n魔鬼氈可調式袖口\n萊卡指套設計\n左胸飾有運動刺繡藝術設計', '表面布料 : 尼龍 100% \n襯裡(1)：尼龍 100%\n襯裡(2)：聚酯纖維 100%\n保暖層 : 聚酯纖維 100%', '2025-02-21 10:45:19', NULL, NULL, NULL),
(2, 'Dimito VTX OG Temp Jacket 智能加熱滑雪外套 - Teal Green', 15400, 3, 3, 'Waterproof : 20K / Breathability : 15K\r\nDitex 布料具有一流的抗水性和防水/透氣性能\r\n溫度控制系統（TCS），可透過輔助電池供電在內部產生熱量 ( 外套背部與胸部處設有加熱區 )\r\n用於連接口袋內 USB TYPE-C 型行動電池的傳輸線\r\n採用 Primaloft 科技羽絨保暖材質，具有高耐寒性與保暖，超輕量材質\r\n寬鬆版型，寬鬆舒適\r\nYKK® 防水拉鍊\r\n拉鍊插手口袋及中央對角拉鍊雙向設計\r\n領口處氣孔設計，呼吸舒適\r\n手臂處通行證口袋\r\n內部雪鏡網袋及內部拉鍊手機置物口袋\r\n腋下拉鍊透氣孔\r\n風帽及下擺有抽繩設計調整鬆緊\r\n可拆卸式雪裙可防止滑行時粉雪侵入\r\n魔鬼氈可調式袖口\r\n萊卡指套設計\r\n左胸飾有運動刺繡藝術設計', '表面布料 : 尼龍 100% \r\n襯裡(1)：尼龍 100%\r\n襯裡(2)：聚酯纖維 100%\r\n保暖層 : 聚酯纖維 100%', '2025-02-21 11:42:36', NULL, NULL, NULL),
(3, 'Dimito VTX OG Temp Jacket 智能加熱滑雪外套 - Slate Blue', 15400, 3, 3, 'Waterproof : 20K / Breathability : 15K\r\nDitex 布料具有一流的抗水性和防水/透氣性能\r\n溫度控制系統（TCS），可透過輔助電池供電在內部產生熱量 ( 外套背部與胸部處設有加熱區 )\r\n用於連接口袋內 USB TYPE-C 型行動電池的傳輸線\r\n採用 Primaloft 科技羽絨保暖材質，具有高耐寒性與保暖，超輕量材質\r\n寬鬆版型，寬鬆舒適\r\nYKK® 防水拉鍊\r\n拉鍊插手口袋及中央對角拉鍊雙向設計\r\n領口處氣孔設計，呼吸舒適\r\n手臂處通行證口袋\r\n內部雪鏡網袋及內部拉鍊手機置物口袋\r\n腋下拉鍊透氣孔\r\n風帽及下擺有抽繩設計調整鬆緊\r\n可拆卸式雪裙可防止滑行時粉雪侵入\r\n魔鬼氈可調式袖口\r\n萊卡指套設計\r\n左胸飾有運動刺繡藝術設計', '表面布料 : 尼龍 100% \r\n襯裡(1)：尼龍 100%\r\n襯裡(2)：聚酯纖維 100%\r\n保暖層 : 聚酯纖維 100%', '2025-02-21 11:46:41', NULL, NULL, NULL);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
