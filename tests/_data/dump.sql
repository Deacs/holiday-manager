# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.6.19-1~exp1ubuntu2)
# Database: homestead
# Generation Time: 2015-05-11 11:14:37 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table departments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `departments`;

CREATE TABLE `departments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `location_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;

INSERT INTO `departments` (`id`, `name`, `location_id`, `created_at`, `updated_at`)
VALUES
	(1,'Engineering',1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(2,'Marketing',1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(3,'Investments',1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(4,'Product',1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(5,'Marketing',1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(6,'Completions',1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(7,'Finance',1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(8,'Legal',1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(9,'Bonds',2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(10,'Business Development',2,'0000-00-00 00:00:00','0000-00-00 00:00:00');

/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table holiday_requests
# ------------------------------------------------------------

DROP TABLE IF EXISTS `holiday_requests`;

CREATE TABLE `holiday_requests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `request_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status_id` int(11) NOT NULL DEFAULT '1',
  `approved_by` int(11) DEFAULT NULL,
  `declined_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `holiday_requests_user_id_index` (`user_id`),
  KEY `holiday_requests_status_id_index` (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table locations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `locations`;

CREATE TABLE `locations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;

INSERT INTO `locations` (`id`, `name`, `address`, `telephone`, `created_at`, `updated_at`)
VALUES
	(1,'Exeter','Innovation Centre, Rennes Drive, Exeter, EX4 4RN','01392 241319','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(2,'London','Dean Street, Soho','0181 1234567','0000-00-00 00:00:00','0000-00-00 00:00:00');

/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`migration`, `batch`)
VALUES
	('2014_10_12_100000_create_password_resets_table',1),
	('2015_03_25_040005_create_locations_table',1),
	('2015_03_25_040010_create_departments_table',1),
	('2015_03_25_040020_create_users_table',1),
	('2015_03_26_043315_create_holiday_requests_table',1),
	('2015_03_26_044144_create_status_table',1);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table password_resets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table statuses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `statuses`;

CREATE TABLE `statuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `statuses` WRITE;
/*!40000 ALTER TABLE `statuses` DISABLE KEYS */;

INSERT INTO `statuses` (`id`, `title`, `created_at`, `updated_at`)
VALUES
	(1,'Pending','2015-03-25 21:44:12','2015-03-25 21:44:12'),
	(2,'Approved','2015-03-25 21:44:13','2015-03-25 21:44:13'),
	(3,'Declined','2015-03-25 21:44:14','2015-03-25 21:44:14'),
	(4,'Active','2015-03-25 21:44:15','2015-03-25 21:44:15'),
	(5,'Cancelled','2015-03-25 20:54:12','2015-03-25 20:54:12'),
	(6,'Completed','2015-03-26 21:56:42','2015-03-26 21:56:42');

/*!40000 ALTER TABLE `statuses` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `department_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `lead` tinyint(1) NOT NULL DEFAULT '0',
  `super_user` tinyint(1) NOT NULL DEFAULT '0',
  `annual_holiday_allowance` int(11) NOT NULL DEFAULT '25',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_department_id_index` (`department_id`),
  KEY `users_location_id_index` (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `telephone`, `department_id`, `location_id`, `lead`, `super_user`, `annual_holiday_allowance`, `created_at`, `updated_at`)
VALUES
	(1,'David','Ives','david@crowdcube.com','password','01392 654321',1,1,1,0,25,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(2,'Rob','Crowe','rob@crowdcube.com','password',NULL,1,1,0,0,25,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(3,'Ben','Christine','ben@crowdcube.com','password',NULL,1,1,0,0,25,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(4,'Luke','Lang','luke@crowdcube.com','password','01392 321456',2,1,1,0,25,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(5,'James','Roberts','james.roberts@crowdcube.com','password',NULL,2,1,0,0,25,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(6,'Becca','Lewis','becca.lewis@crowdcube.com','password',NULL,2,1,0,0,25,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(7,'Bill','Simmons','bill@crowdcube.com','password',NULL,7,1,1,0,25,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(8,'Rebecca','Hand','rebecca@crowdcube.com','password',NULL,7,1,0,0,25,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(9,'Matt','Cooper','matt.cooper@crowdcube.com','password','020 12345678',10,2,1,0,25,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(10,'Tom','Leigh','tom.leigh@crowdcube.com','password',NULL,10,2,0,0,25,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(11,'Paul','Massey','paul.massey@crowdcube.com','password','01392 123456',1,1,1,0,25,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(12,'Dean','Mayer','dean.mayer@crowdcube.com','password',NULL,9,2,1,0,25,'0000-00-00 00:00:00','0000-00-00 00:00:00');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
