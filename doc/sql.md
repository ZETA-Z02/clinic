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
);
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
);
CREATE TABLE `procedimientos` (
  `idprocedimiento` int(11) NOT NULL AUTO_INCREMENT,
  `procedimiento` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `iniciales` varchar(10) DEFAULT NULL,
  `feCreate` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`idprocedimiento`)
);
CREATE TABLE `etiquetas` (
  `idetiqueta` int(11) NOT NULL AUTO_INCREMENT,
  `idpersonal` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `color` varchar(50) NOT NULL,
  PRIMARY KEY (`idetiqueta`),
  UNIQUE KEY `idpersonal` (`idpersonal`),
  CONSTRAINT `etiquetas_ibfk_1` FOREIGN KEY (`idpersonal`) REFERENCES `personal` (`idpersonal`)
);

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
);
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
);
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
);
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
);

INSERT INTO `personal` VALUES
(1,'ADMINISTRADOR','ADMINISTRADOR',72535244,'998777712','MASCULINO','jersson.z032@gmail.com',NULL,'2024-12-05',NULL,'2024-12-05');

INSERT INTO `login` VALUES
(1,1,'admin','$2y$10$Yt3wiTd14EdTf4dGepP49.pWnboRhcwcO9YJN0wNX0ncCT.kALZXO',1,2);

INSERT INTO `procedimientos` VALUES
(1,'Consulta Dental','',50.00,'CONS','2024-12-01 21:01:40'),
(2,'Ortodoncia','',3500.00,'ORTO','2024-12-01 21:40:58'),
(3,'Sellantes','',50.00,'SELLA','2024-12-01 21:46:42'),
(4,'Restauracion de niños','',80.00,'rest ninos','2024-12-01 21:46:42'),
(5,'Restauracion Simple RFS','',120.00,'RFS','2025-02-05 11:40:28'),
(6,'Restauracion compueta RFC','',180.00,'RFC','2025-02-05 11:39:50'),
(7,'Restauracion Angular RFA','',180.00,'RFA','2025-01-19 19:31:36'),
(8,'Endodoncia Posteriores','',300.00,'ENDO','2025-02-05 11:42:07'),
(9,'Endodoncia Anteriores','',180.00,'ENAT','2025-02-05 11:43:16'),
(10,'Poste de Seguridad','',200.00,'POST','2025-02-05 11:43:33'),
(11,'Corona Porcelanato','',500.00,'CORO','2025-02-05 11:44:22'),
(12,'Corona Ivocron','',300.00,NULL,'2025-02-05 11:44:49'),
(13,'Provisional PPR','',400.00,'PPR','2025-02-05 11:45:20'),
(14,'Provisional Coronas','',80.00,NULL,'2025-02-05 11:45:48'),
(15,'Profilaxis + Fluorizacion','',300.00,NULL,'2025-02-05 11:46:11'),
(16,'Blanqueamiento Dental','',300.00,NULL,'2025-02-05 11:46:26'),
(17,'Exodoncia','',60.00,NULL,'2025-02-05 11:47:01'),
(18,'Tercer Molar','',300.00,NULL,'2025-02-05 11:47:21'),
(19,'Cirugia Gingivoplastia. ENCIA POR DIENTE','',100.00,NULL,'2025-02-05 11:47:21'),
(20,'Cirugia Gingivoplastia. OSEA POR DIENTE','',350.00,NULL,'2025-02-05 11:47:21'),
(21,'Cirugia Gingivoplastia. OSEA + ENCIA','',1500.00,NULL,'2025-02-05 11:47:21'),
(22,'Protesis Parcial Removible','',1000.00,NULL,'2025-02-05 11:50:23'),
(23,'Protesis Total Removible','',1000.00,NULL,'2025-02-05 11:50:46'),
(24,'Endodoncia + Poste de SEG. + Resina POSTERIORES','',550.00,NULL,'2025-02-05 11:50:46'),
(25,'Endodoncia + Poste de SEG. + Resina ANTERIORES','',350.00,NULL,'2025-02-05 11:50:46'),
(26,'Endodoncia + Poste de SEG. + Corona POSTERIORES','',930.00,NULL,'2025-02-05 11:50:46'),
(27,'Endodoncia + Poste de SEG. + Corona ANTERIORES','',830.00,NULL,'2025-02-05 11:50:46'),
(28,'RX','',20.00,NULL,'2025-02-05 11:51:04');

// COMPOSER INSTALL
// NPM INSTALL
// database root-clinic