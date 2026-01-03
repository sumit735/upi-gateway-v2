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
-- Table structure for table `role_permissions`
--

DROP TABLE IF EXISTS `role_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint unsigned NOT NULL,
  `page_id` bigint unsigned NOT NULL,
  `action_id` bigint unsigned NOT NULL,
  `scope` enum('self','all') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'self',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_page_action_unique` (`role_id`,`page_id`,`action_id`),
  KEY `role_permissions_page_id_foreign` (`page_id`),
  KEY `role_permissions_action_id_foreign` (`action_id`),
  CONSTRAINT `role_permissions_action_id_foreign` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_permissions_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=165 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_permissions`
--

LOCK TABLES `role_permissions` WRITE;
/*!40000 ALTER TABLE `role_permissions` DISABLE KEYS */;
INSERT INTO `role_permissions` VALUES (119,1,1,1,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(120,1,1,2,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(121,1,1,3,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(122,1,1,4,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(123,1,2,1,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(124,1,2,2,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(125,1,2,3,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(126,1,2,4,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(127,1,3,1,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(128,1,3,2,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(129,1,3,3,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(130,1,3,4,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(131,1,4,1,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(132,1,4,2,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(133,1,4,3,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(134,1,4,4,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(135,1,4,75,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(136,1,9,1,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(137,1,9,2,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(138,1,9,3,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(139,1,9,4,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(140,1,9,75,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(141,1,10,1,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(142,1,10,2,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(143,1,10,3,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(144,1,10,4,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(145,1,10,75,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(146,1,10,119,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(147,1,10,120,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(148,1,10,121,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(149,1,11,1,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(150,1,11,2,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(151,1,11,3,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(152,1,11,4,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(153,1,11,75,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(154,1,11,127,'all','2025-10-17 05:17:13','2025-10-17 05:17:13'),(155,2,1,1,'self','2026-01-02 22:09:36','2026-01-02 22:09:36'),(156,2,2,1,'self','2026-01-02 22:09:37','2026-01-02 22:09:37'),(157,2,3,1,'self','2026-01-02 22:09:37','2026-01-02 22:09:37'),(158,2,3,3,'self','2026-01-02 22:09:37','2026-01-02 22:09:37'),(159,2,11,1,'self','2026-01-02 22:09:37','2026-01-02 22:09:37'),(160,2,11,2,'self','2026-01-02 22:09:37','2026-01-02 22:09:37'),(161,2,11,3,'self','2026-01-02 22:09:37','2026-01-02 22:09:37'),(162,2,11,4,'self','2026-01-02 22:09:37','2026-01-02 22:09:37'),(163,2,11,75,'self','2026-01-02 22:09:37','2026-01-02 22:09:37'),(164,2,11,127,'self','2026-01-02 22:09:37','2026-01-02 22:09:37');
/*!40000 ALTER TABLE `role_permissions` ENABLE KEYS */;
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
