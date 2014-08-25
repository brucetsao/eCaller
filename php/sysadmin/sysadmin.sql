-- phpMyAdmin SQL Dump
-- version 3.3.5
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 建立日期: Jul 18, 2014, 09:45 AM
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
-- 資料表格式： `sysadmin`
--

CREATE TABLE IF NOT EXISTS `sysadmin` (
  `username` varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `passwd` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `userfullname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `userlevel` int(5) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 列出以下資料庫的數據： `sysadmin`
--

INSERT INTO `sysadmin` (`username`, `passwd`, `userfullname`, `userlevel`) VALUES
('admin', '1234', '老師', 9);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
