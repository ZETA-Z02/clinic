<?php
class Dashboard extends Controller
{
	function __construct()
	{
		parent::__construct();
	}

	function render()
	{
		$this->view->Render('dashboard/index');
	}
    public function get(){
        $data = $this->model->Get();
        $json[0] = array();
        $json[1] = array();
        while($row = mysqli_fetch_assoc($data)){
            $json[0][] = array("id"=>$row['idcliente'],);
        }
        mysqli_data_seek($data,0);
        while($row = mysqli_fetch_assoc($data)){
            $json[1][] = array(
                "nombres"=>$row['nombre']." ".$row['apellidos'],
                "telefono"=>$row['telefono'],
            );
        }
        echo json_encode($json);
    }
}
