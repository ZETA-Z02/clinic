-- Base de datos Clinic PROYECT
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
CREATE TABLE `etiquetas` (
  `idetiqueta` int(11) NOT NULL AUTO_INCREMENT,
  `idpersonal` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `color` varchar(50) NOT NULL,
  PRIMARY KEY (`idetiqueta`),
  UNIQUE KEY `idpersonal` (`idpersonal`),
  CONSTRAINT `etiquetas_ibfk_1` FOREIGN KEY (`idpersonal`) REFERENCES `personal` (`idpersonal`)
);
CREATE TABLE `procedimientos` (
  `idprocedimiento` int(11) NOT NULL AUTO_INCREMENT,
  `procedimiento` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `iniciales` varchar(10) DEFAULT NULL,
  `feCreate` datetime DEFAULT current_timestamp(),
  `color` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idprocedimiento`)
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
);
CREATE TABLE `presupuesto_pagos` (
  `idpresupuestopago` int(11) NOT NULL AUTO_INCREMENT,
  `idpresupuestogeneral` int(11) NOT NULL,
  `importe` decimal(10,2) DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`idpresupuestopago`),
  KEY `idpresupuestogeneral` (`idpresupuestogeneral`),
  CONSTRAINT `presupuesto_pagos_ibfk_1` FOREIGN KEY (`idpresupuestogeneral`) REFERENCES `presupuesto_general` (`idpresupuestogeneral`)
);
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
);

-- Primer Personal
INSERT INTO `personal` VALUES
(1,'ADMINISTRADOR','ADMINISTRADOR',72535244,'998777712','MASCULINO','jersson.z032@gmail.com',NULL,'2024-12-05',NULL,'2024-12-05');
INSERT INTO `login` VALUES
(1,1,'admin','$2y$10$Yt3wiTd14EdTf4dGepP49.pWnboRhcwcO9YJN0wNX0ncCT.kALZXO',1,2);
INSERT INTO etiquetas VALUES(null, 1, 'AA', '#ffffff');
-- Primer Personal END

INSERT INTO `procedimientos` VALUES
(1,'Consulta Dental','',50.00,'CONS','2025-01-01 00:00:00','#a0a4ab'),
(2,'Ortodoncia','',3500.00,'ORTO','2025-01-01 00:00:00','#5679A6'),
(3,'Sellantes','',50.00,'SELLA','2025-01-01 00:00:00','#d9b929'),
(4,'Restauracion de niños','',80.00,'rest','2025-01-01 00:00:00','#ec121f'),
(5,'Restauracion Simple RFS','',120.00,'RFS','2025-01-01 00:00:00','#5498a9'),
(6,'Restauracion compueta RFC','',180.00,'RFC','2025-01-01 00:00:00','#9BAF47'),
(7,'Restauracion Angular RFA','',180.00,'RFA','2025-01-01 00:00:00','#00243f'),
(8,'Endodoncia Posteriores','',300.00,'ENDO','2025-01-01 00:00:00','#7b6e4c'),
(9,'Endodoncia Anteriores','',180.00,'ENAT','2025-01-01 00:00:00','#2d5f7d'),
(10,'Poste de Seguridad','',200.00,'POST','2025-01-01 00:00:00','#44b09e'),
(11,'Corona Porcelanato','',500.00,'CORO','2025-01-01 00:00:00','#C1663B'),
(12,'Corona Ivocron','',300.00,'CIVO','2025-01-01 00:00:00','#D8A578'),
(13,'Provisional PPR','',400.00,'PPR','2025-01-01 00:00:00','#9aa8a8'),
(14,'Provisional Coronas','',80.00,'PROC','2025-01-01 00:00:00','#b00002'),
(15,'Profilaxis + Fluorizacion','',300.00,'PROF','2025-01-01 00:00:00','#645045'),
(16,'Blanqueamiento Dental','',300.00,'BLAN','2025-01-01 00:00:00','#C6C3B5'),
(17,'Exodoncia','',60.00,'EXOD','2025-01-01 00:00:00','#1e582a'),
(18,'Tercer Molar','',300.00,'TMOL','2025-01-01 00:00:00','#b9848c'),
(19,'Cirugia Gingivoplastia. ENCIA POR DIENTE','',100.00,'GENG','2025-01-01 00:00:00','#806491'),
(20,'Cirugia Gingivoplastia. OSEA POR DIENTE','',350.00,'GOSD','2025-01-01 00:00:00','#c3de00'),
(21,'Cirugia Gingivoplastia. OSEA + ENCIA','',1500.00,'GOEN','2025-01-01 00:00:00','#344c11'),
(22,'Protesis Parcial Removible','',1000.00,'PPR','2025-01-01 00:00:00','#686461'),
(23,'Protesis Total Removible','',1000.00,'PTR','2025-01-01 00:00:00','#854277'),
(24,'Endodoncia + Poste de SEG. + Resina POSTERIORES','',550.00,'EPPR','2025-01-01 00:00:00','#4d3474'),
(25,'Endodoncia + Poste de SEG. + Resina ANTERIORES','',350.00,'EPRA','2025-01-01 00:00:00','#5F7B86'),
(26,'Endodoncia + Poste de SEG. + Corona POSTERIORES','',930.00,'EPCP','2025-01-01 00:00:00','#4D6570'),
(27,'Endodoncia + Poste de SEG. + Corona ANTERIORES','',830.00,'EPCA','2025-01-01 00:00:00','#3B4F58'),
(28,'RX','',20.00,'RX','2025-02-05 11:51:04','#2A3D46'),
(29,'otro','',500.00,'otro','2025-02-16 13:24:32','#1B2C34');

// COMPOSER INSTALL
// NPM INSTALL
// database root-clinic