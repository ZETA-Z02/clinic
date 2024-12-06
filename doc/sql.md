CREATE TABLE `personal` (
  `idpersonal` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `dni` int(11) UNIQUE NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `sexo` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `foto` varchar(200) DEFAULT NULL,
  `fechaNac` date DEFAULT NULL,
  `feCreate` datetime DEFAULT current_timestamp(),
  `feUpdate` date DEFAULT current_timestamp(),
  PRIMARY KEY (`idpersonal`)
);
CREATE TABLE `login` (
  `idlogin` int(11) NOT NULL AUTO_INCREMENT,
  `idpersonal` int(11) NOT NULL,
  `username` varchar(50) UNIQUE NOT NULL,
  `password` varchar(300) NOT NULL,
  `estado` TINYINT DEFAULT 1,
  `nivel` TINYINT DEFAULT 1,
  PRIMARY KEY (`idlogin`),
  FOREIGN KEY(`idpersonal`) REFERENCES personal(`idpersonal`)

);
CREATE TABLE `procedimientos` (
  `idprocedimiento` int(11) NOT NULL AUTO_INCREMENT,
  `procedimiento` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `feCreate` DATETIME DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`idprocedimiento`)
);
CREATE TABLE `clientes` (
  `idcliente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `dni` int(11) UNIQUE NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `sexo` varchar(15) DEFAULT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `feCreate` datetime DEFAULT current_timestamp(),
  `feUpdate` date DEFAULT current_timestamp(),
  PRIMARY KEY (`idcliente`)
);
CREATE TABLE `pagos` (
  `idpago` int(11) NOT NULL AUTO_INCREMENT,
  `idcliente` int(11) DEFAULT NULL,
  `idprocedimiento` int(11) NOT NULL,
  `monto_pagado` DECIMAL(10,2) NOT NULL,
  `saldo_pendiente` DECIMAL(10,2) NOT NULL,
  `igv` DECIMAL(10,2) DEFAULT NULL,
  `total_pagar` DECIMAL(10,2) NOT NULL,
  `feCreate` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`idpago`),
  FOREIGN KEY (`idcliente`) REFERENCES clientes(`idcliente`),
  FOREIGN KEY (`idprocedimiento`) REFERENCES procedimientos(`idprocedimiento`)
);
CREATE TABLE `pago_detalles` (
  `idpagodetalle` int(11) NOT NULL AUTO_INCREMENT,
  `idpago` int(11) NOT NULL,
  `monto` DECIMAL(10,2) NOT NULL,
  `concepto` varchar(100) NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`idpagodetalle`),
  FOREIGN KEY (`idpago`) REFERENCES pagos(`idpago`)
);
CREATE TABLE `citas` (
  `idcita` int(11) NOT NULL AUTO_INCREMENT,
  `idcliente` int(11) NOT NULL,
  `titulo` VARCHAR(50) NOT NULL,
  `etiqueta` varchar(100) DEFAULT NULL,
  `mensaje` text DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `estado` tinyint DEFAULT 1,
  PRIMARY KEY (`idcita`),
  FOREIGN KEY(`idcliente`) REFERENCES clientes(`idcliente`)
);