-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: gator4166.hostgator.com    Database: salvacer_crediweb
-- ------------------------------------------------------
-- Server version	5.7.23-23

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
-- Table structure for table `cantidad_consultas`
--

DROP TABLE IF EXISTS `cantidad_consultas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cantidad_consultas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `fecha_creado` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cantidad_consultas`
--

LOCK TABLES `cantidad_consultas` WRITE;
/*!40000 ALTER TABLE `cantidad_consultas` DISABLE KEYS */;
/*!40000 ALTER TABLE `cantidad_consultas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `creditos_solicitados`
--

DROP TABLE IF EXISTS `creditos_solicitados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `creditos_solicitados` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `cedula` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `numero` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `correo` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nombre_cliente` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_nacimiento` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `codigo_dactilar` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `credito_aprobado` int(11) DEFAULT NULL,
  `estado` int(11) DEFAULT '1',
  `ip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dispositivo` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_creado` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `creditos_solicitados`
--

LOCK TABLES `creditos_solicitados` WRITE;
/*!40000 ALTER TABLE `creditos_solicitados` DISABLE KEYS */;
/*!40000 ALTER TABLE `creditos_solicitados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `solo_telefonos`
--

DROP TABLE IF EXISTS `solo_telefonos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `solo_telefonos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `codigo` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `terminos` int(11) DEFAULT NULL,
  `ip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dispositivo` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estado` int(11) DEFAULT '1',
  `fecha_creado` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solo_telefonos`
--

LOCK TABLES `solo_telefonos` WRITE;
/*!40000 ALTER TABLE `solo_telefonos` DISABLE KEYS */;
INSERT INTO `solo_telefonos` VALUES (1,'0969786231','6348',1,'186.3.23.2','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36 OPR/106.0.0.0',1,'2024-02-14 12:58:44');
/*!40000 ALTER TABLE `solo_telefonos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'salvacer_crediweb'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-02-25 14:28:49
