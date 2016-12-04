-- 创建数据库
CREATE DATABASE IF NOT EXISTS `shopImooc`;
-- 打开数据库
USER `shopImooc`;
-- 管理员表
DROP TABLE IF EXISTS `imooc_admin`;
CREATE TABLE `imooc_admin`(
	`id` tinyint unsigned auto_increment key,
	`username` varchar(20) not null unique,
	`password` char(32) not null,
	`email` varchar(50) not null
);

-- 分类表
DROP TABLE IF EXISTS `imooc_cate`;
CREATE TABLE `imooc_cate`(
	`id` smallint unsigned auto_increment key,
	`cName` varchar(50) unique
);

-- 商品表
DROP TABLE IF EXISTS `imooc_pro`;
CREATE TABLE `imooc_pro` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pName` varchar(255) NOT NULL,
  `pSn` varchar(50) NOT NULL,
  `pNum` int(10) unsigned DEFAULT '1',
  `mPrice` decimal(10,2) NOT NULL,
  `iPrice` decimal(10,2) NOT NULL,
  `pDesc` text,
  `pImg` varchar(50) not null,
  `pubTime` int(10) unsigned NOT NULL,
  `isShow` tinyint(1) DEFAULT '1',
  `isHot` tinyint(1) DEFAULT '0',
  `cId` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pName` (`pName`),
  UNIQUE KEY `pName_2` (`pName`)
);

-- 用户表
DROP TABLE IF EXISTS `imooc_user`;
CREATE TABLE `imooc_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` char(32) NOT NULL,
  `sex` enum('男','女','保密') NOT NULL DEFAULT '保密',
  `email` varchar(50) NOT NULL,
  `face` varchar(50) NOT NULL,
  `regTime` int(10) unsigned NOT NULL,
  `activeFlag` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
);

-- 相册表
DROP TABLE IF EXISTS `imooc_album`;
CREATE TABLE `imooc_album` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL,
  `albumPath` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
);











