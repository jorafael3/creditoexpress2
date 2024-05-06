-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: crediweb
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.27-MariaDB

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
  `numero` varchar(20) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `fecha_creado` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cantidad_consultas`
--

LOCK TABLES `cantidad_consultas` WRITE;
/*!40000 ALTER TABLE `cantidad_consultas` DISABLE KEYS */;
INSERT INTO `cantidad_consultas` VALUES (1,'0969786231',1,'2024-02-25 15:14:32'),(2,'0969786231',1,'2024-02-25 23:03:51');
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
  `cedula` varchar(20) DEFAULT NULL,
  `numero` varchar(20) DEFAULT NULL,
  `correo` varchar(200) DEFAULT NULL,
  `nombre_cliente` varchar(200) DEFAULT NULL,
  `fecha_nacimiento` varchar(50) DEFAULT NULL,
  `codigo_dactilar` varchar(20) DEFAULT NULL,
  `credito_aprobado` int(11) DEFAULT NULL,
  `estado` int(11) DEFAULT 1,
  `ip` varchar(20) DEFAULT NULL,
  `dispositivo` varchar(500) DEFAULT NULL,
  `fecha_creado` datetime NOT NULL DEFAULT current_timestamp(),
  `cedula_encr` varchar(1000) DEFAULT NULL,
  `estado_encr` int(11) DEFAULT 1,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `creditos_solicitados`
--

LOCK TABLES `creditos_solicitados` WRITE;
/*!40000 ALTER TABLE `creditos_solicitados` DISABLE KEYS */;
INSERT INTO `creditos_solicitados` VALUES (14,'0931531115','0969786231','','ALVARADO ESPINOZA JORGE RAFAEL','12/4/1994','E3343I4242',1,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36 OPR/107.0.0.0','2024-02-25 22:29:27','2VFW/nF5o5uM1yKcWtDWFcHQcGscwHz9jbG82uF0O84=\r\n',0);
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
  `numero` varchar(20) DEFAULT NULL,
  `codigo` varchar(10) DEFAULT NULL,
  `terminos` int(11) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `dispositivo` varchar(500) DEFAULT NULL,
  `estado` int(11) DEFAULT 1,
  `fecha_creado` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solo_telefonos`
--

LOCK TABLES `solo_telefonos` WRITE;
/*!40000 ALTER TABLE `solo_telefonos` DISABLE KEYS */;
INSERT INTO `solo_telefonos` VALUES (4,'0969786231','9709',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36 OPR/107.0.0.0',0,'2024-02-25 22:28:59'),(5,'0969786231','2190',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36 OPR/107.0.0.0',0,'2024-02-25 22:30:42'),(6,'0969786231','5526',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36 OPR/107.0.0.0',0,'2024-02-25 22:31:49'),(7,'0969786231','3012',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36 OPR/107.0.0.0',1,'2024-02-25 22:32:32');
/*!40000 ALTER TABLE `solo_telefonos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'crediweb'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-02-26 13:58:58
