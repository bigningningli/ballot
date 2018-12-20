# Host: localhost  (Version: 5.5.53-log)
# Date: 2018-12-19 17:55:44
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "login"
#

DROP TABLE IF EXISTS `login`;
CREATE TABLE `login` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(16) DEFAULT NULL,
  `password` varchar(225) DEFAULT NULL,
  `QQ` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

#
# Data for table "login"
#

INSERT INTO `login` VALUES (9,'root','e10adc3949ba59abbe56e057f20f883e','1102354384'),(10,'admin','e10adc3949ba59abbe56e057f20f883e','3020448868'),(11,'123123','4297f44b13955235245b2497399d7a93','11111111'),(12,'11111','96e79218965eb72c92a549dd5a330112','11111111'),(13,'1c11','96e79218965eb72c92a549dd5a330112','1233444412');

#
# Structure for table "message"
#

DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `stime` timestamp NULL DEFAULT NULL,
  `etime` timestamp NULL DEFAULT NULL,
  `murl` varchar(255) DEFAULT NULL,
  `images` varchar(255) DEFAULT 'default.jpg',
  `builder` varchar(255) DEFAULT NULL,
  `enroll` int(1) DEFAULT NULL,
  `apply` text,
  `applynum` int(11) DEFAULT '0',
  `join` text,
  `joinnum` int(11) DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Data for table "message"
#

INSERT INTO `message` VALUES (2,'t1','t1content','2018-12-19 12:12:00','2018-12-26 12:12:00','https://y.qq.com/portal/player.html','5c19c69715aa2.jpg','root',1,'',0,'123123,11111,1c11,',3),(3,'123321','123','2018-12-19 17:18:00','2018-12-26 17:18:00','','default.jpg','admin',0,NULL,0,NULL,0);

#
# Structure for table "options"
#

DROP TABLE IF EXISTS `options`;
CREATE TABLE `options` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `mid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `participant` text,
  `participantnum` int(11) DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

#
# Data for table "options"
#

INSERT INTO `options` VALUES (4,2,'o1',',admin,',2),(5,2,'o2','11111,',1),(6,2,'o3',NULL,0),(7,3,'111',NULL,0),(8,3,'222',NULL,0),(9,3,'333','root,',1);
