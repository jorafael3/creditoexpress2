-- MySQL dump 10.13  Distrib 5.5.62, for Win64 (AMD64)
--
-- Host: 50.87.184.179    Database: wsoqajmy_crediweb
-- ------------------------------------------------------
-- Server version	5.7.23-23

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cantidad_consultas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `fecha_creado` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cantidad_consultas`
--

LOCK TABLES `cantidad_consultas` WRITE;
/*!40000 ALTER TABLE `cantidad_consultas` DISABLE KEYS */;
INSERT INTO `cantidad_consultas` VALUES (21,'0993245543',1,'2024-03-10 22:24:01'),(22,'0993245543',1,'2024-03-10 23:30:27'),(23,'0985458618',1,'2024-03-11 10:33:22'),(24,'0967479760',1,'2024-03-11 14:21:47'),(25,'0988488258',1,'2024-03-11 16:49:23'),(26,'0999390035',1,'2024-03-11 17:35:49'),(27,'0990383315',1,'2024-03-11 18:06:56'),(28,'0999390035',1,'2024-03-12 14:10:14'),(29,'0999390035',1,'2024-03-12 14:37:53'),(30,'0969786231',1,'2024-03-12 21:56:53'),(31,'0969786231',1,'2024-03-12 21:57:01'),(32,'0989401304',1,'2024-03-13 08:29:32'),(33,'0969786231',1,'2024-03-13 11:25:45'),(34,'0993457861',1,'2024-03-13 16:09:29'),(35,'0989560773',1,'2024-03-13 16:16:56'),(36,'0959901576',1,'2024-03-13 17:09:58'),(37,'0986057143',1,'2024-03-13 19:23:58'),(38,'0999333913',1,'2024-03-13 20:45:34'),(39,'0990667028',1,'2024-03-13 21:38:54'),(40,'0982757197',1,'2024-03-13 22:37:15'),(41,'0989596991',1,'2024-03-14 08:54:27'),(42,'0986115508',1,'2024-03-14 09:17:31'),(43,'0969786231',1,'2024-03-14 15:20:36'),(44,'0969786231',1,'2024-03-14 15:22:10'),(45,'0969786231',1,'2024-03-14 15:44:05'),(46,'0969786231',1,'2024-03-14 15:45:01'),(47,'0991441686',1,'2024-03-14 20:01:10'),(48,'0989000380',1,'2024-03-14 21:07:43'),(49,'0999390035',1,'2024-03-15 07:30:05'),(50,'0993245543',1,'2024-04-27 10:10:07'),(51,'0969786231',1,'2024-05-05 21:44:59'),(52,'0969786231',1,'2024-05-05 21:46:47'),(53,'0969786231',1,'2024-05-05 21:48:37'),(54,'0969786231',1,'2024-05-05 21:49:34'),(55,'0969786231',1,'2024-05-05 21:55:21'),(56,'0969786231',1,'2024-05-05 21:57:31'),(57,'0969786231',1,'2024-05-05 22:00:52'),(58,'0969786231',1,'2024-05-05 22:01:04'),(59,'0969786231',1,'2024-05-05 22:02:50'),(60,'0969786231',1,'2024-05-05 22:03:00'),(61,'0969786231',1,'2024-05-05 22:04:06'),(62,'0969786231',1,'2024-05-05 22:04:32'),(63,'0969786231',1,'2024-05-05 23:11:52'),(64,'0969786231',1,'2024-05-05 23:12:14'),(65,'0969786231',1,'2024-05-06 07:57:21'),(66,'0969786231',1,'2024-05-06 07:58:00'),(67,'0969786231',1,'2024-05-06 08:01:37'),(68,'0969786231',1,'2024-05-06 08:02:12'),(69,'0969786231',1,'2024-05-06 08:16:21'),(70,'0969786231',1,'2024-05-07 16:16:48'),(71,'0969786231',1,'2024-05-07 21:21:40'),(72,'0969786231',1,'2024-05-07 21:21:54'),(73,'0969786231',1,'2024-05-07 21:22:10'),(74,'0969786231',1,'2024-05-07 21:23:07'),(75,'0969786231',1,'2024-05-08 21:45:36'),(76,'0969786231',1,'2024-05-09 07:39:52'),(77,'0969786231',1,'2024-05-09 07:43:11');
/*!40000 ALTER TABLE `cantidad_consultas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `creditos_solicitados`
--

DROP TABLE IF EXISTS `creditos_solicitados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `creditos_solicitados` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_UNICO` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cedula` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `numero` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `correo` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nombre_cliente` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_nacimiento` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `codigo_dactilar` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estado_civil` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `localidad` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estado` int(11) DEFAULT '1',
  `EST_REGISTRO` int(11) DEFAULT '0',
  `ip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dispositivo` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_creado` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cedula_encr` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estado_encr` int(11) DEFAULT '1',
  `ruta_archivo` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `terminos` int(11) DEFAULT '1',
  `API_SOL_codigo` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `API_SOL_descripcion` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `API_SOL_eserror` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `API_SOL_idSesion` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `API_SOL_secuencial` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `API_SOL_campania` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `API_SOL_identificacion` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `API_SOL_lote` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `API_SOL_montoMaximo` float DEFAULT NULL,
  `API_SOL_nombreCampania` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `API_SOL_plazoMaximo` float DEFAULT NULL,
  `API_SOL_promocion` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `API_SOL_segmentoRiesgo` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `API_SOL_subLote` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `credito_aprobado` int(11) DEFAULT NULL,
  `credito_aprobado_texto` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `API_SOL_ESTADO` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `creditos_solicitados`
--

LOCK TABLES `creditos_solicitados` WRITE;
/*!40000 ALTER TABLE `creditos_solicitados` DISABLE KEYS */;
INSERT INTO `creditos_solicitados` VALUES (17,'202405090805390931531115','0931531115','0969786231','jalvaradoe3@gmail.com','ALVARADO ESPINOZA JORGE RAFAEL','12/4/1994','E3343I4242','SOLTERO','GUAYAQUIL',1,0,'186.3.23.2','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36 OPR/107.0.0.0','2024-05-09 07:40:39','2VFW/nF5o5uM1yKcWtDWFcHQcGscwHz9jbG82uF0O84=\r\n',0,NULL,1,'200','Transacción procesada',NULL,'1','503','','','',0,'',0,'','','',0,'RECHAZADO',1),(18,'202405090805280931531115','0931531115','0969786231','jalvaradoe3@gmail.com','ALVARADO ESPINOZA JORGE RAFAEL','12/4/1994','E3343I4242','SOLTERO','GUAYAQUIL',1,0,'186.3.23.2','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36 OPR/107.0.0.0','2024-05-09 07:42:28','2VFW/nF5o5uM1yKcWtDWFcHQcGscwHz9jbG82uF0O84=\r\n',0,NULL,1,'200','Transacción procesada',NULL,'1','504','','','',0,'',0,'','','',0,'RECHAZADO',1);
/*!40000 ALTER TABLE `creditos_solicitados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incidencias`
--

DROP TABLE IF EXISTS `incidencias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `incidencias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ERROR_TYPE` varchar(100) DEFAULT NULL,
  `ERROR_CODE` varchar(100) DEFAULT NULL,
  `ERROR_TEXT` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incidencias`
--

LOCK TABLES `incidencias` WRITE;
/*!40000 ALTER TABLE `incidencias` DISABLE KEYS */;
INSERT INTO `incidencias` VALUES (46,'2024-04-30 09:38:41','ENCRIP','','ERROR AL OBTERN CEDULA ENCRIPTADA'),(47,'2024-05-04 09:37:12','ENCRIP','','ERROR AL OBTERN CEDULA ENCRIPTADA'),(48,'2024-05-04 09:38:06','ENCRIP','','ERROR AL OBTERN CEDULA ENCRIPTADA'),(49,'2024-05-04 09:38:53','ENCRIP','','ERROR AL OBTERN CEDULA ENCRIPTADA'),(50,'2024-05-04 09:40:58','ENCRIP','','ERROR AL OBTERN CEDULA ENCRIPTADA'),(51,'2024-05-05 21:45:37','ERROR DATOS_API_REGISTRO','\"DATOS_API_REGISTRO\"','\"ERROR EN RESPUESTA\"'),(52,'2024-05-05 21:45:54','ERROR DATOS_API_REGISTRO','\"DATOS_API_REGISTRO\"','\"ERROR EN RESPUESTA\"'),(53,'2024-05-05 21:46:25','ERROR DATOS_API_REGISTRO','\"DATOS_API_REGISTRO\"','\"ERROR EN RESPUESTA\"'),(54,'2024-05-05 21:49:53','ERROR DATOS_API_REGISTRO','\"DATOS_API_REGISTRO\"','\"ERROR EN RESPUESTA\"'),(55,'2024-05-05 21:59:59','ERROR DATOS_API_REGISTRO','\"DATOS_API_REGISTRO\"','\"ERROR EN RESPUESTA\"'),(56,'2024-05-05 23:00:47','ENCRIP','\"\"','\"ERROR AL OBTENER CEDULA ENCRIPTADA\"'),(57,'2024-05-05 23:02:18','ENCRIP','\"\"','\"ERROR AL OBTENER CEDULA ENCRIPTADA\"'),(58,'2024-05-05 23:04:51','ENCRIP','\"\"','\"ERROR AL OBTENER CEDULA ENCRIPTADA\"'),(59,'2024-05-05 23:05:24','ENCRIP','\"\"','\"ERROR AL OBTENER CEDULA ENCRIPTADA\"'),(60,'2024-05-06 08:05:24','ERROR DATOS_API_REGISTRO','\"DATOS_API_REGISTRO\"','\"ERROR EN RESPUESTA\"'),(61,'2024-05-06 08:07:12','ERROR DATOS_API_REGISTRO','\"DATOS_API_REGISTRO\"','\"ERROR EN RESPUESTA\"'),(62,'2024-05-06 08:15:59','ERROR DATOS_API_REGISTRO','\"DATOS_API_REGISTRO\"','\"ERROR EN RESPUESTA\"');
/*!40000 ALTER TABLE `incidencias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parametros`
--

DROP TABLE IF EXISTS `parametros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parametros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `texto` varchar(100) DEFAULT NULL,
  `valor` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parametros`
--

LOCK TABLES `parametros` WRITE;
/*!40000 ALTER TABLE `parametros` DISABLE KEYS */;
INSERT INTO `parametros` VALUES (1,'API_BANCO_SOL',504);
/*!40000 ALTER TABLE `parametros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `solo_telefonos`
--

DROP TABLE IF EXISTS `solo_telefonos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solo_telefonos`
--

LOCK TABLES `solo_telefonos` WRITE;
/*!40000 ALTER TABLE `solo_telefonos` DISABLE KEYS */;
INSERT INTO `solo_telefonos` VALUES (1,'0993245543','9745',1,'179.49.32.247','Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:123.0) Gecko/20100101 Firefox/123.0',1,'2024-03-10 22:22:59'),(2,'0985458618','1708',1,'181.199.61.104','Mozilla/5.0 (Linux; Android 9; moto g(6) Build/PPS29.118-15-11-16; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.105 Mobile Safari/537.36[FBAN/EMA;FBLC/es_ES;FBAV/397.0.0.11.117;]',1,'2024-03-11 10:31:45'),(3,'0988894573','9146',1,'157.100.60.215','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',1,'2024-03-11 11:31:54'),(5,'0994457428','8654',1,'190.63.120.176','Mozilla/5.0 (Linux; Android 12; Infinix X669D Build/SP1A.210812.016; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.105 Mobile Safari/537.36[FBAN/EMA;FBLC/es_ES;FBAV/397.0.0.11.117;]',0,'2024-03-11 12:05:21'),(6,'0994457428','3710',1,'190.63.120.176','Mozilla/5.0 (Linux; Android 12; Infinix X669D Build/SP1A.210812.016; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.105 Mobile Safari/537.36[FBAN/EMA;FBLC/es_ES;FBAV/397.0.0.11.117;]',0,'2024-03-11 12:08:00'),(7,'0994457428','3849',1,'190.63.120.176','Mozilla/5.0 (Linux; Android 12; Infinix X669D Build/SP1A.210812.016; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.105 Mobile Safari/537.36 [FBAN/EMA;FBLC/es_ES;FBAV/397.0.0.11.117;FB_FW/1;FBDM/DisplayMetrics{density=2.0, width=720, height=1444, scaledDensity=2.0, xdpi=268.941, ydpi=269.373};]',1,'2024-03-11 12:10:04'),(8,'0967479760','1580',1,'200.24.133.196','Mozilla/5.0 (Linux; Android 13; CRT-NX3 Build/HONORCRT-N33; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.102 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/454.1.0.49.104;]',1,'2024-03-11 14:20:52'),(9,'0988488258','5504',1,'200.24.135.4','Mozilla/5.0 (Linux; Android 10; STK-LX3 Build/HUAWEISTK-LX3; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.102 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/454.1.0.49.104;]',1,'2024-03-11 16:48:38'),(10,'0999390035','9275',1,'179.0.42.20','Mozilla/5.0 (Linux; Android 11; Infinix X693 Build/RP1A.200720.011; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.102 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/454.1.0.49.104;] [FB_IAB/FB4A;FBAV/454.1.0.49.104;]',1,'2024-03-11 17:34:22'),(11,'0990383315','9617',1,'181.188.198.58','Mozilla/5.0 (Linux; Android 13; RMX3241 Build/TP1A.220905.001; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.66 Mobile Safari/537.36[FBAN/EMA;FBLC/es_ES;FBAV/397.0.0.11.117;]',1,'2024-03-11 18:05:27'),(12,'0981296747','4532',1,'181.199.63.132','Mozilla/5.0 (Linux; Android 13; RMX3830 Build/TP1A.220624.014; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.102 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/454.1.0.49.104;]',0,'2024-03-11 20:06:57'),(13,'0981296747','7717',1,'181.199.63.132','Mozilla/5.0 (Linux; Android 13; RMX3830 Build/TP1A.220624.014; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.102 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/454.1.0.49.104;]',0,'2024-03-11 20:31:53'),(14,'0991615224','2169',1,'181.199.60.155','Mozilla/5.0 (Linux; Android 13; TECNO KI5q Build/TP1A.220624.014; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.102 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/454.1.0.49.104;]',0,'2024-03-12 07:36:41'),(15,'0991615224','8981',1,'181.199.60.155','Mozilla/5.0 (Linux; Android 13; TECNO KI5q Build/TP1A.220624.014; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.102 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/454.1.0.49.104;] [FB_IAB/FB4A;FBAV/454.1.0.49.104;]',1,'2024-03-12 07:40:12'),(16,'0981296747','4245',1,'190.131.45.159','Mozilla/5.0 (Linux; Android 13; RMX3830 Build/TP1A.220624.014; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.102 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/454.1.0.49.104;]',0,'2024-03-12 08:52:02'),(17,'0981296747','1644',1,'190.131.45.159','Mozilla/5.0 (Linux; Android 13; RMX3830 Build/TP1A.220624.014; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.102 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/454.1.0.49.104;] [FB_IAB/FB4A;FBAV/454.1.0.49.104;]',1,'2024-03-12 08:56:03'),(18,'0960034914','5456',1,'157.100.106.111','Mozilla/5.0 (Linux; Android 13; Infinix X6835B Build/TP1A.220624.014; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.102 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/454.1.0.49.104;]',1,'2024-03-12 13:44:23'),(19,'0982873849','8970',1,'157.100.54.16','Mozilla/5.0 (Linux; Android 13; 220333QAG Build/TKQ1.221114.001; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.102 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/454.1.0.49.104;]',1,'2024-03-12 14:51:14'),(20,'0968990513','7412',1,'191.99.28.165','Mozilla/5.0 (Linux; Android 11; M2004J19C Build/RP1A.200720.011; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.102 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/454.1.0.49.104;]',0,'2024-03-12 15:00:35'),(21,'0991350331','3540',1,'157.100.112.162','Mozilla/5.0 (Linux; Android 12; TECNO LG7n Build/SP1A.210812.016; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.102 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/454.1.0.49.104;]',1,'2024-03-12 15:32:25'),(22,'0967455842','6967',1,'45.239.51.7','Mozilla/5.0 (Linux; Android 12; Infinix X6825 Build/SP1A.210812.016; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.105 Mobile Safari/537.36[FBAN/EMA;FBLC/es_ES;FBAV/398.0.0.13.113;]',1,'2024-03-12 15:33:09'),(23,'0987179531','3961',1,'200.7.246.236','Mozilla/5.0 (Linux; Android 12; TECNO BF7 Build/SP1A.210812.016; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.102 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/454.1.0.49.104;]',0,'2024-03-12 15:48:31'),(24,'0985864260','6970',1,'191.99.93.45','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Mobile Safari/537.36',1,'2024-03-12 15:55:27'),(25,'0987179531','4328',1,'179.0.42.20','Mozilla/5.0 (Linux; Android 12; TECNO BF7 Build/SP1A.210812.016; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.102 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/454.1.0.49.104;]',1,'2024-03-12 16:43:08'),(26,'0981505353','2791',1,'181.199.42.129','Mozilla/5.0 (Linux; Android 13; Infinix X6525 Build/TP1A.220624.014; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.105 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/448.0.0.47.109;]',1,'2024-03-12 16:45:48'),(27,'0968990513','6780',1,'191.99.52.163','Mozilla/5.0 (Linux; Android 11; M2004J19C Build/RP1A.200720.011; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.102 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/454.1.0.49.104;]',1,'2024-03-12 16:48:44'),(28,'0980738978','6389',1,'200.24.133.243','Mozilla/5.0 (Linux; Android 14; SM-A042M Build/UP1A.231005.007; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.105 Mobile Safari/537.36[FBAN/EMA;FBLC/es_LA;FBAV/398.0.0.13.113;]',1,'2024-03-12 18:35:17'),(29,'0959087665','1748',1,'181.199.42.4','Mozilla/5.0 (Linux; Android 13; Infinix X678B Build/TP1A.220624.014; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.102 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/454.1.0.49.104;]',1,'2024-03-12 19:48:04'),(30,'0963250523','3857',1,'177.234.211.214','Mozilla/5.0 (Linux; Android 13; SM-A145M Build/TP1A.220624.014; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.105 Mobile Safari/537.36[FBAN/EMA;FBLC/es_LA;FBAV/397.0.0.11.117;]',1,'2024-03-12 20:18:15'),(31,'0992437810','8543',1,'186.70.248.149','Mozilla/5.0 (Linux; Android 13; SM-A032M Build/TP1A.220624.014; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.105 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/454.1.0.49.104;]',1,'2024-03-12 21:42:17'),(33,'0962992007','8116',1,'186.5.91.141','Mozilla/5.0 (Linux; Android 13; SM-A045M Build/TP1A.220624.014; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.102 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/454.1.0.49.104;]',0,'2024-03-13 00:47:42'),(34,'0985380833','6673',1,'186.5.91.141','Mozilla/5.0 (Linux; Android 13; SM-A045M Build/TP1A.220624.014; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.102 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/454.1.0.49.104;] [FB_IAB/FB4A;FBAV/454.1.0.49.104;]',1,'2024-03-13 00:50:03'),(35,'0989401304','1790',1,'181.199.61.235','Mozilla/5.0 (Linux; Android 13; TECNO LH7n Build/TP1A.220624.014; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.105 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/454.1.0.49.104;]',1,'2024-03-13 08:25:29'),(36,'0988910638','5639',1,'190.110.47.46','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Mobile Safari/537.36',0,'2024-03-13 09:10:14'),(37,'0988910638','9502',1,'190.110.47.46','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Mobile Safari/537.36',0,'2024-03-13 09:12:10'),(38,'0988910638','6765',1,'190.110.47.46','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Mobile Safari/537.36',1,'2024-03-13 09:12:52'),(39,'0969786231','9055',1,'186.3.23.2','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36 OPR/107.0.0.0',0,'2024-03-13 11:25:23'),(40,'0993457861','1705',1,'181.199.61.80','Mozilla/5.0 (Linux; Android 13; M2101K9AG Build/TKQ1.221013.002; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.102 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/454.1.0.49.104;]',1,'2024-03-13 16:07:59'),(41,'0989560773','9891',1,'45.170.46.100','Mozilla/5.0 (Linux; Android 12; TECNO CH7n Build/SP1A.210812.016; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.102 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/454.1.0.49.104;]',1,'2024-03-13 16:15:52'),(42,'0967132948','1040',1,'157.100.110.64','Mozilla/5.0 (Linux; Android 12; Infinix X6827 Build/SP1A.210812.016; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.105 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/454.1.0.49.104;]',1,'2024-03-13 16:21:43'),(43,'0959901576','8557',1,'157.100.55.227','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Mobile Safari/537.36',1,'2024-03-13 17:08:28'),(44,'0986057143','6091',1,'191.99.28.55','Mozilla/5.0 (Linux; Android 12; SM-A315G Build/SP1A.210812.016; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.102 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/454.1.0.49.104;]',1,'2024-03-13 19:22:49'),(45,'0962992007','5331',1,'186.5.91.141','Mozilla/5.0 (Linux; Android 13; SM-A045M Build/TP1A.220624.014; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.102 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/454.1.0.49.104;]',1,'2024-03-13 19:53:45'),(46,'0999333913','4729',1,'190.63.214.108','Mozilla/5.0 (Linux; Android 14; SM-A546E Build/UP1A.231005.007; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.66 Mobile Safari/537.36',1,'2024-03-13 20:43:38'),(47,'0978968322','8275',1,'181.199.61.100','Mozilla/5.0 (Linux; Android 10; M2010J19CG Build/QKQ1.200830.002; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.102 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/454.1.0.49.104;]',1,'2024-03-13 21:33:47'),(48,'0990667028','1710',1,'157.100.64.215','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Mobile Safari/537.36',1,'2024-03-13 21:36:18'),(49,'0982757197','4511',1,'157.100.65.79','Mozilla/5.0 (Linux; Android 12; Infinix X6516 Build/SP1A.210812.001; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.105 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/454.1.0.49.104;]',1,'2024-03-13 22:35:35'),(50,'0989596991','3433',1,'201.183.1.158','Mozilla/5.0 (Linux; Android 11; RMX3231 Build/RP1A.201005.001; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.105 Mobile Safari/537.36[FBAN/EMA;FBLC/es_ES;FBAV/398.0.0.13.113;]',1,'2024-03-14 08:53:28'),(51,'0986115508','8019',1,'157.100.56.19','Mozilla/5.0 (Linux; Android 13; CMA-LX3 Build/HONORCMA-L43CQ; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.105 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/454.1.0.49.104;]',1,'2024-03-14 09:16:45'),(56,'0991441686','3803',1,'190.63.96.230','Mozilla/5.0 (Linux; Android 13; TECNO KJ6 Build/TP1A.220624.014; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.64 Mobile Safari/537.36[FBAN/EMA;FBLC/es_LA;FBAV/398.0.0.13.113;]',1,'2024-03-14 19:59:48'),(57,'0989000380','6088',1,'177.234.195.142','Mozilla/5.0 (Linux; Android 12; TECNO KI5k Build/SP1A.210812.016; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.125 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/455.0.0.44.88;]',1,'2024-03-14 21:06:13'),(58,'0979631162','3420',1,'181.199.63.197','Mozilla/5.0 (Linux; Android 13; SM-A135M Build/TP1A.220624.014; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.119 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/455.0.0.44.88;]',1,'2024-03-14 22:14:11'),(59,'0993420590','8253',1,'181.199.60.147','Mozilla/5.0 (Linux; Android 13; M2101K7BL Build/TP1A.220624.014; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.102 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/454.1.0.49.104;]',1,'2024-03-14 22:29:34'),(60,'0996340737','7275',1,'190.89.128.115','Mozilla/5.0 (Linux; Android 14; SM-S916B Build/UP1A.231005.007; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.102 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/454.1.0.49.104;]',0,'2024-03-14 22:47:30'),(61,'0996340737','7700',1,'190.89.128.115','Mozilla/5.0 (Linux; Android 14; SM-S916B Build/UP1A.231005.007; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.102 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/454.1.0.49.104;]',1,'2024-03-14 22:48:14'),(62,'0985793189','3119',1,'190.63.116.138','Mozilla/5.0 (Linux; Android 13; SAMSUNG SM-A032M Build/TP1A.220624.014; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 SamsungBrowser/7.4 Chrome/122.0.6261.106 Mobile Safari/537.36',1,'2024-03-15 06:02:25'),(63,'0986841133','8767',1,'157.100.105.124','Mozilla/5.0 (Linux; Android 10; SM-A305G Build/QP1A.190711.020; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.125 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/455.0.0.44.88;]',0,'2024-03-15 13:04:24'),(64,'0986841133','2955',1,'157.100.105.124','Mozilla/5.0 (Linux; Android 10; SM-A305G Build/QP1A.190711.020; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.125 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/455.0.0.44.88;]',1,'2024-03-15 13:09:50'),(65,'0989083364','7200',1,'157.100.28.190','Mozilla/5.0 (Linux; Android 13; Infinix X678B Build/TP1A.220624.014; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/122.0.6261.102 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/454.1.0.49.104;]',1,'2024-03-15 14:22:36'),(66,'0969786231','7070',1,'190.155.181.76','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36 OPR/108.0.0.0',0,'2024-04-26 22:14:00'),(67,'0986646800','8790',1,'186.3.180.24','Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:124.0) Gecko/20100101 Firefox/124.0',1,'2024-04-27 10:10:45'),(68,'0969786231','8085',1,'186.3.23.2','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36 OPR/107.0.0.0',0,'2024-04-30 09:37:53'),(69,'0969786231','9728',1,'190.155.181.76','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36 OPR/108.0.0.0',0,'2024-05-05 21:37:43'),(70,'0969786231','9188',1,'190.155.181.76','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36 OPR/108.0.0.0',0,'2024-05-05 21:59:31'),(71,'0969786231','3832',1,'190.155.181.76','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36 OPR/108.0.0.0',0,'2024-05-05 22:59:28'),(72,'0969786231','3174',1,'186.3.23.2','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36',0,'2024-05-06 07:55:21'),(73,'0969786231','1492',1,'186.3.23.2','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36',0,'2024-05-06 08:01:15'),(74,'0969786231','1886',1,'186.3.23.2','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36 OPR/107.0.0.0',0,'2024-05-07 07:40:18'),(75,'0969786231','2115',1,'190.155.181.76','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36 OPR/108.0.0.0',0,'2024-05-07 21:21:18'),(76,'0969786231','6043',1,'190.155.181.76','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36 OPR/108.0.0.0',0,'2024-05-08 21:44:54'),(77,'0969786231','1848',1,'186.3.23.2','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36 OPR/107.0.0.0',1,'2024-05-09 07:40:17');
/*!40000 ALTER TABLE `solo_telefonos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pass` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_creado` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'admin','admin12345','2024-03-10 18:38:43',1);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'wsoqajmy_crediweb'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-10 16:19:00
