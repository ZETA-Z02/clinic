<?php
class Pagos extends Controller
{
    function __construct()
    {
        parent::__construct();
    }
    public function render($npam = null)
    {
        $id = $npam[0];
        $cliente = $this->model->GetOne($id);
        $this->view->css = 'clientes';
        $this->view->data = $cliente;
        $this->view->Render('pagos/index');
    }
    public function getProcedimientos()
    {
        $data = $this->model->GetProcedimientos();
        while ($row = mysqli_fetch_assoc($data)) {
            $json[] = array(
                'idprocedimiento' => $row['idprocedimiento'],
                'procedimiento' => $row['procedimiento'],
                'precio' => $row['precio'],
            );
        }
        echo json_encode($json);
    }
    public function getDoctores()
    {
        $data = $this->model->GetDoctores();
        while ($row = mysqli_fetch_assoc($data)) {
            $json[] = array(
                'idpersonal' => $row['idpersonal'],
                'nombre' => $row['nombre'],
                'apellido' => $row['apellido'],
                'etiqueta' => $row['etiqueta'],
            );
        }
        echo json_encode($json);
    }
    public function getPresupuestoGeneral()
    {
        $id = $_POST['id'];
        $data = $this->model->GetPresupuestoGeneral($id);
        while ($row = mysqli_fetch_assoc($data)) {
            $json[] = array(
                'idpago' => $row['idpago'],
                'idpagodetalle' => $row['idpagodetalle'],
                'procedimiento' => $row['procedimiento'],
                'monto_pagado' => $row['monto_pagado'],
                'saldo_pendiente' => $row['saldo_pendiente'],
                'total_pagar' => $row['total_pagar'],
                'monto' => $row['monto'],
                'concepto' => $row['concepto'],
                'pieza' => $row['pieza'],
                'etiqueta' => $row['etiqueta'],
                'fecha' => date("Y-m-d", strtotime($row['fecha'])),
            );
        }
        echo json_encode($json);
    }
    public function nuevoProcedimientoPago()
    {
        $idcliente = $_POST['idcliente'];
        $idprocedimiento = $_POST['idprocedimiento'];
        $total = $_POST['total_pagar'];
        $monto = $_POST['importe'];
        $pieza = $_POST['pieza'];
        $idpersonal = $_POST['doctores'];
        if ($this->model->NuevoProcedimientoPago($idcliente, $idprocedimiento, $monto, $pieza, $idpersonal,$total)) {
            echo 'ok';
        } else {
            throw new Exception('Error al crear el pago');
        }
    }
    public function nuevoPago()
    {
        $idpago = $_POST['idpago'];
        $idcliente = $_POST['idcliente'];
        $idpersonal = $_POST['doctor'];
        $pieza = $_POST['pieza'];
        $monto = $_POST['importe'];
        $pagomonto = $_POST['monto'];
        $pagodeuda = $_POST['deuda'];
        $nuevoMontoTotal = $pagomonto + $monto;
        $nuevaDeudaTotal = $pagodeuda - $monto;
        if ($monto > $pagodeuda) {
            throw new Exception("El monto pagado es mayor al pago acumulado");
        }
        if ($this->model->NuevoPago($idpago, $idcliente, $idpersonal, $monto, $pieza, $nuevoMontoTotal, $nuevaDeudaTotal)) {
            echo "ok";
        } else {
            throw new Exception("Error al crear el pago");
        }
    }
    public function updatePago()
    {
        $idpago = $_POST["idpago"];
        $idpagodetalle = $_POST["idpagodetalle"];
        $pieza = $_POST["pieza"];
        $idpersonal = $_POST["doctor"];
        $idcliente = $_POST["idcliente"];
        $importeActual = $_POST["importeActual"];
        $importeActualizado = $_POST["importeActualizado"];
        $total = $_POST["total"];
        $deuda = $_POST["deuda"];
        $montoPagado = $_POST["montoPagado"];

        if($importeActualizado > $importeActual){
            $diferencia = $importeActualizado - $importeActual;
            $nuevoMontoTotal = $montoPagado + $diferencia;
            $nuevaDeudaTotal = $deuda - $diferencia;
            if($diferencia > $deuda && $nuevaDeudaTotal <= 0){
                throw new Exception("Error al actualizar, el importe actualizado tiene inconvenientes");
            }
        }
        if($importeActualizado < $importeActual){
            $diferencia = $importeActual - $importeActualizado;
            $nuevoMontoTotal = $montoPagado - $diferencia;
            $nuevaDeudaTotal = $deuda + $diferencia;
            if($nuevaDeudaTotal <= 0){
                throw new Exception("Error al actualizar, el importe actualizado tiene inconvenientes");
            }
        }
        if($importeActualizado == $importeActual){
            $diferencia = 0;
            $nuevoMontoTotal = $montoPagado;
            $nuevaDeudaTotal = $deuda;
        }
        if($importeActualizado <= 0){
            throw new Exception("Error al actualizar, el importe actualizado tiene inconvenientes");
        }   
        // echo json_encode(array(
        //     "diferencia" => $diferencia,
        //     "nuevoMontoTotal" => $nuevoMontoTotal,
        //     "nuevaDeudaTotal" => $nuevaDeudaTotal,
        //     "idpago" => $idpago,
        //     "idpagodetalle" => $idpagodetalle,
        //     "pieza" => $pieza,
        //     "idpersonal" => $idpersonal,
        //     "idcliente" => $idcliente,
        // ));
        if ($this->model->UpdatePago($idpago,$idcliente,$idpagodetalle,$idpersonal,$importeActualizado,$pieza,$nuevoMontoTotal,$nuevaDeudaTotal)) {
            echo "ok";
        } else {
            throw new Exception("Error al actualizar el pago");
        }
    }
    public function deletePagoGeneral(){
        $idpago = $_POST['idpago'];
        $idpagodetalle = $_POST['idpagodetalle'];
        $monto = $_POST['monto'];
        $deuda = $_POST['deuda'];
        $total = $_POST['total'];
        $importeActual = $_POST['importeActual'];
        $nuevoMontoTotal = $monto - $importeActual;
        $nuevoDeuda = $deuda + $importeActual;
        // echo json_encode(array(
        //     'idpago'=> $idpago,
        //     'idpagodetalle'=> $idpagodetalle,
        //     'monto'=> $monto,
        //     'deuda'=> $deuda,
        //     'total'=> $total,
        //     'importeActual' => $importeActual,
        //     'nuevoMontoTotal'=> $nuevoMontoTotal,
        //     'nuevadeuda'=>$nuevoDeuda
        // ));
        if($this->model->DeletePagoGeneral($idpago,$idpagodetalle,$nuevoMontoTotal,$nuevoDeuda)){
            echo "ok";
        } else {
            throw new Exception("Error al eliminar el pago");
        }
    }
    // Presupuesto Ortodoncia
    public function getPresupuestoOrtodoncia(){
        $id = $_POST['id'];
        $data = $this->model->GetPresupuestoOrtodoncia($id);
        while ($row = mysqli_fetch_assoc($data)) {
            $json[] = array(
                'idpago' => $row['idpago'],
                'idpagodetalle' => $row['idpagodetalle'],
                'procedimiento' => $row['procedimiento'],
                'monto_pagado' => $row['monto_pagado'],
                'saldo_pendiente' => $row['saldo_pendiente'],
                'total_pagar' => $row['total_pagar'],
                'monto' => $row['monto'],
                'concepto' => $row['concepto'],
                'pieza' => $row['pieza'],
                'etiqueta' => $row['etiqueta'],
                'fecha' => date("Y-m-d", strtotime($row['fecha'])),
            );
        }
        echo json_encode($json);
    }
    public function getProcedimientoOrtodoncia(){
        $data = $this->model->GetProcedimientos('ortodoncia');
        while ($row = mysqli_fetch_assoc($data)) {
            $json[] = array(
                'idprocedimiento' => $row['idprocedimiento'],
                'procedimiento' => $row['procedimiento'],
                'precio' => $row['precio'],
            );
        }
        echo json_encode($json);
    }

    // PRESUPUESTO OTROS
    public function getPresupuestoOtros(){
        $id = $_POST['id'];
        $data = $this->model->GetPresupuestoOtros($id);
        while ($row = mysqli_fetch_assoc($data)) {
            $json[] = array(
                'idpago' => $row['idpago'],
                'idpagodetalle' => $row['idpagodetalle'],
                'procedimiento' => $row['procedimiento'],
                'monto_pagado' => $row['monto_pagado'],
                'saldo_pendiente' => $row['saldo_pendiente'],
                'total_pagar' => $row['total_pagar'],
                'monto' => $row['monto'],
                'concepto' => $row['concepto'],
                'pieza' => $row['pieza'],
                'etiqueta' => $row['etiqueta'],
                'fecha' => date("Y-m-d", strtotime($row['fecha'])),
            );
        }
        echo json_encode($json);
    }
    public function getProcedimientoOtros(){
        $data = $this->model->GetProcedimientos('otros');
        while ($row = mysqli_fetch_assoc($data)) {
            $json[] = array(
                'idprocedimiento' => $row['idprocedimiento'],
                'procedimiento' => $row['procedimiento'],
                'precio' => $row['precio'],
            );
        }
        echo json_encode($json);
    }

}

?>