-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: psubp_db
-- ------------------------------------------------------
-- Server version	10.4.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `academic_calendar`
--

DROP TABLE IF EXISTS `academic_calendar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `academic_calendar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activities` varchar(255) NOT NULL,
  `first_semester_start` date NOT NULL,
  `first_semester_end` date NOT NULL,
  `second_semester_start` date NOT NULL,
  `second_semester_end` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `academic_calendar`
--

LOCK TABLES `academic_calendar` WRITE;
/*!40000 ALTER TABLE `academic_calendar` DISABLE KEYS */;
INSERT INTO `academic_calendar` VALUES (7,'Enrollment','2023-08-30','0000-00-00','0000-00-00','0000-00-00');
/*!40000 ALTER TABLE `academic_calendar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `account_users`
--

DROP TABLE IF EXISTS `account_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `account_id` (`account_id`),
  CONSTRAINT `account_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `account_users_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`account_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_users`
--

LOCK TABLES `account_users` WRITE;
/*!40000 ALTER TABLE `account_users` DISABLE KEYS */;
INSERT INTO `account_users` VALUES (33,56,2),(34,56,7),(35,57,2),(37,59,4),(38,62,9);
/*!40000 ALTER TABLE `account_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `account_id` int(11) NOT NULL,
  `account_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (0,'Admission Office'),(2,'BSIT'),(3,'BSCRIM'),(4,'BSED'),(5,'BEED'),(6,'BSBA'),(7,'BSAGRI'),(8,'Student Government'),(9,'PSUBP');
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `active_sessions`
--

DROP TABLE IF EXISTS `active_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `active_sessions` (
  `session_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `device_info` varchar(255) NOT NULL,
  `last_activity` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `login_time` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`session_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `active_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5520237 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `active_sessions`
--

LOCK TABLES `active_sessions` WRITE;
/*!40000 ALTER TABLE `active_sessions` DISABLE KEYS */;
INSERT INTO `active_sessions` VALUES (4,56,'','2024-11-18 00:48:02','2024-11-18 00:48:02'),(7,56,'','2024-11-19 19:15:33','2024-11-19 19:15:33'),(9,62,'','2024-11-20 04:17:18','2024-11-20 04:17:18'),(5520193,56,'','2024-11-18 00:50:19','2024-11-18 00:50:19'),(5520194,56,'','2024-11-18 00:57:51','2024-11-18 00:57:51'),(5520195,56,'','2024-11-18 01:00:37','2024-11-18 01:00:37'),(5520196,56,'','2024-11-18 01:10:48','2024-11-18 01:10:48'),(5520197,56,'','2024-11-18 01:11:59','2024-11-18 01:11:59'),(5520198,56,'','2024-11-18 01:12:52','2024-11-18 01:12:52'),(5520199,56,'','2024-11-18 01:14:37','2024-11-18 01:14:37'),(5520200,56,'','2024-11-18 01:17:45','2024-11-18 01:17:45'),(5520201,56,'','2024-11-18 01:18:54','2024-11-18 01:18:54'),(5520202,62,'','2024-11-18 01:22:44','2024-11-18 01:22:44'),(5520203,56,'','2024-11-18 03:02:25','2024-11-18 03:02:25'),(5520204,56,'','2024-11-18 03:09:04','2024-11-18 03:09:04'),(5520205,56,'','2024-11-18 03:30:45','2024-11-18 03:30:45'),(5520206,56,'','2024-11-18 03:36:38','2024-11-18 03:36:38'),(5520207,56,'','2024-11-18 03:40:01','2024-11-18 03:40:01'),(5520208,56,'','2024-11-18 03:41:54','2024-11-18 03:41:54'),(5520209,62,'','2024-11-19 13:32:04','2024-11-19 13:32:04'),(5520210,56,'','2024-11-19 15:31:33','2024-11-19 15:31:33'),(5520211,56,'','2024-11-19 18:07:45','2024-11-19 18:07:45'),(5520212,62,'','2024-11-19 18:21:08','2024-11-19 18:21:08'),(5520213,56,'','2024-11-19 18:51:49','2024-11-19 18:51:49'),(5520214,56,'','2024-11-19 18:53:46','2024-11-19 18:53:46'),(5520215,56,'','2024-11-19 19:00:41','2024-11-19 19:00:41'),(5520216,56,'','2024-11-19 19:23:38','2024-11-19 19:23:38'),(5520217,56,'','2024-11-19 19:32:12','2024-11-19 19:32:12'),(5520218,62,'','2024-11-19 19:40:10','2024-11-19 19:40:10'),(5520219,56,'','2024-11-19 19:40:37','2024-11-19 19:40:37'),(5520220,62,'','2024-11-19 19:50:09','2024-11-19 19:50:09'),(5520221,62,'','2024-11-19 19:50:40','2024-11-19 19:50:40'),(5520222,62,'','2024-11-19 19:54:29','2024-11-19 19:54:29'),(5520223,62,'','2024-11-19 19:56:05','2024-11-19 19:56:05'),(5520224,62,'','2024-11-19 19:57:56','2024-11-19 19:57:56'),(5520225,62,'','2024-11-19 19:59:10','2024-11-19 19:59:10'),(5520226,62,'','2024-11-19 19:59:54','2024-11-19 19:59:54'),(5520227,62,'','2024-11-19 20:17:24','2024-11-19 20:17:24'),(5520228,62,'','2024-11-19 20:37:40','2024-11-19 20:37:40'),(5520229,62,'','2024-11-19 23:09:14','2024-11-19 23:09:14'),(5520230,62,'','2024-11-20 04:34:41','2024-11-20 04:34:41'),(5520231,56,'','2024-11-20 04:55:02','2024-11-20 04:55:02'),(5520232,62,'','2024-11-20 04:55:46','2024-11-20 04:55:46'),(5520233,56,'','2024-11-20 04:59:01','2024-11-20 04:59:01'),(5520234,62,'','2024-11-20 05:16:19','2024-11-20 05:16:19'),(5520235,62,'','2024-11-20 13:03:43','2024-11-20 13:03:43'),(5520236,62,'','2024-11-20 13:04:23','2024-11-20 13:04:23');
/*!40000 ALTER TABLE `active_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `account_id` (`account_id`),
  CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `activity_logs_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=494 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
INSERT INTO `activity_logs` VALUES (146,'create_user','User Created a User',57,5,'2024-07-05 07:20:06'),(147,'logout','User logged out Device: Unknown',57,5,'2024-07-05 07:20:27'),(148,'logout','User logged out Device: Unknown',57,5,'2024-07-05 07:20:30'),(149,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-07-05 07:26:33'),(150,'create_post','User Created a Post',62,9,'2024-07-05 13:41:39'),(151,'logout','User logged out Device: Unknown',62,9,'2024-07-05 07:42:24'),(152,'login','mangtomas1234 logged in successfully to BSAGRI',56,7,'2024-07-05 07:42:44'),(153,'create_post','User Created a Post',56,7,'2024-07-05 18:15:46'),(154,'logout','User logged out Device: Unknown',56,7,'2024-07-05 12:54:17'),(155,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-07-05 12:54:22'),(156,'create_post','User Created a Post',62,9,'2024-07-05 18:56:46'),(157,'logout','User logged out Device: Unknown',62,9,'2024-07-05 13:04:28'),(158,'login','mangtomas1234 logged in successfully to BSIT',56,2,'2024-07-05 13:04:37'),(159,'create_post','User Created a Post',56,2,'2024-07-05 19:04:57'),(160,'logout','User logged out Device: Unknown',56,2,'2024-07-05 13:05:27'),(161,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-07-05 13:05:32'),(162,'create_post','User Created a Post',62,9,'2024-07-06 06:05:44'),(163,'create_post','User Created a Post',62,9,'2024-07-06 06:15:58'),(164,'create_post','User Created a Post',62,9,'2024-07-06 09:03:23'),(165,'restore','User Restored A Backup',62,9,'2024-07-07 02:23:19'),(166,'logout','User logged out Device: Unknown',62,9,'2024-07-07 03:09:38'),(167,'login','mangtomas1234 logged in successfully to BSIT',56,2,'2024-07-07 03:09:43'),(168,'logout','User logged out Device: Unknown',56,2,'2024-07-07 03:10:14'),(169,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-07-07 03:10:17'),(170,'logout','User logged out Device: Unknown',62,9,'2024-07-07 03:10:27'),(171,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-07-07 03:10:47'),(172,'logout','User logged out Device: Unknown',62,9,'2024-07-07 03:10:59'),(173,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-07-07 03:11:20'),(174,'logout','User logged out Device: Unknown',62,9,'2024-07-07 03:11:29'),(175,'login','basurero1234 logged in successfully to BSED',59,4,'2024-07-07 03:11:32'),(176,'logout','User logged out Device: Unknown',59,4,'2024-07-07 03:24:58'),(177,'login','mangtomas1234 logged in successfully to BSIT',56,2,'2024-07-07 03:25:02'),(178,'logout','User logged out Device: Unknown',56,2,'2024-07-07 03:29:55'),(179,'login','basurero1234 logged in successfully to BSED',59,4,'2024-07-07 03:29:59'),(180,'create_post','User Created a Post',59,4,'2024-07-07 09:30:32'),(181,'create_post','User Created a Post',59,4,'2024-07-07 10:00:23'),(182,'logout','User logged out Device: Unknown',59,4,'2024-07-07 04:05:36'),(183,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-07-07 04:05:38'),(184,'logout','User logged out Device: Unknown',62,9,'2024-07-07 04:08:27'),(185,'login','mangtomas1234 logged in successfully to BSIT',56,2,'2024-07-07 04:08:32'),(186,'logout','User logged out Device: Unknown',56,2,'2024-07-07 04:08:47'),(187,'login','basurero1234 logged in successfully to BSED',59,4,'2024-07-07 04:08:51'),(188,'logout','User logged out Device: Unknown',59,4,'2024-07-07 04:36:58'),(189,'login','basurero1234 logged in successfully to BSED',59,4,'2024-07-07 04:37:49'),(190,'logout','User logged out Device: Unknown',59,4,'2024-07-07 04:41:43'),(191,'login','basurero1234 logged in successfully to BSED',59,4,'2024-07-07 04:42:12'),(192,'logout','User logged out Device: Unknown',59,4,'2024-07-07 04:47:18'),(193,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-07-07 04:47:21'),(194,'logout','User logged out Device: Unknown',62,9,'2024-07-07 04:48:21'),(195,'login','mangtomas1234 logged in successfully to BSIT',56,2,'2024-07-07 04:48:26'),(196,'logout','User logged out Device: Unknown',56,2,'2024-07-07 04:50:55'),(197,'login','hannah1234 logged in successfully to BEED',57,5,'2024-07-07 04:50:59'),(198,'logout','User logged out Device: Unknown',57,5,'2024-07-07 05:05:24'),(199,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-07-07 05:05:33'),(200,'logout','User logged out Device: Unknown',62,9,'2024-07-07 05:11:38'),(201,'login','hannah1234 logged in successfully to BEED',57,5,'2024-07-07 05:11:47'),(202,'logout','User logged out Device: Unknown',57,5,'2024-07-07 05:11:56'),(203,'login','basurero1234 logged in successfully to BSED',59,4,'2024-07-07 05:12:05'),(204,'logout','User logged out Device: Unknown',59,4,'2024-07-07 05:24:45'),(205,'login','hannah1234 logged in successfully to BEED',57,5,'2024-07-07 05:24:48'),(206,'logout','User logged out Device: Unknown',57,5,'2024-07-07 05:24:53'),(207,'login','mangtomas1234 logged in successfully to BSIT',56,2,'2024-07-07 05:25:00'),(208,'logout','User logged out Device: Unknown',56,2,'2024-07-07 05:31:53'),(209,'login','hannah1234 logged in successfully to BEED',57,5,'2024-07-07 05:32:29'),(210,'logout','User logged out Device: Unknown',57,5,'2024-07-07 05:39:21'),(211,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-07-07 05:39:33'),(212,'backup','User Created A Backup',62,9,'2024-07-07 05:39:48'),(213,'logout','User logged out Device: Unknown',62,9,'2024-07-07 05:52:00'),(214,'login','mangtomas1234 logged in successfully to BSIT',56,2,'2024-07-07 05:52:04'),(215,'logout','User logged out Device: Unknown',56,2,'2024-07-07 05:52:08'),(216,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-07-07 05:52:11'),(217,'logout','User logged out Device: Unknown',62,9,'2024-07-07 05:54:32'),(218,'login','basurero1234 logged in successfully to BSED',59,4,'2024-07-07 05:54:37'),(219,'logout','User logged out Device: Unknown',59,4,'2024-07-07 05:58:39'),(220,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-07-07 05:58:53'),(221,'logout','User logged out Device: Unknown',62,9,'2024-07-07 05:59:57'),(222,'login','mangtomas1234 logged in successfully to BSIT',56,2,'2024-07-07 06:00:04'),(223,'logout','User logged out Device: Unknown',56,2,'2024-07-07 06:58:02'),(224,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-07-07 06:58:05'),(225,'logout','User logged out Device: Unknown',62,9,'2024-07-07 06:58:59'),(226,'login','mangtomas1234 logged in successfully to BSAGRI',56,7,'2024-07-07 06:59:07'),(227,'logout','User logged out Device: Unknown',56,7,'2024-07-07 07:03:50'),(228,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-07-07 07:03:53'),(229,'logout','User logged out Device: Unknown',62,9,'2024-07-07 07:10:16'),(230,'login','mangtomas1234 logged in successfully to BSIT',56,2,'2024-07-07 07:10:23'),(231,'logout','User logged out Device: Unknown',56,2,'2024-07-07 07:12:01'),(232,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-07-07 07:12:10'),(233,'logout','User logged out Device: Unknown',62,9,'2024-07-07 07:12:43'),(234,'login','mangtomas1234 logged in successfully to BSIT',56,2,'2024-07-07 07:12:51'),(235,'logout','User logged out Device: Unknown',56,2,'2024-07-07 07:13:20'),(236,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-07-07 07:13:26'),(237,'logout','User logged out Device: Unknown',62,9,'2024-07-07 07:14:19'),(238,'login','mangtomas1234 logged in successfully to BSAGRI',56,7,'2024-07-07 07:14:41'),(239,'logout','User logged out Device: Unknown',56,7,'2024-07-07 07:16:54'),(240,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-07-07 07:16:59'),(241,'logout','User logged out Device: Unknown',62,9,'2024-07-07 07:17:49'),(242,'login','mangtomas1234 logged in successfully to BSAGRI',56,7,'2024-07-07 07:17:58'),(243,'logout','User logged out Device: Unknown',56,7,'2024-07-07 07:19:53'),(244,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-07-07 07:19:58'),(245,'logout','User logged out Device: Unknown',62,9,'2024-07-07 07:30:50'),(246,'login','mangtomas1234 logged in successfully to BSIT',56,2,'2024-07-07 07:30:56'),(247,'logout','User logged out Device: Unknown',56,2,'2024-07-07 07:36:11'),(248,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-07-07 07:36:14'),(249,'logout','User logged out Device: Unknown',62,9,'2024-07-07 07:42:02'),(250,'login','hannah1234 logged in successfully to BSIT',57,2,'2024-07-07 07:42:05'),(251,'logout','User logged out Device: Unknown',57,2,'2024-07-07 08:24:04'),(252,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-07-07 08:24:12'),(253,'logout','User logged out Device: Unknown',62,9,'2024-07-07 08:35:11'),(254,'login','hannah1234 logged in successfully to BSIT',57,2,'2024-07-07 08:35:22'),(255,'logout','User logged out Device: Unknown',57,2,'2024-07-07 08:39:08'),(256,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-07-07 08:39:11'),(257,'logout','User logged out Device: Unknown',62,9,'2024-07-07 18:13:44'),(258,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-07-07 18:13:48'),(259,'logout','User logged out Device: Unknown',62,9,'2024-07-07 18:14:15'),(260,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-07-07 18:14:25'),(261,'logout','User logged out Device: Unknown',62,9,'2024-07-07 18:14:40'),(262,'login','mangtomas1234 logged in successfully to BSIT',56,2,'2024-07-07 18:14:52'),(263,'logout','User logged out Device: Unknown',56,2,'2024-07-07 18:14:56'),(264,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-07-07 18:15:02'),(265,'logout','User logged out Device: Unknown',62,9,'2024-07-07 18:21:11'),(266,'login','mangtomas1234 logged in successfully to BSAGRI',56,7,'2024-07-07 18:21:16'),(267,'logout','User logged out Device: Unknown',56,7,'2024-07-07 18:21:20'),(268,'login','mangtomas1234 logged in successfully to BSIT',56,2,'2024-07-07 18:21:26'),(269,'logout','User logged out Device: Unknown',56,2,'2024-07-07 18:21:31'),(270,'login','hannah1234 logged in successfully to BSIT',57,2,'2024-07-07 18:21:34'),(271,'create_post','User Created a Post',57,2,'2024-07-08 00:22:47'),(272,'create_post','User Created a Post',57,2,'2024-07-08 00:24:56'),(273,'create_post','User Created a Post',57,2,'2024-07-08 00:36:29'),(274,'logout','User logged out Device: Unknown',57,2,'2024-07-07 18:36:55'),(275,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-07-07 18:36:58'),(276,'logout','User logged out Device: Unknown',62,9,'2024-07-08 00:09:59'),(277,'login','mangtomas1234 logged in successfully to BSAGRI',56,7,'2024-07-08 00:10:08'),(278,'logout','User logged out Device: Unknown',56,7,'2024-07-08 00:32:37'),(279,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-07-08 00:32:45'),(280,'logout','User logged out Device: Unknown',62,9,'2024-07-08 05:51:46'),(281,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-07-08 05:52:30'),(282,'logout','User logged out Device: Unknown',62,9,'2024-07-08 06:04:53'),(283,'login','mangtomas1234 logged in successfully to BSIT',56,2,'2024-07-08 06:04:59'),(284,'create_post','User Created a Post',56,2,'2024-07-08 12:07:56'),(285,'logout','User logged out Device: Unknown',56,2,'2024-07-08 06:08:04'),(286,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-07-08 06:08:09'),(287,'edit_post','User Edited a Post',62,9,'2024-07-08 12:08:42'),(288,'restore','User Restored A Backup',62,9,'2024-07-08 21:48:05'),(289,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-07-22 05:44:30'),(290,'logout','User logged out Device: Unknown',62,9,'2024-07-30 19:10:56'),(291,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-07-30 19:11:29'),(292,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-07-30 19:11:35'),(293,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-07-30 19:11:40'),(294,'create_post','User Created a Post',62,9,'2024-07-31 01:14:21'),(295,'create_post','User Created a Post',62,9,'2024-07-31 01:14:27'),(296,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-07-30 19:18:21'),(297,'logout','User logged out Device: Unknown',62,9,'2024-07-30 19:18:58'),(298,'login','mangtomas1234 logged in successfully to BSAGRI',56,7,'2024-07-30 19:20:25'),(299,'create_post','User Created a Post',56,7,'2024-07-31 01:21:36'),(300,'edit_post','User Edited a Post',56,7,'2024-07-31 01:22:00'),(301,'logout','User logged out Device: Unknown',56,7,'2024-07-30 19:26:31'),(302,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-07-30 19:26:54'),(303,'backup','User Created A Backup',62,9,'2024-07-30 19:28:11'),(304,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-08-11 16:53:51'),(305,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-08-27 08:22:50'),(306,'logout','User logged out Device: Unknown',62,9,'2024-08-27 08:26:02'),(307,'login','mangtomas1234 logged in successfully to BSIT',56,2,'2024-08-27 08:26:17'),(308,'logout','User logged out Device: Unknown',56,2,'2024-08-27 21:40:24'),(309,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-08-27 21:40:28'),(310,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-10-15 13:21:59'),(311,'logout','User logged out Device: Unknown',62,9,'2024-10-15 13:22:28'),(312,'logout','User logged out Device: Unknown',62,9,'2024-10-15 13:22:29'),(313,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-10-15 13:22:40'),(314,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-10-15 14:34:29'),(315,'logout','User logged out Device: Unknown',62,9,'2024-10-15 14:52:45'),(316,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-10-15 14:52:49'),(317,'logout','User logged out Device: Unknown',62,9,'2024-10-15 14:56:57'),(318,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-10-15 14:57:00'),(319,'logout','User logged out Device: Unknown',62,9,'2024-10-15 14:57:04'),(320,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-10-15 15:00:54'),(321,'logout','User logged out Device: Unknown',62,9,'2024-10-15 15:01:00'),(322,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-10-15 15:01:04'),(323,'logout','User logged out Device: Unknown',62,9,'2024-10-15 15:01:07'),(324,'login','basurero1234 logged in successfully to BSED',59,4,'2024-10-15 15:03:07'),(325,'logout','User logged out Device: Unknown',59,4,'2024-10-15 15:03:09'),(326,'login','mangtomas1234 logged in successfully to BSIT',56,2,'2024-10-15 15:03:35'),(327,'logout','User logged out Device: Unknown',56,2,'2024-10-15 15:08:36'),(328,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-10-15 15:08:41'),(329,'backup','User Created A Backup',62,9,'2024-10-15 15:09:03'),(330,'backup','User Created A Backup',62,9,'2024-10-15 15:09:10'),(331,'backup','User Created A Backup',62,9,'2024-10-15 15:09:15'),(332,'backup','User Created A Backup',62,9,'2024-10-15 15:09:17'),(333,'backup','User Created A Backup',62,9,'2024-10-15 15:09:20'),(334,'backup','User Created A Backup',62,9,'2024-10-15 15:09:22'),(335,'backup','User Created A Backup',62,9,'2024-10-15 15:09:25'),(336,'backup','User Created A Backup',62,9,'2024-10-15 15:09:27'),(337,'backup','User Created A Backup',62,9,'2024-10-15 15:09:29'),(338,'backup','User Created A Backup',62,9,'2024-10-15 15:09:31'),(339,'logout','User logged out Device: Unknown',62,9,'2024-10-15 15:09:31'),(340,'logout','User logged out Device: Unknown',62,9,'2024-10-15 15:09:32'),(341,'logout','User logged out Device: Unknown',62,9,'2024-10-15 15:09:32'),(342,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-10-15 15:09:36'),(343,'backup','User Created A Backup',62,9,'2024-10-15 15:10:25'),(344,'backup','User Created A Backup',62,9,'2024-10-15 15:11:18'),(345,'logout','User logged out Device: Unknown',62,9,'2024-10-15 15:11:22'),(346,'login','mangtomas1234 logged in successfully to BSIT',56,2,'2024-10-15 15:11:26'),(347,'logout','User logged out Device: Unknown',56,2,'2024-10-15 15:12:16'),(348,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-10-15 15:12:34'),(349,'logout','User logged out Device: Unknown',62,9,'2024-10-15 15:14:27'),(350,'login','mangtomas1234 logged in successfully to BSIT',56,2,'2024-10-15 15:14:31'),(351,'logout','User logged out Device: Unknown',62,9,'2024-10-15 15:25:56'),(352,'logout','User logged out Device: Unknown',56,2,'2024-10-15 15:31:39'),(353,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-10-15 15:31:47'),(354,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-10-15 15:31:49'),(355,'logout','User logged out Device: Unknown',62,9,'2024-10-15 15:32:09'),(356,'login','mangtomas1234 logged in successfully to BSAGRI',56,7,'2024-10-15 15:32:17'),(357,'logout','User logged out Device: Unknown',56,7,'2024-10-15 15:32:30'),(358,'login','hannah1234 logged in successfully to BSIT',57,2,'2024-10-15 15:32:34'),(359,'logout','User logged out Device: Unknown',57,2,'2024-10-15 15:37:41'),(360,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-10-15 15:41:11'),(361,'logout','User logged out Device: Unknown',62,9,'2024-10-15 15:41:13'),(362,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-10-15 15:42:50'),(363,'logout','User logged out Device: Unknown',62,9,'2024-10-15 15:42:54'),(364,'login','hannah1234 logged in successfully to BSIT',57,2,'2024-10-15 15:43:11'),(365,'logout','User logged out Device: Unknown',57,2,'2024-10-15 15:43:48'),(366,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-10-15 15:43:54'),(367,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-10-15 16:27:11'),(368,'logout','User logged out Device: Unknown',62,9,'2024-10-15 16:27:14'),(369,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-10-15 16:27:17'),(370,'logout','User logged out Device: Unknown',62,9,'2024-10-15 16:27:19'),(371,'login','mangtomas1234 logged in successfully to BSAGRI',56,7,'2024-10-15 16:27:22'),(372,'logout','User logged out Device: Unknown',56,7,'2024-10-15 16:27:25'),(373,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-10-15 16:27:28'),(374,'logout','User logged out Device: Unknown',62,9,'2024-10-15 19:23:48'),(375,'login','mangtomas1234 logged in successfully to BSAGRI',56,7,'2024-10-15 19:23:55'),(376,'login','mangtomas1234 logged in successfully to BSAGRI',56,7,'2024-10-15 19:23:57'),(377,'login','mangtomas1234 logged in successfully to BSAGRI',56,7,'2024-10-15 19:23:59'),(378,'login','mangtomas1234 logged in successfully to BSAGRI',56,7,'2024-10-15 19:24:00'),(379,'logout','User logged out Device: Unknown',56,7,'2024-10-15 19:24:04'),(380,'login','mangtomas1234 logged in successfully to BSIT',56,2,'2024-10-15 19:24:13'),(381,'logout','User logged out Device: Unknown',56,2,'2024-10-15 19:36:33'),(382,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-10-15 19:36:37'),(383,'logout','User logged out Device: Unknown',62,9,'2024-10-15 19:36:40'),(384,'login','mangtomas1234 logged in successfully to BSAGRI',56,7,'2024-10-15 19:36:46'),(385,'logout','User logged out Device: Unknown',56,7,'2024-10-15 19:37:23'),(386,'login','hannah1234 logged in successfully to BSIT',57,2,'2024-10-15 19:37:29'),(387,'login','hannah1234 logged in successfully to BSIT',57,2,'2024-10-15 19:37:33'),(388,'login','hannah1234 logged in successfully to BSIT',57,2,'2024-10-15 19:37:37'),(389,'login','hannah1234 logged in successfully to BSIT',57,2,'2024-10-15 19:37:39'),(390,'login','hannah1234 logged in successfully to BSIT',57,2,'2024-10-15 19:37:46'),(391,'login','hannah1234 logged in successfully to BSIT',57,2,'2024-10-15 19:37:50'),(392,'login','hannah1234 logged in successfully to BSIT',57,2,'2024-10-15 19:37:52'),(393,'login','hannah1234 logged in successfully to BSIT',57,2,'2024-10-15 19:37:57'),(394,'login','hannah1234 logged in successfully to BSIT',57,2,'2024-10-15 19:37:58'),(395,'login','hannah1234 logged in successfully to BSIT',57,2,'2024-10-15 19:38:03'),(396,'logout','User logged out Device: Unknown',57,2,'2024-10-15 19:40:22'),(397,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-10-15 19:40:46'),(398,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-10-15 19:40:50'),(399,'logout','User logged out Device: Unknown',62,9,'2024-10-16 05:32:56'),(400,'login','mangtomas1234 logged in successfully to BSAGRI',56,7,'2024-10-16 05:33:03'),(401,'logout','User logged out Device: Unknown',56,7,'2024-10-16 05:33:11'),(402,'login','basurero1234 logged in successfully to BSED',59,4,'2024-10-16 05:33:26'),(403,'logout','User logged out Device: Unknown',59,4,'2024-10-16 05:33:34'),(404,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-10-16 05:33:38'),(405,'logout','User logged out Device: Unknown',62,9,'2024-10-16 21:27:12'),(406,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-10-16 21:27:27'),(407,'logout','User logged out Device: Unknown',62,9,'2024-10-16 21:27:30'),(408,'login','mangtomas1234 logged in successfully to BSIT',56,2,'2024-10-16 21:43:12'),(409,'logout','User logged out Device: Unknown',56,2,'2024-10-16 21:43:18'),(410,'login','mangtomas1234 logged in successfully to BSAGRI',56,7,'2024-10-16 21:56:52'),(411,'logout','User logged out Device: Unknown',56,7,'2024-10-16 21:56:55'),(412,'login','mangtomas1234 logged in successfully to BSIT',56,2,'2024-10-16 22:02:32'),(413,'logout','User logged out Device: Unknown',56,2,'2024-10-16 22:02:34'),(414,'login','mangtomas1234 logged in successfully to BSAGRI',56,7,'2024-10-16 22:03:27'),(415,'logout','User logged out Device: Unknown',56,7,'2024-10-16 22:03:33'),(416,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-10-17 02:33:55'),(417,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-10-20 19:49:03'),(418,'logout','User logged out Device: Unknown',62,9,'2024-10-26 18:31:16'),(419,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-10-26 18:31:27'),(420,'logout','User logged out Device: Unknown',62,9,'2024-10-26 18:54:39'),(421,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-10-26 18:54:43'),(422,'logout','User logged out Device: Unknown',62,9,'2024-10-26 18:54:45'),(423,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-10-26 18:58:30'),(424,'logout','User logged out Device: Unknown',62,9,'2024-10-26 18:58:33'),(425,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-10-26 18:59:08'),(426,'logout','User logged out Device: Unknown',62,9,'2024-10-26 18:59:10'),(427,'login','mangtomas1234 logged in successfully to BSIT',56,2,'2024-10-26 18:59:23'),(428,'logout','User logged out Device: Unknown',56,2,'2024-10-26 18:59:24'),(429,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-10-26 18:01:53'),(430,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-10-26 18:07:20'),(431,'logout','User logged out Device: Unknown',62,9,'2024-10-26 18:10:56'),(432,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-10-26 18:11:04'),(433,'logout','User logged out Device: Unknown',62,9,'2024-10-26 18:11:15'),(434,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-10-26 20:18:02'),(435,'logout','User logged out Device: Unknown',62,9,'2024-10-26 20:18:10'),(436,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-10-29 21:35:00'),(437,'logout','User logged out Device: Unknown',62,9,'2024-10-29 21:35:04'),(438,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-11-11 07:18:04'),(439,'login','mark1234 logged in successfully to PSUBP',62,9,'2024-11-16 19:42:29'),(440,'logout','User logged out Device: Unknown',62,9,'2024-11-17 00:56:48'),(442,'login','mangtomas1234 logged in successfully to BSIT',56,2,'2024-11-19 12:33:18'),(443,'logout','User logged out Device: Unknown',56,2,'2024-11-19 12:33:22'),(444,'logout','User logged out Device: Unknown',62,9,'2024-11-19 12:34:05'),(445,'logout','User logged out Device: Unknown',62,9,'2024-11-19 12:38:53'),(446,'logout','User logged out Device: Unknown',62,9,'2024-11-19 12:40:32'),(447,'login','mangtomas1234 logged in successfully to BSAGRI',56,7,'2024-11-19 12:40:55'),(448,'login','mangtomas1234 logged in successfully to BSIT',56,2,'2024-11-19 12:41:10'),(449,'login','mangtomas1234 logged in successfully to BSIT',56,2,'2024-11-19 12:41:12'),(450,'login','mangtomas1234 logged in successfully to BSIT',56,2,'2024-11-19 12:41:12'),(451,'login','mangtomas1234 logged in successfully to BSIT',56,2,'2024-11-19 12:41:12'),(452,'login','mangtomas1234 logged in successfully to BSAGRI',56,7,'2024-11-19 12:41:13'),(453,'login','mangtomas1234 logged in successfully to BSAGRI',56,7,'2024-11-19 12:41:13'),(454,'login','mangtomas1234 logged in successfully to BSAGRI',56,7,'2024-11-19 12:41:14'),(455,'login','mangtomas1234 logged in successfully to BSAGRI',56,7,'2024-11-19 12:41:15'),(456,'login','mangtomas1234 logged in successfully to BSIT',56,2,'2024-11-19 12:41:15'),(457,'login','mangtomas1234 logged in successfully to BSIT',56,2,'2024-11-19 12:41:58'),(458,'login','mangtomas1234 logged in successfully to BSAGRI',56,7,'2024-11-19 12:41:58'),(459,'login','mangtomas1234 logged in successfully to BSAGRI',56,7,'2024-11-19 12:41:59'),(460,'login','mangtomas1234 logged in successfully to BSAGRI',56,7,'2024-11-19 12:41:59'),(461,'login','mangtomas1234 logged in successfully to BSAGRI',56,7,'2024-11-19 12:41:59'),(462,'login','mangtomas1234 logged in successfully to BSAGRI',56,7,'2024-11-19 12:42:00'),(463,'login','mangtomas1234 logged in successfully to BSAGRI',56,7,'2024-11-19 12:44:06'),(464,'login','mangtomas1234 logged in successfully to BSAGRI',56,7,'2024-11-19 12:44:07'),(465,'login','mangtomas1234 logged in successfully to BSIT',56,2,'2024-11-19 12:44:28'),(466,'login','mangtomas1234 logged in successfully to BSAGRI',56,7,'2024-11-19 12:48:20'),(467,'login','mangtomas1234 logged in successfully to BSAGRI',56,7,'2024-11-19 12:48:21'),(468,'login','mangtomas1234 logged in successfully to BSAGRI',56,7,'2024-11-19 12:48:21'),(469,'login','mangtomas1234 logged in successfully to BSIT',56,2,'2024-11-19 12:49:15'),(470,'logout','User logged out Device: Unknown',56,2,'2024-11-19 12:49:32'),(471,'login','mangtomas1234 logged in successfully to BSAGRI',56,7,'2024-11-19 12:49:47'),(472,'logout','User logged out Device: Unknown',56,7,'2024-11-19 12:49:52'),(473,'logout','User logged out Device: Unknown',62,9,'2024-11-19 12:50:23'),(474,'logout','User logged out Device: Unknown',62,9,'2024-11-19 12:50:56'),(475,'logout','User logged out Device: Unknown',62,9,'2024-11-19 12:54:49'),(476,'logout','User logged out Device: Unknown',62,9,'2024-11-19 12:57:47'),(477,'logout','User logged out Device: Unknown',62,9,'2024-11-19 12:58:48'),(478,'logout','User logged out Device: Unknown',62,9,'2024-11-19 12:59:48'),(479,'logout','User logged out Device: Unknown',62,9,'2024-11-19 13:16:51'),(480,'logout','User logged out Device: Unknown',62,9,'2024-11-19 13:18:18'),(481,'logout','User logged out Device: Unknown',62,9,'2024-11-19 13:33:52'),(482,'login','mangtomas1234 logged in successfully to BSIT',56,2,'2024-11-19 20:44:02'),(483,'logout','User logged out Device: Unknown',56,2,'2024-11-19 20:44:22'),(484,'logout','User logged out Device: Unknown',62,9,'2024-11-19 23:08:45'),(485,'logout','User logged out Device: Unknown',62,9,'2024-11-19 23:08:47'),(486,'logout','User logged out Device: Unknown',62,9,'2024-11-19 23:08:52'),(487,'logout','User logged out Device: Unknown',62,9,'2024-11-19 23:08:52'),(488,'backup','User Created A Backup',62,9,'2024-11-20 04:53:29'),(489,'logout','User logged out Device: Unknown',62,9,'2024-11-20 04:54:55'),(490,'login','mangtomas1234 logged in successfully to BSAGRI',56,7,'2024-11-20 04:55:27'),(491,'logout','User logged out Device: Unknown',56,7,'2024-11-20 04:55:39'),(492,'login','mangtomas1234 logged in successfully to BSAGRI',56,7,'2024-11-20 04:59:46'),(493,'logout','User logged out Device: Unknown',56,7,'2024-11-20 04:59:48');
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `album`
--

DROP TABLE IF EXISTS `album`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `album_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `album`
--

LOCK TABLES `album` WRITE;
/*!40000 ALTER TABLE `album` DISABLE KEYS */;
/*!40000 ALTER TABLE `album` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `album_media`
--

DROP TABLE IF EXISTS `album_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `album_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `album_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `album_id` (`album_id`),
  KEY `media_id` (`media_id`),
  CONSTRAINT `album_media_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `album` (`id`),
  CONSTRAINT `album_media_ibfk_2` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `album_media`
--

LOCK TABLES `album_media` WRITE;
/*!40000 ALTER TABLE `album_media` DISABLE KEYS */;
/*!40000 ALTER TABLE `album_media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `archive_logs`
--

DROP TABLE IF EXISTS `archive_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `archive_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_archived` datetime DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `item` varchar(255) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `archived` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`),
  CONSTRAINT `archive_logs_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `archive_logs`
--

LOCK TABLES `archive_logs` WRITE;
/*!40000 ALTER TABLE `archive_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `archive_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `archived_items`
--

DROP TABLE IF EXISTS `archived_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `archived_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `item_type` varchar(50) NOT NULL,
  `archived_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `archived_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `archived_by` (`archived_by`),
  KEY `idx_item_id_item_type` (`item_id`,`item_type`),
  CONSTRAINT `archived_items_ibfk_1` FOREIGN KEY (`archived_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `archived_items`
--

LOCK TABLES `archived_items` WRITE;
/*!40000 ALTER TABLE `archived_items` DISABLE KEYS */;
INSERT INTO `archived_items` VALUES (24,156,'Post','2024-07-08 04:45:32',62),(25,159,'Post','2024-07-08 04:45:49',62),(26,154,'Post','2024-07-08 04:45:55',62),(27,158,'Post','2024-07-08 04:45:59',62),(28,157,'Post','2024-07-08 04:46:02',62);
/*!40000 ALTER TABLE `archived_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assets`
--

DROP TABLE IF EXISTS `assets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_type` varchar(50) NOT NULL,
  `asset_category` varchar(50) NOT NULL,
  `account_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_assets_accounts` (`account_id`),
  CONSTRAINT `fk_assets_accounts` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assets`
--

LOCK TABLES `assets` WRITE;
/*!40000 ALTER TABLE `assets` DISABLE KEYS */;
INSERT INTO `assets` VALUES (1,'Photo','Logo',9,'asset_66a993af261db_logo.png','2024-07-07 03:37:08'),(2,'Video','Hero',9,'asset_673d67113e2c4_psu.mp4','2024-07-07 03:37:08');
/*!40000 ALTER TABLE `assets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `audit_trail`
--

DROP TABLE IF EXISTS `audit_trail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audit_trail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  KEY `fk_user_id` (`user_id`),
  CONSTRAINT `audit_trail_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=150 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_trail`
--

LOCK TABLES `audit_trail` WRITE;
/*!40000 ALTER TABLE `audit_trail` DISABLE KEYS */;
INSERT INTO `audit_trail` VALUES (121,56,'create_post',151,'2024-07-05 19:04:54'),(122,56,'publish_post',151,'2024-07-05 19:04:55'),(123,62,'create_post',152,'2024-07-06 06:05:41'),(124,62,'publish_post',152,'2024-07-06 06:05:44'),(127,62,'create_post',154,'2024-07-06 09:03:18'),(128,62,'publish_post',154,'2024-07-06 09:03:22'),(131,59,'create_post',156,'2024-07-07 10:00:23'),(132,59,'publish_post',156,'2024-07-07 10:00:23'),(133,57,'create_post',157,'2024-07-08 00:22:47'),(134,57,'publish_post',157,'2024-07-08 00:22:47'),(135,57,'create_post',158,'2024-07-08 00:24:56'),(136,57,'publish_post',158,'2024-07-08 00:24:56'),(137,57,'create_post',159,'2024-07-08 00:36:29'),(138,57,'publish_post',159,'2024-07-08 00:36:29'),(139,56,'create_post',160,'2024-07-08 12:07:56'),(140,62,'edit_post',160,'2024-07-08 12:08:42'),(141,62,'publish_post',160,'2024-07-08 12:08:42'),(142,62,'create_post',161,'2024-07-31 01:14:13'),(143,62,'publish_post',161,'2024-07-31 01:14:15'),(144,62,'create_post',162,'2024-07-31 01:14:23'),(145,62,'publish_post',162,'2024-07-31 01:14:24'),(146,56,'create_post',163,'2024-07-31 01:21:36'),(147,56,'publish_post',163,'2024-07-31 01:21:36'),(148,56,'edit_post',163,'2024-07-31 01:22:00'),(149,56,'publish_post',163,'2024-07-31 01:22:00');
/*!40000 ALTER TABLE `audit_trail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat_messages`
--

DROP TABLE IF EXISTS `chat_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chat_room_id` int(11) NOT NULL,
  `sender_type` enum('user','admin') NOT NULL,
  `user_sender_id` int(11) DEFAULT NULL,
  `admin_sender_id` int(11) DEFAULT NULL,
  `message` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_sender_id` (`user_sender_id`),
  KEY `admin_sender_id` (`admin_sender_id`),
  CONSTRAINT `chat_messages_ibfk_1` FOREIGN KEY (`user_sender_id`) REFERENCES `chat_users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `chat_messages_ibfk_2` FOREIGN KEY (`admin_sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_messages`
--

LOCK TABLES `chat_messages` WRITE;
/*!40000 ALTER TABLE `chat_messages` DISABLE KEYS */;
INSERT INTO `chat_messages` VALUES (39,2,'admin',NULL,62,'hahahaha','2024-11-20 01:55:45'),(40,2,'admin',NULL,62,'hahaha','2024-11-20 02:02:30'),(41,2,'admin',NULL,62,'lol','2024-11-20 02:02:37'),(42,2,'admin',NULL,62,'haha','2024-11-20 02:04:09'),(43,2,'admin',NULL,62,'aaa','2024-11-20 02:04:12'),(44,2,'admin',NULL,62,'aa','2024-11-20 02:04:14'),(45,2,'user',1,NULL,'hinambalos','2024-11-20 02:04:16'),(46,2,'admin',NULL,62,'haha\r\n','2024-11-20 03:25:55'),(47,2,'admin',NULL,62,'hahah','2024-11-20 03:26:02'),(48,2,'admin',NULL,62,'asaa','2024-11-20 04:45:36'),(49,2,'admin',NULL,62,'sss','2024-11-20 04:54:27');
/*!40000 ALTER TABLE `chat_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat_rooms`
--

DROP TABLE IF EXISTS `chat_rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chat_rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `chat_user_id` int(11) NOT NULL,
  `status` enum('open','closed') DEFAULT 'open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`),
  KEY `chat_user_id` (`chat_user_id`),
  CONSTRAINT `chat_rooms_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`account_id`),
  CONSTRAINT `chat_rooms_ibfk_2` FOREIGN KEY (`chat_user_id`) REFERENCES `chat_users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_rooms`
--

LOCK TABLES `chat_rooms` WRITE;
/*!40000 ALTER TABLE `chat_rooms` DISABLE KEYS */;
INSERT INTO `chat_rooms` VALUES (2,9,1,'open','2024-11-20 00:40:47','2024-11-20 00:42:10');
/*!40000 ALTER TABLE `chat_rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat_users`
--

DROP TABLE IF EXISTS `chat_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chat_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_users`
--

LOCK TABLES `chat_users` WRITE;
/*!40000 ALTER TABLE `chat_users` DISABLE KEYS */;
INSERT INTO `chat_users` VALUES (1,'John Doe','johndoe@example.com','2024-11-20 00:39:43');
/*!40000 ALTER TABLE `chat_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `media` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `otp_codes`
--

DROP TABLE IF EXISTS `otp_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `otp_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `otp_code` varchar(6) DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `otp_codes`
--

LOCK TABLES `otp_codes` WRITE;
/*!40000 ALTER TABLE `otp_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `otp_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'edit_user'),(2,'create_post'),(3,'delete_post'),(4,'view_dashboard'),(5,'manage_accounts'),(6,'admin'),(7,'edit_post'),(8,'archive_post'),(9,'publish_post');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `positions`
--

DROP TABLE IF EXISTS `positions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `positions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `positions`
--

LOCK TABLES `positions` WRITE;
/*!40000 ALTER TABLE `positions` DISABLE KEYS */;
INSERT INTO `positions` VALUES (1,'faculty'),(2,'staff'),(3,'program head'),(4,'dean');
/*!40000 ALTER TABLE `positions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `publish` tinyint(1) NOT NULL DEFAULT 0,
  `auto_archive` tinyint(1) NOT NULL DEFAULT 0,
  `auto_archive_date` date DEFAULT NULL,
  `date_posted` date DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `archived` tinyint(1) DEFAULT 0,
  `publisher_id` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`author_id`),
  KEY `topic_id` (`topic_id`),
  KEY `fk_publisher` (`publisher_id`),
  KEY `fk_account_id` (`account_id`),
  CONSTRAINT `fk_account_id` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`account_id`),
  CONSTRAINT `fk_publisher` FOREIGN KEY (`publisher_id`) REFERENCES `users` (`id`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`),
  CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`topic_id`)
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (151,'hahaha','hahaha_20240706_030453.jpg','asdasd',0,0,'0000-00-00','2024-07-06',56,2,0,56,2),(152,'hahahahahahah','hahahahahahah_20240706_140541.jpg','hahahaha',1,0,'0000-00-00','2024-07-06',62,1,0,62,9),(154,'test','test_20240706_170318.jpg','11',1,0,'0000-00-00','2024-07-06',62,1,1,62,9),(156,'hahah','hahah_20240707_180023.jpg','222',1,0,'0000-00-00','2024-07-07',59,3,1,59,4),(157,'test test test','test test test_20240708_082246.jpg','hahaha',1,0,'0000-00-00','2024-07-08',57,2,1,57,2),(158,'sa pa','sa pa_20240708_082456.jpg','asdas',1,0,'0000-00-00','2024-07-08',57,3,1,57,2),(159,'lmao','lmao_20240708_083628.jpg','kalabaw',1,0,'0000-00-00','2024-07-08',57,2,1,57,2),(160,'BSIT','BSIT_20240708_200756.jpg','hahaha',1,0,'0000-00-00','2024-07-08',56,3,0,62,2),(161,'asadas','asadas_20240731_091411.jpg','asdasd',1,0,'0000-00-00','2024-07-31',62,1,0,62,9),(162,'asadas','asadas_20240731_091422.jpg','asdasd',1,0,'0000-00-00','2024-07-31',62,1,0,62,9),(163,'eqwerw','eqwerw_20240731_092136.jpg','dqsdqxvcb',1,0,'0000-00-00','2024-07-31',56,3,0,56,7);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profile_positions`
--

DROP TABLE IF EXISTS `profile_positions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profile_positions` (
  `profile_id` int(11) DEFAULT NULL,
  `position_id` int(11) DEFAULT NULL,
  KEY `profile_id` (`profile_id`),
  KEY `position_id` (`position_id`),
  CONSTRAINT `profile_positions_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`),
  CONSTRAINT `profile_positions_ibfk_2` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profile_positions`
--

LOCK TABLES `profile_positions` WRITE;
/*!40000 ALTER TABLE `profile_positions` DISABLE KEYS */;
/*!40000 ALTER TABLE `profile_positions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `position` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `bio` text NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profiles`
--

LOCK TABLES `profiles` WRITE;
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;
INSERT INTO `profiles` VALUES (1,'Mark Daniel N. Rodriguez','wala','moralized19@gmail.com','9','as','hahaha_1.jpg'),(10,'Mang Tommy','Faculty','mangtomas2024@gmail.com','63','2','Mang Tommy_1.jpg'),(11,'Hambu','Faculty','mangtomas2024@gmail.com','63','sa','hambu.jpg'),(12,'Basura','Basurero','basorero2024@gmail.com','11','awd','Basura.png');
/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `topics`
--

DROP TABLE IF EXISTS `topics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `topics` (
  `topic_id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_name` varchar(255) NOT NULL,
  PRIMARY KEY (`topic_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `topics`
--

LOCK TABLES `topics` WRITE;
/*!40000 ALTER TABLE `topics` DISABLE KEYS */;
INSERT INTO `topics` VALUES (1,'Event'),(2,'Article'),(3,'Announcement');
/*!40000 ALTER TABLE `topics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_permissions`
--

DROP TABLE IF EXISTS `user_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `permission_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `permission_id` (`permission_id`),
  CONSTRAINT `user_permissions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `user_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_permissions`
--

LOCK TABLES `user_permissions` WRITE;
/*!40000 ALTER TABLE `user_permissions` DISABLE KEYS */;
INSERT INTO `user_permissions` VALUES (37,56,6),(38,57,2),(39,59,7),(40,62,6);
/*!40000 ALTER TABLE `user_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `profile_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `profile_id` (`profile_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (56,'mangtomas1234','1234',10),(57,'hambu1234','1234',11),(59,'basurero1234','1234',12),(62,'mark1234','1234',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-21 23:23:37
