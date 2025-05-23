<?php 
class ClientesModel extends Model{
    function __construct(){
        parent::__construct();
    }
    // OBTENER UN SOLO CLIENTE PARA DETALLES
    public function GetOne($id){
        $sql = "SELECT * FROM clientes WHERE idcliente = '$id';";
        $data = $this->conn->ConsultaArray($sql);
        return $data;
    }
    // Condicion de un solo cliente para detalles
    public function Condicion($id){
        $sql = "SELECT antecedente_enfermedad, antecedente_observacion, medicado, medicado_observacion, complicacion_anestesia, anestesia_observacion, alergia_medicamento, alergiamedicamento_observacion, hemorragias, hemorragias_observacion, enfermedad, observaciones FROM clientes_condicion WHERE idcliente = '$id';";
        $data = $this->conn->ConsultaArray($sql);
        return $data;
        
    }

    public function Get(){
        $sql = "SELECT * FROM clientes ORDER BY idcliente DESC;";
        $data = $this->conn->ConsultaCon($sql);
        return $data;
    }
    public function NuevoCliente($nombre,$apellido,$dni,$telefono,$direccion){
        $this->conn->conn->begin_transaction();
        try{
            /* INSERTAR CLIENTE */
            $sql = "INSERT INTO clientes (nombre,apellido,dni,telefono,direccion) VALUES ('$nombre','$apellido','$dni','$telefono','$direccion');";
            $result = $this->conn->ConsultaSin($sql);
            $idcliente = $this->conn->conn->insert_id;
            $condicion = "INSERT INTO clientes_condicion (idcliente) VALUES('$idcliente');";
            $result = $this->conn->ConsultaSin($condicion);
            $this->conn->conn->commit();
            return true;
        }catch(Exception $e){
            $this->conn->conn->rollback();
            echo "Error: " . $e->getMessage();
        }
        $this->conn->conn->close();
    }
    public function GetProcedimientos():mysqli_result|bool{
        $sql = "SELECT idprocedimiento,procedimiento FROM procedimientos";
        $data = $this->conn->ConsultaCon($sql);
        return $data;
    }
    public function GetProcedimientosOne($idcliente){
        $sql = "SELECT pg.idcliente,pg.idpago,p.idprocedimiento,p.procedimiento FROM procedimientos p join pagos pg ON p.idprocedimiento = pg.idprocedimiento WHERE pg.idcliente = '$idcliente'";
        $data = $this->conn->ConsultaCon($sql);
        return $data;
    }
    // OBTIENE LOS DETALLES DEL PAGO DE UN CLIENTE->DE LA TABLA PAGO_DETALLES
    public function GetPagos($idpago){
        $sql = "SELECT idpago,monto,concepto,fecha FROM pago_detalles WHERE idpago = '$idpago';";
        $data = $this->conn->ConsultaCon($sql);
        return $data;
    }
    // OBTIENE EL PAGO DE UN CLIENTE-> SOLO DE LA TABLA PAGOS
    public function GetPago($idpago,$idprocedimiento){
        $sql = "SELECT monto_pagado, saldo_pendiente, total_pagar, feCreate FROM pagos WHERE idpago = '$idpago' AND idprocedimiento = '$idprocedimiento';";
        $data = $this->conn->ConsultaArray($sql);
        return $data;
    }
    public function NuevoPago($idpago,$idprocedimiento,$idcliente,$monto,$concepto,$nuevoMontoTotal,$nuevaDeudaTotal){
        $this->conn->conn->begin_transaction();
        try{
            $sqlNuevoPago = "INSERT INTO pago_detalles (idpago,monto,concepto) VALUES('$idpago','$monto','$concepto');";
            $resultNuevo = $this->conn->ConsultaSin($sqlNuevoPago);
            $sqlUpdatePago = "UPDATE pagos SET monto_pagado = '$nuevoMontoTotal', saldo_pendiente = '$nuevaDeudaTotal' WHERE idpago = '$idpago' AND idcliente = '$idcliente' AND idprocedimiento = '$idprocedimiento';";
            $resultUpdate = $this->conn->ConsultaSin($sqlUpdatePago);
            $this->conn->conn->commit();
            $result = $resultNuevo && $resultUpdate;
            return $result;
        }catch(Exception $e){
            $this->conn->conn->rollback();
            echo "Error: " . $e->getMessage();
        }
        $this->conn->conn->close();
    }
    // Verificar CLIENTE PARA NUEVO PAGO PERO SIN REGISTRAR DE NUEVO AL CLIENTE
    public function VerificarCliente($dni){
        $sql = "SELECT idcliente FROM clientes WHERE dni = '$dni';";
        $data = $this->conn->ConsultaArray($sql);
        return $data;
    }
    // SE USA ESTO CUANDO YA EXISTE UN CLIENTE
    public function NuevoPagoCliente($idcliente,$idprocedimiento,$totalpagar,$concepto,$primerpago){
        $this->conn->conn->begin_transaction();
        try{
            /* INSERTAR PAGOS HACIENDO CALCULOS */
            $saldo_pendiente = $totalpagar - $primerpago;
            $igv = round($totalpagar - ($totalpagar / 1.18),2);
            $sqlpago = "INSERT INTO pagos (idcliente,idprocedimiento,monto_pagado,saldo_pendiente,igv,total_pagar) VALUES ('$idcliente','$idprocedimiento','$primerpago','$saldo_pendiente','$igv','$totalpagar');";
            $resultpago = $this->conn->ConsultaSin($sqlpago);
            $idpago = $this->conn->conn->insert_id;
            /* INSERTAR PAGO DETALLES */
            $sqlpagodetalle = "INSERT INTO pago_detalles (idpago,monto,concepto) VALUES('$idpago','$primerpago','$concepto');";
            $resultpagodetalle = $this->conn->ConsultaSin($sqlpagodetalle);
            $this->conn->conn->commit();
            $result = $resultpago && $resultpagodetalle;
            return $result;
        }catch(Exception $e){
            $this->conn->conn->rollback();
            echo "Error: " . $e->getMessage();
        }
        $this->conn->conn->close();
    }
    public function ActualizarCliente($idcliente,$nombre,$apellido,$telefono,$email,$sexo,$ciudad,$direccion,$antecedente, $medicado, $anestesia, $alergiamedicamento, $hemorragias, $enfermedad, $observaciones, $antecedente_observacion, $medicado_observacion, $anestesia_observacion, $alergiamedicamento_observacion, $hemorragias_observacion){
        $this->conn->conn->begin_transaction();
        try{
            $fechaActualizacion = date('Y-m-d H:i:s');
            $fecha = date('Y-m-d');
            $sql = "UPDATE clientes SET nombre='$nombre', apellido='$apellido', telefono = '$telefono', email = '$email', sexo = '$sexo', ciudad = '$ciudad', direccion = '$direccion', feUpdate='$fechaActualizacion' WHERE idcliente = '$idcliente';";
            $result = $this->conn->ConsultaSin($sql);
            $sqlcondicion = "UPDATE clientes_condicion SET antecedente_enfermedad='$antecedente',antecedente_observacion='$antecedente_observacion', medicado='$medicado',medicado_observacion='$medicado_observacion', complicacion_anestesia='$anestesia',anestesia_observacion='$anestesia_observacion', alergia_medicamento='$alergiamedicamento',alergiamedicamento_observacion='$alergiamedicamento_observacion', hemorragias='$hemorragias',hemorragias_observacion='$hemorragias_observacion', enfermedad='$enfermedad',observaciones='$observaciones', feActualizacion='$fecha' WHERE idcliente = '$idcliente';";
            $result1 = $this->conn->ConsultaSin($sqlcondicion);
            $this->conn->conn->commit();
            return true;
        }catch(Exception $e){
            $this->conn->conn->rollback();
            echo "Error: " . $e->getMessage();
        }
        $this->conn->conn->close();
    }
    public function DataPagos($id){
        $sql = "SELECT p.total_pagar, proce.procedimiento FROM pagos p join procedimientos proce on proce.idprocedimiento = p.idprocedimiento WHERE idcliente = '$id';";
        $data = $this->conn->ConsultaCon($sql);
        return $data;
    }
    // CITAS
    public function onecita($id){
        $sql = "SELECT c.idcliente,e.idetiqueta,e.color,c.nombre,ci.idcita, ci.idcliente, ci.titulo, ci.idetiqueta, ci.fecha_ini, ci.hora_ini, ci.fecha_fin,ci.hora_fin FROM citas ci JOIN clientes c ON c.idcliente = ci.idcliente JOIN etiquetas e ON ci.idetiqueta=e.idetiqueta WHERE c.idcliente = '$id';";
        $data = $this->conn->ConsultaCon($sql);
        return $data;
    }
    public function CitasCliente($id){
        $sql = "SELECT fecha_ini, titulo, mensaje, hora_ini FROM citas WHERE idcliente = '$id' ORDER BY fecha_ini DESC;";
        $data = $this->conn->ConsultaCon($sql);
        return $data;
    }
}