-- MySQL dump 10.13  Distrib 8.0.28, for Win64 (x86_64)
--
-- Host: localhost    Database: api_cloud
-- ------------------------------------------------------
-- Server version	8.0.28

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `actions`
--

DROP TABLE IF EXISTS `actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `actions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `page_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `actions_page_id_foreign` (`page_id`),
  CONSTRAINT `actions_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actions`
--

LOCK TABLES `actions` WRITE;
/*!40000 ALTER TABLE `actions` DISABLE KEYS */;
INSERT INTO `actions` VALUES (1,1,'View','view','2025-10-10 23:27:01','2025-10-10 23:27:01'),(2,1,'Create','create','2025-10-10 23:27:01','2025-10-10 23:27:01'),(3,1,'Edit','edit','2025-10-10 23:27:01','2025-10-10 23:27:01'),(4,1,'Delete','delete','2025-10-10 23:27:01','2025-10-10 23:27:01'),(5,2,'View','view','2025-10-10 23:27:01','2025-10-10 23:27:01'),(6,2,'Create','create','2025-10-10 23:27:01','2025-10-10 23:27:01'),(7,2,'Edit','edit','2025-10-10 23:27:01','2025-10-10 23:27:01'),(8,2,'Delete','delete','2025-10-10 23:27:01','2025-10-10 23:27:01'),(9,3,'View','view','2025-10-10 23:27:01','2025-10-10 23:27:01'),(10,3,'Create','create','2025-10-10 23:27:01','2025-10-10 23:27:01'),(11,3,'Edit','edit','2025-10-10 23:27:01','2025-10-10 23:27:01'),(12,3,'Delete','delete','2025-10-10 23:27:01','2025-10-10 23:27:01'),(13,4,'View','view','2025-10-10 23:27:01','2025-10-10 23:27:01'),(14,4,'Create','create','2025-10-10 23:27:01','2025-10-10 23:27:01'),(15,4,'Edit','edit','2025-10-10 23:27:01','2025-10-10 23:27:01'),(16,4,'Delete','delete','2025-10-10 23:27:01','2025-10-10 23:27:01'),(75,1,'Export','export','2025-10-11 01:26:17','2025-10-11 01:26:17'),(76,2,'Export','export','2025-10-11 01:26:18','2025-10-11 01:26:18'),(77,2,'Suspend','suspend','2025-10-11 01:26:18','2025-10-11 01:26:18'),(78,2,'Activate','activate','2025-10-11 01:26:18','2025-10-11 01:26:18'),(79,2,'Send Notification','send_notification','2025-10-11 01:26:18','2025-10-11 01:26:18'),(80,3,'Export','export','2025-10-11 01:26:18','2025-10-11 01:26:18'),(81,5,'View','view','2025-10-11 01:26:18','2025-10-11 01:26:18'),(82,5,'Create','create','2025-10-11 01:26:18','2025-10-11 01:26:18'),(83,5,'Edit','edit','2025-10-11 01:26:18','2025-10-11 01:26:18'),(84,5,'Delete','delete','2025-10-11 01:26:18','2025-10-11 01:26:18'),(85,5,'Export','export','2025-10-11 01:26:18','2025-10-11 01:26:18'),(86,5,'Approve','approve','2025-10-11 01:26:18','2025-10-11 01:26:18'),(87,5,'Reject','reject','2025-10-11 01:26:18','2025-10-11 01:26:18'),(88,5,'Reconcile','reconcile','2025-10-11 01:26:18','2025-10-11 01:26:18'),(89,6,'View','view','2025-10-11 01:26:18','2025-10-11 01:26:18'),(90,6,'Create','create','2025-10-11 01:26:18','2025-10-11 01:26:18'),(91,6,'Edit','edit','2025-10-11 01:26:18','2025-10-11 01:26:18'),(92,6,'Delete','delete','2025-10-11 01:26:18','2025-10-11 01:26:18'),(93,6,'Export','export','2025-10-11 01:26:18','2025-10-11 01:26:18'),(94,6,'Approve','approve','2025-10-11 01:26:18','2025-10-11 01:26:18'),(95,6,'Reject','reject','2025-10-11 01:26:18','2025-10-11 01:26:18'),(96,6,'Reconcile','reconcile','2025-10-11 01:26:19','2025-10-11 01:26:19'),(97,7,'View','view','2025-10-11 01:26:19','2025-10-11 01:26:19'),(98,7,'Create','create','2025-10-11 01:26:19','2025-10-11 01:26:19'),(99,7,'Edit','edit','2025-10-11 01:26:19','2025-10-11 01:26:19'),(100,7,'Delete','delete','2025-10-11 01:26:19','2025-10-11 01:26:19'),(101,7,'Export','export','2025-10-11 01:26:19','2025-10-11 01:26:19'),(102,7,'Generate Report','generate_report','2025-10-11 01:26:19','2025-10-11 01:26:19'),(103,4,'Export','export','2025-10-11 01:26:19','2025-10-11 01:26:19'),(104,8,'View','view','2025-10-11 01:26:19','2025-10-11 01:26:19'),(105,8,'Create','create','2025-10-11 01:26:19','2025-10-11 01:26:19'),(106,8,'Edit','edit','2025-10-11 01:26:19','2025-10-11 01:26:19'),(107,8,'Delete','delete','2025-10-11 01:26:19','2025-10-11 01:26:19'),(108,8,'Export','export','2025-10-11 01:26:19','2025-10-11 01:26:19'),(109,9,'View','view','2025-10-11 01:26:19','2025-10-11 01:26:19'),(110,9,'Create','create','2025-10-11 01:26:19','2025-10-11 01:26:19'),(111,9,'Edit','edit','2025-10-11 01:26:19','2025-10-11 01:26:19'),(112,9,'Delete','delete','2025-10-11 01:26:19','2025-10-11 01:26:19'),(113,9,'Export','export','2025-10-11 01:26:19','2025-10-11 01:26:19'),(114,10,'View','view','2025-10-17 05:00:16','2025-10-17 05:00:16'),(115,10,'Create','create','2025-10-17 05:00:16','2025-10-17 05:00:16'),(116,10,'Edit','edit','2025-10-17 05:00:16','2025-10-17 05:00:16'),(117,10,'Delete','delete','2025-10-17 05:00:16','2025-10-17 05:00:16'),(118,10,'Export','export','2025-10-17 05:00:16','2025-10-17 05:00:16'),(119,10,'Assign','assign','2025-10-17 05:00:16','2025-10-17 05:00:16'),(120,10,'Change Status','change_status','2025-10-17 05:00:16','2025-10-17 05:00:16'),(121,10,'Change Priority','change_priority','2025-10-17 05:00:16','2025-10-17 05:00:16'),(122,11,'View','view','2025-10-17 05:00:16','2025-10-17 05:00:16'),(123,11,'Create','create','2025-10-17 05:00:16','2025-10-17 05:00:16'),(124,11,'Edit','edit','2025-10-17 05:00:16','2025-10-17 05:00:16'),(125,11,'Delete','delete','2025-10-17 05:00:16','2025-10-17 05:00:16'),(126,11,'Export','export','2025-10-17 05:00:16','2025-10-17 05:00:16'),(127,11,'Reply','reply','2025-10-17 05:00:16','2025-10-17 05:00:16');
/*!40000 ALTER TABLE `actions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-01-03  9:39:20
