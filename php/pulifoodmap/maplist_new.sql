-- phpMyAdmin SQL Dump
-- version 3.3.5
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 建立日期: Jul 17, 2014, 10:14 AM
-- 伺服器版本: 5.1.49
-- PHP 版本: 5.2.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 資料庫: `ludb`
--

-- --------------------------------------------------------

--
-- 資料表格式： `maplist`
--

CREATE TABLE IF NOT EXISTS `maplist` (
  `mapId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mapName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mapDesc` text COLLATE utf8_unicode_ci NOT NULL,
  `mapLat` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mapLng` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mapTel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mapAddr` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `map_web` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `map_fb` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `map_blog` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`mapId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- 列出以下資料庫的數據： `maplist`
--

INSERT INTO `maplist` (`mapId`, `mapName`, `mapDesc`, `mapLat`, `mapLng`, `mapTel`, `mapAddr`, `map_web`, `map_fb`, `map_blog`) VALUES
(1, '埔里酒廠', '埔里酒廠是一個有特產、名產、小吃的休閒零食，網友認為值得推薦的有：紹興香腸、紹興米糕冰、紹興酒蛋、愛蘭白酒鴨掌。', '23.967910', '120.960203', '049-2984006', '南投縣埔里鎮中山路三段219號', 'http://event.ttl-eshop.com.tw/pl/', '', ''),
(2, '18度C巧克力工房', '18度C低恆溫巧克力工房是一個有巧克力、伴手禮、排隊店的巧克力專賣，網友認為值得推薦的有：生巧克力、情人濃郁65%生巧克力、85%生巧克力、威士忌酒心、抹茶生巧克力', '23.957413', '120.974924', '049-2984863', '台灣南投縣埔里鎮慈恩街20號', 'http://www.feeling18c.com/', '', ''),
(3, '和風食堂', '和風食堂是一個有異國料理、日式料理的其他日式料理，網友認為值得推薦的有：起士豬排、梅醬豬排、(大)肉燥飯', '23.967411', '120.962992', '049-2993873', '南投縣埔里鎮南昌街291號1樓', 'http://hinrickkuma.pixnet.net/blog/post/93269028-%E9%A3%9F%E8%A8%98%EF%BC%8C%E5%9F%94%E9%87%8C-%E5%92%8C%E9%A2%A8%E9%A3%9F%E5%A0%82', '', ''),
(4, '金都餐廳', '好山好水好食材，人親土親故鄉親。胼手胝足努力耕耘十多年，金都餐廳一步一腳印，致力為飲食注入豐富多元的鄉土特色與文化血脈。', '23.973480', '120.972470', '049-2995096', '南投縣埔里鎮信義路236號', 'http://www.jindu1994.com/ge-dian-zi-xun/jin-dou-can-ting-bu-li-dian', '', ''),
(5, '李仔哥爌肉飯', '李仔哥爌肉飯是一個有平價、小吃、吃吃喝喝的台菜餐廳，網友認為值得推薦的有：爌肉販、味噌湯、爌肉飯、梅干菜飯、爌肉、爌肉飯。', '23.973408', '120.969810', '049-2983496', '南投縣埔里鎮信義路326號', 'http://zh-tw.facebook.com/pages/%E6%9D%8E%E4%BB%94%E5%93%A5%E7%88%8C%E8%82%89%E9%A3%AF/146746108713498', 'http://zh-tw.facebook.com/pages/%E6%9D%8E%E4%BB%94%E5%93%A5%E7%88%8C%E8%82%89%E9%A3%AF/146746108713498', ''),
(6, '卓肉圓', '卓肉圓是一個有路邊攤、小吃、平價的其他小吃，網友認為值得推薦的有：肉圓、香菇貢丸湯。', '23.967365', '120.970077', '049-2993815', '台灣南投縣埔里鎮中山路二段219號', 'http://carol218.pixnet.net/blog/post/22628641-%5B%E5%8D%97%E6%8A%95%E5%9F%94%E9%87%8C%5D%E5%8D%93%E8%82%89%E5%9C%93', 'http://carol218.pixnet.net/blog/post/22628641-%5B%E5%8D%97%E6%8A%95%E5%9F%94%E9%87%8C%5D%E5%8D%93%E8%82%89%E5%9C%93', 'http://carol218.pixnet.net/blog/post/22628641-%5B%E5%8D%97%E6%8A%95%E5%9F%94%E9%87%8C%5D%E5%8D%93%E8%82%89%E5%9C%93'),
(7, '羅春捲', '羅春捲是一個有路邊攤、吃吃喝喝、小吃的其他小吃，網友認為值得推薦的有：春捲、魷魚羹和乾麵、原味春捲。', '23.967043', '120.967450', '0921-300164', '南投縣埔里鎮西安路一段167號', 'https://plus.google.com/104040515214523844921/about?gl=tw&hl=zh-TW', '', ''),
(8, '亞卓鄉土客家菜', '亞卓鄉土客家菜是一個有南投美食、家庭聚會、可刷卡的客家菜，網友認為值得推薦的有：薑絲大腸、苦瓜炒鹹蛋、客家小炒。', '23.969817', '120.954173', '049-2918218', '台灣南投縣埔里鎮中山路三段412之1號', 'http://www.yazhuo.com.tw/about.htm', 'http://www.yazhuo.com.tw/about.htm', 'http://www.yazhuo.com.tw/about.htm'),
(9, '蘇媽媽湯圓', '蘇媽媽湯圓是一個有平價、路邊攤、排隊店的其他小吃，網友認為值得推薦的有：紫米湯圓,芝麻湯圓,肉燥麵、花生湯圓。', '23.966766', '120.962827', '049-2988915', '台灣南投縣埔里鎮中山路三段118號', 'http://leiioo3.pixnet.net/blog/post/96662825-%E3%80%90%E9%A3%9F%E3%80%91%E5%8D%97%E6%8A%95%E5%9F%94%E9%87%8C%E3%80%82%E8%98%87%E5%AA%BD%E5%AA%BD%E6%B9%AF%E5%9C%93', 'http://leiioo3.pixnet.net/blog/post/96662825-%E3%80%90%E9%A3%9F%E3%80%91%E5%8D%97%E6%8A%95%E5%9F%94%E9%87%8C%E3%80%82%E8%98%87%E5%AA%BD%E5%AA%BD%E6%B9%AF%E5%9C%93', 'http://leiioo3.pixnet.net/blog/post/96662825-%E3%80%90%E9%A3%9F%E3%80%91%E5%8D%97%E6%8A%95%E5%9F%94%E9%87%8C%E3%80%82%E8%98%87%E5%AA%BD%E5%AA%BD%E6%B9%AF%E5%9C%93'),
(10, '九張桌子', '九張桌子是一個有吃吃喝喝、免服務費、平價的義式料理，網友認為值得推薦的有：番茄牛肉起司義大利麵、咖哩雞肉義大利麵。', '23.969853', '120.971400', '049-2902323', '南投縣埔里鎮北安路78號', 'http://viablog.okmall.tw/blogview.php?blogid=489', 'http://viablog.okmall.tw/blogview.php?blogid=489', 'http://viablog.okmall.tw/blogview.php?blogid=489'),
(11, '牛相觸庭園餐坊', '牛相觸位於中潭公路愛蘭橋旁，隔著南港溪，與埔里最古老的台地烏牛欄台地遙遙相望，古早人覺得這兩座台地，狀似「兩牛相觸」，於是「牛相觸」這個饒富農村趣味的地名就產生了！', '23.963232', '120.946292', '049-2912775', '台灣南投縣埔里鎮桃南路31號', 'http://www.nsc-rose.com.tw/', 'http://www.nsc-rose.com.tw/', 'http://www.nsc-rose.com.tw/'),
(12, '胡國雄古早麵', '胡國雄古早麵是一個有古早味、單點式、小吃的麵食點心，網友認為值得推薦的有：切仔麵、燙青菜、板條、過貓、粿仔條。', '23.967491', '120.963721', '049-2990586', '南投縣埔里鎮仁愛路3號(圓環附近) ', 'http://blog.yam.com/t0415/article/71562821', 'http://blog.yam.com/t0415/article/71562821', 'http://blog.yam.com/t0415/article/71562821'),
(13, '沃克泰泰式料理', '沃克泰泰式料理是一個有吃吃喝喝、平價、免服務費的泰式料理，網友認為值得推薦的有：打拋肉、青木瓜、椰汁雞。', '23.968915', '120.946367', '049-2918569', '南投縣埔里鎮梅村路22號', 'https://zh-tw.facebook.com/pages/%E6%B2%83%E5%85%8B%E6%B3%B0%E6%B3%B0%E5%BC%8F%E9%A4%90%E5%BB%B3-Worker-Thai/112180055498811', 'https://zh-tw.facebook.com/pages/%E6%B2%83%E5%85%8B%E6%B3%B0%E6%B3%B0%E5%BC%8F%E9%A4%90%E5%BB%B3-Worker-Thai/112180055498811', 'https://zh-tw.facebook.com/pages/%E6%B2%83%E5%85%8B%E6%B3%B0%E6%B3%B0%E5%BC%8F%E9%A4%90%E5%BB%B3-Worker-Thai/112180055498811'),
(14, '森心咖啡館', '森心咖啡館是一個有情侶約會、吃吃喝喝、家庭聚會的景觀餐廳，網友認為值得推薦的有：焗烤奶油海鮮義大利貝殼麵。', '23.973028', '120.975600', '049-2983278', '台灣南投縣埔里鎮信義路121號', 'http://springcake.tw/index-3.html', 'http://springcake.tw/index-3.html', 'http://springcake.tw/index-3.html'),
(16, '鹿港天后宮', '鹿港天后宮', '24.059240', '120.431446', '04-7779899', '  505彰化縣鹿港鎮中山路414號 ', 'http://www.lugangmazu.org/', 'http://www.lugangmazu.org/', 'http://www.lugangmazu.org/');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
