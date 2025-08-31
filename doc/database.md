# CLINICA: BASE DE DATOS

Esta base de datos gestiona la información de una clínica dental, incluyendo clientes, personal, tratamientos, pagos y citas. Permite un control eficiente de los servicios ofrecidos, los pagos realizados y las citas programadas.

# Nueva actualizacion de la base de datos para sistema de gestion de Consultorio Dental

## ENTIDADES

### PERSONAL

| **COLUMNA**  | **TIPO**         | **DESCRIPCIÓN**                    |
| ------------ | ---------------- | ---------------------------------- |
| `idpersonal` | **INT(PK)**      | Identificador único del personal   |
| `nombre`     | **VARCHAR(100)** | Nombre del personal                |
| `apellido`   | **VARCHAR(100)** | Apellido del personal              |
| `dni`        | **INT**          | Documento de identidad             |
| `telefono`   | **VARCHAR(15)**  | Número de contacto                 |
| `sexo`       | **VARCHAR(15)**  | Género del personal                |
| `email`      | **VARCHAR(100)** | Correo electrónico                 |
| `foto`       | **VARCHAR(200)** | URL o ruta de la foto del personal |
| `fechaNac`   | **DATE**         | Fecha de nacimiento                |
| `feCreate`   | **DATETIME**     | Fecha de creación del registro     |
| `feUpdate`   | **DATETIME**     | Fecha de la última actualización   |

---

### LOGIN

| **COLUMNA**  | **TIPO**         | **DESCRIPCIÓN**                             |
| ------------ | ---------------- | ------------------------------------------- |
| `idlogin`    | **INT(PK)**      | Identificador único del login               |
| `idpersonal` | **INT(FK)**      | Relación con la tabla `personal`            |
| `username`   | **VARCHAR(50)**  | Nombre de usuario (único)                   |
| `password`   | **VARCHAR(300)** | Contraseña en formato hash                  |
| `estado`     | **TINYINT**      | Estado del login (1 = activo, 0 = inactivo) |
| `nivel`      | **TINYINT**      | Nivel de usuario (1 = admin, 2 = personal)  |

---

### CLIENTES

| **COLUMNA** | **TIPO**         | **DESCRIPCIÓN**                     |
| ----------- | ---------------- | ----------------------------------- |
| `idcliente` | **INT(PK)**      | Identificador único del cliente     |
| `nombre`    | **VARCHAR(50)**  | Nombre del cliente                  |
| `apellido`  | **VARCHAR(50)**  | Apellido del cliente                |
| `dni`       | **INT**          | Documento de identidad (único)      |
| `telefono`  | **VARCHAR(15)**  | Número de celular                   |
| `email`     | **VARCHAR(100)** | Correo electrónico                  |
| `sexo`      | **VARCHAR(15)**  | Género del cliente                  |
| `ciudad`    | **VARCHAR(100)** | Ciudad de procedencia               |
| `direccion` | **VARCHAR(100)** | Dirección actual                    |
| `feCreate`  | **DATETIME**     | Fecha de creación del registro      |
| `feUpdate`  | **DATETIME**     | Fecha de actualización del registro |

---

### CLIENTES_CONDICION

| **COLUMNA**                      | **TIPO**         | **DESCRIPCIÓN**                          |
| -------------------------------- | ---------------- | ---------------------------------------- |
| `idcondicion`                    | **INT(PK)**      | Identificador único de la condición      |
| `idcliente`                      | **INT(FK)**      | Relación con la tabla `clientes`         |
| `antecedente_enfermedad`         | **TINYINT**      | Tiene antecedentes de enfermedad (1/0)   |
| `antecedente_observacion`        | **VARCHAR(20)**  | Observaciones de antecedentes            |
| `medicado`                       | **TINYINT**      | Está medicado (1/0)                      |
| `medicado_observacion`           | **VARCHAR(20)**  | Observaciones de medicación              |
| `complicacion_anestesia`         | **TINYINT**      | Complicación con anestesia (1/0)         |
| `anestesia_observacion`          | **VARCHAR(20)**  | Observaciones sobre la anestesia         |
| `alergia_medicamento`            | **TINYINT**      | Alergia a medicamentos (1/0)             |
| `alergiamedicamento_observacion` | **VARCHAR(20)**  | Observaciones de alergias a medicamentos |
| `hemorragias`                    | **TINYINT**      | Historial de hemorragias (1/0)           |
| `hemorragias_observacion`        | **VARCHAR(20)**  | Observaciones sobre hemorragias          |
| `enfermedad`                     | **VARCHAR(100)** | Enfermedad que padece                    |
| `observaciones`                  | **TEXT**         | Observaciones generales                  |
| `feCreate`                       | **DATETIME**     | Fecha de creación                        |
| `feActualizacion`                | **DATE**         | Fecha de actualización                   |

---

### CITAS

| **COLUMNA**  | **TIPO**        | **DESCRIPCIÓN**                                                                 |
| ------------ | --------------- | ------------------------------------------------------------------------------- |
| `idcita`     | **INT(PK)**     | Identificador único de la cita                                                  |
| `idcliente`  | **INT(FK)**     | Relación con la tabla `clientes`                                                |
| `idetiqueta` | **INT(FK)**     | Relación con la tabla `etiquetas`                                               |
| `titulo`     | **VARCHAR(50)** | Título de la cita                                                               |
| `mensaje`    | **TEXT**        | Mensaje o detalle adicional                                                     |
| `fecha_ini`  | **DATE**        | Fecha de inicio de la cita                                                      |
| `hora_ini`   | **TIME**        | Hora de inicio de la cita                                                       |
| `estado`     | **TINYINT**     | Estado de la cita: 1 = atendido, 0 = pendiente, 2 = reprogramado, 3 = cancelado |
| `fecha_fin`  | **DATE**        | Fecha de finalización                                                           |
| `hora_fin`   | **TIME**        | Hora de finalización                                                            |

---

### ETIQUETAS

| **COLUMNA**  | **TIPO**        | **DESCRIPCIÓN**                    |
| ------------ | --------------- | ---------------------------------- |
| `idetiqueta` | **INT(PK)**     | Identificador único de la etiqueta |
| `idpersonal` | **INT(FK)**     | Relación con la tabla `personal`   |
| `nombre`     | **VARCHAR(50)** | Nombre de la etiqueta              |
| `color`      | **VARCHAR(50)** | Color de la etiqueta               |

---

### PROCEDIMIENTOS

| **COLUMNA**       | **TIPO**          | **DESCRIPCIÓN**                       |
| ----------------- | ----------------- | ------------------------------------- |
| `idprocedimiento` | **INT(PK)**       | Identificador único del procedimiento |
| `procedimiento`   | **VARCHAR(100)**  | Nombre del procedimiento              |
| `descripcion`     | **TEXT**          | Descripción del procedimiento         |
| `precio`          | **DECIMAL(10,2)** | Precio del procedimiento              |
| `iniciales`       | **VARCHAR(10)**   | Iniciales                             |
| `feCreate`        | **DATETIME**      | Fecha de creación                     |
| `color`           | **VARCHAR(50)**   | Color asignado (opcional)             |

---

### ODONTOGRAMA

| **COLUMNA**       | **TIPO**         | **DESCRIPCIÓN**                                               |
| ----------------- | ---------------- | ------------------------------------------------------------- |
| `idodontograma`   | **INT(PK)**      | Identificador único del odontograma                           |
| `idcliente`       | **INT(FK)**      | Relación con la tabla `clientes`                              |
| `idprocedimiento` | **INT(FK)**      | Relación con la tabla `procedimientos`                        |
| `pieza`           | **TINYINT**      | Número de pieza dental                                        |
| `imagen`          | **VARCHAR(400)** | Ruta de la imagen asociada                                    |
| `observaciones`   | **TEXT**         | Observaciones específicas                                     |
| `estado`          | **TINYINT**      | Estado: 1 = ZOE, 2 = D+I, 3 = DIR                             |
| `condicion`       | **TINYINT**      | Condición: 1 = sano, 2 = careado, 3 = ausente, 4 = restaurado |
| `feCreate`        | **DATE**         | Fecha de creación                                             |
| `feActualizacion` | **DATE**         | Fecha de actualización                                        |

---

### PAGOS

| **COLUMNA**       | **TIPO**          | **DESCRIPCIÓN**                        |
| ----------------- | ----------------- | -------------------------------------- |
| `idpago`          | **INT(PK)**       | Identificador único del pago           |
| `idcliente`       | **INT(FK)**       | Relación con la tabla `clientes`       |
| `idprocedimiento` | **INT(FK)**       | Relación con la tabla `procedimientos` |
| `monto_pagado`    | **DECIMAL(10,2)** | Monto pagado                           |
| `saldo_pendiente` | **DECIMAL(10,2)** | Saldo pendiente                        |
| `igv`             | **DECIMAL(10,2)** | Impuesto IGV                           |
| `total_pagar`     | **DECIMAL(10,2)** | Total a pagar                          |
| `feCreate`        | **DATETIME**      | Fecha de creación                      |

---

### PAGO_DETALLES

| **COLUMNA**     | **TIPO**          | **DESCRIPCIÓN**                         |
| --------------- | ----------------- | --------------------------------------- |
| `idpagodetalle` | **INT(PK)**       | Identificador único del detalle de pago |
| `idpago`        | **INT(FK)**       | Relación con la tabla `pagos`           |
| `idpersonal`    | **INT(FK)**       | Relación con la tabla `personal`        |
| `monto`         | **DECIMAL(10,2)** | Monto pagado                            |
| `concepto`      | **VARCHAR(100)**  | Concepto del pago                       |
| `pieza`         | **VARCHAR(20)**   | Pieza o diente                          |
| `fecha`         | **DATETIME**      | Fecha del pago                          |

---

### PRESUPUESTO_GENERAL

| **COLUMNA**            | **TIPO**          | **DESCRIPCIÓN**                             |
| ---------------------- | ----------------- | ------------------------------------------- |
| `idpresupuestogeneral` | **INT(PK)**       | Identificador único del presupuesto         |
| `idcliente`            | **INT(FK)**       | Relación con la tabla `clientes`            |
| `monto_pagado`         | **DECIMAL(10,2)** | Monto pagado                                |
| `deuda_pendiente`      | **DECIMAL(10,2)** | Deuda pendiente                             |
| `descuento`            | **DECIMAL(10,2)** | Descuento realizado                         |
| `total_pagar`          | **DECIMAL(10,2)** | Total a pagar                               |
| `estado`               | **TINYINT**       | Estado: 0 = pendiente, 1 = pagado ,         |
|                        |                   | solo debe haber un presupuesto en pendiente |
| `feCreate`             | **DATETIME**      | Fecha de creación                           |

---

### PRESUPUESTO_PROCEDIMIENTOS

| **COLUMNA**                  | **TIPO**          | **DESCRIPCIÓN**                     |
| ---------------------------- | ----------------- | ----------------------------------- |
| `idpresupuestoprocedimiento` | **INT(PK)**       | Identificador único del presupuesto |
| `idpresupuestogeneral`       | **INT(FK)**       | Relación con `presupuesto_general`  |
| `idprocedimiento`            | **INT(FK)**       | Relación con `procedimientos`       |
| `pieza`                      | **VARCHAR(20)**   | Pieza o diente                      |
| `precio`                     | **DECIMAL(10,2)** | Precio del procedimiento            |
| `fecha`                      | **DATE**          | Fecha que se agrego el procedimiento|

---

### PRESUPUESTO_PAGOS

| **COLUMNA**            | **TIPO**          | **DESCRIPCIÓN**                             |
| ---------------------- | ----------------- | ------------------------------------------- |
| `idpresupuestopago`    | **INT(PK)**       | Identificador único del pago de presupuesto |
| `idpresupuestogeneral` | **INT(FK)**       | Relación con `presupuesto_general`          |
| `importe`              | **DECIMAL(10,2)** | Importe del pago                            |
| `fecha`                | **DATETIME**      | Fecha del pago                              |

## RELACIONES

1. PERSONAL (1:1 LOGIN)

-   Un miembro del personal solo puede tener un login, y un login solo pertenece a un miembro del personal.

2. CLIENTES (1:N PAGOS)

-   Un cliente puede realizar múltiples pagos, pero cada pago está asociado a un solo cliente.

3. PAGOS (1:N PAGO_DETALLE)

-   Un pago puede desglosarse en múltiples detalles de pago.

4. PROCEDIMIENTOS (1:N PAGOS)

-   Un procedimiento puede ser incluido en múltiples pagos.

5. CLIENTES (1:N CITAS)

-   Un cliente puede agendar múltiples citas.

6. ETIQUETAS (1:N CITAS)

-   Una etiqueta puede aplicarse a múltiples citas.

7. CLIENTES (1:N ODONTOGRAMA)

-   Un cliente puede tener múltiples registros en el odontograma para distintas piezas dentales y procedimientos.

8. PROCEDIMIENTOS (1:N ODONTOGRAMA)

-   Un procedimiento puede estar asociado a múltiples registros en el odontograma.

## REGLAS DE NEGOCIO

1. Gestión de Usuarios

-   Solo el personal autorizado puede acceder al sistema mediante credenciales de login.

-   Se deben aplicar medidas de seguridad como el almacenamiento de contraseñas en formato hash.

2. Gestión de Clientes

-   Un cliente no puede agendar una cita si tiene pagos pendientes.

-   Los datos de contacto de los clientes deben ser validados antes del registro.

3. Gestión de Pagos

-   Todo pago debe estar asociado a un cliente y a un procedimiento.

-   No se puede registrar un pago si el monto supera el saldo pendiente.

-   Los pagos deben incluir impuestos (IGV) si aplica.

4. Gestión de Citas

-   No se pueden agendar citas en horarios que ya están ocupados.

-   Una cita debe cambiar a "atendida" solo si ha pasado la fecha y hora de finalización.

-   Se pueden reprogramar o cancelar citas con anticipación, pero se debe notificar al cliente.

5. Gestión del Odontograma

-   Cada registro del odontograma debe estar asociado a un cliente y a un procedimiento.

-   Una pieza dental no puede registrar el mismo procedimiento más de una vez en una fecha determinada.

-   Se debe permitir actualizar el estado y la condición del diente en el tiempo.

6. Control de Procedimientos

-   No se pueden registrar procedimientos sin un precio definido.

-   Un procedimiento debe estar asociado a un pago antes de ser realizado.

7. Reglas Generales del Sistema

-   Todo registro en el sistema debe contar con una fecha de creación y actualización.

-   Los estados de los registros deben manejar valores específicos (por ejemplo, 1 para activo, 0 para inactivo).

-   Se debe garantizar la integridad de los datos mediante validaciones en cada transacción.
