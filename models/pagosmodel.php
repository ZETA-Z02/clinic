<?php  
class PagosModel extends Model{
    function __construct(){
        parent::__construct();
    }
    // PROCEDIMIENTOS
    public function GetProcedimientos($type=null){
        $sql = "SELECT idprocedimiento, procedimiento, precio FROM procedimientos";
        if($type == 'ortodoncia'){
            $sql .= " WHERE procedimiento = 'ortodoncia';";
        }else if($type == 'otros'){
            $sql .= " WHERE idprocedimiento > 28;";
        }
        else{
            $sql .= " WHERE procedimiento != 'ortodoncia' AND idprocedimiento <= '28';";
        }
        $data = $this->conn->ConsultaCon($sql);
        return $data;
    }
    public function GetOneProcedimiento($id){
        $sql = "SELECT idprocedimiento, precio FROM procedimientos WHERE idprocedimiento = '$id';";
        $data = $this->conn->ConsultaArray($sql);
        return $data;
    }
    public function GetDoctores(){
        $sql = "SELECT p.idpersonal,p.nombre,p.apellido,e.nombre as etiqueta FROM personal p JOIN etiquetas e ON p.idpersonal = e.idpersonal where p.idpersonal != 1;";
        $data = $this->conn->ConsultaCon($sql);
        return $data;
    }
    public function Get(){
        $sql = "SELECT * FROM pagos";
        $data = $this->conn->ConsultaCon($sql);
        return $data;
    }
    public function GetOne($id){
        $sql = "SELECT * FROM clientes WHERE idcliente = '$id';";
        $data = $this->conn->ConsultaArray($sql);
        return $data;
    }
    // PRESUPUESTO GENERAL
    public function GetPresupuestoGeneral($id){
        $sql = "SELECT p.idpago,pro.procedimiento,p.monto_pagado,p.saldo_pendiente,p.total_pagar,pd.idpagodetalle,pd.monto,pd.concepto,pd.pieza,pd.fecha, pd.idpersonal,e.nombre AS etiqueta
                FROM pagos p 
                JOIN pago_detalles pd ON p.idpago = pd.idpago 
                JOIN procedimientos pro ON p.idprocedimiento = pro.idprocedimiento 
                JOIN etiquetas e ON e.idpersonal = pd.idpersonal
                WHERE p.idcliente = '$id' AND pro.procedimiento != 'ortodoncia' AND pro.idprocedimiento <= 28 ORDER BY p.idpago ASC, pd.fecha ASC;";
        $data = $this->conn->ConsultaCon($sql);
        return $data;
    }
    public function NuevoProcedimientoPago($idcliente, $idprocedimiento, $monto, $pieza, $idpersonal,$total){
        $this->conn->conn->begin_transaction();
        try{
            /* INSERTAR PAGOS HACIENDO CALCULOS */
            //$precioProcedimiento = $this->GetOneProcedimiento($idprocedimiento);
            if($total < $monto){
                throw new Exception("Error: El monto supera al total");
            }
            $precioProcedimiento = $total;
            $saldo_pendiente = $precioProcedimiento - $monto;
            $igv = round($precioProcedimiento - ($precioProcedimiento / 1.18),2);
            $sqlpago = "INSERT INTO pagos (idcliente,idprocedimiento,monto_pagado,saldo_pendiente,igv,total_pagar) VALUES ('$idcliente','$idprocedimiento','$monto','$saldo_pendiente','$igv','$precioProcedimiento');";
            $resultpago = $this->conn->ConsultaSin($sqlpago);
            $idpago = $this->conn->conn->insert_id;
            /* INSERTAR PAGO DETALLES */
            $sqlpagodetalle = "INSERT INTO pago_detalles (idpago,idpersonal, monto,pieza) VALUES('$idpago','$idpersonal','$monto','$pieza');";
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
    // Nuevo PAgo de un procedimiento ya creado
    public function NuevoPago($idpago, $idcliente, $idpersonal,$monto,$pieza, $nuevoMontoTotal, $nuevaDeudaTotal){
        $this->conn->conn->begin_transaction();
        try{
            // Obtener el total a pagar y el monto ya pagado
            $sqlCheck = "SELECT total_pagar, monto_pagado FROM pagos WHERE idpago = '$idpago' AND idcliente = '$idcliente' FOR UPDATE;";
            $resultCheck = $this->conn->ConsultaArray($sqlCheck);
            
            if (!$resultCheck) {
                throw new Exception("Error al obtener los datos del pago.");
            }
            $total_pagar = $resultCheck['total_pagar'];
            $monto_pagado = $resultCheck['monto_pagado'];
             // Verificar si el nuevo pago excede el total a pagar
            if (($monto_pagado + $monto) > $total_pagar) {
                throw new Exception("El monto total pagado no puede exceder el total a pagar.");
            }
            $sqlNuevoPago = "INSERT INTO pago_detalles (idpago,idpersonal,monto,pieza) VALUES('$idpago','$idpersonal','$monto','$pieza');";
            $resultNuevo = $this->conn->ConsultaSin($sqlNuevoPago);

            $sqlUpdatePago = "UPDATE pagos SET monto_pagado = '$nuevoMontoTotal', saldo_pendiente = '$nuevaDeudaTotal' WHERE idpago = '$idpago' AND idcliente = '$idcliente';";
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
    public function UpdatePago($idpago,$idcliente,$idpagodetalle,$idpersonal,$importeActualizado,$pieza,$nuevoMontoTotal,$nuevaDeudaTotal){
        $this->conn->conn->begin_transaction();
        try{
            $sqlActualizar = "UPDATE pago_detalles SET idpersonal = '$idpersonal', monto = '$importeActualizado', pieza = '$pieza' WHERE idpagodetalle = '$idpagodetalle' AND idpago = '$idpago';";
            $resultNuevo = $this->conn->ConsultaSin($sqlActualizar);
            $sqlUpdatePago = "UPDATE pagos SET monto_pagado = '$nuevoMontoTotal', saldo_pendiente = '$nuevaDeudaTotal' WHERE idpago = '$idpago' AND idcliente = '$idcliente';";
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
    public function DeletePagoGeneral($idpago,$idpagodetalle,$nuevoMontoTotal,$nuevoDeuda){
        $this->conn->conn->begin_transaction();
        try{
            $sqlDelet = "DELETE FROM pago_detalles WHERE idpagodetalle = '$idpagodetalle';";
            $resultNuevo = $this->conn->ConsultaSin($sqlDelet);
            $sqlUpdatePago = "UPDATE pagos SET monto_pagado = '$nuevoMontoTotal', saldo_pendiente = '$nuevoDeuda' WHERE idpago = '$idpago';";
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
    public function GetPresupuestoOrtodoncia($id){
        $sql = "SELECT p.idpago,pro.procedimiento,p.monto_pagado,p.saldo_pendiente,p.total_pagar,pd.idpagodetalle,pd.monto,pd.concepto,pd.pieza,pd.fecha, pd.idpersonal,e.nombre AS etiqueta
                FROM pagos p 
                JOIN pago_detalles pd ON p.idpago = pd.idpago 
                JOIN procedimientos pro ON p.idprocedimiento = pro.idprocedimiento 
                JOIN etiquetas e ON e.idpersonal = pd.idpersonal
                WHERE p.idcliente = '$id' AND pro.procedimiento = 'ortodoncia' ORDER BY p.idpago ASC, pd.fecha ASC;";
        $data = $this->conn->ConsultaCon($sql);
        return $data;
    }
    public function GetPresupuestoOtros($id){
        $sql = "SELECT p.idpago,pro.procedimiento,p.monto_pagado,p.saldo_pendiente,p.total_pagar,pd.idpagodetalle,pd.monto,pd.concepto,pd.pieza,pd.fecha, pd.idpersonal,e.nombre AS etiqueta
                FROM pagos p 
                JOIN pago_detalles pd ON p.idpago = pd.idpago 
                JOIN procedimientos pro ON p.idprocedimiento = pro.idprocedimiento 
                JOIN etiquetas e ON e.idpersonal = pd.idpersonal
                WHERE p.idcliente = '$id' AND pro.idprocedimiento > 28 ORDER BY p.idpago ASC, pd.fecha ASC;";
        $data = $this->conn->ConsultaCon($sql);
        return $data;
    }
}
?>