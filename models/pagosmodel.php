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
            $sql .= " WHERE procedimiento != 'ortodoncia'";
            // $sql .= "AND idprocedimiento <= '28';";
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
    // informacion del presupuesto general que tiene activo el cliente
    public function GetPresupuestoGeneralTotal($idcliente){
        $sql = "SELECT pg.idpresupuestogeneral,p.procedimiento,pg.total_pagar, pg.feCreate,pp.pieza,pp.precio FROM presupuesto_general pg JOIN presupuesto_procedimientos pp ON pg.idpresupuestogeneral = pp.idpresupuestogeneral JOIN procedimientos p ON pp.idprocedimiento = p.idprocedimiento WHERE pg.idcliente = '$idcliente' AND pg.estado = 0;";
        $data = $this->conn->ConsultaCon($sql);
        return $data;
    }
    // registra un nuevo presupuesto de un cliente
    public function NuevoPresupuestoGeneral($idcliente,$data){
        $this->conn->conn->begin_transaction();
        try{
            $precio = 0;
            foreach($data as $row){
                $precio += $row['precio'];
            }
            $sqlgeneral = "INSERT INTO presupuesto_general (idcliente, monto_pagado, deuda_pendiente, total_pagar) VALUES ($idcliente, 0, 0,$precio);";
            $result = $this->conn->ConsultaSin($sqlgeneral);
            $idgeneral = $this->conn->conn->insert_id;
            foreach($data as $row1){
                $idprocedimiento = $row1['idprocedimiento'];
                $pieza = $row1['pieza'];
                $precioprocedimiento = $row1['precio'];
                $sql = "INSERT INTO presupuesto_procedimientos(idpresupuestogeneral,idprocedimiento,pieza,precio) VALUES ($idgeneral,$idprocedimiento,'$pieza',$precioprocedimiento);";
                $resultprocedimiento = $this->conn->ConsultaSin($sql);
            }
            $this->conn->conn->commit();
            return $result && $resultprocedimiento;
        }catch(Exception $e){
            $this->conn->conn->rollback();
            echo "Error: " . $e->getMessage();
            //error_log("Error en NuevoPresupuestoGeneral: ". print_r($data,true));
        }
        $this->conn->conn->close();
    }
    // NUevo pago del presupuesto general 
    public function NuevoPagoPresupuestoGeneral($idcliente, $importe){
        $this->conn->conn->begin_transaction();
        try{
            // Obtener el total a pagar y el monto ya pagado
            $sqlCheckPresupuesto = "SELECT idpresupuestogeneral,total_pagar, monto_pagado, deuda_pendiente FROM presupuesto_general WHERE idcliente = '$idcliente' AND estado = 0 FOR UPDATE;";
            $resultCheckPresupuesto = $this->conn->ConsultaArray($sqlCheckPresupuesto);
            if (!$resultCheckPresupuesto) {
                throw new Exception("Error al obtener los datos del pago.");
            }
            $total_pagar = $resultCheckPresupuesto['total_pagar'];
            $monto_pagado = $resultCheckPresupuesto['monto_pagado'];
             // Verificar si el nuevo pago excede el total a pagar
            if (($monto_pagado + $importe) > $total_pagar || $importe > $total_pagar) {
                throw new Exception("El monto total pagado no puede exceder el total a pagar.");
            }
            $idpresupuestogeneral = intval($resultCheckPresupuesto['idpresupuestogeneral']);
            $sqlPago = "INSERT INTO presupuesto_pagos(idpresupuestogeneral, importe) VALUES($idpresupuestogeneral,$importe);";
            $result = $this->conn->ConsultaSin($sqlPago);

            $sqlUpdate = "UPDATE presupuesto_general SET monto_pagado = (SELECT SUM(importe) FROM presupuesto_pagos WHERE idpresupuestogeneral = $idpresupuestogeneral), deuda_pendiente = $total_pagar - (SELECT SUM(importe) FROM presupuesto_pagos WHERE idpresupuestogeneral = $idpresupuestogeneral) WHERE idpresupuestogeneral = $idpresupuestogeneral;";
            $resultUpdate = $this->conn->ConsultaSin($sqlUpdate);
            $this->conn->conn->commit();
            return $result && $resultUpdate;
        }catch(Exception $e){
            $this->conn->conn->rollback();
            echo "Error: " . $e->getMessage();
        }
        $this->conn->conn->close();
    }
    // Obtiene datos de los pagos de un presupuesto activo
    public function GetPresupuestoPagos($idcliente,$idpresupuestogeneral){
        $sql = "SELECT pg.idcliente,pg.total_pagar,pg.monto_pagado,pp.idpresupuestopago, pp.idpresupuestogeneral, pp.importe,pp.fecha FROM presupuesto_pagos pp JOIN presupuesto_general pg ON pp.idpresupuestogeneral=pg.idpresupuestogeneral WHERE pg.idcliente='$idcliente' AND pg.idpresupuestogeneral='$idpresupuestogeneral' ORDER BY pp.fecha;";
        $data = $this->conn->ConsultaCon($sql);
        return $data;
    }
    // Actualiza un pago de un presupuesto_pagos, actualiza el monto pagado y la deuda pendiente del presupuesto general
    public function UpdatePresupuestoPagos($idpresupuestogeneral, $idpresupuestopago, $importeNuevo){
        $this->conn->conn->begin_transaction();
        try{
            $sqlCheckPagos = "SELECT importe FROM presupuesto_pagos WHERE idpresupuestopago = '$idpresupuestopago' AND idpresupuestogeneral='$idpresupuestogeneral' FOR UPDATE;";
            $resultcheckpagos = $this->conn->ConsultaArray($sqlCheckPagos);
            if(!$resultcheckpagos){
                throw new Exception("Error al obtener los datos del presupuesto para actualizar");
            }
            // Obtener el total a pagar y el monto ya pagado
            $sqlCheckPresupuesto = "SELECT total_pagar, monto_pagado, deuda_pendiente FROM presupuesto_general WHERE idpresupuestogeneral = '$idpresupuestogeneral' FOR UPDATE;";
            $resultCheckPresupuesto = $this->conn->ConsultaArray($sqlCheckPresupuesto);
            
            if (!$resultCheckPresupuesto) {
                throw new Exception("Error al obtener los datos del pago.");
            }
            $total_pagar = $resultCheckPresupuesto['total_pagar'];
            $monto_pagado = $resultCheckPresupuesto['monto_pagado'];
            $verify = $monto_pagado - $resultcheckpagos['importe'];
             // Verificar si el nuevo pago excede el total a pagar
            if (($verify + $importeNuevo) > $total_pagar) {
                throw new Exception("El monto total pagado no puede exceder el total a pagar.");
            }
            $sqlpresupuestopagos = "UPDATE presupuesto_pagos SET importe='$importeNuevo' WHERE idpresupuestopago = '$idpresupuestopago' AND idpresupuestogeneral = '$idpresupuestogeneral';";
            $resultpagos = $this->conn->ConsultaSin($sqlpresupuestopagos);

            $sqlpresupuesto = "UPDATE presupuesto_general
                            SET monto_pagado = (SELECT SUM(importe) FROM presupuesto_pagos WHERE idpresupuestogeneral = '$idpresupuestogeneral'), 
                            deuda_pendiente = $total_pagar - (SELECT SUM(importe) FROM presupuesto_pagos WHERE idpresupuestogeneral = '$idpresupuestogeneral')
                            WHERE idpresupuestogeneral = '$idpresupuestogeneral';";
            $resultpresupuesto = $this->conn->ConsultaSin($sqlpresupuesto);
            $this->conn->conn->commit();
            $result = $resultpresupuesto && $resultpagos;
            return $result;
        }catch(Exception $e){
            $this->conn->conn->rollback();
            echo "Error: " . $e->getMessage();
        }        
    }
    // Eliminar un pago de un presupuesto_pagos, actualiza el monto pagado y la deuda pendiente del presupuesto general
    public function DeletePresupuestoPagos($idpresupuestopago){
        $this->conn->conn->begin_transaction();
        try{
            $sqlidpresupuestogeneral = "SELECT idpresupuestogeneral FROM presupuesto_pagos WHERE idpresupuestopago = '$idpresupuestopago';";
            $idpresupuestogeneral = $this->conn->ConsultaArray($sqlidpresupuestogeneral);
            $idpresupuestogeneral = $idpresupuestogeneral['idpresupuestogeneral'];
            $sqlcheck =  "SELECT monto_pagado,deuda_pendiente,total_pagar FROM presupuesto_general WHERE idpresupuestogeneral = '$idpresupuestogeneral' FOR UPDATE;";
            $resultCheck = $this->conn->ConsultaArray($sqlcheck);
            $sql = "DELETE FROM presupuesto_pagos WHERE idpresupuestopago = '$idpresupuestopago' AND idpresupuestogeneral = '$idpresupuestogeneral';";
            $result = $this->conn->ConsultaSin($sql);
            if(!$resultCheck){
                throw new Exception("Error al obtener los datos del presupuesto general para actualizar");
            }
            $total_pagar = $resultCheck['total_pagar'];
            $sqlpresupuesto = "UPDATE presupuesto_general
                            SET monto_pagado = (SELECT SUM(importe) FROM presupuesto_pagos WHERE idpresupuestogeneral = '$idpresupuestogeneral'), 
                            deuda_pendiente = $total_pagar - (SELECT SUM(importe) FROM presupuesto_pagos WHERE idpresupuestogeneral = '$idpresupuestogeneral')
                            WHERE idpresupuestogeneral = '$idpresupuestogeneral';";
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
        $sqlpresupuestos = "SELECT (SELECT SUM(pg.importe) FROM presupuesto_pagos pg JOIN presupuesto_general pp ON pg.idpresupuestogeneral=pp.idpresupuestogeneral WHERE pp.idcliente='$idcliente') as suma_importe, (SELECT sum(total_pagar) FROM presupuesto_general WHERE idcliente='$idcliente') as suma_total;";
        $datapresupuesto = $this->conn->ConsultaArray($sqlpresupuestos);
        // Obtiene los pagos de un cliente escepto ortodoncia
        $sqlgeneral = "SELECT (SELECT SUM(pdt.monto) FROM pago_detalles pdt JOIN pagos p ON pdt.idpago=p.idpago WHERE p.idcliente='$idcliente' AND p.idprocedimiento!=2) AS suma_monto, (SELECT SUM(DISTINCT p.total_pagar) FROM pagos p JOIN pago_detalles pdt ON p.idpago = pdt.idpago WHERE p.idcliente = '$idcliente' AND p.idprocedimiento!=2) AS suma_total;";
        $datageneral = $this->conn->ConsultaArray($sqlgeneral);
        return array("presupuesto" => $datapresupuesto, "general" => $datageneral);
    }
    public function DataBoleta($idcliente,$status){
        $sql = "SELECT p.procedimiento, pd.importe FROM presupuesto_detalles pd JOIN presupuestos pre ON pd.idpresupuesto = pre.idpresupuesto JOIN procedimientos p ON pre.idprocedimiento=p.idprocedimiento WHERE pre.idcliente='$idcliente'";
        if($status=='actual'){
            $sql .= "ORDER BY pd.fecha DESC LIMIT 1";
        }
        $sql .= ";";
        $data = $this->conn->ConsultaCon($sql);
        return $data;
    }
}
?>