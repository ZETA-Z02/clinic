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
-- Dumping data for table `citas`
--

LOCK TABLES `citas` WRITE;
/*!40000 ALTER TABLE `citas` DISABLE KEYS */;
INSERT INTO `citas` VALUES
(1,1,2,'nueva cita','Es una nueva cita para probar el formulario','2024-12-08','15:00:00',1,'2024-12-08','16:00:00'),
(5,4,2,'test numero 5','algo que decir aqui','2024-12-08','07:00:00',1,'2024-12-08','07:00:00'),
(7,3,2,'nelida cita','algo','2024-12-09','07:00:00',1,'2024-12-09','07:00:00'),
(12,1,2,'New Cite Alv','nueva cita ctm','2024-12-11','07:00:00',1,'2024-12-11','07:00:00'),
(13,2,2,'titulos','notas','2024-12-25','07:00:00',1,'2024-12-25','07:00:00'),
(14,5,2,'ortodoncia','sadfsadf','2024-12-12','10:00:00',1,'2024-12-12','11:00:00'),
(15,9,2,'algo','','2025-01-10','07:00:00',1,'2025-01-10','07:00:00'),
(16,5,2,'otra cosa mas','','2025-01-10','08:00:00',1,'2025-01-10','09:00:00'),
(17,3,2,'dame mas','','2025-01-10','07:00:00',1,'2025-01-10','07:00:00'),
(18,14,2,'uno mas','','2025-01-10','07:00:00',1,'2025-01-10','07:00:00'),
(19,21,2,'dame mas ','','2025-01-10','07:00:00',1,'2025-01-10','07:00:00'),
(20,6,2,'algo ,as','','2025-01-09','07:00:00',1,'2025-01-09','07:00:00'),
(21,21,2,'nueva cita','','2025-01-11','10:00:00',1,'2025-01-11','10:30:00'),
(22,9,2,'rojo','','2025-01-11','07:00:00',1,'2025-01-11','08:00:00'),
(23,10,2,'azul','','2025-01-11','09:30:00',1,'2025-01-11','10:30:00'),
(24,1,2,'AA-JERSSON-Ciru-30M-AA','','2025-01-20','07:00:00',1,'2025-01-20','07:00:00'),
(25,9,7,'YQ-RENZO-Orto-1H30M-JS','','2025-01-21','07:00:00',1,'2025-01-21','07:00:00'),
(26,21,3,'JS-JHENNIFER-Orto-30M-JS','','2025-01-22','07:00:00',1,'2025-01-22','07:00:00'),
(27,1,3,'JS-JERSSON-dent-1H-YQ','','2025-01-21','07:00:00',1,'2025-01-21','07:00:00'),
(28,1,3,'JS-JERSSON-Orto-30M-YQ','cambiar arco 16','2025-01-08','07:00:00',1,'2025-01-08','07:00:00'),
(29,21,3,'JS-JHENNIFER-Orto-30M-JS','','2025-01-29','07:00:00',1,'2025-01-29','07:00:00'),
(30,1,2,'AA-JERSSON-Ciru-30M-AA','','2025-01-27','07:00:00',1,'2025-01-27','07:00:00'),
(31,21,3,'JS-JHENNIFER-Orto-30M-JS','','2025-02-03','07:00:00',1,'2025-02-03','07:00:00'),
(32,1,2,'AA-JERSSON-Ciru-30M-AA','','2025-02-05','07:00:00',1,'2025-02-05','07:00:00'),
(33,21,3,'JS-JHENNIFER-Orto-30M-JS','','2025-02-06','07:00:00',1,'2025-02-06','07:00:00'),
(34,21,3,'JS-JHENNIFER-Orto-30M-JS','','2025-02-04','07:00:00',1,'2025-02-04','07:00:00');
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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
(8,'Alberto','Apaza',69234123,'927846329','','','','','2024-12-09 23:19:57','2024-12-09'),
(9,'RENZO PELAYO','QUISPE SUBIA',1298506,'923784673',NULL,NULL,NULL,NULL,'2024-12-09 23:22:19','2024-12-09'),
(10,'JAMES JAIR','BRIOSO GONZAGA',71325432,'93243242',NULL,NULL,NULL,NULL,'2024-12-09 23:35:28','2024-12-09'),
(11,'RAQUEL MIRELLA','DAMIAN RENGIFO',76328745,'932879463',NULL,NULL,NULL,NULL,'2024-12-09 23:36:29','2024-12-09'),
(13,'SEBASTIAN ALDO','MELENDEZ ARGUELLES',73840912,'973829742',NULL,NULL,NULL,NULL,'2025-01-09 12:00:51','2025-01-09'),
(14,'DANTE YEFERSON','HERMOZA FRANCO',70234324,'893624896',NULL,NULL,NULL,NULL,'2025-01-09 12:02:08','2025-01-09'),
(21,'JHENNIFER IRENE','CÓRDOVA VALDIVIA',70000000,'986329463',NULL,NULL,NULL,NULL,'2025-01-09 12:18:38','2025-01-09'),
(22,'ALEXANDER ABRANCZIK','MAQUE CHICAÑA',70991823,'926187361','dota2jersson3@gmail.com','','Puno','jr. Piura 312','2025-01-15 14:09:02','2025-01-15'),
(23,'CHRISTOPHER JUNIOR','CHAVIL ROMAYNA',72783568,'923894328',NULL,NULL,NULL,'jr pierdete buscando','2025-02-05 20:03:58','2025-02-05'),
(24,'FRANCISCO JOSE ALBERTO','RODRIGUEZ CAMPOS',71233523,'893946732',NULL,NULL,NULL,'leoncio prado','2025-02-05 20:05:06','2025-02-05');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `etiquetas`
--

LOCK TABLES `etiquetas` WRITE;
/*!40000 ALTER TABLE `etiquetas` DISABLE KEYS */;
INSERT INTO `etiquetas` VALUES
(3,6,'JJ','#000000'),
(8,5,'YV','#a51d2d');
/*!40000 ALTER TABLE `etiquetas` ENABLE KEYS */;
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
-- Dumping data for table `pago_detalles`
--

LOCK TABLES `pago_detalles` WRITE;
/*!40000 ALTER TABLE `pago_detalles` DISABLE KEYS */;
INSERT INTO `pago_detalles` VALUES
(1,1,6,150.50,'Primer Pago','1','2024-12-02 10:28:01'),
(2,2,6,200.00,'primer pago','1','2024-12-02 14:48:19'),
(3,3,6,275.30,'Primer Pago','1','2024-12-02 17:31:16'),
(4,4,6,100.00,'Primer Pago','1','2024-12-02 22:09:15'),
(5,1,6,50.00,'Segundo Pago','1','2024-12-03 07:18:32'),
(6,1,6,100.00,'Tercer Pago','1','2024-12-03 10:01:43'),
(8,1,6,50.00,'Cuarto Pago','1','2024-12-03 10:03:57'),
(9,1,6,25.00,'Quinto Pago','1','2024-12-03 10:08:39'),
(10,2,6,45.00,'Test numero 2','1','2024-12-03 10:09:09'),
(11,1,6,25.00,'Sexto Pago','1','2024-12-03 10:17:43'),
(14,3,6,124.30,'Segundo Pago','1','2024-12-03 10:45:45'),
(15,5,6,1200.00,'Primer Pago','1','2024-12-03 17:19:32'),
(16,6,6,150.00,'Primer Pago de Dental','1','2024-12-03 17:39:24'),
(17,6,6,150.00,'Segundo Pago test numero 2 en cliente con mas de un pago con diferente tratamiento','1','2024-12-03 17:45:10'),
(18,4,6,50.00,'Test #4','1','2024-12-03 21:02:27'),
(19,7,6,120.00,'Primer Pago','1','2024-12-03 22:02:45'),
(20,1,6,10.00,'Septimo pago','1','2024-12-03 22:17:24'),
(21,3,6,100.00,'test4','1','2024-12-03 22:18:06'),
(22,6,6,200.00,'ultimo pago','1','2024-12-03 22:18:51'),
(23,8,6,150.00,'primer pago','1','2024-12-03 22:20:32'),
(24,7,6,100.00,'fdedfg','1','2024-12-03 22:21:23'),
(25,2,6,10.00,'test 6','1','2024-12-03 22:21:42'),
(26,2,6,245.00,'test 7','1','2024-12-04 11:07:23'),
(28,2,6,200.00,'test 8','1','2024-12-04 11:08:21'),
(29,4,6,50.00,'test8 ','1','2024-12-04 11:09:22'),
(31,4,6,200.00,'test 8','1','2024-12-04 11:13:22'),
(32,7,6,100.00,'test 9','1','2024-12-04 11:17:38'),
(33,9,6,200.00,'primer pago','1','2024-12-04 13:40:46'),
(34,7,6,880.00,'test 10','1','2024-12-04 14:00:42'),
(36,9,6,800.00,'ultimo pago','1','2024-12-04 14:15:17'),
(37,3,6,400.40,'ultimo','1','2024-12-04 14:15:44'),
(39,1,6,10.00,'octavo pago','1','2024-12-04 18:38:55'),
(40,10,6,120.00,'Primer Pago','1','2024-12-09 23:17:47'),
(41,11,6,90.00,'Primer Pago','1','2024-12-09 23:19:32'),
(42,12,6,130.00,'Primer Pago','1','2024-12-09 23:19:57'),
(43,13,6,230.00,'pirmer pago','1','2024-12-09 23:22:19'),
(44,14,6,150.00,'Primer Pago','1','2024-12-09 23:35:28'),
(45,15,6,100.00,'Primer Pago','1','2024-12-09 23:36:29'),
(46,8,6,11.00,'sdfgdsf','1','2025-01-09 09:39:30'),
(47,8,6,15.00,'prueba','1','2025-01-09 11:03:24'),
(48,8,6,10.00,'test12','1','2025-01-09 11:07:23'),
(49,16,6,100.00,'primer pago','1','2025-01-09 12:00:51'),
(50,17,6,100.00,'algo','1','2025-01-09 12:02:08'),
(51,18,6,150.00,'primer pago','1','2025-01-09 12:18:38'),
(52,19,6,200.00,'pago no se de que','1','2025-01-09 12:36:24'),
(53,20,6,100.00,'primer pago','1','2025-01-09 14:40:23'),
(54,20,6,10.00,'concepto','1','2025-01-09 14:40:33'),
(55,21,6,10.00,'primer pago','1.2','2025-01-15 14:09:02'),
(56,1,6,10.00,'algo','1','2025-01-22 21:21:36'),
(57,28,6,100.00,NULL,'1.1','2025-01-27 22:09:52'),
(58,29,6,200.00,NULL,'1.1','2025-01-27 22:12:15'),
(59,30,5,100.00,NULL,'1.1','2025-01-28 13:04:33'),
(60,31,6,50.00,NULL,'1.1','2025-01-28 13:06:22'),
(61,32,6,50.00,NULL,'1.1','2025-01-28 13:07:32'),
(62,33,5,100.00,NULL,'3.5','2025-01-28 13:07:43'),
(63,1,5,100.00,NULL,'1.3','2025-01-28 15:10:53'),
(64,1,5,100.00,NULL,'2.8','2025-01-28 15:14:04'),
(65,1,5,55.00,NULL,'3.3','2025-01-28 15:14:17'),
(66,1,6,114.50,NULL,'4.7','2025-01-28 15:14:37'),
(67,31,5,25.00,NULL,'2.8','2025-01-28 15:16:50'),
(71,21,5,100.00,NULL,'2.5','2025-01-30 20:05:12'),
(72,18,5,200.00,NULL,'2.1','2025-01-31 12:13:20'),
(73,34,6,50.00,NULL,'4.8','2025-01-31 12:13:41'),
(74,35,5,100.00,NULL,'3.5','2025-01-31 12:14:07'),
(75,36,6,200.00,NULL,'3.2','2025-01-31 12:19:19'),
(76,17,5,300.00,NULL,'3.5','2025-01-31 12:21:29'),
(77,37,5,100.00,NULL,'1.8','2025-01-31 12:21:51'),
(78,38,6,100.00,NULL,'2.7','2025-01-31 12:22:56'),
(79,16,5,200.00,NULL,'2.4','2025-01-31 12:28:27'),
(80,39,6,100.00,NULL,'4.3','2025-01-31 12:28:49'),
(84,40,6,200.00,NULL,'2.4','2025-02-05 15:51:36'),
(85,41,5,100.00,NULL,'6','2025-02-05 15:53:55'),
(87,43,6,100.00,NULL,'2.4','2025-02-05 20:05:51');
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
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagos`
--

LOCK TABLES `pagos` WRITE;
/*!40000 ALTER TABLE `pagos` DISABLE KEYS */;
INSERT INTO `pagos` VALUES
(1,1,1,800.00,0.00,144.00,800.00,'2024-12-02 10:28:01'),
(2,2,2,700.00,0.00,106.78,700.00,'2024-12-02 14:48:19'),
(3,3,3,900.00,0.00,144.00,900.00,'2024-12-02 17:31:16'),
(4,1,2,400.00,0.00,61.02,400.00,'2024-12-02 22:08:03'),
(5,4,2,1200.00,0.00,183.05,1200.00,'2024-12-03 17:19:32'),
(6,2,3,500.00,0.00,76.27,500.00,'2024-12-03 17:39:24'),
(7,5,2,1200.00,0.00,183.05,1200.00,'2024-12-03 22:02:45'),
(8,1,3,186.00,714.00,137.29,900.00,'2024-12-03 22:20:32'),
(9,5,3,1000.00,0.00,152.54,1000.00,'2024-12-04 13:40:46'),
(10,6,2,120.00,780.00,137.29,900.00,'2024-12-09 23:17:47'),
(11,7,3,90.00,450.00,82.37,540.00,'2024-12-09 23:19:32'),
(12,8,1,130.00,659.00,120.36,789.00,'2024-12-09 23:19:57'),
(13,9,1,230.00,660.00,135.76,890.00,'2024-12-09 23:22:19'),
(14,10,3,150.00,1350.00,228.81,1500.00,'2024-12-09 23:35:28'),
(15,11,1,100.00,443.00,82.83,543.00,'2024-12-09 23:36:29'),
(16,13,1,300.00,500.00,122.03,800.00,'2025-01-09 12:00:51'),
(17,14,3,400.00,4600.00,762.71,5000.00,'2025-01-09 12:02:08'),
(18,21,3,350.00,8650.00,1372.88,9000.00,'2025-01-09 12:18:38'),
(19,1,3,200.00,9800.00,1525.42,10000.00,'2025-01-09 12:36:24'),
(20,21,1,110.00,390.00,76.27,500.00,'2025-01-09 14:40:23'),
(21,22,1,110.00,390.00,76.27,500.00,'2025-01-15 14:09:02'),
(28,1,1,100.00,400.00,76.27,500.00,'2025-01-27 22:09:52'),
(29,1,1,200.00,300.00,76.27,500.00,'2025-01-27 22:12:15'),
(30,1,2,100.00,300.00,61.02,400.00,'2025-01-28 13:04:33'),
(31,1,7,75.00,25.00,15.25,100.00,'2025-01-28 13:06:22'),
(32,1,1,50.00,450.00,76.27,500.00,'2025-01-28 13:07:32'),
(33,1,3,100.00,100.00,30.51,200.00,'2025-01-28 13:07:43'),
(34,21,3,50.00,150.00,30.51,200.00,'2025-01-31 12:13:41'),
(35,21,2,100.00,300.00,61.02,400.00,'2025-01-31 12:14:07'),
(36,21,2,200.00,150.00,53.39,350.00,'2025-01-31 12:19:19'),
(37,14,2,100.00,100.00,30.51,200.00,'2025-01-31 12:21:51'),
(38,14,2,100.00,600.00,106.78,700.00,'2025-01-31 12:22:56'),
(39,13,2,100.00,250.00,53.39,350.00,'2025-01-31 12:28:49'),
(40,22,2,200.00,200.00,61.02,400.00,'2025-02-04 11:40:05'),
(41,22,2,100.00,300.00,61.02,400.00,'2025-02-05 15:53:55'),
(42,24,1,0.00,100.00,15.25,100.00,'2025-02-05 20:05:23'),
(43,24,3,100.00,100.00,30.51,200.00,'2025-02-05 20:05:51');
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
