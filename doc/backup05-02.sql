/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.6.2-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: clinic
-- ------------------------------------------------------
-- Server version	11.6.2-MariaDB

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
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  `feUpdate` date DEFAULT current_timestamp(),
  PRIMARY KEY (`idcliente`),
  UNIQUE KEY `dni` (`dni`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `etiquetas`
--

DROP TABLE IF EXISTS `etiquetas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `etiquetas` (
  `idetiqueta` int(11) NOT NULL AUTO_INCREMENT,
  `idpersonal` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `color` varchar(50) NOT NULL,
  PRIMARY KEY (`idetiqueta`),
  UNIQUE KEY `idpersonal` (`idpersonal`),
  CONSTRAINT `etiquetas_ibfk_1` FOREIGN KEY (`idpersonal`) REFERENCES `personal` (`idpersonal`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login`
--

LOCK TABLES `login` WRITE;
/*!40000 ALTER TABLE `login` DISABLE KEYS */;
INSERT INTO `login` VALUES
(1,1,'admin','$2y$10$Yt3wiTd14EdTf4dGepP49.pWnboRhcwcO9YJN0wNX0ncCT.kALZXO',1,2);
/*!40000 ALTER TABLE `login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pago_detalles`
--

DROP TABLE IF EXISTS `pago_detalles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pagos`
--

DROP TABLE IF EXISTS `pagos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `personal`
--

DROP TABLE IF EXISTS `personal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  `feUpdate` date DEFAULT current_timestamp(),
  PRIMARY KEY (`idpersonal`),
  UNIQUE KEY `dni` (`dni`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal`
--

LOCK TABLES `personal` WRITE;
/*!40000 ALTER TABLE `personal` DISABLE KEYS */;
INSERT INTO `personal` VALUES
(1,'ADMINISTRADOR','ADMINISTRADOR',72535244,'998777712','MASCULINO','jersson.z032@gmail.com',NULL,'2024-12-05',NULL,'2024-12-05');
/*!40000 ALTER TABLE `personal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `procedimientos`
--

DROP TABLE IF EXISTS `procedimientos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `procedimientos` (
  `idprocedimiento` int(11) NOT NULL AUTO_INCREMENT,
  `procedimiento` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `iniciales` varchar(10) DEFAULT NULL,
  `feCreate` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`idprocedimiento`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `procedimientos`
--

LOCK TABLES `procedimientos` WRITE;
/*!40000 ALTER TABLE `procedimientos` DISABLE KEYS */;
INSERT INTO `procedimientos` VALUES
(1,'Consulta Dental','',500.00,'CONS','2024-12-01 21:01:40'),
(2,'Ortodoncia','',400.00,'ORTO','2024-12-01 21:40:58'),
(3,'Sellantes','',50.00,'SELLA','2024-12-01 21:46:42'),
(7,'Restauracion Angular RFA','',180.00,'RFA','2025-01-19 19:31:36'),
(8,'Restauracion compueta RFC','',180.00,'RFC','2025-02-05 11:39:50'),
(9,'Restauracion Simple RFS','',120.00,'RFS','2025-02-05 11:40:28'),
(10,'Endodoncia Posteriores','',300.00,'ENDO','2025-02-05 11:42:07'),
(11,'Endodoncia Anteriores','',180.00,'ENAT','2025-02-05 11:43:16'),
(12,'Poste de Seguridad','',200.00,'POST','2025-02-05 11:43:33'),
(13,'Corona Protesis Fija Porcelanato','',500.00,'CORO','2025-02-05 11:44:22'),
(14,'Corona Protesis Fija Ivocron','',300.00,NULL,'2025-02-05 11:44:49'),
(15,'Provisional PPR','',400.00,'PPR','2025-02-05 11:45:20'),
(16,'Provisional Coronas','',80.00,NULL,'2025-02-05 11:45:48'),
(17,'Profilaxis + Fluorizacion','',300.00,NULL,'2025-02-05 11:46:11'),
(18,'Blanqueamiento Dental','',300.00,NULL,'2025-02-05 11:46:26'),
(19,'Exodoncia ','',60.00,NULL,'2025-02-05 11:47:01'),
(20,'Tercer Molar','',300.00,NULL,'2025-02-05 11:47:21'),
(21,'Protesis Parcial Removible','',1000.00,NULL,'2025-02-05 11:50:23'),
(22,'Protesis Total Removible','',1000.00,NULL,'2025-02-05 11:50:46'),
(23,'RX','',20.00,NULL,'2025-02-05 11:51:04');
/*!40000 ALTER TABLE `procedimientos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2025-02-06 11:30:13
