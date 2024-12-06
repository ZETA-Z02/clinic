<?php

class Login extends Controller
{

	function __construct()
	{
		parent::__construct();
	}

	function render():void
	{
		$this->view->Render('login/index');
	}
	public function user():void{
		$username = strtolower(trim($_POST['username']));
		$password = strtolower(trim($_POST['password']));
		$data = $this->model->User($username);
		if($data['estado'] == 0){
			$this->render();
		}
		if($data['username']==$username && password_verify($password,$data['password'])){
			$_SESSION['katari'] = 'katariEnterprice';
			if($data['nivel'] == 2){
				$_SESSION['katari'] = 'katariAdmin';
			}
			// $this->view->render('dashboard/index');
			header("Location:".constant('URL'));	
		}else{
			$this->render();
		}
	}
	public function logout():void{
		session_destroy();
		$_SESSION['katari'] = null;
		header("Location:".constant('URL'));
	}
}