-- MySQL dump 10.13  Distrib 8.0.45, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: CVVEN
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Table structure for table `Chambre`
--

DROP TABLE IF EXISTS `Chambre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Chambre` (
  `chamb_id` varchar(50) NOT NULL,
  `chamb_emplacement` varchar(50) NOT NULL,
  `chamb_numero` int(11) NOT NULL,
  `chamb_remarque` varchar(255) DEFAULT NULL,
  `type_id` int(11) NOT NULL,
  PRIMARY KEY (`chamb_id`),
  UNIQUE KEY `chamb_numero` (`chamb_numero`),
  KEY `type_id` (`type_id`),
  CONSTRAINT `Chambre_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `Type_Chambre` (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Chambre`
--

LOCK TABLES `Chambre` WRITE;
/*!40000 ALTER TABLE `Chambre` DISABLE KEYS */;
INSERT INTO `Chambre` VALUES ('DBL001','Aile B',201,NULL,2),('DBL002','Aile B',202,NULL,2),('DBL003','Aile B',203,NULL,2),('DBL004','Aile B',204,NULL,2),('DBL005','Aile B',205,NULL,2),('DBL006','Aile B',206,NULL,2),('DBL007','Aile B',207,NULL,2),('DBL008','Aile B',208,NULL,2),('DBL009','Aile B',209,NULL,2),('DBL010','Aile B',210,NULL,2),('DBL011','Aile B',211,NULL,2),('DBL012','Aile B',212,NULL,2),('DBL013','Aile B',213,NULL,2),('DBL014','Aile B',214,NULL,2),('DBL015','Aile B',215,NULL,2),('FAM001','Aile A',101,NULL,1),('FAM002','Aile A',102,NULL,1),('FAM003','Aile A',103,NULL,1),('FAM004','Aile A',104,NULL,1),('FAM005','Aile A',105,NULL,1),('FAM006','Aile A',106,NULL,1),('FAM007','Aile A',107,NULL,1),('FAM008','Aile A',108,NULL,1),('FAM009','Aile A',109,NULL,1),('FAM010','Aile A',110,NULL,1),('FAM011','Aile A',111,NULL,1),('FAM012','Aile A',112,NULL,1),('FAM013','Aile A',113,NULL,1),('FAM014','Aile A',114,NULL,1),('FAM015','Aile A',115,NULL,1),('FAM016','Aile A',116,NULL,1),('FAM017','Aile A',117,NULL,1),('FAM018','Aile A',118,NULL,1),('FAM019','Aile A',119,NULL,1),('FAM020','Aile A',120,NULL,1),('FAM021','Aile A',121,NULL,1),('FAM022','Aile A',122,NULL,1),('FAM023','Aile A',123,NULL,1),('FAM024','Aile A',124,NULL,1),('FAM025','Aile A',125,NULL,1),('FAM026','Aile A',126,NULL,1),('FAM027','Aile A',127,NULL,1),('FAM028','Aile A',128,NULL,1),('FAM029','Aile A',129,NULL,1),('FAM030','Aile A',130,NULL,1),('FAM031','Aile A',131,NULL,1),('FAM032','Aile A',132,NULL,1),('FAM033','Aile A',133,NULL,1),('FAM034','Aile A',134,NULL,1),('FAM035','Aile A',135,NULL,1),('FAM036','Aile A',136,NULL,1),('FAM037','Aile A',137,NULL,1),('FAM038','Aile A',138,NULL,1),('FAM039','Aile A',139,NULL,1),('FAM040','Aile A',140,NULL,1),('PMR001','Aile A',501,'Accès adapté PMR',5),('QDP001','Aile B',401,NULL,4),('QDP002','Aile B',402,NULL,4),('QDP003','Aile B',403,NULL,4),('QDP004','Aile B',404,NULL,4),('QDP005','Aile B',405,NULL,4),('QDP006','Aile B',406,NULL,4),('QDP007','Aile B',407,NULL,4),('QDP008','Aile B',408,NULL,4),('QDP009','Aile B',409,NULL,4),('QDP010','Aile B',410,NULL,4),('QDP011','Aile B',411,NULL,4),('QDP012','Aile B',412,NULL,4),('TRP001','Aile B',301,NULL,3),('TRP002','Aile B',302,NULL,3),('TRP003','Aile B',303,NULL,3),('TRP004','Aile B',304,NULL,3),('TRP005','Aile B',305,NULL,3),('TRP006','Aile B',306,NULL,3),('TRP007','Aile B',307,NULL,3),('TRP008','Aile B',308,NULL,3);
/*!40000 ALTER TABLE `Chambre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Client`
--

DROP TABLE IF EXISTS `Client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Client` (
  `client_id` varchar(20) NOT NULL,
  `client_nom` varchar(100) NOT NULL,
  `client_prenom` varchar(100) NOT NULL,
  `client_email` varchar(150) DEFAULT NULL,
  `client_telephone` varchar(20) DEFAULT NULL,
  `client_adresse` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Client`
--

LOCK TABLES `Client` WRITE;
/*!40000 ALTER TABLE `Client` DISABLE KEYS */;
/*!40000 ALTER TABLE `Client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Reserve`
--

DROP TABLE IF EXISTS `Reserve`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Reserve` (
  `reser_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) NOT NULL,
  `chamb_id` varchar(50) NOT NULL,
  `reser_dateDebut` datetime NOT NULL,
  `reser_dateFin` datetime NOT NULL,
  PRIMARY KEY (`reser_id`),
  KEY `Reserve_ibfk_1` (`user_id`),
  KEY `Reserve_ibfk_2` (`chamb_id`),
  CONSTRAINT `Reserve_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Utilisateur` (`user_id`),
  CONSTRAINT `Reserve_ibfk_2` FOREIGN KEY (`chamb_id`) REFERENCES `Chambre` (`chamb_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Reserve`
--

LOCK TABLES `Reserve` WRITE;
/*!40000 ALTER TABLE `Reserve` DISABLE KEYS */;
INSERT INTO `Reserve` VALUES (14,'USR002','TRP001','2026-03-30 14:00:00','2026-04-03 10:00:00'),(15,'USR002','FAM001','2026-03-30 14:00:00','2026-04-03 10:00:00');
/*!40000 ALTER TABLE `Reserve` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Type_Chambre`
--

DROP TABLE IF EXISTS `Type_Chambre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Type_Chambre` (
  `type_id` int(11) NOT NULL,
  `type_libelle` varchar(50) NOT NULL,
  `type_desc` varchar(500) NOT NULL,
  `type_prix` decimal(10,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`type_id`),
  UNIQUE KEY `type_libelle` (`type_libelle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Type_Chambre`
--

LOCK TABLES `Type_Chambre` WRITE;
/*!40000 ALTER TABLE `Type_Chambre` DISABLE KEYS */;
INSERT INTO `Type_Chambre` VALUES (1,'Logement familial','Entrée, douche et wc, 2 chambres à 2 lits avec coin toilette et balkon',0.00),(2,'Chambre double','Entrée, douche et wc, 1 lit double',0.00),(3,'Chambre 3 lits','3 lits séparés par une cloison mobile avec coin toilette, wc, douche',0.00),(4,'Chambre 4 lits','4 lits séparés par une cloison mobile avec douche, wc et balkon',0.00),(5,'Logement PMR','Logement adapté pour les personnes à mobilité réduite',0.00);
/*!40000 ALTER TABLE `Type_Chambre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Utilisateur`
--

DROP TABLE IF EXISTS `Utilisateur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Utilisateur` (
  `user_id` varchar(50) NOT NULL,
  `user_login` varchar(150) NOT NULL,
  `user_nom` varchar(255) NOT NULL,
  `user_prenom` varchar(255) NOT NULL,
  `user_mail` varchar(255) NOT NULL,
  `user_telephone` varchar(14) NOT NULL,
  `user_mdp` varchar(255) NOT NULL,
  `user_role` enum('client','personnel','administrateur') NOT NULL DEFAULT 'client',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_login` (`user_login`),
  UNIQUE KEY `user_mail` (`user_mail`),
  UNIQUE KEY `user_telephone` (`user_telephone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Utilisateur`
--

LOCK TABLES `Utilisateur` WRITE;
/*!40000 ALTER TABLE `Utilisateur` DISABLE KEYS */;
INSERT INTO `Utilisateur` VALUES ('USR001','utest','user','user','usertest@test.com','0162626568','$2y$10$Da1WDjrvdIdhDalOxNvlj.p.m1Eaa.lV3hqrmIEbSONtOELTGy6SG','client'),('USR002','aadmin','admin','admin','admintest@test.com','0162626598','$2y$10$OQVCGXvfT7ZZ6.OeRCFhF.tq9hdNx4qfViAJnuPYd1G/fmwdlZOBe','administrateur'),('USR003','jdupont','dupont','jean','jeandupont@test.com','016298971','$2y$10$zp77GR4NXN0.toLdqDWJcOJGkrue3cs4TLtwX9HiyAufqqAeSxho2','client');
/*!40000 ALTER TABLE `Utilisateur` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-09 20:09:26
