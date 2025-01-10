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
}