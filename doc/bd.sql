-- Base de datos Clinic PROYECT
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

