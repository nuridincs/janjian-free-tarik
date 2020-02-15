# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.27)
# Database: db_janjian_free_tarik
# Generation Time: 2020-02-15 15:03:40 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table app_account
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_account`;

CREATE TABLE `app_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `app_account` WRITE;
/*!40000 ALTER TABLE `app_account` DISABLE KEYS */;

INSERT INTO `app_account` (`id`, `password`)
VALUES
	(1,'admin123'),
	(2,'user123');

/*!40000 ALTER TABLE `app_account` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table app_tarik
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_tarik`;

CREATE TABLE `app_tarik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_time` int(11) DEFAULT NULL,
  `name_line` varchar(50) DEFAULT NULL,
  `date_label` varchar(20) DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `time` (`id_time`),
  CONSTRAINT `time` FOREIGN KEY (`id_time`) REFERENCES `app_time` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `app_tarik` WRITE;
/*!40000 ALTER TABLE `app_tarik` DISABLE KEYS */;

INSERT INTO `app_tarik` (`id`, `id_time`, `name_line`, `date_label`, `date`)
VALUES
	(11,14,'ncs','today','2020-02-14'),
	(12,22,'ncs 13','today','2020-02-15'),
	(13,1,'zibran','tomorrow','2020-02-16');

/*!40000 ALTER TABLE `app_tarik` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table app_time
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_time`;

CREATE TABLE `app_time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` char(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `app_time` WRITE;
/*!40000 ALTER TABLE `app_time` DISABLE KEYS */;

INSERT INTO `app_time` (`id`, `label`)
VALUES
	(1,'00.00'),
	(2,'01.00'),
	(3,'02.00'),
	(4,'03.00'),
	(5,'04.00'),
	(6,'05.00'),
	(7,'06.00'),
	(8,'07.00'),
	(9,'08.00'),
	(10,'09.00'),
	(11,'10.00'),
	(12,'11.00'),
	(13,'12.00'),
	(14,'13.00'),
	(15,'14.00'),
	(16,'15.00'),
	(17,'16.00'),
	(18,'17.00'),
	(19,'18.00'),
	(20,'19.00'),
	(21,'20.00'),
	(22,'21.00'),
	(23,'22.00'),
	(24,'23.00');

/*!40000 ALTER TABLE `app_time` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
