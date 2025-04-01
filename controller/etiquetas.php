<?php
class Etiquetas extends Controller
{
	function __construct()
	{
		parent::__construct();
	}
	function render()
	{
		$this->view->Render('etiquetas/index');
	}
	public function get(){
		$this->disabledCache();
		$data = $this->model->Get();
		while($row = mysqli_fetch_assoc($data)){
			$json[] = array(
				"id" => $row['idetiqueta'],
				"personal" => $row['personal'],
				"color" => $row['color'],
				"nombre" => $row['nombre'],
			);
		}
		echo json_encode($json);
	}
	public function getOne(){
		$this->disabledCache();
		$id = $_POST['id'];
		$data = $this->model->GetOne($id);
		echo json_encode($data);
	}
	public function create(){
		$this->disabledCache();
		$idetiqueta = $_POST['id'];
		$idpersonal = $_POST['idpersonal'];
		$nombre = $_POST['nombre'];
		$color = $_POST['color'];
		if(empty($idetiqueta)){
			if($this->model->Create($idpersonal,$color,$nombre)){
				echo "ok etiquetas";
			}else{
				echo "error create etiquetas";
			}
		}else{
			if($this->model->Update($idetiqueta,$idpersonal,$color,$nombre)){
				echo "ok etiquetas";
			}else{
				echo "error create etiquetas";
			}
		}
	}
	public function delete(){
		$this->disabledCache();
		$id = $_POST['id'];
		if($this->model->Delete($id)){
			echo 1;
		}else{
			trigger_error("Error al eliminar el procedimiento");
		}
	}
	public function getPersonal(){
		$this->disabledCache();
		$data = $this->model->GetPersonal();
		while($row = mysqli_fetch_assoc($data)){
			$json[] = array(
				"id" => $row["idpersonal"],
				"nombres" => $row["nombres"],
			);
		}
		echo json_encode($json);
	}
}