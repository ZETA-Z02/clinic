<?php
require_once './vendor/setasign/fpdf/fpdf.php';
class Pagos extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->disabledCache();
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
    public function presupuestos()
    {
        $this->disabledCache();
        $id = $_POST['id'];
        $type = $_POST['tipo'];
        if ($type == 'general') {
            $data = $this->model->GetPresupuestoGeneral($id);
        } else if ($type == 'ortodoncia') {
            $data = $this->model->GetPresupuestoOrtodoncia($id);
        } else if ($type == 'otros') {
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
        if ($this->model->NuevoProcedimientoPago($idcliente, $idprocedimiento, $monto, $pieza, $idpersonal, $total)) {
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

        if ($importeActualizado > $importeActual) {
            $diferencia = $importeActualizado - $importeActual;
            $nuevoMontoTotal = $montoPagado + $diferencia;
            $nuevaDeudaTotal = $deuda - $diferencia;
            if ($diferencia > $deuda && $nuevaDeudaTotal <= 0) {
                throw new Exception("Error al actualizar, el importe actualizado tiene inconvenientes");
            }
        }
        if ($importeActualizado < $importeActual) {
            $diferencia = $importeActual - $importeActualizado;
            $nuevoMontoTotal = $montoPagado - $diferencia;
            $nuevaDeudaTotal = $deuda + $diferencia;
            if ($nuevaDeudaTotal <= 0) {
                throw new Exception("Error al actualizar, el importe actualizado tiene inconvenientes");
            }
        }
        if ($importeActualizado == $importeActual) {
            $diferencia = 0;
            $nuevoMontoTotal = $montoPagado;
            $nuevaDeudaTotal = $deuda;
        }
        if ($importeActualizado <= 0) {
            throw new Exception("Error al actualizar, el importe actualizado tiene inconvenientes");
        }

        if ($this->model->UpdatePago($idpago, $idcliente, $idpagodetalle, $idpersonal, $importeActualizado, $pieza, $nuevoMontoTotal, $nuevaDeudaTotal)) {
            echo "ok";
        } else {
            throw new Exception("Error al actualizar el pago");
        }
    }
    public function deletePago()
    {
        $idpago = $_POST['idpago'];
        $idpagodetalle = $_POST['idpagodetalle'];
        $monto = $_POST['monto'];
        $deuda = $_POST['deuda'];
        $total = $_POST['total'];
        $importeActual = $_POST['importeActual'];
        $nuevoMontoTotal = $monto - $importeActual;
        $nuevoDeuda = $deuda + $importeActual;

        if ($this->model->DeletePagoGeneral($idpago, $idpagodetalle, $nuevoMontoTotal, $nuevoDeuda)) {
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
    public function getProcedimientosOrtodoncia()
    {
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
    public function getProcedimientosOtros()
    {
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
    public function getProcedimientosPresupuesto()
    {
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
    // Obtiene el presupuesto general de un cliente, mostrando los procedimientos y el total a pagar
    public function getPresupuestoGeneral()
    {
        $this->disabledCache();
        $idcliente = $_POST['id'];
        $data = $this->model->GetPresupuestoGeneralTotal($idcliente);
        if (mysqli_num_rows($data)===0) {
            echo json_encode(array("response" => false));
        } else {
            while ($row = mysqli_fetch_assoc($data)) {
                $json[] = array(
                    "idpresupuestogeneral" => $row['idpresupuestogeneral'],
                    "pieza" => $row['pieza'],
                    "procedimiento" => $row['procedimiento'],
                    "precio" => $row['precio'],
                    "total" => $row['total_pagar'],
                    "fecha" => $row['feCreate'],
                );
            }
            echo json_encode($json);
        }
    }
    // Crea el presupuesto general, con informacion de los procedimientos y el total a pagar
    public function nuevoPresupuestoGeneral()
    {
        $this->disabledCache();
        $data = $_POST['data'];
        $idcliente = $data[0]["idcliente"];
        $datos = $data[1];
        if (empty($idcliente)) {
            throw new Exception("Error al obtener los datos del pago.");
        }
        // echo json_encode($data);
        if ($this->model->NuevoPresupuestoGeneral($idcliente, $datos)) {
            echo 'ok';
        } else {
            throw new Exception('Error al crear el presupuesto general');
        }
    }
    // NUevo pago de un presupuesto general 
    public function nuevoPagoPresupuestoGeneral()
    {
        $this->disabledCache();
        $idcliente = $_POST['idcliente'];
        $importe = $_POST['importe'];
        if ($this->model->NuevoPagoPresupuestoGeneral($idcliente, $importe)) {
            echo "ok";
        } else {
            //throw new Exception("Error al crear el pago del presupuesto");
        }
    }
    // Obtiene datos de los pagos de un presupuesto activo
    public function getPresupuestoPagos()
    {
        $this->disabledCache();
        $idcliente = $_POST['id'];
        $idpresupuestogeneral = $_POST['idpresupuestogeneral'];
        $data = $this->model->GetPresupuestoPagos($idcliente, $idpresupuestogeneral);
        while ($row = mysqli_fetch_assoc($data)) {
            $json[] = array(
                'idpresupuestopago' => $row['idpresupuestopago'],
                'importe' => $row['importe'],
                'monto_pagado' => $row['monto_pagado'],
                'total' => $row['total_pagar'],
                'fecha' => date("Y-m-d", strtotime($row['fecha'])),
            );
        }
        echo json_encode($json);
    }
    // EDITAR PRESUPUESTO_PAGOS
    public function updatePresupuestoPagos()
    {
        $idcliente = $_POST['idcliente'];
        $idpresupuestogeneral = $_POST['idpresupuestogeneral'];
        $idpresupuestopago = $_POST['idpresupuestopago'];
        $importeNuevo = $_POST['importe'];
        if ($this->model->UpdatePresupuestoPagos($idpresupuestogeneral, $idpresupuestopago, $importeNuevo)) {
            echo "OK";
        } else {
            throw new Exception("Error al actualizar el presupuesto pagos");
        }
    }
    // Eliminar PRESUPUESTO PAGOS
    public function deletePresupuestoPagos()
    {
        $idpresupuestopago = $_POST['idpresupuestopago'];
        if ($this->model->DeletePresupuestoPagos($idpresupuestopago)) {
            echo "OK";
        } else {
            throw new Exception("Error al eliminar el presupuesto Pago");
        }
    }
    // Mostrar informacion de los pagos
    public function mostrarInformacionPagos()
    {
        $idcliente = $_POST['id'];
        $data = $this->model->MostrarInformacionPagos($idcliente);
        echo json_encode($data);
    }
    public function DataBoleta($nparam = null)
    {
        $this->disabledCache();
        //$idcliente = $nparam[0];
        $idcliente = $_POST['id'];
        $status = $_POST['status'];
        if ($status == 'todo') {
            $status = 'todo';
        }
        $data = $this->model->DataBoleta($idcliente, $status);
        $cliente = $this->model->GetOne($idcliente);
        $nombre = $cliente['nombre'] . ' ' . $cliente['apellido'];
        while ($row = mysqli_fetch_assoc($data)) {
            $datos[] = array($row['procedimiento'], $row['importe']);
        }
        //echo json_encode($datos);
        $this->Boleta($datos, $nombre);
        //$this->render($idcliente);
    }
    public function boleta($data, $nombre)
    {
        if (count($data) < 7) {
            $height = 140;
        }
        if (count($data) > 7 && count($data) <= 12) {
            $height = 200;
        }
        // 7 ya se hace otra pagina
        if (count($data) > 12) {
            $porFila = 14.5;
            $height = $porFila * count($data);
        }

        $pdf = new Boleta('P', 'mm', array(72, $height)); // Asegurar el ancho correcto
        $pdf->SetMargins(4, 2, 4); // Agregar márgenes para evitar desbordamientos
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(70, 6, 'Boleta N: B001-00012345', 0, 1, 'L');
        //$pdf->Cell(70, 6, 'Cliente: '.$nombre, 0, 1, 'L');
        $pdf->MultiCell(70, 6, 'Cliente: ' . $nombre, 0, 'L');
        $pdf->Cell(35, 6, 'Fecha: ' . date('d/m/Y'), 0, 0, 'L');
        $pdf->Cell(35, 6, 'Hora: ' . date(' h:i A'), 0, 1, 'L');
        $pdf->Ln(2);
        $pdf->Cell(70, 0, str_repeat('-', 60), 0, 1, 'C');
        $pdf->Ln(2);

        // Detalle de productos
        $pdf->SetFont('Arial', 'B', 9);
        // $pdf->Cell(15, 6, 'Cant', 0, 0, 'C');
        $pdf->Cell(40, 6, 'Descripcion', 0, 0, 'C');
        $pdf->Cell(30, 6, 'Total', 0, 1, 'C');
        $pdf->Cell(70, 0, str_repeat('-', 60), 0, 1, 'C');
        $pdf->Ln(2);

        $total = 0;
        $pdf->SetFont('Arial', '', 9);
        foreach ($data as $p) {
            if (strlen($p[0]) < 27) {
                $pdf->Cell(40, 6, $p[0], 0, 0, 'L');
                $pdf->Cell(30, 6, number_format($p[1], 2), 0, 1, 'C');
                $total += $p[1];
            }
            if (strlen($p[0]) > 27) {
                $x = $pdf->GetX(); // Guarda la posición actual
                $y = $pdf->GetY(); // Guarda la posición actual
                $pdf->MultiCell(50, 6, $p[0], 0, 'L'); // Descripción (salto de línea automático)
                // Ajustar la posición del siguiente dato
                $pdf->SetXY($x + 40, $y); // Mueve el cursor después de la descripción     
                $pdf->Cell(30, 6, number_format($p[1], 2), 0, 1, 'C');
                $pdf->ln(5);
                $total += $p[1];
            }
        }
        $pdf->ln(4);
        $pdf->Cell(70, 0, str_repeat('-', 60), 0, 1, 'C');
        $pdf->Ln(2);
        $pdf->Cell(45, 6, 'Subtotal:', 0, 0, 'R');
        $pdf->Cell(18, 6, number_format($total, 2), 0, 1, 'R');
        $pdf->Cell(45, 6, 'IGV (18%):', 0, 0, 'R');
        $pdf->Cell(18, 6, number_format($total * 0.18, 2), 0, 1, 'R');
        $pdf->Cell(45, 6, 'Total a pagar:', 0, 0, 'R');
        $pdf->Cell(18, 6, number_format($total * 1.18, 2), 0, 1, 'R');
        // $pdf->Ln(5);

        $pdf->Output('F', 'boleta.pdf');

    }
}
class Boleta extends FPDF
{
    function Header()
    {
        $this->SetFont('Courier', '', 9);
        $this->Cell(70, 6, 'CHIC CONSULTORIO DENTAL', 0, 1, 'C');
        $this->SetFont('Arial', '', 9);
        $this->Cell(70,4,'Jr. Lambayeque 123, Puno',0,1,'C');
        $this->Cell(70, 4, 'RUC: 12345678901', 0, 1, 'C');
        $this->Cell(70, 4, 'Tel: 951781807', 0, 1, 'C');
        $this->Ln(2);
        $this->Cell(70, 0, str_repeat('-', 60), 0, 1, 'C');
        $this->Ln(2);
    }

    function Footer()
    {
        $this->SetY(-30);
        $this->SetFont('Arial', '', 9);
        $this->MultiCell(68, 6, 'Representacion impresa de la Boleta de venta Electronica', 0, 'C');
        $this->MultiCell(70, 6, 'CHIC CONSULTORIO DENTAL', 0, 'C');
        $this->Cell(72, 6, '!Gracias por su compra!', 0, 1, 'C');
        $this->Cell(72, 0, str_repeat('-', 32), 0, 1, 'C');
    }
}

?>