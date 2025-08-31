/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-12.0.2-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: clinic
-- ------------------------------------------------------
-- Server version	12.0.2-MariaDB-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `citas`
--

DROP TABLE IF EXISTS `citas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `citas` (
  `idcita` int(11) NOT NULL AUTO_INCREMENT,
  `idcliente` int(11) NOT NULL,
  `idetiqueta` int(11) DEFAULT NULL,
  `titulo` varchar(50) NOT NULL,
  `mensaje` text DEFAULT NULL,
  `fecha_ini` date NOT NULL,
  `hora_ini` time NOT NULL,
  `estado` tinyint(4) DEFAULT 1,
  `fecha_fin` date NOT NULL,
  `hora_fin` time NOT NULL,
  PRIMARY KEY (`idcita`),
  KEY `idcliente` (`idcliente`),
  CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `citas`
--

LOCK TABLES `citas` WRITE;
/*!40000 ALTER TABLE `citas` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `citas` VALUES
(1,1,1,'JS-YOJAN-ORTO-1H-JS','','2025-01-29','07:00:00',1,'2025-01-29','07:30:00'),
(2,1,1,'JS-YOJAN-ORTO-1H-JS','','2025-02-12','07:00:00',1,'2025-02-12','08:30:00'),
(3,1,1,'JS-YOJAN-ORTO-1H-JS','','2025-02-13','07:30:00',1,'2025-02-13','08:30:00'),
(4,1,1,'JS-YOJAN-CONS-1H30M-JS','','2025-02-19','09:00:00',1,'2025-02-19','10:30:00'),
(5,2,1,'JS-JERSSON-ORTO-1H30M-JS','','2025-02-05','07:00:00',1,'2025-02-05','07:00:00'),
(6,1,1,'JS-YOJAN-ORTO-1H-JS','','2025-02-07','07:00:00',1,'2025-02-07','07:00:00'),
(7,2,1,'JS-JERSSON-SELLA-1H-JS','','2025-01-28','07:00:00',1,'2025-01-28','07:00:00'),
(8,1,1,'JS-YOJAN-ORTO-30M-JS','','2025-01-30','07:00:00',1,'2025-01-30','07:00:00'),
(9,2,1,'JS-JERSSON-CONS-30M-JS','','2025-01-31','07:00:00',1,'2025-01-31','07:00:00'),
(10,1,1,'JS-YOJAN-CONS-30M-JS','','2025-02-01','07:00:00',1,'2025-02-01','07:00:00'),
(11,1,1,'JS-YOJAN-CONS-30M-JS','','2025-02-02','07:00:00',1,'2025-02-02','07:00:00'),
(12,1,1,'JS-YOJAN-CONS-30M-JS','','2025-02-03','07:00:00',1,'2025-02-03','07:00:00'),
(13,1,1,'JS-YOJAN-CONS-30M-JS','','2025-02-03','07:00:00',1,'2025-02-03','07:00:00'),
(14,2,1,'JS-JERSSON-CONS-1H30M-JS','','2025-02-04','07:00:00',1,'2025-02-04','08:30:00'),
(15,2,1,'JS-JERSSON-CONS-1H30M-JS','','2025-02-04','08:30:00',1,'2025-02-04','10:00:00'),
(16,3,1,'JS-ENGERBETH-CONS-30M-JS','','2025-02-05','07:00:00',1,'2025-02-05','07:00:00'),
(17,2,1,'JS-JERSSON-CONS-2H-JS','','2025-02-04','10:00:00',1,'2025-02-04','12:00:00'),
(18,2,1,'JS-JERSSON-CONS-30M-JS','','2025-02-04','15:00:00',1,'2025-02-04','15:30:00'),
(19,2,1,'JS-JERSSON-CONS-1H30M-JS','','2025-02-04','15:30:00',1,'2025-02-04','17:00:00'),
(20,2,1,'JS-JERSSON-CONS-30M-JS','','2025-02-11','07:00:00',1,'2025-02-11','07:00:00'),
(21,2,1,'JS-JERSSON-CONS-30M-JS','','2025-02-11','07:00:00',1,'2025-02-11','07:00:00'),
(22,2,1,'JS-JERSSON-CONS-30M-JS','','2025-02-12','07:00:00',1,'2025-02-12','07:00:00'),
(23,2,1,'JS-JERSSON-CONS-30M-JS','','2025-02-10','07:00:00',1,'2025-02-10','07:00:00'),
(24,2,1,'JS-JERSSON-CONS-30M-JS','','2025-02-10','07:00:00',1,'2025-02-10','07:00:00'),
(25,2,1,'JS-JERSSON-CONS-30M-JS','','2025-02-06','07:00:00',1,'2025-02-06','07:00:00'),
(26,1,1,'JS-YOJAN-CONS-30M-JS','','2025-02-17','07:00:00',1,'2025-02-17','07:00:00'),
(27,1,1,'JS-YOJAN-CONS-30M-JS','','2025-02-18','07:00:00',1,'2025-02-18','07:00:00'),
(28,1,1,'JS-YOJAN-CONS-30M-JS','','2025-02-17','07:00:00',1,'2025-02-17','07:00:00'),
(29,1,1,'JS-YOJAN-CONS-30M-JS','','2025-02-25','07:00:00',1,'2025-02-25','07:00:00'),
(30,1,1,'JS-YOJAN-CONS-30M-JS','','2025-02-24','07:00:00',1,'2025-02-24','08:30:00'),
(31,1,1,'JS-YOJAN-CONS-30M-JS','','2025-02-24','09:00:00',1,'2025-02-24','10:00:00'),
(32,1,1,'JS-YOJAN-CONS-30M-JS','','2025-02-26','07:00:00',1,'2025-02-26','07:00:00'),
(33,1,1,'JS-YOJAN-CONS-30M-JS','','2025-02-26','07:00:00',1,'2025-02-26','07:00:00'),
(34,1,1,'JS-YOJAN-CONS-30M-JS','','2025-02-26','07:00:00',1,'2025-02-26','07:00:00'),
(35,1,1,'JS-YOJAN-CONS-30M-JS','','2025-02-27','07:00:00',1,'2025-02-27','07:00:00'),
(36,2,1,'JS-JERSSON-CONS-30M-JS','','2025-02-28','07:00:00',1,'2025-02-28','07:00:00'),
(37,2,1,'JS-JERSSON-CONS-30M-JS','','2025-02-28','07:00:00',1,'2025-02-28','07:00:00'),
(38,2,1,'JS-JERSSON-CONS-30M-JS','','2025-03-01','07:00:00',1,'2025-03-01','07:00:00'),
(39,2,1,'JS-JERSSON-CONS-30M-JS','','2025-03-02','07:00:00',1,'2025-03-02','07:00:00'),
(40,2,1,'JS-j-CONS-30M-JS','','2025-03-03','07:00:00',1,'2025-03-03','07:00:00'),
(41,2,1,'JS-j-CONS-30M-JS','','2025-03-04','07:00:00',1,'2025-03-04','07:00:00'),
(42,3,1,'JS-ENGERBETH-CONS-30M-JS','','2025-03-05','07:00:00',1,'2025-03-05','07:00:00'),
(43,3,1,'JS-dgsdfg-CONS-30M-JS','','2025-03-06','07:00:00',1,'2025-03-06','07:00:00'),
(44,1,1,'JS-YOJAN-CONS-30M-JS','','2025-03-07','07:00:00',1,'2025-03-07','07:00:00'),
(45,1,1,'JS-sdfsdf-CONS-30M-JS','','2025-03-08','07:00:00',1,'2025-03-08','07:00:00'),
(46,2,1,'JS-JERSSON-CORO-1H30M-JS','','2025-02-21','07:00:00',1,'2025-02-21','07:00:00'),
(47,2,1,'JS-JERSSON-SELLA-1H30M-JS','','2025-02-20','07:00:00',1,'2025-02-20','07:00:00'),
(48,2,1,'JS-sdfsfsd-CONS-30M-JS','','2025-02-14','07:00:00',1,'2025-02-14','07:00:00'),
(49,1,1,'JS-YOJAN-SELLA-1H-JS','','2025-02-08','07:30:00',1,'2025-02-08','08:30:00'),
(50,2,1,'JS-JERSSON-CONS-30M-JS','','2025-02-09','07:00:00',1,'2025-02-09','07:00:00'),
(51,1,1,'JS-YOJAN-CONS-30M-JS','','2025-02-16','07:00:00',1,'2025-02-16','07:00:00'),
(52,2,1,'JS-JERSSON-CONS-30M-JS','','2025-02-23','07:00:00',1,'2025-02-23','07:00:00'),
(53,2,1,'JS-JERSSON-CONS-30M-JS','','2025-02-23','07:00:00',1,'2025-02-23','07:00:00'),
(54,2,1,'JS-JERSSON-CONS-30M-JS','','2025-02-23','07:00:00',1,'2025-02-23','07:00:00'),
(56,1,1,'JS-YOJAN-CONS-30M-JS','','2025-02-23','07:00:00',1,'2025-02-23','07:00:00'),
(57,2,1,'JS-JERSSON-CONS-30M-JS','','2025-02-16','07:00:00',1,'2025-02-16','07:00:00'),
(58,1,1,'JS-YOJAN-CONS-30M-JS','','2025-02-16','07:00:00',1,'2025-02-16','07:00:00'),
(59,1,1,'JS-YOJAN-CONS-30M-JS','','2025-02-25','07:00:00',1,'2025-02-25','07:00:00'),
(60,1,1,'JS-YOJAN-CONS-30M-JS','','2025-02-25','07:00:00',1,'2025-02-25','07:00:00'),
(63,2,1,'JS-JERSSON-CONS-30M-JS','','2025-02-27','07:00:00',1,'2025-02-27','07:00:00'),
(64,3,1,'JS-ENGERBETH-CONS-30M-JS','','2025-02-27','07:00:00',1,'2025-02-27','07:00:00'),
(65,4,1,'JS-RENZO-CONS-30M-JS','','2025-02-28','07:00:00',1,'2025-02-28','07:00:00'),
(66,3,1,'JS-ENGERBETH-CONS-30M-JS','','2025-03-01','07:00:00',1,'2025-03-01','07:00:00'),
(67,2,1,'JS-JERSSON-CONS-30M-JS','','2025-03-17','07:00:00',1,'2025-03-17','07:00:00'),
(68,1,1,'JS-YOJAN-CONS-30M-JS','','2025-03-18','07:00:00',1,'2025-03-18','07:00:00'),
(69,1,1,'JS-YOJAN-CONS-30M-JS','','2025-03-17','07:00:00',1,'2025-03-17','07:00:00'),
(70,2,1,'JS-JERSSON-CONS-30M-JS','','2025-03-09','07:00:00',1,'2025-03-09','07:00:00'),
(71,1,1,'JS-YOJAN-CONS-30M-JS','','2025-03-10','07:00:00',1,'2025-03-10','07:00:00'),
(72,4,1,'JS-RENZO-CONS-2H-JS','','2025-02-06','10:00:00',1,'2025-02-06','12:00:00'),
(73,2,1,'JS-JERSSON-ORTO-1H30M-JS','','2025-01-28','10:30:00',1,'2025-01-28','12:00:00'),
(74,1,1,'JS-YOJAN-CONS-30M-JS','','2025-01-28','10:00:00',1,'2025-01-28','10:30:00'),
(75,4,1,'JS-RENZO-SELLA-1H-JS','','2025-01-28','14:00:00',1,'2025-01-28','15:00:00'),
(76,4,1,'JS-RENZO-RFS-2H-JS','','2025-01-28','15:00:00',1,'2025-01-28','17:00:00'),
(77,2,1,'JS-JERSSON-RFA-30M-JS','','2025-01-28','09:00:00',1,'2025-01-28','09:30:00'),
(78,2,1,'JS-JERSSON-SELLA-1H-JS','','2025-02-07','09:00:00',1,'2025-02-07','10:00:00'),
(79,3,1,'JS-ENGERBETH-ORTO-1H30M-JS','','2025-02-15','12:30:00',1,'2025-02-15','14:00:00'),
(80,4,1,'JS-RENZO-ENAT-1H30M-JS','','2025-02-15','11:30:00',1,'2025-02-15','13:00:00'),
(81,1,1,'JS-YOJAN-ENDO-1H30M-JS','','2025-02-22','07:00:00',1,'2025-02-22','08:30:00'),
(82,3,1,'JS-ENGERBETH-SELLA-2H-JS','','2025-02-22','12:00:00',1,'2025-02-22','14:00:00'),
(83,3,1,'JS-ENGERBETH-RFS-2H-JS','','2025-02-22','10:30:00',1,'2025-02-22','12:30:00'),
(84,2,1,'JS-JERSSON-PPR-1H30M-JS','','2025-02-21','12:00:00',1,'2025-02-21','13:30:00'),
(85,2,1,'JS-JERSSON-SELL-1H30M-JS','','2025-03-13','07:00:00',1,'2025-03-13','07:00:00'),
(86,3,1,'JS-ENGERBETH-CON-1H-JS','','2025-03-13','07:00:00',1,'2025-03-13','07:00:00'),
(87,1,1,'JS-YOJAN-CONS-30M-JS','','2025-03-14','08:00:00',1,'2025-03-14','08:30:00'),
(88,4,2,'AA-RENZO-ORTO-1H-AA','','2025-04-02','07:30:00',1,'2025-04-02','08:30:00'),
(89,5,1,'JS-LAURA-ORTO-1H-JS','','2025-04-09','08:00:00',1,'2025-04-09','09:00:00'),
(90,1,1,'JS-YOJAN-rest-1H30M-AA','','2025-06-04','08:30:00',1,'2025-06-04','10:00:00'),
(91,4,2,'AA-RENZO-ENDO-1H30M-JS','algo va pasar','2025-08-06','09:30:00',1,'2025-08-06','11:00:00'),
(92,1,1,'JS-YOJAN-POST-2H-AA','','2025-08-21','09:00:00',1,'2025-08-21','11:00:00'),
(93,3,2,'AA-ENGERBETH-RFS-1H30M-YQ','sfsdgasgsd','2025-08-25','09:00:00',1,'2025-08-25','10:30:00');
/*!40000 ALTER TABLE `citas` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `clientes` (
  `idcliente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `dni` int(11) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `sexo` varchar(15) DEFAULT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `feCreate` datetime DEFAULT current_timestamp(),
  `feUpdate` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`idcliente`),
  UNIQUE KEY `dni` (`dni`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `clientes` VALUES
(1,'YOJAN VICTOR','QUISPE APAZA',72535242,'988929723',NULL,NULL,NULL,'','2025-02-16 11:21:13','2025-02-16 11:21:13'),
(2,'JERSSON PELAYO','QUISPE APAZA',72535244,'594643513',NULL,NULL,NULL,'','2025-02-21 12:51:16','2025-02-21 12:51:16'),
(3,'ENGERBETH YERICO','CASTRO CHUQUINEIRA',75135464,'798794513',NULL,NULL,NULL,'9945641','2025-02-21 15:17:52','2025-02-21 15:17:52'),
(4,'RENZO PELAYO','QUISPE SUBIA',1298506,'896546123','','','','','2025-02-21 20:31:44','2025-03-31 12:11:46'),
(5,'LAURA YANE','SERIN YUPANQUI',72143123,'978923649','','','','no se','2025-03-11 18:39:54','2025-04-04 09:27:25'),
(6,'CARLOS DANIEL','SANTA CRUZ BAZAN',72546132,'945453151',NULL,NULL,NULL,'jr','2025-07-24 21:33:57','2025-07-24 21:33:57'),
(7,'GABRIELA','CHOMBA INGOL',76265464,'989454165',NULL,NULL,NULL,'jr, sfs','2025-08-03 13:40:12','2025-08-03 13:40:12'),
(8,'RAMIRO FERMIN','QUISPE ZEBALLOS',70217389,'324324',NULL,NULL,NULL,'32423432432','2025-08-24 21:34:15','2025-08-24 21:34:15'),
(9,'JHON TITO','NAVARRO GARCIA',71628361,'876873638',NULL,NULL,NULL,'6876328743','2025-08-24 21:34:46','2025-08-24 21:34:46');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `clientes_condicion`
--

DROP TABLE IF EXISTS `clientes_condicion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `clientes_condicion` (
  `idcondicion` int(11) NOT NULL AUTO_INCREMENT,
  `idcliente` int(11) NOT NULL,
  `antecedente_enfermedad` tinyint(4) DEFAULT NULL,
  `antecedente_observacion` varchar(20) DEFAULT NULL,
  `medicado` tinyint(4) DEFAULT NULL,
  `medicado_observacion` varchar(20) DEFAULT NULL,
  `complicacion_anestesia` tinyint(4) DEFAULT NULL,
  `anestesia_observacion` varchar(20) DEFAULT NULL,
  `alergia_medicamento` tinyint(4) DEFAULT NULL,
  `alergiamedicamento_observacion` varchar(20) DEFAULT NULL,
  `hemorragias` tinyint(4) DEFAULT NULL,
  `hemorragias_observacion` varchar(20) DEFAULT NULL,
  `enfermedad` varchar(100) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `feCreate` datetime DEFAULT current_timestamp(),
  `feActualizacion` date DEFAULT NULL,
  PRIMARY KEY (`idcondicion`),
  KEY `clientes_condicion_ibfk_1` (`idcliente`),
  CONSTRAINT `clientes_condicion_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes_condicion`
--

LOCK TABLES `clientes_condicion` WRITE;
/*!40000 ALTER TABLE `clientes_condicion` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `clientes_condicion` VALUES
(1,5,2,'nada',3,'nada1',2,'nada2',3,'nada3',2,'nada4','covid','es intolorante a un medicamento 123','2025-03-11 18:39:54','2025-04-04'),
(2,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-03-11 18:40:58',NULL),
(3,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-03-11 18:41:00',NULL),
(4,3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-03-11 18:41:02',NULL),
(5,4,1,'tiene algo',3,'no tiene nada',3,'algo tiene',3,'no es alergico',3,'si es propenso','una enfermedad','algo general','2025-03-11 18:41:06','2025-03-31'),
(6,6,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-24 21:33:57',NULL),
(7,7,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-03 13:40:12',NULL),
(8,8,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-24 21:34:15',NULL),
(9,9,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-24 21:34:46',NULL);
/*!40000 ALTER TABLE `clientes_condicion` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `etiquetas`
--

DROP TABLE IF EXISTS `etiquetas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `etiquetas` (
  `idetiqueta` int(11) NOT NULL AUTO_INCREMENT,
  `idpersonal` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `color` varchar(50) NOT NULL,
  PRIMARY KEY (`idetiqueta`),
  UNIQUE KEY `idpersonal` (`idpersonal`),
  CONSTRAINT `etiquetas_ibfk_1` FOREIGN KEY (`idpersonal`) REFERENCES `personal` (`idpersonal`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `etiquetas`
--

LOCK TABLES `etiquetas` WRITE;
/*!40000 ALTER TABLE `etiquetas` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `etiquetas` VALUES
(1,2,'JJ','#c01c28'),
(2,1,'AA','#c01c29'),
(3,5,'YQ','#1a5fb4');
/*!40000 ALTER TABLE `etiquetas` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `login` (
  `idlogin` int(11) NOT NULL AUTO_INCREMENT,
  `idpersonal` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(300) NOT NULL,
  `estado` tinyint(4) DEFAULT 1,
  `nivel` tinyint(4) DEFAULT 1,
  PRIMARY KEY (`idlogin`),
  UNIQUE KEY `username` (`username`),
  KEY `idpersonal` (`idpersonal`),
  CONSTRAINT `login_ibfk_1` FOREIGN KEY (`idpersonal`) REFERENCES `personal` (`idpersonal`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login`
--

LOCK TABLES `login` WRITE;
/*!40000 ALTER TABLE `login` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `login` VALUES
(1,1,'admin','$2y$12$UztfH8hRe25EH3cFlC5h8.pe0DIsjwWraHsBvyw91lEsW6oxfmx7i',1,2),
(2,2,'julio','$2y$12$jqfRtyNjPZSYkVWZx1eJcOZ/l3CXWhK1yQ8M0Hs3Gd1035P2ApuUq',1,1),
(3,3,'renzo','$2y$12$iS4ZwgjZSznYiOhgCtg3S.oN/jBLaF5a5gwQ7DFL/Lj7VAII7.p9a',1,1),
(4,5,'johan','$2y$12$c92atPORTh0z3vMHzFFd8ele1Zr1gLsiKhOIPmfIC1OQNHLQLS8pK',1,1);
/*!40000 ALTER TABLE `login` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `odontograma`
--

DROP TABLE IF EXISTS `odontograma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `odontograma` (
  `idodontograma` int(11) NOT NULL AUTO_INCREMENT,
  `idcliente` int(11) NOT NULL,
  `idprocedimiento` int(11) NOT NULL,
  `pieza` tinyint(4) NOT NULL,
  `imagen` varchar(400) NOT NULL,
  `observaciones` text DEFAULT NULL,
  `estado` tinyint(4) NOT NULL,
  `condicion` tinyint(4) DEFAULT NULL,
  `feCreate` date DEFAULT current_timestamp(),
  `feActualizacion` date DEFAULT NULL,
  PRIMARY KEY (`idodontograma`),
  KEY `odontograma_ibfk_1` (`idcliente`),
  KEY `odontograma_ibfk_2` (`idprocedimiento`),
  CONSTRAINT `odontograma_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`),
  CONSTRAINT `odontograma_ibfk_2` FOREIGN KEY (`idprocedimiento`) REFERENCES `procedimientos` (`idprocedimiento`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `odontograma`
--

LOCK TABLES `odontograma` WRITE;
/*!40000 ALTER TABLE `odontograma` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `odontograma` VALUES
(1,4,3,18,'http://localhost/clinic/dumps/piezas/RENZO18/lm.png','hola 2',2,2,'2025-03-06',NULL),
(2,4,2,17,'http://localhost/clinic/dumps/piezas/RENZO17/diente.png','diente prueba',1,2,'2025-03-06',NULL),
(3,4,2,43,'http://localhost/clinic/dumps/piezas/RENZO43/diente.png','diente prueba 2\r\n',2,3,'2025-03-06',NULL),
(4,4,4,16,'http://localhost/clinic/dumps/piezas/RENZO16/diente.png','nada que ver',1,2,'2025-03-06',NULL),
(5,4,1,15,'http://localhost/clinic/dumps/piezas/RENZO15/lm.png','123',2,3,'2025-03-06',NULL),
(6,5,28,18,'http://localhost/clinic/dumps/piezas/LAURA18/lm.png','123',1,2,'2025-03-13',NULL),
(7,5,17,17,'http://localhost/clinic/dumps/piezas/LAURA17/diente.png','123',1,1,'2025-03-16',NULL),
(8,5,3,16,'http://localhost/clinic/dumps/piezas/LAURA16/icon.jpg','123',2,1,'2025-03-16',NULL),
(9,5,4,15,'http://localhost/clinic/dumps/piezas/LAURA15/lm.png','123',1,2,'2025-03-16',NULL),
(10,5,17,14,'http://localhost/clinic/dumps/piezas/LAURA14/diente.png','123',2,2,'2025-03-16',NULL),
(11,4,16,26,'http://localhost/clinic/dumps/piezas/RENZO26/icon.jpg','123',1,2,'2025-03-26',NULL),
(12,4,14,27,'1','456',2,1,'2025-03-26',NULL),
(13,4,15,25,'http://localhost/clinic/dumps/piezas/RENZO25/icon.jpg','789',1,1,'2025-03-26',NULL),
(14,7,3,18,'http://localhost/clinic/dumps/piezas/GABRIELA18/diente.png','ALguna observacion aqui',2,2,'2025-08-04',NULL),
(15,7,3,18,'http://localhost/clinic/dumps/piezas/GABRIELA18/diente.png','ALguna observacion aqui',2,2,'2025-08-04',NULL),
(16,7,4,17,'http://localhost/clinic/dumps/piezas/GABRIELA17/lm.png','',1,2,'2025-08-04',NULL),
(17,7,5,16,'http://localhost/clinic/dumps/piezas/GABRIELA16/lm.png','12',2,2,'2025-08-04',NULL),
(18,7,8,15,'http://localhost/clinic/dumps/piezas/GABRIELA15/lm.png','32432',3,2,'2025-08-04',NULL),
(19,7,9,14,'http://localhost/clinic/dumps/piezas/GABRIELA14/lm.png','4354',2,1,'2025-08-04',NULL),
(20,7,10,13,'http://localhost/clinic/dumps/piezas/GABRIELA13/lm.png','657',1,3,'2025-08-04',NULL),
(21,7,11,12,'http://localhost/clinic/dumps/piezas/GABRIELA12/lm.png','657657',3,3,'2025-08-04',NULL),
(22,7,12,11,'http://localhost/clinic/dumps/piezas/GABRIELA11/lm.png','fsfsd',2,3,'2025-08-04',NULL),
(23,7,14,21,'http://localhost/clinic/dumps/piezas/GABRIELA21/lm.png','fgdhf',2,3,'2025-08-04',NULL),
(24,7,17,22,'http://localhost/clinic/dumps/piezas/GABRIELA22/lm.png','lkjghkh',2,3,'2025-08-04',NULL),
(25,7,1,23,'1','12',3,2,'2025-08-04',NULL),
(26,7,6,24,'1','hj',3,2,'2025-08-04',NULL),
(27,7,7,25,'1','543',3,2,'2025-08-04',NULL),
(28,7,13,26,'1','dfgfd',2,3,'2025-08-04',NULL),
(29,7,15,27,'1','fhbgh',2,3,'2025-08-04',NULL),
(30,7,16,28,'1','fhgfh',2,3,'2025-08-04',NULL),
(31,7,18,48,'1','gffr',3,1,'2025-08-04',NULL),
(32,7,19,47,'1','dgfdgfd',3,2,'2025-08-04',NULL),
(33,7,21,46,'1','fghfgh',3,2,'2025-08-04',NULL),
(34,7,22,45,'1','dgdfg',3,2,'2025-08-04',NULL),
(35,7,24,43,'1','fgrg',2,3,'2025-08-04',NULL),
(36,7,23,44,'1','dfggf',3,3,'2025-08-04',NULL),
(37,7,25,42,'1','dgfdgd',3,3,'2025-08-04',NULL),
(38,7,26,41,'1','fgd',3,1,'2025-08-04',NULL),
(39,7,27,31,'1','ghfgh',3,1,'2025-08-04',NULL),
(40,7,28,32,'1','hyh',2,3,'2025-08-04',NULL),
(41,7,29,33,'1','tyuyt',2,3,'2025-08-04',NULL),
(42,7,20,34,'1','dgfd',2,1,'2025-08-04',NULL),
(43,3,16,18,'http://localhost/clinic/dumps/piezas/ENGERBETH/icon.jpg','4857',2,1,'2025-08-31',NULL);
/*!40000 ALTER TABLE `odontograma` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `pago_detalles`
--

DROP TABLE IF EXISTS `pago_detalles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pago_detalles` (
  `idpagodetalle` int(11) NOT NULL AUTO_INCREMENT,
  `idpago` int(11) NOT NULL,
  `idpersonal` int(11) DEFAULT NULL,
  `monto` decimal(10,2) NOT NULL,
  `concepto` varchar(100) DEFAULT NULL,
  `pieza` varchar(20) DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`idpagodetalle`),
  KEY `idpago` (`idpago`),
  CONSTRAINT `pago_detalles_ibfk_1` FOREIGN KEY (`idpago`) REFERENCES `pagos` (`idpago`)
) ENGINE=InnoDB AUTO_INCREMENT=267 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pago_detalles`
--

LOCK TABLES `pago_detalles` WRITE;
/*!40000 ALTER TABLE `pago_detalles` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `pago_detalles` VALUES
(241,40,2,10.00,NULL,'1.2','2025-08-24 18:25:34'),
(242,41,5,100.00,NULL,'2.7','2025-08-24 18:26:16'),
(243,41,2,20.00,NULL,'3.1','2025-08-24 18:26:24'),
(245,42,2,300.00,NULL,'3.6','2025-08-24 18:26:47'),
(246,43,5,100.00,NULL,'1.2','2025-08-24 18:31:48'),
(247,43,2,100.00,NULL,'1.1','2025-08-24 18:33:25'),
(248,43,5,100.00,NULL,'1.5','2025-08-24 18:33:41'),
(249,44,5,100.00,NULL,'4.8','2025-08-24 18:36:32'),
(252,43,2,500.00,NULL,'1.2','2025-08-24 18:43:35'),
(253,43,2,300.00,NULL,'1.3','2025-08-24 18:43:52'),
(254,43,5,2400.00,NULL,'2.8','2025-08-24 18:44:00'),
(255,44,5,100.00,NULL,'1.2','2025-08-24 18:44:08'),
(256,44,5,300.00,NULL,'1.7','2025-08-24 18:44:15'),
(257,44,5,500.00,NULL,'1.8','2025-08-24 18:44:24'),
(259,44,5,100.00,NULL,'1.2','2025-08-24 18:45:24'),
(262,44,2,100.00,NULL,'3.3','2025-08-24 18:46:25'),
(263,44,2,1000.00,NULL,'1.1','2025-08-24 18:46:31'),
(264,48,5,100.00,NULL,'3.7','2025-08-24 18:47:03'),
(265,49,5,10.00,NULL,'1.2','2025-08-24 20:45:14'),
(266,49,2,10.00,NULL,'1.5','2025-08-24 20:45:22');
/*!40000 ALTER TABLE `pago_detalles` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `pagos`
--

DROP TABLE IF EXISTS `pagos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pagos` (
  `idpago` int(11) NOT NULL AUTO_INCREMENT,
  `idcliente` int(11) DEFAULT NULL,
  `idprocedimiento` int(11) NOT NULL,
  `monto_pagado` decimal(10,2) NOT NULL,
  `saldo_pendiente` decimal(10,2) NOT NULL,
  `igv` decimal(10,2) DEFAULT NULL,
  `total_pagar` decimal(10,2) NOT NULL,
  `feCreate` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`idpago`),
  KEY `idcliente` (`idcliente`),
  KEY `idprocedimiento` (`idprocedimiento`),
  CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`),
  CONSTRAINT `pagos_ibfk_2` FOREIGN KEY (`idprocedimiento`) REFERENCES `procedimientos` (`idprocedimiento`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagos`
--

LOCK TABLES `pagos` WRITE;
/*!40000 ALTER TABLE `pagos` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `pagos` VALUES
(40,1,4,10.00,70.00,12.20,80.00,'2025-08-24 18:25:34'),
(41,1,15,120.00,180.00,45.76,300.00,'2025-08-24 18:26:16'),
(42,1,23,300.00,700.00,152.54,1000.00,'2025-08-24 18:26:47'),
(43,1,2,3500.00,0.00,533.90,3500.00,'2025-08-24 18:31:48'),
(44,1,2,2200.00,1300.00,533.90,3500.00,'2025-08-24 18:36:32'),
(45,1,2,0.00,3500.00,533.90,3500.00,'2025-08-24 18:43:18'),
(46,1,2,0.00,3500.00,533.90,3500.00,'2025-08-24 18:43:27'),
(47,1,2,0.00,3500.00,533.90,3500.00,'2025-08-24 18:45:34'),
(48,1,2,100.00,3400.00,533.90,3500.00,'2025-08-24 18:47:03'),
(49,6,3,20.00,30.00,7.63,50.00,'2025-08-24 20:45:14');
/*!40000 ALTER TABLE `pagos` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `personal`
--

DROP TABLE IF EXISTS `personal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal` (
  `idpersonal` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `dni` int(11) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `sexo` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `foto` varchar(200) DEFAULT NULL,
  `fechaNac` date DEFAULT NULL,
  `feCreate` datetime DEFAULT current_timestamp(),
  `feUpdate` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`idpersonal`),
  UNIQUE KEY `dni` (`dni`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal`
--

LOCK TABLES `personal` WRITE;
/*!40000 ALTER TABLE `personal` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `personal` VALUES
(1,'ADMINISTRADOR','ADMINISTRADOR',72535244,'998777712','MASCULINO','jersson.z032@gmail.com',NULL,'2024-12-05',NULL,'2024-12-05 00:00:00'),
(2,'JULIO JHONATAN','SABINO VALDIVIA',72535243,'998777712',NULL,NULL,NULL,NULL,'2025-02-16 11:20:47','2025-02-16 11:20:47'),
(3,'RENZO PELAYO','QUISPE SUBIA',1298506,'98151545',NULL,NULL,NULL,NULL,'2025-02-21 21:23:55','2025-02-21 21:23:55'),
(5,'YOJAN VICTOR','QUISPE APAZA',72535242,'987398432',NULL,NULL,NULL,NULL,'2025-08-04 14:11:21','2025-08-04 14:11:21');
/*!40000 ALTER TABLE `personal` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `presupuesto_general`
--

DROP TABLE IF EXISTS `presupuesto_general`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `presupuesto_general` (
  `idpresupuestogeneral` int(11) NOT NULL AUTO_INCREMENT,
  `idcliente` int(11) NOT NULL,
  `monto_pagado` decimal(10,2) DEFAULT NULL,
  `deuda_pendiente` decimal(10,2) DEFAULT NULL,
  `descuento` decimal(10,2) DEFAULT NULL,
  `total_pagar` decimal(10,2) DEFAULT NULL,
  `estado` tinyint(4) DEFAULT 0,
  `feCreate` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`idpresupuestogeneral`),
  KEY `idcliente` (`idcliente`),
  CONSTRAINT `presupuesto_general_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `presupuesto_general`
--

LOCK TABLES `presupuesto_general` WRITE;
/*!40000 ALTER TABLE `presupuesto_general` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `presupuesto_general` VALUES
(6,1,1580.00,0.00,NULL,1580.00,1,'2025-06-29 12:22:57'),
(8,2,0.00,0.00,NULL,350.00,0,'2025-06-30 09:37:56'),
(9,2,0.00,0.00,NULL,380.00,0,'2025-06-30 09:38:29'),
(10,3,850.00,0.00,NULL,850.00,1,'2025-06-30 09:42:23'),
(11,5,110.00,150.00,NULL,260.00,0,'2025-07-21 10:36:20'),
(12,6,310.00,400.00,NULL,710.00,0,'2025-07-24 21:34:11'),
(13,8,0.00,0.00,NULL,380.00,0,'2025-08-24 21:34:32'),
(14,9,5430.00,0.00,NULL,5430.00,1,'2025-08-24 21:34:59'),
(15,7,50.00,0.00,NULL,50.00,1,'2025-08-25 13:46:51'),
(16,3,3350.00,0.00,100.00,3350.00,1,'2025-08-25 14:53:36'),
(17,7,470.00,0.00,130.00,470.00,1,'2025-08-28 18:38:04'),
(18,7,80.00,150.00,0.00,230.00,0,'2025-08-28 19:06:22'),
(19,3,20.00,120.00,0.00,2340.00,0,'2025-08-31 16:23:43');
/*!40000 ALTER TABLE `presupuesto_general` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `presupuesto_pagos`
--

DROP TABLE IF EXISTS `presupuesto_pagos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `presupuesto_pagos` (
  `idpresupuestopago` int(11) NOT NULL AUTO_INCREMENT,
  `idpresupuestogeneral` int(11) NOT NULL,
  `importe` decimal(10,2) DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`idpresupuestopago`),
  KEY `idpresupuestogeneral` (`idpresupuestogeneral`),
  CONSTRAINT `presupuesto_pagos_ibfk_1` FOREIGN KEY (`idpresupuestogeneral`) REFERENCES `presupuesto_general` (`idpresupuestogeneral`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `presupuesto_pagos`
--

LOCK TABLES `presupuesto_pagos` WRITE;
/*!40000 ALTER TABLE `presupuesto_pagos` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `presupuesto_pagos` VALUES
(1,6,100.00,'2025-06-30 10:05:56'),
(8,6,150.00,'2025-06-30 10:29:45'),
(9,6,50.00,'2025-07-02 16:27:17'),
(10,6,12.00,'2025-07-07 08:57:35'),
(11,6,1.00,'2025-07-07 08:58:30'),
(12,6,1.00,'2025-07-07 08:59:13'),
(13,6,20.00,'2025-07-07 09:01:51'),
(14,6,6.00,'2025-07-07 09:08:44'),
(15,6,10.00,'2025-07-07 09:10:56'),
(16,6,10.00,'2025-07-07 09:22:41'),
(17,6,10.00,'2025-07-07 09:23:13'),
(18,6,10.00,'2025-07-07 09:24:11'),
(19,6,10.00,'2025-07-07 09:52:49'),
(20,11,100.00,'2025-07-21 10:36:30'),
(21,11,10.00,'2025-07-21 10:37:10'),
(22,12,100.00,'2025-07-24 21:34:18'),
(23,12,50.00,'2025-07-24 21:34:28'),
(25,12,160.00,'2025-08-03 13:17:10'),
(26,10,850.00,'2025-08-25 13:46:34'),
(27,15,50.00,'2025-08-25 13:46:55'),
(28,14,5430.00,'2025-08-25 13:47:24'),
(29,6,1190.00,'2025-08-25 13:47:39'),
(30,17,470.00,'2025-08-28 18:53:41'),
(31,18,50.00,'2025-08-28 19:07:33'),
(32,18,10.00,'2025-08-28 19:08:00'),
(33,18,10.00,'2025-08-28 19:08:30'),
(34,18,10.00,'2025-08-28 19:08:48'),
(35,16,100.00,'2025-08-29 10:16:00'),
(36,16,50.00,'2025-08-29 10:16:08'),
(37,16,100.00,'2025-08-31 16:14:21'),
(38,16,3100.00,'2025-08-31 16:14:45'),
(39,19,20.00,'2025-08-31 16:23:47');
/*!40000 ALTER TABLE `presupuesto_pagos` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `presupuesto_procedimientos`
--

DROP TABLE IF EXISTS `presupuesto_procedimientos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `presupuesto_procedimientos` (
  `idpresupuestoprocedimiento` int(11) NOT NULL AUTO_INCREMENT,
  `idpresupuestogeneral` int(11) NOT NULL,
  `idprocedimiento` int(11) NOT NULL,
  `pieza` varchar(20) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`idpresupuestoprocedimiento`),
  KEY `idpresupuestogeneral` (`idpresupuestogeneral`),
  KEY `idprocedimiento` (`idprocedimiento`),
  CONSTRAINT `presupuesto_procedimientos_ibfk_1` FOREIGN KEY (`idpresupuestogeneral`) REFERENCES `presupuesto_general` (`idpresupuestogeneral`),
  CONSTRAINT `presupuesto_procedimientos_ibfk_2` FOREIGN KEY (`idprocedimiento`) REFERENCES `procedimientos` (`idprocedimiento`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `presupuesto_procedimientos`
--

LOCK TABLES `presupuesto_procedimientos` WRITE;
/*!40000 ALTER TABLE `presupuesto_procedimientos` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `presupuesto_procedimientos` VALUES
(5,6,21,'3.1',1500.00,NULL),
(6,6,14,'2.7',80.00,NULL),
(7,8,1,'1.2',50.00,NULL),
(8,8,15,'2.5',300.00,NULL),
(9,9,4,'1.2',80.00,NULL),
(10,9,15,'2.6',300.00,NULL),
(11,10,15,'2.6',300.00,NULL),
(12,10,11,'1.6',500.00,NULL),
(13,10,3,'1.6',50.00,NULL),
(14,11,4,'1.4',80.00,NULL),
(15,11,7,'1.1',180.00,NULL),
(16,12,18,'3.1',300.00,NULL),
(17,12,20,'2.1',350.00,NULL),
(18,12,17,'1.8',60.00,NULL),
(19,13,5,'1.5',120.00,NULL),
(20,13,6,'1.4',180.00,NULL),
(21,13,14,'2.6',80.00,NULL),
(22,14,6,'1.4',180.00,NULL),
(25,14,16,'2.6',300.00,NULL),
(33,14,10,'3.2',200.00,NULL),
(49,14,18,'3.4',300.00,NULL),
(51,14,22,'3.5',1000.00,NULL),
(53,14,13,'1.1',400.00,NULL),
(55,14,1,'1.1',50.00,NULL),
(57,14,21,'1.1',1500.00,NULL),
(59,14,29,'3.5',500.00,NULL),
(60,14,22,'3.4',1000.00,NULL),
(61,15,3,'1.3',50.00,NULL),
(62,16,5,'1.4',120.00,NULL),
(64,16,16,'2.8',300.00,NULL),
(65,16,17,'3.3',60.00,NULL),
(66,16,13,'2.3',400.00,NULL),
(67,16,21,'1.1',1500.00,NULL),
(68,16,23,'2.8',1000.00,NULL),
(71,17,8,'2.8',300.00,NULL),
(72,17,16,'1.1',300.00,NULL),
(73,18,7,'1.1',180.00,NULL),
(74,18,1,'1.3',50.00,NULL),
(75,16,3,'1.1',50.00,NULL),
(76,16,28,'3.2',20.00,'2025-08-31'),
(77,19,17,'3.1',60.00,NULL),
(78,19,14,'3.2',80.00,NULL),
(79,19,18,'2.8',300.00,'2025-08-31'),
(80,19,21,'3.4',1500.00,'2025-08-31'),
(81,19,12,'2.8',300.00,'2025-08-31'),
(82,19,19,'3.2',100.00,'2025-08-31');
/*!40000 ALTER TABLE `presupuesto_procedimientos` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `procedimientos`
--

DROP TABLE IF EXISTS `procedimientos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `procedimientos` (
  `idprocedimiento` int(11) NOT NULL AUTO_INCREMENT,
  `procedimiento` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `iniciales` varchar(10) DEFAULT NULL,
  `feCreate` datetime DEFAULT current_timestamp(),
  `color` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idprocedimiento`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `procedimientos`
--

LOCK TABLES `procedimientos` WRITE;
/*!40000 ALTER TABLE `procedimientos` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `procedimientos` VALUES
(1,'Consulta Dental','',50.00,'CONS','2024-12-01 21:01:40','#a0a4ab'),
(2,'Ortodoncia','',3500.00,'ORTO','2024-12-01 21:40:58','#5679A6'),
(3,'Sellantes','',50.00,'SELLA','2024-12-01 21:46:42','#d9b929'),
(4,'Restauracion de niños','',80.00,'rest','2024-12-01 21:46:42','#ec121f'),
(5,'Restauracion Simple RFS','',120.00,'RFS','2025-02-05 11:40:28','#5498a9'),
(6,'Restauracion compueta RFC','',180.00,'RFC','2025-02-05 11:39:50','#9BAF47'),
(7,'Restauracion Angular RFA','',180.00,'RFA','2025-01-19 19:31:36','#00243f'),
(8,'Endodoncia Posteriores','',300.00,'ENDO','2025-02-05 11:42:07','#7b6e4c'),
(9,'Endodoncia Anteriores','',180.00,'ENAT','2025-02-05 11:43:16','#2d5f7d'),
(10,'Poste de Seguridad','',200.00,'POST','2025-02-05 11:43:33','#44b09e'),
(11,'Corona Porcelanato','',500.00,'CORO','2025-02-05 11:44:22','#C1663B'),
(12,'Corona Ivocron','',300.00,'CIVO','2025-02-05 11:44:49','#D8A578'),
(13,'Provisional PPR','',400.00,'PPR','2025-02-05 11:45:20','#9aa8a8'),
(14,'Provisional Coronas','',80.00,'PROC','2025-02-05 11:45:48','#b00002'),
(15,'Profilaxis + Fluorizacion','',300.00,'PROF','2025-02-05 11:46:11','#645045'),
(16,'Blanqueamiento Dental','',300.00,'BLAN','2025-02-05 11:46:26','#C6C3B5'),
(17,'Exodoncia','',60.00,'EXOD','2025-02-05 11:47:01','#1e582a'),
(18,'Tercer Molar','',300.00,'TMOL','2025-02-05 11:47:21','#b9848c'),
(19,'Cirugia Gingivoplastia. ENCIA POR DIENTE','',100.00,'GENG','2025-02-05 11:47:21','#806491'),
(20,'Cirugia Gingivoplastia. OSEA POR DIENTE','',350.00,'GOSD','2025-02-05 11:47:21','#c3de00'),
(21,'Cirugia Gingivoplastia. OSEA + ENCIA','',1500.00,'GOEN','2025-02-05 11:47:21','#344c11'),
(22,'Protesis Parcial Removible','',1000.00,'PPR','2025-02-05 11:50:23','#686461'),
(23,'Protesis Total Removible','',1000.00,'PTR','2025-02-05 11:50:46','#854277'),
(24,'Endodoncia + Poste de SEG. + Resina POSTERIORES','',550.00,'EPPR','2025-02-05 11:50:46','#4d3474'),
(25,'Endodoncia + Poste de SEG. + Resina ANTERIORES','',350.00,'EPRA','2025-02-05 11:50:46','#5F7B86'),
(26,'Endodoncia + Poste de SEG. + Corona POSTERIORES','',930.00,'EPCP','2025-02-05 11:50:46','#4D6570'),
(27,'Endodoncia + Poste de SEG. + Corona ANTERIORES','',830.00,'EPCA','2025-02-05 11:50:46','#3B4F58'),
(28,'RX','',20.00,'RX','2025-02-05 11:51:04','#2A3D46'),
(29,'otro','',500.00,'otro','2025-02-16 13:24:32','#1B2C34');
/*!40000 ALTER TABLE `procedimientos` ENABLE KEYS */;
UNLOCK TABLES;
commit;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2025-08-31 16:46:54
