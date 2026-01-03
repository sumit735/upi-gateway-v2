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
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route_pattern` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pages_route_pattern_unique` (`route_pattern`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (1,'Dashboard','dashboard','Main dashboard page','2025-10-10 23:27:01','2025-10-10 23:27:01'),(2,'User Management','admin.users.*','Manage users and their roles','2025-10-10 23:27:01','2025-10-10 23:27:01'),(3,'Profile','profile.*','User profile management','2025-10-10 23:27:01','2025-10-10 23:27:01'),(4,'Settings','admin.settings.*','Application configuration','2025-10-10 23:27:01','2025-10-11 01:16:07'),(5,'Transactions','admin.transactions.*','View and manage transactions','2025-10-11 01:16:07','2025-10-11 01:16:07'),(6,'Payments','admin.payments.*','Process and manage payments','2025-10-11 01:16:07','2025-10-11 01:16:07'),(7,'Reports','admin.reports.*','Generate and view reports','2025-10-11 01:16:07','2025-10-11 01:16:07'),(8,'Developer Tools','portal.dev.*','Developer tools and utilities','2025-10-11 01:16:07','2025-10-11 01:16:07'),(9,'Subscriptions','admin.settings.subscriptions.*','Manage user subscriptions','2025-10-11 01:16:07','2025-10-11 01:16:07'),(10,'All Tickets','portal.tickets.*','Manage all support tickets (Admin)','2025-10-17 05:00:16','2025-10-17 05:00:16'),(11,'My Tickets','portal.my-tickets.*','View and manage your support tickets','2025-10-17 05:00:16','2025-10-17 05:00:16');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-01-03  9:39:19
