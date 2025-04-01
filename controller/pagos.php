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
    // PRESUPUESTOS
    public function presupuestos(){
        $this->disabledCache();
        $id = $_POST['id'];
        $type = $_POST['tipo'];
        if($type=='general'){
            $data = $this->model->GetPresupuestoGeneral($id);
        }else if($type=='ortodoncia'){
            $data = $this->model->GetPresupuestoOrtodoncia($id);
        }else if($type=='otros'){
            $data = $this->model->GetPresupuestoOtros($id);
        }
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
        $idpersonal = $_POST['doctor'];
        if ($this->model->NuevoProcedimientoPago($idcliente, $idprocedimiento, $monto, $pieza, $idpersonal,$total)) {
            echo 'ok';
        } else {
            throw new Exception('Error al crear el pago');
        }
    }
    public function nuevoPago()
    {
        $this->disabledCache();
        $idpago = $_POST['idpago'];
        $idcliente = $_POST['idcliente'];
        $idpersonal = $_POST['doctor'];
        $pieza = $_POST['pieza'];
        $monto = $_POST['importe'];
        //$pagomonto = $_POST['monto'];
        $pagodeuda = $_POST['deuda'];
        if ($monto > $pagodeuda) {
            throw new Exception("El monto pagado es mayor al pago acumulado");
        }
        if ($this->model->NuevoPago($idpago, $idcliente, $idpersonal, $monto, $pieza)) {
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

        if ($this->model->UpdatePago($idpago,$idcliente,$idpagodetalle,$idpersonal,$importeActualizado,$pieza,$nuevoMontoTotal,$nuevaDeudaTotal)) {
            echo "ok";
        } else {
            throw new Exception("Error al actualizar el pago");
        }
    }
    public function deletePago(){
        $idpago = $_POST['idpago'];
        $idpagodetalle = $_POST['idpagodetalle'];
        $monto = $_POST['monto'];
        $deuda = $_POST['deuda'];
        $total = $_POST['total'];
        $importeActual = $_POST['importeActual'];
        $nuevoMontoTotal = $monto - $importeActual;
        $nuevoDeuda = $deuda + $importeActual;

        if($this->model->DeletePagoGeneral($idpago,$idpagodetalle,$nuevoMontoTotal,$nuevoDeuda)){
            echo "ok";
        } else {
            throw new Exception("Error al eliminar el pago");
        }
    }
    public function getProcedimientosGeneral()
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
    public function getProcedimientosOrtodoncia(){
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
    public function getProcedimientosOtros(){
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
    public function getProcedimientosPresupuesto(){
        $data = $this->model->GetProcedimientos('presupuesto');
        while ($row = mysqli_fetch_assoc($data)) {
            $json[] = array(
                'idprocedimiento' => $row['idprocedimiento'],
                'procedimiento' => $row['procedimiento'],
                'precio' => $row['precio'],
            );
        }
        echo json_encode($json);
    }

    // PRESUPUESTO TOTAL OTRA TABLA DE TRATAMIENTOS Y PAGOS QUE SIGUE EL CLIENTE
    // Presupuesto total de un cliente, suma de todos sus procedimientos y del total de sus pagos
    // Tambien el total de su deuda y si tiene un saldo, si deja dinero extra
    public function getPresupuestoTotal(){
        $this->disabledCache();
        $idcliente = $_POST['id'];
        $data = $this->model->GetPresupuestoTotal($idcliente);
        while ($row = mysqli_fetch_assoc($data)) {
            $json[] = array(
                'idpresupuesto' => $row['idpresupuesto'],
                'idpresupuestodetalle' => $row['idpresupuestodetalle'],
                'procedimiento' => $row['procedimiento'],
                'pieza' => $row['pieza'],
                'total_pagar' => $row['total_pagar'],
                'monto_pagado' => $row['monto_pagado'],
                'importe' => $row['importe'],
                'deuda_pendiente' => $row['deuda_pendiente'],
                'fecha' => date("Y-m-d", strtotime($row['fecha'])),
            );
        }
        echo json_encode($json);
    }
    public function nuevoPresupuestoTotal(){
        $idcliente = $_POST['idcliente'];
        $idprocedimiento = $_POST['idprocedimiento'];
        $monto = $_POST['importe'];
        $pieza = $_POST['pieza'];
        $total = $_POST['total_pagar'];
        if ($this->model->NuevoPresupuestoTotal($idcliente, $idprocedimiento, $monto, $pieza, $total)) {
            echo 'ok';
        } else {
            throw new Exception('Error al crear el presupuesto total');
        }
    }
    public function nuevoPagoPresupuestoTotal(){
        $this->disabledCache();
        $idpresupuesto = $_POST['idpresupuesto'];
        $idcliente = $_POST['idcliente'];
        $pieza = $_POST['pieza'];
        $importe = $_POST['importe'];
        if ($this->model->NuevoPagoPresupuestoTotal($idpresupuesto, $idcliente, $importe, $pieza)) {
            echo "ok";
        } else {
            throw new Exception("Error al crear el presupuesto");
        }
    }
    // Actualiza el saldo del presupuesto
    // REDISE;AR LAS TABLAS PRESUPUESTO Y PRESUPEUSTO DETALLES YA QUE HAY MUCHA DEPENDENDIA 
    // EN LOS CAMPOS DE MONTO Y DEUDA.REHACER PRESUPUESTOS APRENDIENDO A NO HACER TABLAS DEPENDIENTES MRD
    // PTM -> by: ZETA
    public function updatePresupuestoTotal(){
        $idcliente = $_POST['idcliente'];
        $idpresupuesto = $_POST['idpresupuesto'];
        $idpresupuestodetalle = $_POST['idpresupuestodetalle'];
        $importeNuevo = $_POST['importe'];
        $piezaNuevo = $_POST['pieza'];

        if($this->model->UpdatePresupuestoTotal($idpresupuesto,$idpresupuestodetalle,$importeNuevo,$piezaNuevo)){
            echo "OK";
        }else{
            throw new Exception("Error al actualizar el presupuesto Total");
        }
    }
    public function deletePresupuestoTotal(){
        $idpresupuesto = $_POST['idpresupuesto'];
        $idpresupuestodetalle = $_POST['idpresupuestodetalle'];
        if($this->model->DeletePresupuestoTotal($idpresupuesto,$idpresupuestodetalle)){
            echo "OK";
        }else{
            throw new Exception("Error al eliminar el presupuesto Total");
        }
    }
    public function mostrarInformacionPagos(){
        $idcliente = $_POST['idcliente'];
        $data = $this->model->MostrarInformacionPagos(4);
        echo json_encode($data);
    }

    // 
}

?>