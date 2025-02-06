# CLINICA: BASE DE DATOS

Esta base de datos gestiona la información de una clínica dental, incluyendo clientes, personal, tratamientos, pagos y citas. Permite un control eficiente de los servicios ofrecidos, los pagos realizados y las citas programadas.
# Nueva actualizacion de la base de datos para sistema de gestion de Consultorio Dental

## ENTIDADES

### PERSONAL

| **COLUMNA**  | **TIPO**         | **DESCRIPCION**                       |
| ------------ | ---------------- | ------------------------------------- |
| `idpersonal` | **INT(PK)**      | Identificador unico del personal      |
| `nombre`     | **VARCHAR(100)** | Nombre del personal                   |
| `apellido`   | **VARCHAR(100)** | Apellido del personal                 |
| `dni`        | **INT**          | Documento del identidad               |
| `telefono`   | **VARCHAR(15)**  | Numero de Contacto                    |
| `sexo`       | **VARCHAR(15)**  | Genero del personal                   |
| `email`      | **VARCHAR(100)**  | Correo electronico                   |
| `foto`       | **VARCHAR(200)** | URL O ruta de la foto del personal    |
| `fechaNac`   | **DATE**         | Fecha de Nacimiento                   |
| `feCreate`   | **DATETIME**     | Fecha y hora de creacion del registro |
| `feUpdate`   | **DATE**         | FEcha de la ultima actualizacion      |

### LOGIN

| **COLUMNA**  | **TIPO**         | **DESCRIPCION**                                   |
| ------------ | ---------------- | ------------------------------------------------- |
| `idlogin`    | **INT(PK)**      | Identificador unico del login                     |
| `idpersonal` | **INT(FK)**      | Relacion con la tabla `personal`                  |
| `username`   | **VARCHAR(50)**  | Nombre de usuario                                 |
| `password`   | **VARCHAR(300)** | Contrasena en formato hash                        |
| `estado`     | **TINYINT**      | Estado del login, 1->activo,0->inactivo           |
| `nivel`      | **TINYINT**      | Nivel del personal,1->administrador o 2->personal |

### CLIENTES

| **COLUMNA** | **TIPO**         | **DESCRIPCION**                     |
| ----------- | ---------------- | ----------------------------------- |
| `idcliente` | **INT(PK)**      | Identificador unico del cliente     |
| `nombre`    | **VARCHAR(100)** | Nombre del cliente                  |
| `apellido`  | **VARCHAR(100)** | Apellido del cliente                |
| `dni`       | **INT**          | Documento de identidad              |
| `telefono`  | **VARCHAR(15)**  | Numero de celular                   |
| `email`     | **VARCHAR(100)** | Correo electronico                  |
| `sexo`      | **VARCHAR(15)**  | Genero del cliente                  |
| `ciudad`    | **VARCHAR(100)** | Ciudad de procedencia               |
| `direccion` | **VARCHAR(100)** | Direccion actual                    |
| `feCreate`  | **DATETIME**     | Fecha de creacion del registro      |
| `feUpdate`  | **DATE**         | Fecha de actualizacion del registro |

### PAGOS

| **COLUMNA**       | **TIPO**          | **DESCRIPCION**                        |
| ----------------- | ----------------- | -------------------------------------- |
| `idpago`          | **INT(PK)**       | Identificador unico del pago           |
| `idcliente`       | **INT(FK)**       | Relacion con la tabla `cliente`        |
| `idprocedimiento` | **INT(FK)**       | Relacion con la tabla `procedimientos` |
| `monto_pagado`    | **DECIMAL(10,2)** | Pago total actual                      |
| `saldo_pendiente` | **DECIMAL(10,2)** | Deuda pendiente                        |
| `igv`             | **DECIMAL(10,2)** | Impuestos IGV                          |
| `total_pagar`     | **DECIMAL(10,2)** | Total a pagar por el servicio          |
| `feCreate`        | DATETIME          | Fecha de creacion del pago             |

### PAGO_DETALLEs

| **COLUMNA**     | **TIPO**          | **DESCRIPCION**                         |
| --------------- | ----------------- | --------------------------------------- |
| `idpagodetalle` | **INT(PK)**       | Identificador unico del detalle de pago |
| `idpago`        | **INT(FK)**       | Relacion con la tabla `pagos`           |
| `idpersonal`    | **INT(FK)**       | Relacion con la tabla `personal`        |
| `monto`         | **DECIMAL(10,2)** | Monto que pago                          |
| `concepto`      | **VARCHAR(100)**  | Concepto del pago realizado             |
| `pieza`         | **VARCHAR(20)**   | Numero de Pieza(Diente)                 |
| `fecha`         | **DATE**          | Fecha que se realizo el pago            |

### PROCEDIMIENTOS

| **COLUMNA**       | **TIPO**         | **DESCRIPCION**                       |
| ----------------- | ---------------- | ------------------------------------- |
| `idprocedimiento` | **INT(PK)**      | Identificador unico del procedimiento |
| `procedimiento`   | **VARCHAR(100)** | Nombre del procedimiento a realizar   |
| `descripcion`     | **TEXT**         | Descripcion del procedimiento         |
| `precio`          | **DECIMAL(10,2)**| Precio del procedimiento              |
| `iniciales`       | **VARCHAR(20)**  | Iniciales del procedimiento           |
| `feCreate`        | **DATE**         | Fecha de creacion                     |

### ETIQUETAS

| **COLUMNA** | **TIPO**     | **DESCRIPCION**                                                          |
| ----------- | ------------ | ------------------------------------------------------------------------ |
| `idetiqueta`| INT(PK)      | Identificador unico de la cita                                           |
| `idpersonal`| INT(FK)      | Relacion con la tabla `personal`                                         |
| `nombre`    | VARCHAR(50)  | Nombre de la etiqueta                                                    |
| `color`     | VARCHAR(50)  | Color que tendra de la  etiqueta                                         |

### CITAS

| **COLUMNA** | **TIPO**     | **DESCRIPCION**                                                          |
| ----------- | ------------ | ------------------------------------------------------------------------ |
| `idcita`    | INT(PK)      | Identificador unico de la cita                                           |
| `idcliente` | INT(FK)      | Relacion con la tabla `clientes`                                         |
| `idetiqueta`| INT(FK)      | Relacion con la tabla `etiquetas`                                        |
| `titulo`    | VARCHAR(50)  | Nombre de la cita                                                        |
| `mensaje`   | TEXT         | Algun mensaje en especifico sobre la cita                                |
| `fecha_ini` | DATE         | Fecha del inicio de la cita                                              |
| `hora_ini`  | TIME         | Hora del inicio de la cita                                               |
| `fecha_fin` | DATE         | Fecha de finalizacion de la cita                                         |
| `hora_fin`  | TIME         | Hora de finalizacion de la cita                                          |
| `estado`    | TINYINT      | Estado de la cita: 1->atendido,0->En espera,2->reprogramado,3->cancelado |


## RELACIONES

1. PERSONAL (1:1 LOGIN)
2. CLIENTES (1:N PAGOS)
3. PAGOS (1.N PAGOS_DETALLE)
4. PROCEDIMIENTOS (1:N PAGOS)
5. CLIENTES (1:N CITAS)
6. ETIQUETAS (1:N CITAS)

- La entidad PERSONAL tiene una relacion de 1 a 1 con la entidad LOGIN, ya que un personal solo puede tener un login

- La entidad CLIENTES tiene una relacion de 1 a Muchos con la entidad PAGOS, puesto que un clientes puede tener varios Pagos.

- La entidad PAGOS tiene una relacion de 1 a Muchos con la entidad PAGOS_DETALLE, por consecuensia de que un pago puede tener una varios detalles de cada pago que se va haciendo

- La entidad PROCEDIMIENTOS tiene una relacion de 1 a Muchos con la entidad PAGOS, porque 1 procedimiento puede estar incluidos en varios pagos.

- La entidad CLIENTES tiene una relacion de 1 a Muchos con la entidad CITAS, ya que un cliente puede tener varias citas

## REGLAS DE NEGOCIO
