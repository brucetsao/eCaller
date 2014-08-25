-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生日期: 2012 年 10 月 24 日 05:29
-- 伺服器版本: 5.5.25a
-- PHP 版本: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 資料庫: `pulifoodmap`
--

-- --------------------------------------------------------

--
-- 表的結構 `mapadmin`
--

CREATE TABLE IF NOT EXISTS `mapadmin` (
  `username` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `passwd` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 轉存資料表中的資料 `mapadmin`
--

INSERT INTO `mapadmin` (`username`, `passwd`) VALUES
('admin', 'admin');

-- --------------------------------------------------------

--
-- 表的結構 `maplist`
--

CREATE TABLE IF NOT EXISTS `maplist` (
  `mapId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mapName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mapDesc` text COLLATE utf8_unicode_ci NOT NULL,
  `mapLat` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mapLng` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mapTel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mapAddr` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`mapId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- 轉存資料表中的資料 `maplist`
--

INSERT INTO `maplist` (`mapId`, `mapName`, `mapDesc`, `mapLat`, `mapLng`, `mapTel`, `mapAddr`) VALUES
(1, '埔里酒廠', '埔里酒廠是一個有特產、名產、小吃的休閒零食，網友認為值得推薦的有：紹興香腸、紹興米糕冰、紹興酒蛋、愛蘭白酒鴨掌。', '23.967910', '120.960203', '049-2984006', '南投縣埔里鎮中山路三段219號'),
(2, '18度C巧克力工房', '18度C低恆溫巧克力工房是一個有巧克力、伴手禮、排隊店的巧克力專賣，網友認為值得推薦的有：生巧克力、情人濃郁65%生巧克力、85%生巧克力、威士忌酒心、抹茶生巧克力', '23.957413', '120.974924', '049-2984863', '台灣南投縣埔里鎮慈恩街20號'),
(3, '和風食堂', '和風食堂是一個有異國料理、日式料理的其他日式料理，網友認為值得推薦的有：起士豬排、梅醬豬排、(大)肉燥飯', '23.967411', '120.962992', '049-2993873', '南投縣埔里鎮南昌街291號1樓'),
(4, '金都餐廳', '好山好水好食材，人親土親故鄉親。胼手胝足努力耕耘十多年，金都餐廳一步一腳印，致力為飲食注入豐富多元的鄉土特色與文化血脈。', '23.973480', '120.972470', '049-2995096', '南投縣埔里鎮信義路236號'),
(5, '李仔哥爌肉飯', '李仔哥爌肉飯是一個有平價、小吃、吃吃喝喝的台菜餐廳，網友認為值得推薦的有：爌肉販、味噌湯、爌肉飯、梅干菜飯、爌肉、爌肉飯。', '23.973408', '120.969810', '049-2983496', '南投縣埔里鎮信義路326號'),
(6, '卓肉圓', '卓肉圓是一個有路邊攤、小吃、平價的其他小吃，網友認為值得推薦的有：肉圓、香菇貢丸湯。', '23.967365', '120.970077', '049-2993815', '台灣南投縣埔里鎮中山路二段219號'),
(7, '羅春捲', '羅春捲是一個有路邊攤、吃吃喝喝、小吃的其他小吃，網友認為值得推薦的有：春捲、魷魚羹和乾麵、原味春捲。', '23.967043', '120.967450', '0921-300164', '南投縣埔里鎮西安路一段167號'),
(8, '亞卓鄉土客家菜', '亞卓鄉土客家菜是一個有南投美食、家庭聚會、可刷卡的客家菜，網友認為值得推薦的有：薑絲大腸、苦瓜炒鹹蛋、客家小炒。', '23.969817', '120.954173', '049-2918218', '台灣南投縣埔里鎮中山路三段412之1號'),
(9, '蘇媽媽湯圓', '蘇媽媽湯圓是一個有平價、路邊攤、排隊店的其他小吃，網友認為值得推薦的有：紫米湯圓,芝麻湯圓,肉燥麵、花生湯圓。', '23.966766', '120.962827', '049-2988915', '台灣南投縣埔里鎮中山路三段118號'),
(10, '九張桌子', '九張桌子是一個有吃吃喝喝、免服務費、平價的義式料理，網友認為值得推薦的有：番茄牛肉起司義大利麵、咖哩雞肉義大利麵。', '23.969853', '120.971400', '049-2902323', '南投縣埔里鎮北安路78號'),
(11, '牛相觸庭園餐坊', '牛相觸位於中潭公路愛蘭橋旁，隔著南港溪，與埔里最古老的台地烏牛欄台地遙遙相望，古早人覺得這兩座台地，狀似「兩牛相觸」，於是「牛相觸」這個饒富農村趣味的地名就產生了！', '23.963232', '120.946292', '049-2912775', '台灣南投縣埔里鎮桃南路31號'),
(12, '胡國雄古早麵', '胡國雄古早麵是一個有古早味、單點式、小吃的麵食點心，網友認為值得推薦的有：切仔麵、燙青菜、板條、過貓、粿仔條。', '23.967491', '120.963721', '049-2990586', '南投縣埔里鎮仁愛路3號(圓環附近) '),
(13, '沃克泰泰式料理', '沃克泰泰式料理是一個有吃吃喝喝、平價、免服務費的泰式料理，網友認為值得推薦的有：打拋肉、青木瓜、椰汁雞。', '23.968915', '120.946367', '049-2918569', '南投縣埔里鎮梅村路22號'),
(14, '森心咖啡館', '森心咖啡館是一個有情侶約會、吃吃喝喝、家庭聚會的景觀餐廳，網友認為值得推薦的有：焗烤奶油海鮮義大利貝殼麵。', '23.973028', '120.975600', '049-2983278', '台灣南投縣埔里鎮信義路121號');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
