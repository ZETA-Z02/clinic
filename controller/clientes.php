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
	public function citas($nparam = null)
	{
		$id = $nparam[0];
		$cliente = $this->model->GetOne($id);
		$this->view->data = $cliente;
		$this->view->css = 'clientes';
		$this->view->Render('clientes/citas');
	}
	public function onecita($nparam = null)
	{
		$id = $nparam[0];
		$data = $this->model->onecita($id);
		while ($row = mysqli_fetch_array($data)) {
			$json[] = array(
				'id' => $row['idcita'],
				'title' => $row['titulo'],
				'start' => $row['fecha_ini'] . 'T' . $row['hora_ini'],
				'end' => $row['fecha_fin'] . 'T' . $row['hora_fin'],
				'borderColor' => $row['color'],
				'backgroundColor' => $row['color'],
				'textColor' => '#ffffff',
				'idcliente' => $row['idcliente'],
				'idetiqueta' => $row['idetiqueta'],
				'fecha_ini' => $row['fecha_ini'],
				'hora_ini' => $row['hora_ini'],
				'fecha_fin' => $row['fecha_fin'],
				'hora_fin' => $row['hora_fin'],
			);
		}
		echo json_encode($json);
	}
	// CITAS DE UN SOLO CLIENTE END
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
		try {
			$post = json_decode(file_get_contents("php://input"), true);
			$dni = $post['dni'];
			$telefono = $post['telefono'];
			$nombre = $post['nombre'];
			$apellido = $post['apellido'];
			$direccion = $post['direccion'];
			// SE VERIFICA SI YA EXISTE EL CLIENTE-> SI ES ASI SE OBTIENE SU ID
			$data = $this->model->VerificarCliente($dni);
			if (!empty($data)) {
				throw new Exception("Ya Existe este cliente en la base de datos");
			}
			if ($result = $this->model->NuevoCliente($nombre, $apellido, $dni, $telefono, $direccion)) {
				echo json_encode([
					"success" => true,
					"message" => "Cliente creado correctamente",
					"data" => $result,
					"error" => false
				]);
			} else {
				throw new Exception("Error al crear un nuevo cliente");
			}
		} catch (Exception $e) {
			http_response_code($e->getCode() ?: 500);
			echo json_encode([
				"success" => false,
				"error" => $e->getMessage()
			]);
		}
	}
	public function actualizarCliente()
	{
		try {
			$post = json_decode(file_get_contents("php://input"), true);
			$idcliente = $post['idcliente'];
			$nombre = $post['nombre'];
			$apellido = $post['apellido'];
			$telefono = $post['telefono'];
			$email = $post['email'];
			$sexo = $post['sexo'];
			$ciudad = $post['ciudad'];
			$direccion = $post['direccion'];
			// CONDICION DEL CLIENTE
			$antecedente = $post['antecedente'];
			$antecedente_observacion = $post['antecedente_observacion'];
			$medicado = $post['medicamento'];
			$medicado_observacion = $post['medicado_observacion'];
			$anestesia = $post['anestesia'];
			$anestesia_observacion = $post['anestesia_observacion'];
			$alergiamedicamento = $post['alergiamedicamento'];
			$alergiamedicamento_observacion = $post['alergiamedicamento_observacion'];
			$hemorragias = $post['hemorragias'];
			$hemorragias_observacion = $post['hemorragias_observacion'];
			$enfermedad = $post['enfermedad'];
			$observaciones = $post['observaciones'];

			if ($result = $this->model->ActualizarCliente($idcliente, $nombre, $apellido, $telefono, $email, $sexo, $ciudad, $direccion, $antecedente, $medicado, $anestesia, $alergiamedicamento, $hemorragias, $enfermedad, $observaciones, $antecedente_observacion, $medicado_observacion, $anestesia_observacion, $alergiamedicamento_observacion, $hemorragias_observacion)) {
				//echo "ok";
				// $this->detalles([$idcliente,0]);
				echo json_encode([
					"success" => true,
					"message" => "Cliente actualizado correctamente",
					"data" => $result,
					"error" => false
				]);
			} else {
				throw new Exception("Error al actualizar el cliente");
			}
		} catch (Exception $e) {
			http_response_code($e->getCode() ?: 500);
			echo json_encode([
				"success" => false,
				"error" => $e->getMessage()
			]);
		}
	}
	public function citasCliente()
	{
		$post = json_decode(file_get_contents("php://input"),true);
		$id = $post['id'];
		$data = $this->model->CitasCliente($id);
		while ($row = mysqli_fetch_array($data)) {
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