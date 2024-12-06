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
		
	}
}