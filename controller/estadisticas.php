<?php
class Estadisticas extends Controller
{
	function __construct()
	{
		parent::__construct();
	}

	function render()
	{
		$this->view->css='estadisticas';
		$this->view->Render('estadisticas/index');
	}
	public function get(){
		$data = $this->model->get();
		echo json_encode($data);
	}
	public function getLine(){
		$post = json_decode(file_get_contents('php://input'), true);
		$fecha = $post['fecha'];
		$data = $this->model->GetLine($fecha);
		echo json_encode($data);
	}
	public function getBarras(){
		$post = json_decode(file_get_contents('php://input'), true);
		$fecha = $post['fecha'];
		$data = $this->model->GetBarras($fecha);
		echo json_encode($data);
	}
}