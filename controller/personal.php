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
	function detalles($nparam=null){
		$id = $nparam[0];
		$data = $this->model->GetPersonal($id);
		$this->view->data = $data;
		$this->view->Render('personal/detalles');
	}
	function login($nparam=null){
		$id = $nparam[0];
		$data = $this->model->GetLogin($id);
		$this->view->data = $data;
		$this->view->Render('personal/login');
	}
	public function get(){
		$this->disabledCache();
		$data = $this->model->Get();
		while($row = mysqli_fetch_assoc($data)){
			$json[] = array(
				"id"=>$row['idpersonal'],
				"nombre"=>$row['nombre'],
				"apellido"=>$row['apellido'],
				"dni"=>$row['dni'],
				"telefono"=>$row['telefono'],
			);
		}
		echo json_encode($json);
	}
	public function nuevoPersonal(){
		$this->disabledCache();
		$dni = $_POST['dni'];
		$telefono = $_POST['telefono'];
		$nombre = $_POST['nombre'];
		$apellido = $_POST['apellido'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$password = password_hash($password, PASSWORD_DEFAULT);
		if($this->model->NuevoPersonal($dni,$telefono,$nombre,$apellido,$username,$password)){
			echo "ok";
		}else{
			//echo "Error al crear el personal";
			//throw new Exception("Error al crear el personal");
		}
	}
	public function actualizarPersonal(){
		$id = $_POST['idpersonal'];
		$telefono = $_POST['telefono'];
		$sexo = $_POST['sexo'];
		$email = $_POST['email'];
		$fechanacimiento = $_POST['fechanacimiento'];
		//var_dump($fechanacimiento);
		$foto = $_FILES['foto'];
		if($this->model->ActualizarPersonal($id,$telefono,$sexo,$email,$fechanacimiento)){
			echo "ok";
		}else{
			//echo "Error al actualizar el personal";
			throw new Exception("Error al actualizar el personal");
		}
		$this->detalles($id);
	}
	public function actualizarLogin(){
		$id = $_POST['idpersonal'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$estado = $_POST['estado'];
		$nivel = $_POST['nivel'];
		$password = password_hash($password, PASSWORD_DEFAULT);
		if($this->model->ActualizarLogin($id,$username,$password,$estado,$nivel)){
			echo "ok";
		}else{
			throw new Exception("Error al actualizar el login");
		}
		$this->login($id);
	}
}