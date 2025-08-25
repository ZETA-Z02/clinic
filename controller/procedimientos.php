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
		$this->disabledCache();
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
		$this->disabledCache();
		$post = json_decode(file_get_contents('php://input'), true);
		$id = $post['id'];
		$data = $this->model->GetOne($id);
		echo json_encode($data);
	}
	public function nuevoProcedimiento():void{
		try{
			$data = json_decode(file_get_contents('php://input'),true);
			//echo json_encode($data);
			$id = $data['id'];
			$procedimiento = $data['procedimiento'];
			$precio = $data['precio'];
			$descripcion = $data['descripcion'];
			$iniciles = $data['iniciales'];
			$color = $data['color'];
			if(empty($id)){
				if($result = $this->model->NuevoProcedimiento($procedimiento,$descripcion,$precio,$iniciles,$color)){
					echo json_encode([
						"success" => true,
						"message" => "procedimiento creado exitosamente",
						"data" => $result,
						"error" => false
					]);
				}else{
					throw new Exception("Error al crear el procedimiento");
				}
			}else{
				if($result = $this->model->EditarProcedimiento($id,$procedimiento,$descripcion,$precio,$iniciles,$color)){
					echo json_encode([
						"success" => true,
						"message" => "Procedimiento actualizado correctamente",
						"data" => $result,
						"error" => false
					]);
				}else{
					throw new Exception("Error al actualizar el procedimiento");
				}
			}
		}catch(Exception $e) {
            http_response_code($e->getCode() ?: 500);
            echo json_encode([
                "success" => false,
                "error" => $e->getMessage()
            ]);
        }
	}
	public function delete(){
		try{
			$post = json_decode(file_get_contents('php://input'), true);
			$id = $post['id'];
			if($result = $this->model->Delete($id)){
				echo json_encode([
					"success" => true,
					"message" => "Procedimiento eliminado correctamente",
					"data" => $result,
					"error" => false
				]);
			}else{
				throw new Exception("Error al eliminar el procedimiento");
			}
		}catch(Exception $e) {
			http_response_code($e->getCode() ?: 500);
            echo json_encode([
                "success" => false,
                "error" => $e->getMessage()
            ]);
		}
	}
}