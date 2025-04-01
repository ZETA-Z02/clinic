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
        }else if($type == 'presupuesto'){
            $sql .= " WHERE procedimiento != 'ortodoncia';";
        }else{
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
        $sql = "SELECT idcliente,nombre,apellido FROM clientes WHERE idcliente = '$id';";
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
    // 
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
    public function NuevoPago($idpago, $idcliente, $idpersonal,$monto,$pieza){
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

            $sqlUpdatePago = "UPDATE pagos 
                            SET monto_pagado = (SELECT SUM(monto) FROM pago_detalles WHERE idpago = '$idpago'), 
                            saldo_pendiente = $total_pagar - (SELECT SUM(monto) FROM pago_detalles WHERE idpago = '$idpago')
                            WHERE idpago = '$idpago' AND idcliente = '$idcliente';";
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
    // Presupuesto Total */*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/**/*/*/*/*/*/*/*/*/*/*/*/* */
    public function GetPresupuestoTotal($idcliente){
        $sql = "SELECT ptd.idpresupuestodetalle,ptd.pieza,ptd.importe,ptd.fecha,p.idcliente,p.idpresupuesto,p.total_pagar,p.monto_pagado,p.deuda_pendiente,pro.procedimiento,pro.idprocedimiento FROM presupuestos p JOIN presupuesto_detalles ptd ON p.idpresupuesto=ptd.idpresupuesto JOIN procedimientos pro ON pro.idprocedimiento=p.idprocedimiento WHERE p.idcliente='$idcliente';";
        $data = $this->conn->ConsultaCon($sql); 
        return $data;
    }
    public function NuevoPresupuestoTotal($idcliente, $idprocedimiento, $monto, $pieza, $total){
        $this->conn->conn->begin_transaction();
        try{
            /* INSERTAR PAGOS HACIENDO CALCULOS */
            if($total < $monto){
                throw new Exception("Error: El monto supera al total");
            }
            $deuda_pendiente = $total - $monto;
            $igv = round($total - ($total / 1.18),2);
            // INSERTAR PRESUPUESTO
            $sqlpresupuesto = "INSERT INTO presupuestos (idcliente,idprocedimiento,monto_pagado,deuda_pendiente,total_pagar) VALUES ('$idcliente','$idprocedimiento','$monto','$deuda_pendiente','$total');";
            $resultpresupuesto = $this->conn->ConsultaSin($sqlpresupuesto);
            $idpresupuesto = $this->conn->conn->insert_id;
            /* INSERTAR PRESUPUESTO DETALLES */
            $sqlpresupuestodetalle = "INSERT INTO presupuesto_detalles (idpresupuesto, pieza,importe) VALUES('$idpresupuesto','$pieza','$monto');";
            $resultpresupuestodetalle = $this->conn->ConsultaSin($sqlpresupuestodetalle);
            $this->conn->conn->commit();
            $result = $resultpresupuesto && $resultpresupuestodetalle;
            return $result;
        }catch(Exception $e){
            $this->conn->conn->rollback();
            echo "Error: " . $e->getMessage();
        }
        $this->conn->conn->close();
    }
    public function NuevoPagoPresupuestoTotal($idpresupuesto, $idcliente, $importe, $pieza){
        $this->conn->conn->begin_transaction();
        try{
            // Obtener el total a pagar y el monto ya pagado
            $sqlCheck = "SELECT total_pagar, monto_pagado,deuda_pendiente FROM presupuestos WHERE idpresupuesto = '$idpresupuesto' AND idcliente = '$idcliente' FOR UPDATE;";
            $resultCheck = $this->conn->ConsultaArray($sqlCheck);
            
            if (!$resultCheck) {
                throw new Exception("Error al obtener los datos del pago.");
            }
            $total_pagar = $resultCheck['total_pagar'];
            $monto_pagado = $resultCheck['monto_pagado'];
            $deuda = $resultCheck['deuda_pendiente']; 
             // Verificar si el nuevo pago excede el total a pagar
            if (($monto_pagado + $importe) > $total_pagar) {
                throw new Exception("El monto total pagado no puede exceder el total a pagar.");
            }
            //$deuda_pendiente = $resultCheck['deuda_pendiente'] - $importe;
            $monto = $deuda - $importe;
            $sqlNuevoPago = "INSERT INTO presupuesto_detalles (idpresupuesto,pieza,importe) VALUES('$idpresupuesto','$pieza','$importe');";
            $resultNuevo = $this->conn->ConsultaSin($sqlNuevoPago);

            $sqlUpdatePago = "UPDATE presupuestos 
                            SET monto_pagado = (SELECT SUM(importe) FROM presupuesto_detalles WHERE idpresupuesto = '$idpresupuesto'), 
                            deuda_pendiente = $total_pagar - (SELECT SUM(importe) FROM presupuesto_detalles WHERE idpresupuesto = '$idpresupuesto')
                            WHERE idpresupuesto = '$idpresupuesto' AND idcliente = '$idcliente';";
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
    
    public function UpdatePresupuestoTotal($idpresupuesto,$idpresupuestodetalle,$importeNuevo,$piezaNuevo){
        $this->conn->conn->begin_transaction();
        try{
            $sqlCheckDetalles = "SELECT pieza, importe FROM presupuesto_detalles WHERE idpresupuestodetalle = '$idpresupuestodetalle' AND idpresupuesto='$idpresupuesto' FOR UPDATE;";
            $resultcheckdetalles = $this->conn->ConsultaArray($sqlCheckDetalles);
            if(!$resultcheckdetalles){
                throw new Exception("Error al obtener los datos del presupuesto para actualizar");
            }
            // Obtener el total a pagar y el monto ya pagado
            $sqlCheckPresupuesto = "SELECT total_pagar, monto_pagado, deuda_pendiente FROM presupuestos WHERE idpresupuesto = '$idpresupuesto' FOR UPDATE;";
            $resultCheckPresupuesto = $this->conn->ConsultaArray($sqlCheckPresupuesto);
            
            if (!$resultCheckPresupuesto) {
                throw new Exception("Error al obtener los datos del pago.");
            }
            $total_pagar = $resultCheckPresupuesto['total_pagar'];
            $monto_pagado = $resultCheckPresupuesto['monto_pagado'];
            $verify = $monto_pagado - $resultcheckdetalles['importe'];
             // Verificar si el nuevo pago excede el total a pagar
            if (($verify + $importeNuevo) > $total_pagar) {
                throw new Exception("El monto total pagado no puede exceder el total a pagar.");
            }
            $sqlpresupuestodetalle = "UPDATE presupuesto_detalles SET pieza='$piezaNuevo', importe='$importeNuevo' WHERE idpresupuestodetalle = '$idpresupuestodetalle' AND idpresupuesto = '$idpresupuesto';";
            $resultdetalle = $this->conn->ConsultaSin($sqlpresupuestodetalle);

            $sqlpresupuesto = "UPDATE presupuestos 
                            SET monto_pagado = (SELECT SUM(importe) FROM presupuesto_detalles WHERE idpresupuesto = '$idpresupuesto'), 
                            deuda_pendiente = $total_pagar - (SELECT SUM(importe) FROM presupuesto_detalles WHERE idpresupuesto = '$idpresupuesto')
                            WHERE idpresupuesto = '$idpresupuesto';";
            $resultpresupuesto = $this->conn->ConsultaSin($sqlpresupuesto);

            $this->conn->conn->commit();
            $result = $resultpresupuesto && $resultdetalle;
            return $result;
        }catch(Exception $e){
            $this->conn->conn->rollback();
            echo "Error: " . $e->getMessage();
        }        
    }
    public function DeletePresupuestoTotal($idpresupuesto, $idpresupuestodetalle){
        $this->conn->conn->begin_transaction();
        try{
            $sql = "DELETE FROM presupuesto_detalles WHERE idpresupuestodetalle = '$idpresupuestodetalle';";
            $result = $this->conn->ConsultaSin($sql);
            $sqlcheck =  "SELECT total_pagar, monto_pagado, deuda_pendiente FROM presupuestos WHERE idpresupuesto = '$idpresupuesto' FOR UPDATE;";
            $resultCheck = $this->conn->ConsultaArray($sqlcheck);
            if(!$resultCheck){
                throw new Exception("Error al obtener los datos del presupuesto");
            }
            $total_pagar = $resultCheck['total_pagar'];
            $sqlpresupuesto = "UPDATE presupuestos 
                            SET monto_pagado = (SELECT SUM(importe) FROM presupuesto_detalles WHERE idpresupuesto = '$idpresupuesto'), 
                            deuda_pendiente = $total_pagar - (SELECT SUM(importe) FROM presupuesto_detalles WHERE idpresupuesto = '$idpresupuesto')
                            WHERE idpresupuesto = '$idpresupuesto';";
            $resultpresupuesto = $this->conn->ConsultaSin($sqlpresupuesto);
            $this->conn->conn->commit();
            return $result && $resultpresupuesto;
        }catch(Exception $e){
            $this->conn->conn->rollback();
            echo "Error: " . $e->getMessage();
        }
    }
    public function MostrarInformacionPagos($idcliente){
        // Obtiene los presupuestos de un cliente
        $sqlpresupuestos = "SELECT (SELECT SUM(pdt.importe) FROM presupuestos p JOIN presupuesto_detalles pdt ON p.idpresupuesto=pdt.idpresupuesto WHERE p.idcliente=5) AS suma_importe, (SELECT SUM(total_pagar) FROM presupuestos WHERE idcliente=5) AS suma_total;";
        $datapresupuesto = $this->conn->ConsultaArray($sqlpresupuestos);
        // Obtiene los pagos de un cliente escepto ortodoncia
        $sqlgeneral = "SELECT (SELECT SUM(pdt.monto) FROM pago_detalles pdt JOIN pagos p ON pdt.idpago=p.idpago WHERE p.idcliente=4 AND p.idprocedimiento!=2) AS suma_monto, (SELECT SUM(DISTINCT p.total_pagar) FROM pagos p JOIN pago_detalles pdt ON p.idpago = pdt.idpago WHERE p.idcliente = 4 AND p.idprocedimiento!=2) AS suma_total;";
        $datageneral = $this->conn->ConsultaArray($sqlgeneral);
        return array("presupuesto" => $datapresupuesto, "general" => $datageneral);
    }
}
?>