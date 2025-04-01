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
| `email`      | **VARCHAR(100)** | Correo electronico                    |
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

### clientes_condicion

| **COLUMNA**                      | **TIPO**         | **DESCRIPCION**                                   |
| -------------------------------- | ---------------- | ------------------------------------------------- |
| `idcondicion`                    | **INT(PK)**      | Identificador unico de la odontograma             |
| `idcliente`                      | **INT(FK)**      | Relacion con la tabla `clientes`                  |
| `antecedente_enfermedad`         | **TINYINT**      | Condicion del cliente, 1=>Si,2=>No,3=>No se sabe  |
| `antecedente_observacion`        | **VARCHAR(20)**  | Obervaciones de sus antecedentes con enfermedades |
| `medicado`                       | **TINYINT**      | Condicion del cliente, 1=>Si,2=>No,3=>No se sabe  |
| `medicado_observacion`           | **VARCHAR(20)**  | Observaciones de medimentos que toma              |
| `complicacion_anestesia`         | **TINYINT**      | Condicion del cliente, 1=>Si,2=>No,3=>No se sabe  |
| `anestesia_observacion`          | **VARCHAR(20)**  | Observaciones con la anestesia                    |
| `alergia_medicamento`            | **TINYINT**      | Condicion del cliente, 1=>Si,2=>No,3=>No se sabe  |
| `alergiamedicamento_observacion` | **VARCHAR(20)**  | Obervaciones con alergias a medicamentos          |
| `hemorragias`                    | **TINYINT**      | Condicion del cliente, 1=>Si,2=>No,3=>No se sabe  |
| `hemorragias_observacion`        | **VARCHAR(20)**  | Observaciones de las hemorragias anteriores       |
| `enfermedad`                     | **VARCHAR(100)** | Enfermedad que sufre el paciente(cliente)         |
| `observaciones`                  | **TEXT**         | Observacion sobre el cliente y su condicion       |
| `feCreate`                       | **DATE**         | Fecha de creacion                                 |
| `feActualizacion`                | **DATE**         | Fecha de Actualizacion                            |

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
| `feCreate`        | **DATETIME**      | Fecha de creacion del pago             |

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

| **COLUMNA**       | **TIPO**          | **DESCRIPCION**                       |
| ----------------- | ----------------- | ------------------------------------- |
| `idprocedimiento` | **INT(PK)**       | Identificador unico del procedimiento |
| `procedimiento`   | **VARCHAR(100)**  | Nombre del procedimiento a realizar   |
| `descripcion`     | **TEXT**          | Descripcion del procedimiento         |
| `precio`          | **DECIMAL(10,2)** | Precio del procedimiento              |
| `iniciales`       | **VARCHAR(20)**   | Iniciales del procedimiento           |
| `feCreate`        | **DATE**          | Fecha de creacion                     |
| `color`           | **VARCHAR(50)**   | Color que tendra de la etiqueta       |

### ETIQUETAS

| **COLUMNA**  | **TIPO**        | **DESCRIPCION**                  |
| ------------ | --------------- | -------------------------------- |
| `idetiqueta` | **INT(PK)**     | Identificador unico de la cita   |
| `idpersonal` | **INT(FK)**     | Relacion con la tabla `personal` |
| `nombre`     | **VARCHAR(50)** | Nombre de la etiqueta            |
| `color`      | **VARCHAR(50)** | Color que tendra de la etiqueta  |

### CITAS

| **COLUMNA**  | **TIPO**        | **DESCRIPCION**                                                          |
| ------------ | --------------- | ------------------------------------------------------------------------ |
| `idcita`     | **INT(PK)**     | Identificador unico de la cita                                           |
| `idcliente`  | **INT(FK)**     | Relacion con la tabla `clientes`                                         |
| `idetiqueta` | **INT(FK)**     | Relacion con la tabla `etiquetas`                                        |
| `titulo`     | **VARCHAR(50)** | Nombre de la cita                                                        |
| `mensaje`    | **TEXT**        | Algun mensaje en especifico sobre la cita                                |
| `fecha_ini`  | **DATE**        | Fecha del inicio de la cita                                              |
| `hora_ini`   | **TIME**        | Hora del inicio de la cita                                               |
| `fecha_fin`  | **DATE**        | Fecha de finalizacion de la cita                                         |
| `hora_fin`   | **TIME**        | Hora de finalizacion de la cita                                          |
| `estado`     | **TINYINT**     | Estado de la cita: 1->atendido,0->En espera,2->reprogramado,3->cancelado |

### ODONTOGRAMA

| **COLUMNA**       | **TIPO**         | **DESCRIPCION**                                                   |
| ----------------- | ---------------- | ----------------------------------------------------------------- |
| `idodontograma`   | **INT(PK)**      | Identificador unico de la odontograma                             |
| `idcliente`       | **INT(FK)**      | Relacion con la tabla `clientes`                                  |
| `idprocedimiento` | **INT(FK)**      | Relacion con la tabla `procedimientos`                            |
| `pieza`           | **TINYINT**      | Numero de la pieza                                                |
| `imagen`          | **VARCHAR(400)** | Ruta de la imagen en el servidor                                  |
| `observaciones`   | **TEXT**         | Algun mensaje en especifico sobre la pieza                        |
| `estado`          | **TINYINT**      | Estado que se encuentra en el procedimiento, 1=>ZOE,2=>D+I,3=>DIR |
| `condicion`       | **TINYINT**      | Condicion del diente, 1=>sano,2=>careado,3=>Ausente,4=>Restaurado |
| `feCreate`        | **DATE**         | Fecha de creacion                                                 |
| `feActualizacion` | **DATE**         | Fecha de Actualizacion                                            |

### PRESUPUESTOS

| **COLUMNA**       | **TIPO**          | **DESCRIPCION**                        |
| ----------------- | ----------------- | -------------------------------------- |
| `idpresupuesto`   | **INT(PK)**       | Identificador unico del presupuesto    |
| `idcliente`       | **INT(FK)**       | Relacion con la tabla `cliente`        |
| `idprocedimiento` | **INT(FK)**       | Relacion con la tabla `procedimientos` |
| `monto_pagado`    | **DECIMAL(10,2)** | Pago total actual                      |
| `deuda_pendiente` | **DECIMAL(10,2)** | Deuda pendiente                        |
| `total_pagar`     | **DECIMAL(10,2)** | Total a pagar por el servicio          |
| `feCreate`        | **DATETIME**      | Fecha de creacion del presupuesto      |

### PRESUPUESTO_DETALLES

| **COLUMNA**            | **TIPO**          | **DESCRIPCION**                                |
| ---------------------- | ----------------- | ---------------------------------------------- |
| `idpresupuestodetalle` | **INT(PK)**       | Identificador unico del detalle de presupuesto |
| `idpresupuesto`        | **INT(FK)**       | Relacion con la tabla `presupuesot`            |
| `pieza`                | **DECIMAL(10,2)** | Monto que pago en el presupuesto               |
| `importe`              | **VARCHAR(100)**  | Concepto del pago realizado                    |
| `fecha`                | **DATE**          | Fecha que se realizo el presupuesto            |

## RELACIONES

1. PERSONAL (1:1 LOGIN)

- Un miembro del personal solo puede tener un login, y un login solo pertenece a un miembro del personal.

2. CLIENTES (1:N PAGOS)

- Un cliente puede realizar múltiples pagos, pero cada pago está asociado a un solo cliente.

3. PAGOS (1:N PAGO_DETALLE)

- Un pago puede desglosarse en múltiples detalles de pago.

4. PROCEDIMIENTOS (1:N PAGOS)

- Un procedimiento puede ser incluido en múltiples pagos.

5. CLIENTES (1:N CITAS)

- Un cliente puede agendar múltiples citas.

6. ETIQUETAS (1:N CITAS)

- Una etiqueta puede aplicarse a múltiples citas.

7. CLIENTES (1:N ODONTOGRAMA)

- Un cliente puede tener múltiples registros en el odontograma para distintas piezas dentales y procedimientos.

8. PROCEDIMIENTOS (1:N ODONTOGRAMA)

- Un procedimiento puede estar asociado a múltiples registros en el odontograma.

## REGLAS DE NEGOCIO

1. Gestión de Usuarios

- Solo el personal autorizado puede acceder al sistema mediante credenciales de login.

- Se deben aplicar medidas de seguridad como el almacenamiento de contraseñas en formato hash.

2. Gestión de Clientes

- Un cliente no puede agendar una cita si tiene pagos pendientes.

- Los datos de contacto de los clientes deben ser validados antes del registro.

3. Gestión de Pagos

- Todo pago debe estar asociado a un cliente y a un procedimiento.

- No se puede registrar un pago si el monto supera el saldo pendiente.

- Los pagos deben incluir impuestos (IGV) si aplica.

4. Gestión de Citas

- No se pueden agendar citas en horarios que ya están ocupados.

- Una cita debe cambiar a "atendida" solo si ha pasado la fecha y hora de finalización.

- Se pueden reprogramar o cancelar citas con anticipación, pero se debe notificar al cliente.

5. Gestión del Odontograma

- Cada registro del odontograma debe estar asociado a un cliente y a un procedimiento.

- Una pieza dental no puede registrar el mismo procedimiento más de una vez en una fecha determinada.

- Se debe permitir actualizar el estado y la condición del diente en el tiempo.

6. Control de Procedimientos

- No se pueden registrar procedimientos sin un precio definido.

- Un procedimiento debe estar asociado a un pago antes de ser realizado.

7. Reglas Generales del Sistema

- Todo registro en el sistema debe contar con una fecha de creación y actualización.

- Los estados de los registros deben manejar valores específicos (por ejemplo, 1 para activo, 0 para inactivo).

- Se debe garantizar la integridad de los datos mediante validaciones en cada transacción.
