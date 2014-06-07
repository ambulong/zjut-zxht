-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014-06-07 21:00:21
-- 服务器版本: 5.5.37-MariaDB
-- PHP 版本: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `jhzx`
--

-- --------------------------------------------------------

--
-- 表的结构 `jh_items_29`
--

CREATE TABLE IF NOT EXISTS `jh_items_29` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_bin NOT NULL,
  `uid` varchar(200) COLLATE utf8_bin NOT NULL,
  `desc` text COLLATE utf8_bin NOT NULL,
  `ei` text COLLATE utf8_bin NOT NULL,
  `site` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `sex` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=41 ;

--
-- 转存表中的数据 `jh_items_29`
--

INSERT INTO `jh_items_29` (`id`, `name`, `uid`, `desc`, `ei`, `site`, `sex`) VALUES
(1, 'r', '123', 'xs', '{"ip":"127.0.0.1","time":"2014-06-07 22:34:37","HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":null,"HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64; rv:29.0) Gecko\\/20100101 Firefox\\/29.0"}', 'asdf', 'male'),
(2, 'r', '123', 'xs', '{"ip":"127.0.0.1","time":"2014-06-07 22:35:11","HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":null,"HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64; rv:29.0) Gecko\\/20100101 Firefox\\/29.0"}', 'asdf', 'male'),
(3, 'eee', '44234234', 'werwerwe', '{"ip":"127.0.0.1","time":"2014-06-07 22:48:24","HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":null,"HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64; rv:29.0) Gecko\\/20100101 Firefox\\/29.0"}', 'werwr', 'male');

-- --------------------------------------------------------

--
-- 表的结构 `jh_items_30`
--

CREATE TABLE IF NOT EXISTS `jh_items_30` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ei` text COLLATE utf8_bin NOT NULL,
  `we` varchar(200) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `jh_params`
--

CREATE TABLE IF NOT EXISTS `jh_params` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `proj_id` int(11) NOT NULL,
  `default_show` int(11) NOT NULL,
  `jindex` int(11) DEFAULT '0',
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `label` varchar(100) COLLATE utf8_bin NOT NULL,
  `method` varchar(10) COLLATE utf8_bin NOT NULL,
  `type` varchar(20) COLLATE utf8_bin NOT NULL,
  `jcase` text COLLATE utf8_bin NOT NULL,
  `allow_null` varchar(2) COLLATE utf8_bin NOT NULL DEFAULT 'n',
  `regex` varchar(200) COLLATE utf8_bin NOT NULL,
  `comment` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=55 ;

--
-- 转存表中的数据 `jh_params`
--

INSERT INTO `jh_params` (`id`, `proj_id`, `default_show`, `jindex`, `name`, `label`, `method`, `type`, `jcase`, `allow_null`, `regex`, `comment`) VALUES
(38, 29, 1, 1, 'name', '姓名', 'post', 'text', '', 'n', '', ''),
(40, 29, 1, 0, 'uid', '学号', 'post', 'text', '', 'n', '', ''),
(42, 29, 1, 4, 'desc', '简介', 'post', 'textarea', '', 'n', '', ''),
(46, 29, 1, 3, 'site', '个人网站', 'request', 'text', '', 'y', '', ''),
(53, 29, 1, 2, 'sex', '性别', 'post', 'radio', '{"male":"男","female":"女"}', 'n', '^(male|female)$', ''),
(54, 30, 0, 0, 'we', 'we', 'post', 'text', '', 'n', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `jh_projs`
--

CREATE TABLE IF NOT EXISTS `jh_projs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `users` text COLLATE utf8_bin NOT NULL COMMENT '用户ID的json',
  `desc` text COLLATE utf8_bin NOT NULL,
  `perpage` int(11) NOT NULL,
  `reurl` text COLLATE utf8_bin NOT NULL,
  `errurl` text COLLATE utf8_bin NOT NULL,
  `recaptcha_status` int(11) NOT NULL DEFAULT '0',
  `recaptcha_pubkey` text COLLATE utf8_bin NOT NULL,
  `recaptcha_privkey` text COLLATE utf8_bin NOT NULL,
  `mail_status` int(11) NOT NULL DEFAULT '0',
  `mails` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=31 ;

--
-- 转存表中的数据 `jh_projs`
--

INSERT INTO `jh_projs` (`id`, `name`, `status`, `users`, `desc`, `perpage`, `reurl`, `errurl`, `recaptcha_status`, `recaptcha_pubkey`, `recaptcha_privkey`, `mail_status`, `mails`) VALUES
(29, '测试', 1, '[5]', 'test', 0, 'http://localhost/ht/success', 'http://localhost/ht/error', 0, '', '', 1, 'ambulongtest@163.com'),
(30, 'r', 0, '', 'r', 23, 'http://localhost/ht/success', 'http://localhost/ht/error', 0, '', '', 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `jh_regex`
--

CREATE TABLE IF NOT EXISTS `jh_regex` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `text` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `jh_users`
--

CREATE TABLE IF NOT EXISTS `jh_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) COLLATE utf8_bin NOT NULL,
  `password` varchar(200) COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '0.0.0.0',
  `last_time` datetime NOT NULL,
  `role` int(11) NOT NULL DEFAULT '0',
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `jh_users`
--

INSERT INTO `jh_users` (`id`, `username`, `password`, `last_ip`, `last_time`, `role`) VALUES
(1, 'zjut', '$2a$08$QDUSoiUUhiBmgeJdN4CCt..xH.LCrwV3hCOYw3LmMrjchwrDzLwxO', '127.0.0.1', '2014-06-08 00:50:23', 1),
(2, 'test', '$2a$08$pv5CKGu3gmJgGp8QcI4B7.RiL8mlY0ubPBmCXMpQrity6bfUFo1Fe', '127.0.0.1', '2014-06-01 18:52:16', 0),
(5, 'admin', '$2a$08$/eITKuvCV.db/sPFCIPKpOPI0jE0w3GYtwL.UNf12Ne6zZ4pEhglC', '127.0.0.1', '2014-06-08 00:49:28', 0),
(6, 'werw', '$2a$08$mxT9pZRtT5kWDFTARvptQ.RNfq9gPC7xU/CfPMvxnCYser6pkXTZy', '0.0.0.0', '0000-00-00 00:00:00', 0),
(7, 't2', '$2a$08$yug7jqn7zAtW7uw6ygrbz.90epGJBmfQMAgOKZQawASt4P678JwxK', '0.0.0.0', '0000-00-00 00:00:00', 0),
(8, 't3', '$2a$08$4lAy4EgrslRhqs5V5ZwPQu4okNTPLciWBSnod35xqJQgbV14xtCou', '0.0.0.0', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- 表的结构 `jh_users_log`
--

CREATE TABLE IF NOT EXISTS `jh_users_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `ip` varchar(20) COLLATE utf8_bin NOT NULL,
  `time` datetime NOT NULL,
  `extend` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=46 ;

--
-- 转存表中的数据 `jh_users_log`
--

INSERT INTO `jh_users_log` (`id`, `uid`, `ip`, `time`, `extend`) VALUES
(1, 1, '127.0.0.1', '2014-05-31 22:09:48', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(2, 1, '127.0.0.1', '2014-05-31 22:10:04', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(3, 1, '127.0.0.1', '2014-05-31 22:13:00', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(4, 1, '127.0.0.1', '2014-05-31 22:14:37', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(5, 1, '127.0.0.1', '2014-05-31 22:31:52', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login&err=1","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(6, 1, '127.0.0.1', '2014-05-31 22:35:33', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(7, 1, '127.0.0.1', '2014-05-31 22:37:40', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(8, 1, '127.0.0.1', '2014-05-31 22:37:55', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(9, 1, '127.0.0.1', '2014-05-31 22:41:25', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(10, 1, '127.0.0.1', '2014-05-31 22:42:16', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(11, 1, '127.0.0.1', '2014-05-31 22:44:09', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(12, 1, '127.0.0.1', '2014-05-31 22:45:02', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(13, 1, '127.0.0.1', '2014-05-31 22:45:13', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(14, 1, '127.0.0.1', '2014-05-31 23:13:52', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (<b>compatible;<\\/b> MSIE 10.0; Windows NT 6.2; Trident\\/6.0)"}'),
(15, 1, '127.0.0.1', '2014-05-31 23:19:16', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(16, 1, '127.0.0.1', '2014-05-31 23:22:53', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(17, 1, '127.0.0.1', '2014-05-31 23:25:54', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(18, 1, '127.0.0.1', '2014-05-31 23:33:07', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(19, 1, '127.0.0.1', '2014-05-31 23:37:58', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login&err=1","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(20, 1, '127.0.0.1', '2014-06-01 17:59:46', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login&err=1","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(21, 1, '127.0.0.1', '2014-06-01 18:20:22', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login&err=1","HTTP_USER_AGENT":"Mozilla\\/5.0 (<b>compatible;<\\/b> MSIE 10.0; Windows NT 6.2; Trident\\/6.0)"}'),
(22, 1, '127.0.0.1', '2014-06-01 18:22:02', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(23, 2, '127.0.0.1', '2014-06-01 18:45:47', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(24, 2, '127.0.0.1', '2014-06-01 18:52:16', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login&err=1","HTTP_USER_AGENT":"Mozilla\\/5.0 (<b>compatible;<\\/b> MSIE 10.0; Windows NT 6.2; Trident\\/6.0)"}'),
(25, 1, '127.0.0.1', '2014-06-01 18:52:39', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(26, 5, '127.0.0.1', '2014-06-01 20:31:09', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login&err=1","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64; rv:29.0) Gecko\\/20100101 Firefox\\/29.0"}'),
(27, 5, '127.0.0.1', '2014-06-01 20:31:35', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64; rv:29.0) Gecko\\/20100101 Firefox\\/29.0"}'),
(28, 5, '127.0.0.1', '2014-06-01 20:32:07', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login&err=1","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64; rv:29.0) Gecko\\/20100101 Firefox\\/29.0"}'),
(29, 5, '127.0.0.1', '2014-06-02 02:57:52', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login&err=1","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(30, 1, '127.0.0.1', '2014-06-02 02:58:04', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(31, 5, '127.0.0.1', '2014-06-03 21:37:50', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(32, 1, '127.0.0.1', '2014-06-03 21:43:28', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(33, 5, '127.0.0.1', '2014-06-04 12:49:20', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(34, 1, '127.0.0.1', '2014-06-04 12:49:51', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(35, 1, '127.0.0.1', '2014-06-05 18:22:40', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(36, 5, '127.0.0.1', '2014-06-06 00:07:06', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (<b>compatible;<\\/b> MSIE 10.0; Windows NT 6.2; Trident\\/6.0)"}'),
(37, 1, '127.0.0.1', '2014-06-06 00:12:47', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(38, 1, '127.0.0.1', '2014-06-06 18:16:22', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(39, 1, '127.0.0.1', '2014-06-07 14:41:40', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login&err=1","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(40, 5, '127.0.0.1', '2014-06-07 21:04:39', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(41, 1, '127.0.0.1', '2014-06-07 21:04:47', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(42, 5, '127.0.0.1', '2014-06-07 21:04:58', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(43, 1, '127.0.0.1', '2014-06-07 21:06:39', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(44, 5, '127.0.0.1', '2014-06-08 00:49:29', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}'),
(45, 1, '127.0.0.1', '2014-06-08 00:50:24', '{"HTTP_ACCEPT":"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/webp,*\\/*;q=0.8","HTTP_HOST":"localhost","HTTP_REFERER":"http:\\/\\/localhost\\/ht\\/index.php?action=show&m=login","HTTP_USER_AGENT":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
