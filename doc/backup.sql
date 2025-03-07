/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.6.2-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: clinic
-- ------------------------------------------------------
-- Server version	11.6.2-MariaDB-log

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
  `titulo` varchar(50) NOT NULL,
  `etiqueta` varchar(100) DEFAULT NULL,
  `mensaje` text DEFAULT NULL,
  `fecha_ini` date NOT NULL,
  `hora_ini` time NOT NULL,
  `estado` tinyint(4) DEFAULT 1,
  `fecha_fin` date NOT NULL,
  `hora_fin` time NOT NULL,
  PRIMARY KEY (`idcita`),
  KEY `idcliente` (`idcliente`),
  CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `citas`
--

LOCK TABLES `citas` WRITE;
/*!40000 ALTER TABLE `citas` DISABLE KEYS */;
INSERT INTO `citas` VALUES
(1,1,'nueva cita','verde','Es una nueva cita para probar el formulario','2024-12-08','15:00:00',1,'2024-12-08','16:00:00'),
(5,4,'test numero 5','rojo','algo que decir aqui','2024-12-08','07:00:00',1,'2024-12-08','07:00:00'),
(7,3,'nelida cita','verde','algo','2024-12-09','07:00:00',1,'2024-12-09','07:00:00'),
(12,1,'New Cite Alv','azul','nueva cita ctm','2024-12-11','07:00:00',1,'2024-12-11','07:00:00'),
(13,2,'titulos','azul','notas','2024-12-25','07:00:00',1,'2024-12-25','07:00:00'),
(14,5,'ortodoncia','rojo','sadfsadf','2024-12-12','10:00:00',1,'2024-12-12','11:00:00');
/*!40000 ALTER TABLE `citas` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES
(1,'JERSSON PELAYO','QUISPE APAZA',72535244,'998777712','jersson.z032@gmail.com','','puno2','','2024-12-02 10:28:01','2024-12-02'),
(2,'IVAN JHUNIOR','HARO PRUDENCIO',77234732,'923489632',NULL,NULL,NULL,NULL,'2024-12-02 14:48:19','2024-12-02'),
(3,'NELIDA ADELINA','SANCHEZ RONCAL',73647628,'973824893',NULL,NULL,NULL,NULL,'2024-12-02 17:31:16','2024-12-02'),
(4,'DARWIN REYNOLDS','CARY QUISPE',70101961,'973584395',NULL,NULL,NULL,NULL,'2024-12-03 17:19:32','2024-12-03'),
(5,'DEYSI JULIANA','ONCOY AGUILAR',73243242,'932849632',NULL,NULL,NULL,NULL,'2024-12-03 22:02:45','2024-12-03'),
(6,'CLEMENTINA','SALVADOR YOVERA',72536723,'934879563',NULL,NULL,NULL,NULL,'2024-12-09 23:17:47','2024-12-09'),
(7,'SALOMON','ELIAS CARDENAS',71234232,'987328964',NULL,NULL,NULL,NULL,'2024-12-09 23:19:32','2024-12-09'),
(8,'','undefined undefined',69234123,'927846329',NULL,NULL,NULL,NULL,'2024-12-09 23:19:57','2024-12-09'),
(9,'RENZO PELAYO','QUISPE SUBIA',1298506,'923784673',NULL,NULL,NULL,NULL,'2024-12-09 23:22:19','2024-12-09'),
(10,'JAMES JAIR','BRIOSO GONZAGA',71325432,'93243242',NULL,NULL,NULL,NULL,'2024-12-09 23:35:28','2024-12-09'),
(11,'RAQUEL MIRELLA','DAMIAN RENGIFO',76328745,'932879463',NULL,NULL,NULL,NULL,'2024-12-09 23:36:29','2024-12-09');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

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
(1,1,'admin','$2y$10$Yt3wiTd14EdTf4dGepP49.pWnboRhcwcO9YJN0wNX0ncCT.kALZXO',1,2),
(2,5,'zeta','$2y$10$jCKq8MGoOhyn1hJdpvTdL.UGbZKVICya2ujbah9IZk7yz14XOzcwy',1,1),
(3,6,'silvia','$2y$10$RYYxrgzKC8acMj/arQQ11eWVdIk78muSgAyC5YCv2TaNgjwCrERY.',1,1);
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
  `monto` decimal(10,2) NOT NULL,
  `concepto` varchar(100) NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`idpagodetalle`),
  KEY `idpago` (`idpago`),
  CONSTRAINT `pago_detalles_ibfk_1` FOREIGN KEY (`idpago`) REFERENCES `pagos` (`idpago`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pago_detalles`
--

LOCK TABLES `pago_detalles` WRITE;
/*!40000 ALTER TABLE `pago_detalles` DISABLE KEYS */;
INSERT INTO `pago_detalles` VALUES
(1,1,150.50,'Primer Pago','2024-12-02 10:28:01'),
(2,2,200.00,'primer pago','2024-12-02 14:48:19'),
(3,3,275.30,'Primer Pago','2024-12-02 17:31:16'),
(4,4,100.00,'Primer Pago','2024-12-02 22:09:15'),
(5,1,50.00,'Segundo Pago','2024-12-03 07:18:32'),
(6,1,100.00,'Tercer Pago','2024-12-03 10:01:43'),
(8,1,50.00,'Cuarto Pago','2024-12-03 10:03:57'),
(9,1,25.00,'Quinto Pago','2024-12-03 10:08:39'),
(10,2,45.00,'Test numero 2','2024-12-03 10:09:09'),
(11,1,25.00,'Sexto Pago','2024-12-03 10:17:43'),
(14,3,124.30,'Segundo Pago','2024-12-03 10:45:45'),
(15,5,1200.00,'Primer Pago','2024-12-03 17:19:32'),
(16,6,150.00,'Primer Pago de Dental','2024-12-03 17:39:24'),
(17,6,150.00,'Segundo Pago test numero 2 en cliente con mas de un pago con diferente tratamiento','2024-12-03 17:45:10'),
(18,4,50.00,'Test #4','2024-12-03 21:02:27'),
(19,7,120.00,'Primer Pago','2024-12-03 22:02:45'),
(20,1,10.00,'Septimo pago','2024-12-03 22:17:24'),
(21,3,100.00,'test4','2024-12-03 22:18:06'),
(22,6,200.00,'ultimo pago','2024-12-03 22:18:51'),
(23,8,150.00,'primer pago','2024-12-03 22:20:32'),
(24,7,100.00,'fdedfg','2024-12-03 22:21:23'),
(25,2,10.00,'test 6','2024-12-03 22:21:42'),
(26,2,245.00,'test 7','2024-12-04 11:07:23'),
(28,2,200.00,'test 8','2024-12-04 11:08:21'),
(29,4,50.00,'test8 ','2024-12-04 11:09:22'),
(31,4,200.00,'test 8','2024-12-04 11:13:22'),
(32,7,100.00,'test 9','2024-12-04 11:17:38'),
(33,9,200.00,'primer pago','2024-12-04 13:40:46'),
(34,7,880.00,'test 10','2024-12-04 14:00:42'),
(36,9,800.00,'ultimo pago','2024-12-04 14:15:17'),
(37,3,400.40,'ultimo','2024-12-04 14:15:44'),
(39,1,10.00,'octavo pago','2024-12-04 18:38:55'),
(40,10,120.00,'Primer Pago','2024-12-09 23:17:47'),
(41,11,90.00,'Primer Pago','2024-12-09 23:19:32'),
(42,12,130.00,'Primer Pago','2024-12-09 23:19:57'),
(43,13,230.00,'pirmer pago','2024-12-09 23:22:19'),
(44,14,150.00,'Primer Pago','2024-12-09 23:35:28'),
(45,15,100.00,'Primer Pago','2024-12-09 23:36:29');
/*!40000 ALTER TABLE `pago_detalles` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagos`
--

LOCK TABLES `pagos` WRITE;
/*!40000 ALTER TABLE `pagos` DISABLE KEYS */;
INSERT INTO `pagos` VALUES
(1,1,1,420.50,379.50,144.00,800.00,'2024-12-02 10:28:01'),
(2,2,2,700.00,0.00,106.78,700.00,'2024-12-02 14:48:19'),
(3,3,3,900.00,0.00,144.00,900.00,'2024-12-02 17:31:16'),
(4,1,2,400.00,0.00,61.02,400.00,'2024-12-02 22:08:03'),
(5,4,2,1200.00,0.00,183.05,1200.00,'2024-12-03 17:19:32'),
(6,2,3,500.00,0.00,76.27,500.00,'2024-12-03 17:39:24'),
(7,5,2,1200.00,0.00,183.05,1200.00,'2024-12-03 22:02:45'),
(8,1,3,150.00,750.00,137.29,900.00,'2024-12-03 22:20:32'),
(9,5,3,1000.00,0.00,152.54,1000.00,'2024-12-04 13:40:46'),
(10,6,2,120.00,780.00,137.29,900.00,'2024-12-09 23:17:47'),
(11,7,3,90.00,450.00,82.37,540.00,'2024-12-09 23:19:32'),
(12,8,1,130.00,659.00,120.36,789.00,'2024-12-09 23:19:57'),
(13,9,1,230.00,660.00,135.76,890.00,'2024-12-09 23:22:19'),
(14,10,3,150.00,1350.00,228.81,1500.00,'2024-12-09 23:35:28'),
(15,11,1,100.00,443.00,82.83,543.00,'2024-12-09 23:36:29');
/*!40000 ALTER TABLE `pagos` ENABLE KEYS */;
UNLOCK TABLES;

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
(1,'ADMINISTRADOR','ADMINISTRADOR',72535244,'998777712','MASCULINO','jersson.z032@gmail.com',NULL,'2024-12-05',NULL,'2024-12-05'),
(5,'YOJAN VICTOR','QUISPE APAZA',72535242,'998777712','masculino','dotatiny@gmail.com',NULL,'1999-06-03','2024-12-04 21:32:37','2024-12-05'),
(6,'JULIO JHONATAN','SABINO VALDIVIA',72535243,'93242343','femenino','',NULL,'2024-12-25','2024-12-04 21:33:56','2024-12-05');
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
  `feCreate` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`idprocedimiento`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `procedimientos`
--

LOCK TABLES `procedimientos` WRITE;
/*!40000 ALTER TABLE `procedimientos` DISABLE KEYS */;
INSERT INTO `procedimientos` VALUES
(1,'Cirugia','Procedimiento de intervencion por cirugia','2024-12-01 21:01:40'),
(2,'Ortodoncia','ortodoncia, no conozco este procedimiento xd','2024-12-01 21:40:58'),
(3,'dental','tratamiento dental','2024-12-01 21:46:42');
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

-- Dump completed on 2024-12-12 10:30:58
