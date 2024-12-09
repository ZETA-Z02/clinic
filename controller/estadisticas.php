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
		$fecha = $_POST['fecha'];
		$data = $this->model->GetLine($fecha);
		echo json_encode($data);
	}
	public function getBarras(){
		$fecha = $_POST['fecha'];
		$data = $this->model->GetBarras($fecha);
		echo json_encode($data);
	}
}