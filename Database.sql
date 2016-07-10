-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Anamakine: localhost
-- Üretim Zamanı: 10 Tem 2016, 17:06:28
-- Sunucu sürümü: 5.6.17
-- PHP Sürümü: 5.5.12

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Veritabanı: `prophecy`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `CategoryId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CategoryName` varchar(200) NOT NULL,
  `Sub` int(11) NOT NULL,
  PRIMARY KEY (`CategoryId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `CommentId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `PostId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `Comment` text NOT NULL,
  `Sub` int(11) NOT NULL,
  `OtherUserInfo` text NOT NULL,
  PRIMARY KEY (`CommentId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `messages_messages`
--

CREATE TABLE IF NOT EXISTS `messages_messages` (
  `MessageId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `SubjectId` int(11) NOT NULL,
  `Message` text NOT NULL,
  `SenderId` int(11) NOT NULL,
  `ReceiverId` int(11) NOT NULL,
  `SenderIsDeleted` tinyint(1) NOT NULL,
  `ReceiverIsDeleted` tinyint(1) NOT NULL,
  `Date` varchar(20) NOT NULL,
  `Hour` varchar(20) NOT NULL,
  `Time` int(11) NOT NULL,
  `Info` text NOT NULL,
  PRIMARY KEY (`MessageId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `messages_subjects`
--

CREATE TABLE IF NOT EXISTS `messages_subjects` (
  `SubjectId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Subject` varchar(100) NOT NULL,
  `SenderId` int(11) NOT NULL,
  `ReceiverId` int(11) NOT NULL,
  `SenderRead` tinyint(1) NOT NULL,
  `ReceiverRead` tinyint(1) NOT NULL,
  `LastSenderId` int(11) NOT NULL,
  `SenderIsDeleted` tinyint(1) NOT NULL,
  `ReceiverIsDeleted` tinyint(1) NOT NULL,
  `Date` varchar(200) NOT NULL,
  `Info` text NOT NULL,
  `SenderTime` int(11) NOT NULL,
  `ReceiverTime` int(11) NOT NULL,
  PRIMARY KEY (`SubjectId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `PostId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `PostUserId` int(11) NOT NULL,
  `Link` varchar(500) NOT NULL,
  `PostTitle` varchar(200) NOT NULL,
  `Post` text NOT NULL,
  `PostDate` varchar(20) NOT NULL,
  `PostTime` int(11) NOT NULL,
  `CategoryId` int(11) NOT NULL,
  PRIMARY KEY (`PostId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `post_images`
--

CREATE TABLE IF NOT EXISTS `post_images` (
  `ImageId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `PostId` int(11) NOT NULL,
  `ImageName` varchar(100) NOT NULL,
  `ImageType` varchar(25) NOT NULL,
  PRIMARY KEY (`ImageId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `post_info`
--

CREATE TABLE IF NOT EXISTS `post_info` (
  `PostInfoId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `PostId` int(11) NOT NULL,
  `SubScript` varchar(100) NOT NULL,
  `Value` varchar(200) NOT NULL,
  PRIMARY KEY (`PostInfoId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `post_tags`
--

CREATE TABLE IF NOT EXISTS `post_tags` (
  `TagId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `PostId` int(11) NOT NULL,
  `Tag` varchar(50) NOT NULL,
  `Time` int(11) NOT NULL,
  PRIMARY KEY (`TagId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `UserId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `UserName` varchar(50) NOT NULL,
  `Password` varchar(32) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `ActivationCode` varchar(20) NOT NULL,
  `IsActivated` tinyint(1) NOT NULL,
  `IsBanned` tinyint(1) NOT NULL,
  `IsFreeze` tinyint(1) NOT NULL,
  PRIMARY KEY (`UserId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user_info`
--

CREATE TABLE IF NOT EXISTS `user_info` (
  `UserInfoId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `UserId` int(11) NOT NULL,
  `SubScript` varchar(100) NOT NULL,
  `Value` varchar(200) NOT NULL,
  PRIMARY KEY (`UserInfoId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
