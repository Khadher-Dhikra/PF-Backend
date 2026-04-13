-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               12.2.2-MariaDB - MariaDB Server
-- Server OS:                    Win64
-- HeidiSQL Version:             12.14.0.7165
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping data for table pf_db.coordinateurs: ~1 rows (approximately)
INSERT INTO `coordinateurs` (`id`, `nom`, `email`, `password`, `created_at`, `token`) VALUES
	(1, 'Dhikra Khadher', 'dhikra.khadher@gmail.com', '$2y$10$eNffvengU9DqwB0rQZ5iqulT3VvKc/d2qTDUKN0gCPH7JmzbKbC8G', '2026-04-05 15:16:01', '781fe36b1988c53383e38704d4e7858cfb6a2e89b3a16bec07ea40e6ec86fedb');

-- Dumping data for table pf_db.etudiant: ~0 rows (approximately)

-- Dumping data for table pf_db.password_resets: ~0 rows (approximately)
INSERT INTO `password_resets` (`id`, `user_id`, `token_hash`, `expires_at`, `used`, `created_at`) VALUES
	(1, 6, '$2y$10$sZLvXoGkxOzdOUXbDlZLp.igaGb6dIYr8KnwqgSYAHk4UVDh6HOFO', '2026-04-05 15:28:04', 1, '2026-04-05 13:28:04');

-- Dumping data for table pf_db.propositions: ~0 rows (approximately)

-- Dumping data for table pf_db.users: ~4 rows (approximately)
INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `role`) VALUES
	(5, 'baha jebali', 'bahajebali40@gmail.com', '$2y$12$H8QS/ftpSOieOfC5M8mZEuuF3fCsMU2CPYlT5.BLACtL4nMyGH5X6', '2026-03-27 15:56:02', 'etudiant'),
	(6, 'Dhikra khadher ', 'dhikra.khadher@gmail.com', '$2y$10$K0HkwNIUx54q7TDXfslMXuydcnIZyGN/TCp9EWmRUtHC8BlUpRire', '2026-04-01 08:34:36', 'etudiant'),
	(7, 'Wael', 'wael@gmail.com', '$2y$10$A7kW8upF.lLmkeyRXatcKukU8RkF1TAzl8Cbt19UhPdwFrIezE66W', '2026-04-01 09:30:13', 'etudiant'),
	(8, 'asma saadouli', 'asma@gmail.com', '$2y$10$okLKCi2cWg6VhG7tz79.4eNGJI7HYNWm4K3MAD6rxM.8bd6a/9tEy', '2026-04-05 13:35:04', 'etudiant');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
