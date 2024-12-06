<?php
class Clientes extends Controller
{

	function __construct()
	{
		parent::__construct();
	}
	function render()
	{
		$this->view->css='clientes';
		$this->view->Render('clientes/index');
	}
	function detalles($nparam = null){
		$id = $nparam[0];
		$data = $this->model->GetOne($id);
		$this->view->data = $data;
		$this->view->css='clientes';
		$this->view->Render('clientes/detalles');
	}
	public function get(){
		$data = $this->model->Get();
		while($row = mysqli_fetch_assoc($data)){
			$json[] = array(
				"id"=>$row['idcliente'],
				"nombre"=>$row['nombre'],
				"apellido"=>$row['apellido'],
				"dni"=>$row['dni'],
				"telefono"=>$row['telefono'],
			);
		}
		echo json_encode($json);
	}
	public function nuevoCliente(){
		$dni = $_POST['dni'];
		$telefono = $_POST['telefono'];
		$idprocedimiento = $_POST['procedimiento'];
		$concepto = $_POST['concepto'];
		$totalpagar = intval($_POST['totalpagar']);
		$primerpago = intval($_POST['primerpago']);
		$nombre = $_POST['nombre'];
		$apellido = $_POST['apellido'];
		if($totalpagar < $primerpago){
			throw new Exception("El total a pagar debe ser mayor al primer pago");
		}
		// SE VERIFICA SI YA EXISTE EL CLIENTE-> SI ES ASI SE OBTIENE SU ID
		$data = $this->model->VerificarCliente($dni);
		if(!empty($data)){
			$idcliente = $data['idcliente'];
			if($this->model->NuevoPagoCliente($idcliente,$idprocedimiento,$totalpagar,$concepto,$primerpago)){
				echo "ok";
			}else{
				throw new Exception("Error al crear el pago con cliente ya registrado");
			}
		}else{
			// SI NO SE OBTIENE TODOS LOS DATOS Y CREA EL NUEVO CLIENTE MAS
			if($this->model->NuevoCliente($nombre,$apellido,$dni,$telefono,$idprocedimiento,$totalpagar,$concepto,$primerpago)){
				echo "ok";
			}else{
				throw new Exception("Error al crear el cliente");
			}
		}
	}
	public function getProcedimientos():void{
		$data = $this->model->GetProcedimientos();
		while($row = mysqli_fetch_assoc($data)){
			$json[] = array(
				"id"=>$row['idprocedimiento'],
				"procedimiento"=>$row['procedimiento'],
			);
		}
		echo json_encode($json);
	}
	public function getProcedimientosOne(){
		$idcliente = $_POST['id'];
		$data = $this->model->GetProcedimientosOne($idcliente);
		while($row = mysqli_fetch_assoc($data)){
			$json[] = array(
				"idcliente"=>$row['idcliente'],
				"idprocedimiento"=>$row['idprocedimiento'],
				"idpago"=>$row['idpago'],
				"procedimiento"=>$row['procedimiento'],
			);
		}
		echo json_encode($json);
	}
	public function getPagos(){
		$idpago = $_POST['id'];
		$data = $this->model->GetPagos($idpago);
		while($row = mysqli_fetch_assoc($data)){
			$json[] = array(
				"idpago"=>$row['idpago'],
				"monto"=>$row['monto'],
				"concepto"=>$row['concepto'],
				"fecha"=>date("Y-m-d", strtotime($row['fecha'])),
			);
		}
		echo json_encode($json);
	}
	public function getPago(){
		$idpago = $_POST['idpago'];
		$idprocedimiento = $_POST['idprocedimiento'];
		$pago = $this->model->GetPago($idpago,$idprocedimiento);
		echo json_encode($pago);
	}
	public function nuevoPago(){
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
		if($monto > $pagodeuda){
			throw new Exception("El monto pagado es mayor al pago acumulado");
		}
		if($this->model->NuevoPago($idpago,$idprocedimiento,$idcliente,$monto,$concepto,$nuevoMontoTotal,$nuevaDeudaTotal)){
			echo "ok";
		}else{
			throw new Exception("Error al crear el pago");
		}
	}
	function actualizarCliente(){
		$idcliente = $_POST['idcliente'];
		$telefono = $_POST['telefono'];
		$email = $_POST['email'];
		$sexo = $_POST['sexo'];
		$ciudad = $_POST['ciudad'];
		$direccion = $_POST['direccion'];
		if($this->model->ActualizarCliente($idcliente,$telefono,$email,$sexo,$ciudad,$direccion)){
			//echo "ok";
		}else{
			throw new Exception("Error al actualizar el cliente");
		}
		$this->detalles($idcliente);
	}
}