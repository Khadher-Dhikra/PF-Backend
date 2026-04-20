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
-- Table structure for table `jury_members`
--

DROP TABLE IF EXISTS `jury_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jury_members` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `jury_members_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jury_members`
--

LOCK TABLES `jury_members` WRITE;
/*!40000 ALTER TABLE `jury_members` DISABLE KEYS */;
/*!40000 ALTER TABLE `jury_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_id` int DEFAULT NULL,
  `receiver_id` int DEFAULT NULL,
  `content` text,
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `sender_id` (`sender_id`),
  KEY `idx_messages_receiver` (`receiver_id`),
  CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `milestones`
--

DROP TABLE IF EXISTS `milestones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `milestones` (
  `id` int NOT NULL AUTO_INCREMENT,
  `project_id` int DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `status` enum('Comming_soon','In_progress','Completed') DEFAULT 'Comming_soon',
  `order_index` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  CONSTRAINT `milestones_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `milestones`
--

LOCK TABLES `milestones` WRITE;
/*!40000 ALTER TABLE `milestones` DISABLE KEYS */;
INSERT INTO `milestones` VALUES (1,5,'Create Dashbord','2026-04-23','Completed',1,'2026-04-20 00:54:16'),(2,5,'Create register page','2026-04-27','In_progress',2,'2026-04-20 00:55:51'),(3,5,'Create login page','2026-04-30','Comming_soon',3,'2026-04-20 00:56:31');
/*!40000 ALTER TABLE `milestones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `content` text,
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

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
  `used` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_password_resets_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
INSERT INTO `password_resets` VALUES (1,3,'$2y$12$eBqRuqNZn5csBlCtDipmBOu/NwHX0XW81L7O/2SdV8Ab.5Gvw8e1i','2026-04-16 20:53:56',0,'2026-04-16 19:53:56'),(2,1,'$2y$12$BG10lPoLs4holym9G7FE3urnxQ5X6iKuT17kOksE3QWTehDhKxu9m','2026-04-20 00:37:31',0,'2026-04-19 23:37:31');
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_students`
--

DROP TABLE IF EXISTS `project_students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_students` (
  `id` int NOT NULL AUTO_INCREMENT,
  `project_id` int DEFAULT NULL,
  `student_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_student` (`student_id`),
  KEY `project_id` (`project_id`),
  CONSTRAINT `project_students_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `project_students_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_students`
--

LOCK TABLES `project_students` WRITE;
/*!40000 ALTER TABLE `project_students` DISABLE KEYS */;
INSERT INTO `project_students` VALUES (5,5,1);
/*!40000 ALTER TABLE `project_students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `projects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `status` enum('In_Progress','Finished','late') DEFAULT NULL,
  `progress` int DEFAULT '0',
  `tutor_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_project_tutor` (`tutor_id`),
  CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`tutor_id`) REFERENCES `tutors` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (1,'GH','project','In_Progress',30,NULL,'2026-04-16 21:07:13'),(5,'systeme de gestion','system','In_Progress',35,1,'2026-04-17 15:51:54');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refresh_tokens`
--

LOCK TABLES `refresh_tokens` WRITE;
/*!40000 ALTER TABLE `refresh_tokens` DISABLE KEYS */;
INSERT INTO `refresh_tokens` VALUES (7,18,'fd0ce315cc4bc1f6062b998f2f719028ed8264ad0c81e7d404cadb2772e95b68934293aa4fe19a60543694d991c314371d43c50e48b7f29fa665adbff48dcbd7','2026-04-19 00:54:27'),(8,22,'7e8c3c8325aa4979218ebd8edf8f8915147471a612bab5ca177751b4b86e81ddfd2fcd493f2245568825fc3110002dc4555a6bad907c4782de8e3d3daacb280c','2026-04-19 00:56:18'),(9,18,'80e87e51d918d3fc9ef4a8cf1aca6830c1ced48ec485a8db931349c0623305d3c63b29304276fe6592c9da948be0550e761f45807419fac4f53807d7193462bc','2026-04-19 14:29:18'),(10,21,'dbb827792227bead2d55d356286b33461d8a8e1d3168f86ff26cf5f5281a16889447c4bc00b64a48812a7b3affa43f8a710a6eed853e900cfd6ea9e9e0506669','2026-04-19 15:46:09'),(11,18,'844f86443834dc34591d4cdb4db20c53e0a3e0f71783028aef6562dac90abeb11fed3f05746b8acbf4ea1d2d3c19a528313dfc43c1902682206952fd2788be3d','2026-04-19 15:46:32'),(12,18,'852b9fefa6077fbab5d2354033558a2100f98851992167bf0b41ef4b6dceb96e225101761df85e93866fec5ebd4b281464aab7c43e14d197d1d6ff5cb35c5b01','2026-04-19 16:10:57'),(13,18,'5a114de084d34fcee97dd498e2e763a39380c74d4f8a0711ed5a082f26af7bc56c88bcfb2b3e111fab4a652a2fc129e0d36f54224a6941c9fc63073960380064','2026-04-19 21:23:21'),(14,18,'a2b53af27fae3aaac28323138f02116f6f8a66267409c7c824c4c0f267a51b505dcdc81ec6c2a5594e952a5041f52ffa7e635ae5ca2eefd6b579eccc5311e77d','2026-04-20 00:02:41'),(15,18,'bed9c425b768a8c0a82b9ed607d378b3bf92344a5dae9b900ea98bd0cbe4377ede51d7786bb7bcf25d5f4162a29b40a3ec1d2719ad0dab7f775c7f660f6c7210','2026-04-20 00:03:41'),(16,18,'d8fbe97c6710995807c1260ba47dff2b11f8e726479fc00e228ef5d98340a41d117e58b44948028ea709eeef41e875c600448f4fde4d1292cd224490f39fb924','2026-04-20 00:23:29'),(17,18,'682f4c3b2010676584467e7fc3e2ff6017407ed2aeb48890afc433c1f4fca52d1278c9b1db91adb6f0659ef9061bdb31d020791a94cc2f2c59b49e639e12b01b','2026-04-20 12:42:45'),(18,21,'f1a5a6c484014f4fdb69643e01abd280567c8fa91bb37354e06ee2dfd34eba6e751a986abb03fc222be0e3fb685a7c2a6fa1a39787cda37e14c63bb32317b016','2026-04-20 13:01:37'),(19,18,'f53b330a6e23a0f8faad6c3358fd2bf52ec6e5c9f9d409a1ba48b1d6baa584aed454d7e1b94a5ae6f0c14c3e5c8da48d213971ca41859949644849b75ec3417e','2026-04-20 13:03:07'),(20,21,'fab1e7ff1b7bf346cb03e548134d66c0d139060455d0bdb591c12e95795cacab43648a424b73ce87eedc907242adcd77cd622a61780e4bb8cb23f29c8f7f017c','2026-04-20 13:23:20'),(21,18,'40da49e37b625db47cf618a091836fa46973cff2e5d4543cd822050d26d266df4de9edd3211906b800faedb902b87900c0b26732e540d3c5d54382ad3c9c4daf','2026-04-20 13:41:21'),(22,18,'24a437cb416bee97a1d88bddcde388071dc53d742fc28c9b63899806e17ffe39050cae2e7cb79d0359e9155c6535a0166edf165062a6d856a084c440b9f63238','2026-04-20 13:51:58'),(23,21,'875b7eb7b63082d16960c08dda5f8bc90202bb3dbc42080d67053f315841f0bf71563e4fa92d85b39b890c0408a1aa1f5fb83a1a0115be888543e4dd45fb4554','2026-04-20 13:53:38'),(24,21,'f0d96599031d900ef7423ffa89f0d448a2b54160ec7ea5ebe892f9d383b290dfac272ca1ddfcb5a5aa669f545de11d54e371614f5388f290b029601459a44514','2026-04-20 14:03:59'),(25,20,'94937bebcd46143db3d10303178d0cdc88290b35e0fab4733779d7b704ca19d06de2b67e3a212a37eddb753fa7c58e3397916ebbbfee6e945d8157008b5e7fbc','2026-04-20 14:05:22'),(26,18,'268a8f25524a3fe07e987efeb3d85e0bfb4d16f257e2a86172b43fe704623ba4e51973e790b8b0609d217d4ab9f8e07f02bb2d810bbe4df1a304081cdd4e67d1','2026-04-20 14:07:50'),(27,18,'f36cfa076527f0e119e3996a9b10c2331e60426acc276417580a4ee6c135490d4cc98ddae6537148084e943200fa19488c00c959a84132a1f918f3dac863ec90','2026-04-20 20:32:13'),(28,18,'479138acb94b7680ee907cae8d7a418d29157367955edd7d05ab3082223196e9c41f33533404b0e11f221fe20c3a7845144f73f76d8a71ad827b80f85b5c6908','2026-04-20 20:57:09'),(29,21,'fb87064d64ef1ae2be2cd14b31a62fbd9a1e96978e5c6dbf2bb71b058cfafd7d80618b9ad4d18a5e8558337afc29c8d093a3bb3392c0b678784dff11946f291c','2026-04-20 20:59:14'),(30,18,'7d9557f662f2d1fbb91ab86093ef339f0cc2189cf14ac2c20ef38f945d89139a5e8556987cdbc91ee5219a0d95b4c6b2a7a0ce4588c34ca1db02f460ef60a036','2026-04-20 21:27:26'),(31,18,'f8e620273e4ab45418a66bb95c878800b0f63a0f887be536a303c98c12aa2f2f3a39ec26c9b52c232b609beac700f2b6774ae53e0060fd347230450ed463b315','2026-04-21 14:29:06'),(32,18,'d0f0f0e2bff7128cb77a3646d302b290cc296d2ba7ebce623772c34636f16aef59c390484a89a2af62e687da030955c644939a773d3fb4cbfaeabe709b79ef65','2026-04-21 14:34:26'),(33,18,'ca919a277969891e5afbef1f8afe0cb3b21a9629672ea30f8ffdb8915ddf22b602a4cb77b9b628d9e8284a37890f399348469edd7b402d6906bedd835cae21bb','2026-04-21 14:35:03'),(34,18,'fb1a869386ef3de9041163022979de55e57131abd307682165f663e402dafe03252f0ef7293b262fd82c56fcdd8183906854199c18451ca7e48675b7a98af854','2026-04-21 15:02:54'),(35,18,'2d0e84a5d4b0229ee98e727a7d532ccac5438545ed2d2ff05acc381b89c9a73a2dd73315e861bf73ccdfb6ada0d36561edcaf9d85b32ceb2fdfd190dbb33ccce','2026-04-21 15:28:13'),(36,18,'6bfd636b3905e6fbf17481c0873bffe91b731baa61bd1567820ad9ad1de4af29f689472be71de5f80e452461806699e79c73caf9ceb1d9d63272bea01a288e6b','2026-04-21 17:30:26'),(38,18,'6b7a981c871a40318f228183d71bcdc06da16954fe2d37cbf332b448175f7ceaa687af3bec17ae47df8b9ee537aa50c0af50051c2bec6a1a1c4aff18f3eee5ea','2026-04-21 18:17:45'),(39,18,'46a52a6e4c1ff79c8c0b08f4bf34615b1cf86002ff5709ecd472aefe8fbdd7ccca729dff802ea5d41e66353789875fbbb145f1de00dfffcb286fca54402b1081','2026-04-21 18:18:57'),(40,18,'5ae86829def2e8440e2280d946e1cde2c47e093e38f969709589b2d90e1aa52f2b721114ff162617d283f9c83638a8eb157d41eae2f9c42769d27cc6e4f383e9','2026-04-21 18:20:23'),(41,18,'ff7ba748f58dc971d5f5cc1eb1709a43710c4eb574d8aa52c5b0c785c573a7f9c27baf72d0bb07b55fcd054d3bf392c21dd7a82ab5aa4ef912cff2f4c39c39a2','2026-04-21 18:21:21'),(42,18,'2b281a82df319075baa91a810bf0d29225ac8435e91e825cc641c7026a04201e96f6b5d99e9f8a079cfe910e3b5d4cab5cd641fe0c8594b5d6fd7dcaaabf521e','2026-04-21 18:24:38'),(76,5,'ed2dad8cdcc37b01177ccd83ace4ef827f3209d4d45947e86b46310d1458eef704119565bf7879998a753c16dcd74636897eb6ff1c72e62c3e339ccf9ddf18d0','2026-04-24 00:53:21'),(77,5,'f262fc011c9ea5d1ccd84e887303f23bdfa6539a37c2638842585d0ec008b88e271c93ef43db072827522ef90a3e5362f78126e44e69bb93036790888c11c9bd','2026-04-24 15:45:46'),(78,5,'0449dc58a95c9a8ff827066769dea089198e9afe42d8087b3b89580ccd867b7a893586db39d47689dd8d9c3d45080cb0bcf8cb43294e89b8a0f121927cfe71ec','2026-04-24 16:10:55'),(88,1,'bc49788771a27f59ef84eea3b759f3d4b2420c68ed58e00ce201bc6d655ac7aec34d41869ca80418cbfcf512daccfa556fb6d8766242084740d83503ea81f117','2026-04-26 23:39:41'),(90,1,'bb7876a18c4072e8855af7f947c5f35b8a3724aae6218ba86a4c8117dad892dd04ebf8f2fc16c9cdcd97fcdca07a1b7cf8cf097850f11bc0d6a93ad75caeb7c7','2026-04-27 00:43:20'),(94,1,'bcf03d53e95b50ca49e9ebc64244b219dbfd95682a40f83a9029bc7742c9f4d28b57f53f12e2f8d127c883eeff3f0bb8f74ea3084ee48e5fa2e6191ae9c6db80','2026-04-27 13:03:19');
/*!40000 ALTER TABLE `refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reports` (
  `id` int NOT NULL AUTO_INCREMENT,
  `project_id` int DEFAULT NULL,
  `student_id` int DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `file_url` varchar(255) DEFAULT NULL,
  `status` enum('en_attente','valide','refuse') DEFAULT 'en_attente',
  `feedback` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  KEY `student_id` (`student_id`),
  KEY `idx_reports_status` (`status`),
  CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `soutenance_jury`
--

DROP TABLE IF EXISTS `soutenance_jury`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `soutenance_jury` (
  `id` int NOT NULL AUTO_INCREMENT,
  `soutenance_id` int DEFAULT NULL,
  `jury_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `soutenance_id` (`soutenance_id`),
  KEY `jury_id` (`jury_id`),
  CONSTRAINT `soutenance_jury_ibfk_1` FOREIGN KEY (`soutenance_id`) REFERENCES `soutenances` (`id`) ON DELETE CASCADE,
  CONSTRAINT `soutenance_jury_ibfk_2` FOREIGN KEY (`jury_id`) REFERENCES `jury_members` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `soutenance_jury`
--

LOCK TABLES `soutenance_jury` WRITE;
/*!40000 ALTER TABLE `soutenance_jury` DISABLE KEYS */;
/*!40000 ALTER TABLE `soutenance_jury` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `soutenances`
--

DROP TABLE IF EXISTS `soutenances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `soutenances` (
  `id` int NOT NULL AUTO_INCREMENT,
  `project_id` int DEFAULT NULL,
  `date` date DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `status` enum('planifie','termine') DEFAULT 'planifie',
  PRIMARY KEY (`id`),
  UNIQUE KEY `project_id` (`project_id`),
  CONSTRAINT `soutenances_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `soutenances`
--

LOCK TABLES `soutenances` WRITE;
/*!40000 ALTER TABLE `soutenances` DISABLE KEYS */;
/*!40000 ALTER TABLE `soutenances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `students` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `student_code` varchar(50) DEFAULT NULL,
  `group_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (1,1,'1168','topGTeam');
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tutors`
--

DROP TABLE IF EXISTS `tutors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tutors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `specialty` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `tutors_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tutors`
--

LOCK TABLES `tutors` WRITE;
/*!40000 ALTER TABLE `tutors` DISABLE KEYS */;
INSERT INTO `tutors` VALUES (1,5,'controle');
/*!40000 ALTER TABLE `tutors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','tutor','coordinator','jury') NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `cin` int DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `tel` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `cin` (`cin`),
  UNIQUE KEY `cin_2` (`cin`),
  UNIQUE KEY `tel` (`tel`),
  KEY `idx_user_role` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Jebali Baha Eddine','bahajebali40@gmail.com','$2y$12$EOauPZg6X.RidrfXzI8Pmuok.Dg/evfTxopdj.iE6EzD68qQiGADS','student',NULL,'2026-04-14 21:34:50',NULL,'',NULL),(2,'ahmed salah','ahmedsalah@fstsbz-coord.com','$2y$12$GcTILnTq0r32oiveXhqYqO27zORECOcz3RkIBYjXenHJ3MrqPpP4.','coordinator',NULL,'2026-04-15 00:51:04',NULL,NULL,NULL),(3,'oussema','oussemamouldi59@gmail.com','$2y$12$j6Aegi9hA.3.oV.sbnQHQO9KYkMEnsa42ohgBA8jRP6G/rj.SLaWm','student',NULL,'2026-04-16 18:53:24',NULL,NULL,NULL),(4,'baha','baha@coord.com','$2y$12$E1wkE9J4KX0Ag4Pwo6./S.TWrW.s15BysebiTZxOtGE0SL0WXjSqy','coordinator',NULL,'2026-04-16 19:48:31',NULL,NULL,NULL),(5,'baha','baha@tutor.com','$2y$12$TI1dLzDx6wH3s5cl11W6Y.bm33NzH22sSEGffXot0mUj/aCKYn82C','tutor',NULL,'2026-04-16 19:49:33',NULL,NULL,NULL),(6,'baha','baha@jury','$2y$12$ucHu7NfX0xqOPOzZyAgy/expiF28j7U/YS6l/94txrR/oYml6hYtC','jury',NULL,'2026-04-16 19:49:52',NULL,NULL,NULL);
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

-- Dump completed on 2026-04-20 14:55:45
