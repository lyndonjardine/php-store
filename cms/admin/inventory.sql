CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(72) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;


CREATE TABLE IF NOT EXISTS `items` (
  `category` int(11) NOT NULL,
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(72) NOT NULL,
  `description` varchar(128) NOT NULL,
  `price` varchar(24) NOT NULL,
  `quantity` varchar(16) NOT NULL,
  `sku` varchar(32) NOT NULL,
  `picture` varchar(128) NOT NULL,
  PRIMARY KEY (`item_id`),
  KEY `category` (`category`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;
