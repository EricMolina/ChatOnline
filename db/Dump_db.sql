-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: db_chatonline
-- ------------------------------------------------------
-- Server version	8.0.34

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
-- Table structure for table `friend_request`
--

DROP TABLE IF EXISTS `friend_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `friend_request` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user_sender` int DEFAULT NULL,
  `id_user_receiver` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user_sender` (`id_user_sender`),
  KEY `id_user_receiver` (`id_user_receiver`),
  CONSTRAINT `friend_request_ibfk_1` FOREIGN KEY (`id_user_sender`) REFERENCES `user` (`id`),
  CONSTRAINT `friend_request_ibfk_2` FOREIGN KEY (`id_user_receiver`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friend_request`
--

LOCK TABLES `friend_request` WRITE;
/*!40000 ALTER TABLE `friend_request` DISABLE KEYS */;
/*!40000 ALTER TABLE `friend_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `friend_ship`
--

DROP TABLE IF EXISTS `friend_ship`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `friend_ship` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user1` int DEFAULT NULL,
  `id_user2` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user1` (`id_user1`),
  KEY `id_user2` (`id_user2`),
  CONSTRAINT `friend_ship_ibfk_1` FOREIGN KEY (`id_user1`) REFERENCES `user` (`id`),
  CONSTRAINT `friend_ship_ibfk_2` FOREIGN KEY (`id_user2`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friend_ship`
--

LOCK TABLES `friend_ship` WRITE;
/*!40000 ALTER TABLE `friend_ship` DISABLE KEYS */;
INSERT INTO `friend_ship` VALUES (22,18,17),(23,19,18);
/*!40000 ALTER TABLE `friend_ship` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `message` (
  `id` int NOT NULL AUTO_INCREMENT,
  `content` longtext COLLATE utf8mb4_bin,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  `id_friendship` int DEFAULT NULL,
  `id_user_sender` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_friendship` (`id_friendship`),
  KEY `id_user_sender` (`id_user_sender`),
  CONSTRAINT `message_ibfk_1` FOREIGN KEY (`id_friendship`) REFERENCES `friend_ship` (`id`),
  CONSTRAINT `message_ibfk_2` FOREIGN KEY (`id_user_sender`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message`
--

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
INSERT INTO `message` VALUES (92,'ola','2023-11-13 15:10:56',22,18),(93,'Holaaa ??????','2023-11-13 15:11:04',22,17),(94,'Heeey amigo! ??','2023-11-13 15:11:18',22,18),(95,'Te acuerdas cuando... Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia, molestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum numquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium ','2023-11-13 15:11:27',22,17),(96,'Por lo tanto, hermanos, ustedes que han sido santificados y que tienen parte en el mismo llamamiento celestial, consideren a Jesús, apóstol y sumo sacerdote de la fe que profesamos.  Él fue fiel al que lo nombró, como lo fue también Moisés en t','2023-11-13 15:11:55',22,18),(97,'Amén hermano!!! ?????','2023-11-13 15:12:01',22,17),(98,'Problemas de caché bro ?','2023-11-13 15:13:02',22,18),(99,'¿Qué ocurria?','2023-11-13 15:13:06',22,17),(100,'El Alberto me habia bloqueado la MAC... ','2023-11-13 15:13:21',22,18),(101,'Hola, Ricard. Que sepas que has hecho un trabajo NEFASTO. Eric Ha hecho mucho mejor trabajo que tu!!','2023-11-13 15:14:12',23,19),(102,'NOOOO, Alberto tengo hijos por favor...','2023-11-13 15:14:29',23,18),(103,'Lo siento, Ricard. Estás suspendido ??','2023-11-13 15:14:39',23,19),(104,'??????','2023-11-13 15:14:53',23,18),(105,'</div> </div>','2023-11-13 15:15:23',23,19),(106,'veo que funciona bien... Te voy a aprobar, pero raspadito.','2023-11-13 15:15:37',23,19),(107,'Agradecido con el de arriba, gracias senpai ?','2023-11-13 15:16:14',23,18);
/*!40000 ALTER TABLE `message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(20) COLLATE utf8mb4_bin DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `pwd` longtext COLLATE utf8mb4_bin,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (17,'emolina','Eric Molina Molina','$2y$10$1vmeaXwP38/Ob4tWxglFuOO7T3Zt1c9Pv1z6cQnlVmRZJNWiPe3K6'),(18,'ricardcasals','Ricard Casals','$2y$10$i9ntRVpBC8e8UvyIEKdC6.IE9kYNXurwjThFIMabo2UqX5fHNmQtK'),(19,'adesantos','Alberto De Santos','$2y$10$FR/viwRWaObPLM.Ha046vOxFEVzlEB6r8C9aZUDAKCWapOrEj1rEi');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-11-13 15:22:58
