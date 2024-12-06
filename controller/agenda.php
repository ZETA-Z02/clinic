<?php
class Agenda extends Controller
{

	function __construct()
	{
		parent::__construct();
	}

	function render()
	{
		$this->view->css='agenda';
		$this->view->Render('agenda/index');
	}
	public function get(){
		
	}
}