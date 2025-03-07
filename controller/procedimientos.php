<?php
class Procedimientos extends Controller
{
	function __construct()
	{
		parent::__construct();
	}

	function render()
	{
		$this->view->Render('procedimientos/index');
	}
	public function get():void{
		$data = $this->model->Get();
		while($row = mysqli_fetch_assoc($data)){
			$json[] = array(
				"id"=>$row['idprocedimiento'],
				"procedimiento"=>$row['procedimiento'],
				"descripcion"=>$row['descripcion'],
				"precio"=>$row['precio'],
				"fecha"=>$row['feCreate']
			);
		}
		echo json_encode($json);
	}
	public function getOne(){
		$id = $_POST['id'];
		$data = $this->model->GetOne($id);
		echo json_encode($data);
	}
	public function nuevoProcedimiento():void{
		$id = $_POST['id'];
		$procedimiento = $_POST['procedimiento'];
		$precio = $_POST['precio'];
		$descripcion = $_POST['descripcion'];
		$iniciles = $_POST['iniciales'];
		$color = $_POST['color'];
		if(empty($id)){
			if($this->model->NuevoProcedimiento($procedimiento,$descripcion,$precio,$iniciles,$color)){
				echo 1;
			}else{
				trigger_error("Error al crear el procedimiento");
			}
		}else{
			if($this->model->EditarProcedimiento($id,$procedimiento,$descripcion,$precio,$iniciles,$color)){
				echo 1;
			}else{
				trigger_error("Error al Actualizar el procedimiento");
			}
		}
	}
	public function delete(){
		$id = $_POST['id'];
		if($this->model->Delete($id)){
			echo 1;
		}else{
			trigger_error("Error al eliminar el procedimiento");
		}
	}
}