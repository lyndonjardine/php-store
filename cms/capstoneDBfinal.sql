# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.23)
# Database: capstone
# Generation Time: 2019-04-15 00:28:13 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table admin_info
# ------------------------------------------------------------

DROP TABLE IF EXISTS `admin_info`;

CREATE TABLE `admin_info` (
  `admin_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `admin_info` WRITE;
/*!40000 ALTER TABLE `admin_info` DISABLE KEYS */;

INSERT INTO `admin_info` (`admin_id`, `username`, `password`, `active`)
VALUES
	(1,'username','secret',1),
	(2,'lyndon','password',1);

/*!40000 ALTER TABLE `admin_info` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cart
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cart`;

CREATE TABLE `cart` (
  `cart_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`cart_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(72) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;

INSERT INTO `categories` (`category_id`, `category`)
VALUES
	(16,'Asus'),
	(15,'Dell'),
	(14,'Apple'),
	(17,'Test');

/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table current_sessions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `current_sessions`;

CREATE TABLE `current_sessions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sessionID` text NOT NULL,
  `admin_id` int(11) NOT NULL,
  `login_time` int(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table items
# ------------------------------------------------------------

DROP TABLE IF EXISTS `items`;

CREATE TABLE `items` (
  `category` int(11) NOT NULL,
  `item_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(9999) NOT NULL DEFAULT '',
  `price` double NOT NULL,
  `quantity` varchar(16) NOT NULL,
  `sku` varchar(32) NOT NULL,
  `picture` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`item_id`),
  KEY `category` (`category`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;

INSERT INTO `items` (`category`, `item_id`, `title`, `description`, `price`, `quantity`, `sku`, `picture`)
VALUES
	(14,31,'Macbook Pro','<p>This is a <em>mac book pro</em></p>',1499.99,'993','1235243','macbookpro.jpeg'),
	(16,32,'Asus Laptop','<p>This is a <em>asus laptop</em></p>',999.99,'966','8716813','asusVivobook15.png'),
	(15,34,'Dell 15.6 Laptop','<p>This is a dell laptop</p>',799.99,'29','123556','dellInspiron.jpg');

/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table items_sold
# ------------------------------------------------------------

DROP TABLE IF EXISTS `items_sold`;

CREATE TABLE `items_sold` (
  `sell_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `sell_price` int(11) NOT NULL,
  `sell_quantity` int(11) NOT NULL,
  PRIMARY KEY (`sell_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `items_sold` WRITE;
/*!40000 ALTER TABLE `items_sold` DISABLE KEYS */;

INSERT INTO `items_sold` (`sell_id`, `item_id`, `order_id`, `sell_price`, `sell_quantity`)
VALUES
	(17,31,16,1500,3),
	(18,32,16,1000,10),
	(19,31,17,1500,1),
	(20,31,18,1500,1),
	(21,32,18,1000,1),
	(22,32,19,1000,19);

/*!40000 ALTER TABLE `items_sold` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table order_info
# ------------------------------------------------------------

DROP TABLE IF EXISTS `order_info`;

CREATE TABLE `order_info` (
  `order_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `firstName` varchar(30) NOT NULL DEFAULT '',
  `lastName` varchar(30) NOT NULL DEFAULT '',
  `phone` varchar(10) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `userID` int(11) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `order_info` WRITE;
/*!40000 ALTER TABLE `order_info` DISABLE KEYS */;

INSERT INTO `order_info` (`order_id`, `firstName`, `lastName`, `phone`, `email`, `userID`)
VALUES
	(16,'Lyndon','Jardine','9023221325','w0287543@nscc.ca',12),
	(17,'Lyndon','Jardine','902123456','w0287543@nscc.ca',12),
	(18,'asdf','asdf','asdf','asdf@asdf.com',12),
	(19,'asdf','jardine','zxcv','lyndon.jardine@gmail.com',12);

/*!40000 ALTER TABLE `order_info` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sessionID` varchar(255) NOT NULL DEFAULT '',
  `user_ip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `sessionID`, `user_ip`)
VALUES
	(10,'59t07ro853vv55pgqi25lmotai','::1'),
	(11,'mia931t96ehdnt30et1mv21k6i','::1'),
	(12,'qgkjo5bhgb0b4dmrj6vuggnld5','::1');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
