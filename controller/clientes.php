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
	public function pagos()
	{
		$this->view->Render('clientes/pagos');
	}
	function detalles($nparam = null)
	{
		$id = $nparam[0];
		$data = $this->model->GetOne($id);
		$this->view->data = $data;
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
		$idprocedimiento = $_POST['procedimiento'];
		$concepto = $_POST['concepto'];
		$totalpagar = intval($_POST['totalpagar']);
		$primerpago = intval($_POST['primerpago']);
		$nombre = $_POST['nombre'];
		$apellido = $_POST['apellido'];
		if ($totalpagar < $primerpago) {
			throw new Exception("El total a pagar debe ser mayor al primer pago");
		}
		// SE VERIFICA SI YA EXISTE EL CLIENTE-> SI ES ASI SE OBTIENE SU ID
		$data = $this->model->VerificarCliente($dni);
		if (!empty($data)) {
			$idcliente = $data['idcliente'];
			if ($this->model->NuevoPagoCliente($idcliente, $idprocedimiento, $totalpagar, $concepto, $primerpago)) {
				echo "ok";
			} else {
				throw new Exception("Error al crear el pago con cliente ya registrado");
			}
		} else {
			// SI NO SE OBTIENE TODOS LOS DATOS Y CREA EL NUEVO CLIENTE MAS
			if ($this->model->NuevoCliente($nombre, $apellido, $dni, $telefono, $idprocedimiento, $totalpagar, $concepto, $primerpago)) {
				echo "ok";
			} else {
				throw new Exception("Error al crear el cliente");
			}
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
		$telefono = $_POST['telefono'];
		$email = $_POST['email'];
		$sexo = $_POST['sexo'];
		$ciudad = $_POST['ciudad'];
		$direccion = $_POST['direccion'];
		if ($this->model->ActualizarCliente($idcliente, $telefono, $email, $sexo, $ciudad, $direccion)) {
			//echo "ok";
		} else {
			throw new Exception("Error al actualizar el cliente");
		}
		$this->detalles($idcliente);
	}
	public function boletaPagos($nparam = null)
	{
		$id = $nparam[0];
		$cliente = $this->model->GetOne($id);
		$datapagos = $this->model->DataPagos($id);
		$dia = date("d");
		$mes = date('m');
		$anio = date('Y');
		$data = '';
		$total = 0;
		while($row = mysqli_fetch_assoc($datapagos)){
			$data .= '<tr>
                    <td>1</td>
                    <td>'.$row['procedimiento'].'</td>
                    <td>'.$row['total_pagar'].'</td>
                </tr>';
			$total += intval($row['total_pagar']);
		}
		$dompdf = new Dompdf();
		//$dompdf->set_option('isRemoteEnabled', true);
		$html = '<!DOCTYPE html>
					<html>

					<head>
						<title>Recibo</title>
						<style>
							.container {
								margin: auto;
								width: 100%;
								max-width: 600px;
								color: #77f;
							}
							table{
								width: 100%;
								border-collapse: collapse;
								border-spacing: 0;
							}
							.titulo-principal, .recibo{
								border: 1px solid #77f;
								border-radius: 15px;
								overflow: hidden;
							}
							.titulo-principal td, .fecha th, .fecha td{
								border-radius: none;
								overflow: hidden;
							}
							#fecha{
								margin-top: 10px;
							}
							.bordeado{
								border: 1px solid #77f;
								border-radius: 15px;
								padding: 5px;
							}
							.title{
								
							}
							td {
								text-align: center;
							}
							.boleta-contenido tr td{
								border: 1px solid #77f;
								margin: 0;
								padding: 0;
							}
							.totales p {
								text-align: right;
							}
						</style>
					</head>

					<body>
						<div class="container">
							<div class="titulo-principal">
							<table>
								<tr>
									<td >
										<h2>Gestión y Asesoramiento para Empresas de la
											Salud</h2>
										<h4>Ortodoncia</h4>
										<p>JR. Lambayeque Nº 117 A Puno - Puno - Puno</p>
									</td>
									<td class="">
										<div class="recibo">
											<h2 class="title">RECIBO</h2>
											<span>N : 1000123</span>
										</div>
										<div class="bordeado" id="fecha">
										<table class="fecha">
											<tr>
												<th>Dia</th>
												<th>Mes</th>
												<th>Año</th>
											</tr>
											<tr>
												<td>'.$dia.'</td>
												<td>'.$mes.'</td>
												<td>'.$anio.'</td>
											</tr>
										</table>
										</div>
									</td>
								</tr>
							</table>
							</div>
							<div class="cliente bordeado">
								<p><strong>Señor(a): </strong> '.$cliente['nombre'] .' '.$cliente['apellido'].'</p>
								<p><strong>DNI: </strong> '.$cliente['dni'].'</p>
							</div>
							<div class="bordeado">
							<table class="boleta-contenido">
								<thead>
									<tr>
										<th>Cant.</th>
										<th>Descripcion</th>
										<th>Importe</th>
									</tr>
								</thead>
								<tbody>
									'.$data.'
								</tbody>
							</table>
							</div>
							<div class="totales">
								<p><strong>TOTAL S/:'.$total.'</strong></p>
							</div>
						</div>
					</body>

					</html>';
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A5', 'portrait');
		$dompdf->render();
		$dompdf->stream("Boleta.pdf", array("Attachment" => false));
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
	}

}