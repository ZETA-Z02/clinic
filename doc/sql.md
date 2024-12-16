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
  `feCreate` datetime DEFAULT current_timestamp(),
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
  `feUpdate` date DEFAULT current_timestamp(),
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
  `monto` decimal(10,2) NOT NULL,
  `concepto` varchar(100) NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`idpagodetalle`),
  KEY `idpago` (`idpago`),
  CONSTRAINT `pago_detalles_ibfk_1` FOREIGN KEY (`idpago`) REFERENCES `pagos` (`idpago`)
);
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
);