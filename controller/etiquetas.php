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
	public function get()
	{
		$this->disabledCache();
		$data = $this->model->Get();
		while ($row = mysqli_fetch_assoc($data)) {
			$json[] = array(
				"id" => $row['idetiqueta'],
				"personal" => $row['personal'],
				"color" => $row['color'],
				"nombre" => $row['nombre'],
			);
		}
		echo json_encode($json);
	}
	public function getOne()
	{
		$this->disabledCache();
		$data = json_decode(file_get_contents('php://input'), true);
		//echo json_encode($data);
		$id = $data['id'];
		$data = $this->model->GetOne($id);
		echo json_encode($data);
	}
	public function create()
	{
		try {
			$data = json_decode(file_get_contents('php://input'), true);
			//echo json_encode($data);
			$idetiqueta = $data['id'];
			$idpersonal = $data['idpersonal'];
			$nombre = $data['nombre'];
			$color = $data['color'];
			if (empty($idetiqueta)) {
				if ($result = $this->model->Create($idpersonal, $color, $nombre)) {
					echo json_encode([
						"success" => true,
						"message" => "Etiqueta creado correctamente",
						"data" => $result,
						"error" => false
					]);
				} else {
					throw new Exception("Error al actualizar la etiqueta");
				}
			} else {
				if ($result = $this->model->Update($idetiqueta, $idpersonal, $color, $nombre)) {
					echo json_encode([
						"success" => true,
						"message" => "Etiqueta actualizado correctamente",
						"data" => $result,
						"error" => false
					]);
				} else {
					throw new Exception("Error al actualizar la etiqueta");
				}
			}
		} catch (Exception $e) {
			http_response_code($e->getCode() ?: 500);
            echo json_encode([
                "success" => false,
                "error" => $e->getMessage()
            ]);
		}
	}
	public function delete()
	{
		try{
			$data = json_decode(file_get_contents('php://input'), true);
			$id = $data['id'];
			if ($result = $this->model->Delete($id)) {
				echo json_encode([
					"success" => true,
					"message" => "Etiqueta eliminado correctamente",
					"data" => $result,
					"error" => false
				]);
			} else {
				throw new Exception("Error al eliminar la etiqueta");
			}
		}catch(Exception $e) {
			http_response_code($e->getCode() ?: 500);
            echo json_encode([
                "success" => false,
                "error" => $e->getMessage()
            ]);
		}
	}
	public function getPersonal()
	{
		$this->disabledCache();
		$data = $this->model->GetPersonal();
		while ($row = mysqli_fetch_assoc($data)) {
			$json[] = array(
				"id" => $row["idpersonal"],
				"nombres" => $row["nombres"],
			);
		}
		echo json_encode($json);
	}
}