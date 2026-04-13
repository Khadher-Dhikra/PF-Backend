-- MySQL dump 10.13  Distrib 8.0.45, for Win64 (x86_64)
--
-- Host: localhost    Database: pf_db
-- ------------------------------------------------------
-- Server version	8.0.45

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `token_hash` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `used` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
INSERT INTO `password_resets` VALUES (75,18,'$2y$12$X2XqMwTJQ/q3OfpNuD8/vuXWFkNamwjoNO7i07Njv63d2A4wG5UVK','2026-04-12 00:19:38','2026-04-11 23:19:38',1);
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `refresh_tokens`
--

DROP TABLE IF EXISTS `refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `refresh_tokens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `token` text,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refresh_tokens`
--

LOCK TABLES `refresh_tokens` WRITE;
/*!40000 ALTER TABLE `refresh_tokens` DISABLE KEYS */;
INSERT INTO `refresh_tokens` VALUES (7,18,'fd0ce315cc4bc1f6062b998f2f719028ed8264ad0c81e7d404cadb2772e95b68934293aa4fe19a60543694d991c314371d43c50e48b7f29fa665adbff48dcbd7','2026-04-19 00:54:27'),(8,22,'7e8c3c8325aa4979218ebd8edf8f8915147471a612bab5ca177751b4b86e81ddfd2fcd493f2245568825fc3110002dc4555a6bad907c4782de8e3d3daacb280c','2026-04-19 00:56:18'),(9,18,'80e87e51d918d3fc9ef4a8cf1aca6830c1ced48ec485a8db931349c0623305d3c63b29304276fe6592c9da948be0550e761f45807419fac4f53807d7193462bc','2026-04-19 14:29:18'),(10,21,'dbb827792227bead2d55d356286b33461d8a8e1d3168f86ff26cf5f5281a16889447c4bc00b64a48812a7b3affa43f8a710a6eed853e900cfd6ea9e9e0506669','2026-04-19 15:46:09'),(11,18,'844f86443834dc34591d4cdb4db20c53e0a3e0f71783028aef6562dac90abeb11fed3f05746b8acbf4ea1d2d3c19a528313dfc43c1902682206952fd2788be3d','2026-04-19 15:46:32'),(12,18,'852b9fefa6077fbab5d2354033558a2100f98851992167bf0b41ef4b6dceb96e225101761df85e93866fec5ebd4b281464aab7c43e14d197d1d6ff5cb35c5b01','2026-04-19 16:10:57'),(13,18,'5a114de084d34fcee97dd498e2e763a39380c74d4f8a0711ed5a082f26af7bc56c88bcfb2b3e111fab4a652a2fc129e0d36f54224a6941c9fc63073960380064','2026-04-19 21:23:21'),(14,18,'a2b53af27fae3aaac28323138f02116f6f8a66267409c7c824c4c0f267a51b505dcdc81ec6c2a5594e952a5041f52ffa7e635ae5ca2eefd6b579eccc5311e77d','2026-04-20 00:02:41'),(15,18,'bed9c425b768a8c0a82b9ed607d378b3bf92344a5dae9b900ea98bd0cbe4377ede51d7786bb7bcf25d5f4162a29b40a3ec1d2719ad0dab7f775c7f660f6c7210','2026-04-20 00:03:41'),(16,18,'d8fbe97c6710995807c1260ba47dff2b11f8e726479fc00e228ef5d98340a41d117e58b44948028ea709eeef41e875c600448f4fde4d1292cd224490f39fb924','2026-04-20 00:23:29'),(17,18,'682f4c3b2010676584467e7fc3e2ff6017407ed2aeb48890afc433c1f4fca52d1278c9b1db91adb6f0659ef9061bdb31d020791a94cc2f2c59b49e639e12b01b','2026-04-20 12:42:45'),(18,21,'f1a5a6c484014f4fdb69643e01abd280567c8fa91bb37354e06ee2dfd34eba6e751a986abb03fc222be0e3fb685a7c2a6fa1a39787cda37e14c63bb32317b016','2026-04-20 13:01:37'),(19,18,'f53b330a6e23a0f8faad6c3358fd2bf52ec6e5c9f9d409a1ba48b1d6baa584aed454d7e1b94a5ae6f0c14c3e5c8da48d213971ca41859949644849b75ec3417e','2026-04-20 13:03:07'),(20,21,'fab1e7ff1b7bf346cb03e548134d66c0d139060455d0bdb591c12e95795cacab43648a424b73ce87eedc907242adcd77cd622a61780e4bb8cb23f29c8f7f017c','2026-04-20 13:23:20'),(21,18,'40da49e37b625db47cf618a091836fa46973cff2e5d4543cd822050d26d266df4de9edd3211906b800faedb902b87900c0b26732e540d3c5d54382ad3c9c4daf','2026-04-20 13:41:21'),(22,18,'24a437cb416bee97a1d88bddcde388071dc53d742fc28c9b63899806e17ffe39050cae2e7cb79d0359e9155c6535a0166edf165062a6d856a084c440b9f63238','2026-04-20 13:51:58'),(23,21,'875b7eb7b63082d16960c08dda5f8bc90202bb3dbc42080d67053f315841f0bf71563e4fa92d85b39b890c0408a1aa1f5fb83a1a0115be888543e4dd45fb4554','2026-04-20 13:53:38'),(24,21,'f0d96599031d900ef7423ffa89f0d448a2b54160ec7ea5ebe892f9d383b290dfac272ca1ddfcb5a5aa669f545de11d54e371614f5388f290b029601459a44514','2026-04-20 14:03:59'),(25,20,'94937bebcd46143db3d10303178d0cdc88290b35e0fab4733779d7b704ca19d06de2b67e3a212a37eddb753fa7c58e3397916ebbbfee6e945d8157008b5e7fbc','2026-04-20 14:05:22'),(26,18,'268a8f25524a3fe07e987efeb3d85e0bfb4d16f257e2a86172b43fe704623ba4e51973e790b8b0609d217d4ab9f8e07f02bb2d810bbe4df1a304081cdd4e67d1','2026-04-20 14:07:50');
/*!40000 ALTER TABLE `refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role` varchar(20) DEFAULT 'student',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `email_2` (`email`),
  UNIQUE KEY `email_3` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (18,'Jebali Baha Jebali','bahajebali40@gmail.com','$2y$12$d3yWUB.lcQZsFw00pNRzN.rR/aqO57czUVLMCHGShWaka5Wk0/E/K','2026-04-11 22:15:30','student'),(20,'tutor','tutor@fstsbz-turor.com','$2y$12$gvKbOCkjS7eW7SiLjhRVaufHlGmDsnbiYi66tfFe.2JF50JWHjBUS','2026-04-11 22:44:49','tutor'),(21,'coordinator','coord@fstsbz-coordinator.com','$2y$12$tKh2DHwZn84oExI7gY2nOO4OBV99KuJrs8NxZGsYggZz9z77U8UVi','2026-04-11 22:51:24','coordinator'),(22,'jury','jury@fstsbz-jury.com','$2y$12$p9ldTOcheHFpY1LXDaHK0u0ChtT/1MbWjIylfcE49IPuz7Gvsm1Oe','2026-04-11 22:51:59','jury');
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

-- Dump completed on 2026-04-13 14:58:44
