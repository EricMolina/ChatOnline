CREATE DATABASE  IF NOT EXISTS `db_chatonline` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `db_chatonline`;
-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: db_chatonline
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.28-MariaDB

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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user_sender` int(11) DEFAULT NULL,
  `id_user_receiver` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user_sender` (`id_user_sender`),
  KEY `id_user_receiver` (`id_user_receiver`),
  CONSTRAINT `friend_request_ibfk_1` FOREIGN KEY (`id_user_sender`) REFERENCES `user` (`id`),
  CONSTRAINT `friend_request_ibfk_2` FOREIGN KEY (`id_user_receiver`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user1` int(11) DEFAULT NULL,
  `id_user2` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user1` (`id_user1`),
  KEY `id_user2` (`id_user2`),
  CONSTRAINT `friend_ship_ibfk_1` FOREIGN KEY (`id_user1`) REFERENCES `user` (`id`),
  CONSTRAINT `friend_ship_ibfk_2` FOREIGN KEY (`id_user2`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friend_ship`
--

LOCK TABLES `friend_ship` WRITE;
/*!40000 ALTER TABLE `friend_ship` DISABLE KEYS */;
INSERT INTO `friend_ship` VALUES (1,1,2),(2,1,3),(3,3,4),(4,2,4);
/*!40000 ALTER TABLE `friend_ship` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` longtext DEFAULT NULL,
  `image` longtext DEFAULT NULL,
  `date` datetime DEFAULT current_timestamp(),
  `id_friendship` int(11) DEFAULT NULL,
  `id_user_sender` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_friendship` (`id_friendship`),
  KEY `id_user_sender` (`id_user_sender`),
  CONSTRAINT `message_ibfk_1` FOREIGN KEY (`id_friendship`) REFERENCES `friend_ship` (`id`),
  CONSTRAINT `message_ibfk_2` FOREIGN KEY (`id_user_sender`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message`
--

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
INSERT INTO `message` VALUES (2,'hola ricard',NULL,'2024-01-11 16:59:40',1,1),(3,'hola eric',NULL,'2024-01-11 16:59:43',1,2),(4,'que tal todo?',NULL,'2024-01-11 16:59:46',1,2),(5,'todo bien!!! mira donde me fuí el otro día',NULL,'2024-01-11 16:59:54',1,1),(6,'Precioso, no?','./img/chats/4548cfc1-d1f9-48ff-87e8-d98d35fc1cfe_65a01082748a8.png','2024-01-11 17:00:02',1,1),(7,'wow!!! se ve increíble!',NULL,'2024-01-11 17:00:09',1,2),(8,'yo aproveché para ir al zoo!','./img/chats/inicio_65a010988e4fd.png','2024-01-11 17:00:24',1,2),(9,':000 con animalitos??',NULL,'2024-01-11 17:00:32',1,1),(10,'si :)',NULL,'2024-01-11 17:00:36',1,2),(11,'jeje nice',NULL,'2024-01-11 17:00:58',1,1),(12,'jeje',NULL,'2024-01-11 17:01:00',1,2),(13,'Hola, Eric.',NULL,'2024-01-11 17:02:53',2,3),(14,'Hola Alberto! ¿Qué tal tu día?',NULL,'2024-01-11 17:03:05',2,1),(15,'No estoy para tonterías, Eric. ',NULL,'2024-01-11 17:03:12',2,3),(16,'Te escribo para avisarte de que estás expulsado de la escuela.',NULL,'2024-01-11 17:03:26',2,3),(17,'¿C',NULL,'2024-01-11 17:03:29',2,1),(18,'¿Cómo?? Porque???',NULL,'2024-01-11 17:03:36',2,1),(19,'Lo siento. Hemos detectado que... estás hackeando el A.D. de nuestros sistemas y estás intentando hacer inyecciones.',NULL,'2024-01-11 17:04:13',2,3),(20,'Me habéis pillado... pero nunca me cogeréis con vida!! >:D','./img/chats/istockphoto-962366210-612x612_65a011a2efcde.jpg','2024-01-11 17:04:50',2,1),(21,'No huyas!!!!',NULL,'2024-01-11 17:04:58',2,3),(22,'Alberto!! Sabes si mañana se trabaja?',NULL,'2024-01-11 17:05:51',3,4),(23,'Que estoy cansado ya de estos críos de DAW2... Jajajaja',NULL,'2024-01-11 17:06:00',3,4),(24,'Hola Fatima!!! No... Por desgracia no, el claustro ha cancelado todas las festividades :(',NULL,'2024-01-11 17:06:34',3,3),(25,':(','./img/chats/768px-Face-sad.svg_65a01223543f6.png','2024-01-11 17:06:59',3,3),(26,'Enserio???',NULL,'2024-01-11 17:07:05',3,4),(27,'Vaya...',NULL,'2024-01-11 17:07:07',3,4),(28,'H-hola fatima...',NULL,'2024-01-11 17:08:44',4,2),(29,'te he escrito esto :)','./img/chats/Captura de pantalla 2024-01-11 170908_65a012b6e3ed9.png','2024-01-11 17:09:26',4,2),(30,'Hola ricard!',NULL,'2024-01-11 17:09:47',4,4),(31,'¿CÓMO????',NULL,'2024-01-11 17:09:51',4,4),(32,'Te voy a decir la verdad...',NULL,'2024-01-11 17:09:58',4,4),(33,'No pienso consentir estas barbaridades.',NULL,'2024-01-11 17:10:16',4,4),(34,'P-pero... Fatima... No me hagas esto :(',NULL,'2024-01-11 17:10:25',4,2),(35,'Te llevas un parte.',NULL,'2024-01-11 17:11:27',4,4),(36,'...',NULL,'2024-01-11 17:11:29',4,2),(37,'El otro día me fui de viaje a los pirineos!','./img/chats/188778 (720p)_65a0145b8bad4.mp4','2024-01-11 17:16:27',3,4),(38,'wow! que bonito :)',NULL,'2024-01-11 17:16:46',3,3),(39,'Pero ahora, a trabajar, que no son horas.',NULL,'2024-01-11 17:16:54',3,3),(40,'vaaaalee.... :(',NULL,'2024-01-11 17:16:59',3,4);
/*!40000 ALTER TABLE `message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `pwd` longtext DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'emolina','Eric Molina Molina','$2y$10$VOjh5Ni0b6ODMWCnHsRdOuXw/bgqa7n6nFcVb.ohvItUIpbLuiThy'),(2,'rcasals','Ricard Casals Dorador','$2y$10$RgrwqJdk863vRn34.RRG/.swIoW7VYgfJEPCkjNf7xhXdEGI1Ivy2'),(3,'asantos','Alberto De Santos','$2y$10$i89O8H1JbcybvyWGCjhDce1nXTP0cDNLOIAjKdLQQ0nTUjA5pDKw2'),(4,'fmartinez','Fatima Martinez','$2y$10$M9h695SIm2K3ItqChCmH4usRPc01m8iZp4QUTGrWq8sS/nPzFhSy.');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'db_chatonline'
--

--
-- Dumping routines for database 'db_chatonline'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-01-11 17:19:06
