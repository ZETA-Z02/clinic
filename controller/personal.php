<?php
class Personal extends Controller
{
	function __construct()
	{
		parent::__construct();
	}
	function render()
	{
		$this->view->Render('personal/index');
	}
	function detalles($nparam = null)
	{
		$id = $nparam[0];
		$data = $this->model->GetPersonal($id);
		$this->view->data = $data;
		$this->view->Render('personal/detalles');
	}
	function login($nparam = null)
	{
		$id = $nparam[0];
		$data = $this->model->GetLogin($id);
		$this->view->data = $data;
		$this->view->Render('personal/login');
	}
	public function get()
	{
		$this->disabledCache();
		$data = $this->model->Get();
		while ($row = mysqli_fetch_assoc($data)) {
			$json[] = array(
				"id" => $row['idpersonal'],
				"nombre" => $row['nombre'],
				"apellido" => $row['apellido'],
				"dni" => $row['dni'],
				"telefono" => $row['telefono'],
			);
		}
		echo json_encode($json);
	}
	public function nuevoPersonal()
	{
		try {
			$data = json_decode(file_get_contents('php://input'), true);
			//echo json_encode($data);
			$dni = $data['dni'];
			$telefono = $data['telefono'];
			$nombre = $data['nombre'];
			$apellido = $data['apellido'];
			$etiqueta = $data['nombre_etiqueta'];
			$color = $data['color'];
			$username = $data['username'];
			$password = $data['password'];
			$password = password_hash($password, PASSWORD_DEFAULT);
			$result = $this->model->NuevoPersonal($dni, $telefono, $nombre, $apellido, $username, $password, $etiqueta, $color);
			echo json_encode([
				"success" => true,
				"message" => "Personal creado correctamente",
				"data" => $result,
				"error" => false
			]);
		} catch (Exception $e) {
			http_response_code($e->getCode() ?: 500);
			echo json_encode([
				"success" => false,
				"error" => $e->getMessage()
			]);
		}
	}
	public function actualizarPersonal()
	{
		$id = $_POST['idpersonal'];
		$nombre = $_POST['nombre'];
		$dni = $_POST['dni'];
		$telefono = $_POST['telefono'];
		$sexo = $_POST['sexo'];
		$email = $_POST['email'];
		$fechanacimiento = $_POST['fechanacimiento'];
		$foto = $_FILES['foto'];
		if (!$ruta = $this->File($foto, $nombre, $dni)) {
			$ruta = "";
		}
		if ($this->model->ActualizarPersonal($id, $telefono, $sexo, $email, $fechanacimiento, $ruta)) {
			// echo "ok";
			$this->detalles($id);
		} else {
			//echo "Error al actualizar el personal";
			throw new Exception("Error al actualizar el personal");
		}
		$this->detalles($id);
	}
	public function actualizarLogin()
	{
		$id = $_POST['idpersonal'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$estado = $_POST['estado'];
		$nivel = $_POST['nivel'];
		if (!empty($password)) {
			$password = password_hash($password, PASSWORD_DEFAULT);
		}
		if ($this->model->ActualizarLogin($id, $username, $password, $estado, $nivel)) {
			//echo "$password";
		} else {
			throw new Exception("Error al actualizar el login");
		}
		$this->login($id);
	}
}