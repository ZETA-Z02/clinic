<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;
class Clientes extends Controller
{
	function __construct()
	{
		parent::__construct();
	}
	function render()
	{
		$this->view->css = 'clientes';
		$this->view->Render('clientes/index');
	}
	// CITAS DE UN SOLO CLIENTE
	public function citas($nparam = null){
		$id = $nparam[0];
		$cliente = $this->model->GetOne($id);
		$this->view->data = $cliente;
		$this->view->css = 'clientes';
		$this->view->Render('clientes/citas');
	}
	public function onecita($nparam = null){
		$id = $nparam[0];
		$data = $this->model->onecita($id);
		while($row = mysqli_fetch_array($data)){
            $json[] = array(
				'id'=> $row['idcita'],
				'title' => $row['titulo'],
                'start' => $row['fecha_ini'].'T'.$row['hora_ini'],
                'end'   => $row['fecha_fin'].'T'.$row['hora_fin'],
                'borderColor' => $row['color'],
                'backgroundColor' => $row['color'],
                'textColor' => '#ffffff',
				'idcliente' => $row['idcliente'],
				'idetiqueta' => $row['idetiqueta'],
				'fecha_ini'	=> $row['fecha_ini'],
				'hora_ini'	=> $row['hora_ini'],
				'fecha_fin'	=> $row['fecha_fin'],
				'hora_fin'	=> $row['hora_fin'],
            );
        }
        echo json_encode($json);
	}
	// CITAS DE UN SOLO CLIENTE END
	public function renderNuevoPago($npam = null){
		$id = $npam[0];
		$cliente = $this->model->GetOne($id);
		$this->view->css = 'clientes';
		$this->view->data = $cliente;
		$this->view->Render('clientes/nuevopago');
	}
	public function newPago(){
		$this->view->css = 'clientes';
		$this->view->Render('clientes/newpago');
	}
	public function pagos()
	{
		$this->view->Render('clientes/pagos');
	}

	function detalles($nparam = null)
	{
		$id = $nparam[0];
		$data = $this->model->GetOne($id);
		$response = $this->model->Condicion($id);
		$this->view->data = $data;
		$this->view->response = $response;
		$this->view->css = 'clientes';
		$this->view->Render('clientes/detalles');
	}
	public function getCliente(){
		$id = $_POST['id'];
		$data = $this->model->GetOne($id);
		echo json_encode($data);
	}
	public function get()
	{
		$data = $this->model->Get();
		while ($row = mysqli_fetch_assoc($data)) {
			$json[] = array(
				"id" => $row['idcliente'],
				"nombre" => $row['nombre'],
				"apellido" => $row['apellido'],
				"dni" => $row['dni'],
				"telefono" => $row['telefono'],
			);
		}
		echo json_encode($json);
	}
	public function nuevoCliente()
	{
		$dni = $_POST['dni'];
		$telefono = $_POST['telefono'];
		$nombre = $_POST['nombre'];
		$apellido = $_POST['apellido'];
		$direccion = $_POST['direccion'];
		// SE VERIFICA SI YA EXISTE EL CLIENTE-> SI ES ASI SE OBTIENE SU ID
		$data = $this->model->VerificarCliente($dni);
		if (!empty($data)) {
			throw new Exception("Ya Existe este cliente en la base de datos");
		}
		if ($this->model->NuevoCliente($nombre,$apellido,$dni,$telefono,$direccion)) {
			echo "ok";
		} else {
			throw new Exception("Error al crear un nuevo cliente");
		}
	}
	public function getProcedimientos(): void
	{
		$data = $this->model->GetProcedimientos();
		while ($row = mysqli_fetch_assoc($data)) {
			$json[] = array(
				"id" => $row['idprocedimiento'],
				"procedimiento" => $row['procedimiento'],
			);
		}
		echo json_encode($json);
	}
	public function getProcedimientosOne()
	{
		$idcliente = $_POST['id'];
		$data = $this->model->GetProcedimientosOne($idcliente);
		while ($row = mysqli_fetch_assoc($data)) {
			$json[] = array(
				"idcliente" => $row['idcliente'],
				"idprocedimiento" => $row['idprocedimiento'],
				"idpago" => $row['idpago'],
				"procedimiento" => $row['procedimiento'],
			);
		}
		echo json_encode($json);
	}
	public function getPagos()
	{
		$idpago = $_POST['id'];
		$data = $this->model->GetPagos($idpago);
		while ($row = mysqli_fetch_assoc($data)) {
			$json[] = array(
				"idpago" => $row['idpago'],
				"monto" => $row['monto'],
				"concepto" => $row['concepto'],
				"fecha" => date("Y-m-d", strtotime($row['fecha'])),
			);
		}
		echo json_encode($json);
	}
	public function getPago()
	{
		$idpago = $_POST['idpago'];
		$idprocedimiento = $_POST['idprocedimiento'];
		$pago = $this->model->GetPago($idpago, $idprocedimiento);
		echo json_encode($pago);
	}
	public function nuevoPago()
	{
		$idpago = $_POST['idpago'];
		$idprocedimiento = $_POST['idprocedimiento'];
		$idcliente = $_POST['idcliente'];
		$monto = $_POST['monto'];
		$concepto = $_POST['nuevoconcepto'];
		//$pagototal = $_POST['pago-total'];
		$pagomonto = $_POST['pago-monto'];
		$pagodeuda = $_POST['pago-deuda'];
		$nuevoMontoTotal = $pagomonto + $monto;
		$nuevaDeudaTotal = $pagodeuda - $monto;
		if ($monto > $pagodeuda) {
			throw new Exception("El monto pagado es mayor al pago acumulado");
		}
		if ($this->model->NuevoPago($idpago, $idprocedimiento, $idcliente, $monto, $concepto, $nuevoMontoTotal, $nuevaDeudaTotal)) {
			echo "ok";
		} else {
			throw new Exception("Error al crear el pago");
		}
	}
	public function actualizarCliente()
	{
		$idcliente = $_POST['idcliente'];
		$nombre = $_POST['nombre'];
		$apellido = $_POST['apellido'];
		$telefono = $_POST['telefono'];
		$email = $_POST['email'];
		$sexo = $_POST['sexo'];
		$ciudad = $_POST['ciudad'];
		$direccion = $_POST['direccion'];
		// CONDICION DEL CLIENTE
		$antecedente = $_POST['antecedente'];
		$antecedente_observacion = $_POST['antecedente_observacion'];
		$medicado = $_POST['medicamento'];
		$medicado_observacion = $_POST['medicado_observacion'];
		$anestesia = $_POST['anestesia'];
		$anestesia_observacion = $_POST['anestesia_observacion'];
		$alergiamedicamento = $_POST['alergiamedicamento'];
		$alergiamedicamento_observacion = $_POST['alergiamedicamento_observacion'];
		$hemorragias = $_POST['hemorragias'];
		$hemorragias_observacion = $_POST['hemorragias_observacion'];
		$enfermedad = $_POST['enfermedad'];
		$observaciones = $_POST['observaciones'];

		if ($this->model->ActualizarCliente($idcliente,$nombre,$apellido,$telefono,$email,$sexo,$ciudad,$direccion,$antecedente, $medicado, $anestesia, $alergiamedicamento, $hemorragias, $enfermedad, $observaciones, $antecedente_observacion, $medicado_observacion, $anestesia_observacion, $alergiamedicamento_observacion, $hemorragias_observacion)) {
			//echo "ok";
		} else {
			throw new Exception("Error al actualizar el cliente");
		}
		//$this->detalles(array($idcliente,0));
	}
	public function borrarCliente():void{
		$idcliente = $_POST['idcliente'];
		$this->model->BorrarCliente($idcliente);
		$this->render();
	}
	public function citasCliente(){
		$id = $_POST['id'];
		$data = $this->model->CitasCliente($id);
		while($row = mysqli_fetch_array($data)){
			$json[] = array(
				// "fecha" => date("Y-m-d", strtotime($row['fecha'])),
				"fecha" => $row['fecha_ini'],
				"hora" => $row['hora_ini'],
				"titulo" => $row['titulo'],
				"mensaje" => $row['mensaje'],
			);
		}
		echo json_encode($json);
	}

}