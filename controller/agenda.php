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
	public function get():void{
		$data = $this->model->Get();
        while($row = mysqli_fetch_array($data)){
            $json[] = array(
				'id'=> $row['idcliente'],
                'title' => $row['nombre'].' '.$row['titulo'],
                'start' => $row['fecha_ini'].'T'.$row['hora_ini'],
                'end'   => $row['fecha_fin'].'T'.$row['hora_fin'],
                'borderColor' => '#000000',
                'backgroundColor' => '#00c853',
                'textColor' => '#ffffff'
            );
        }
        echo json_encode($json);
		// [
		// 	{
		// 	  id: "1",
		// 	  title: "Cita 1",
		// 	  start: "2024-12-05T09:30:00",
		// 	  color: "#00c853",
		// 	},
		// 	{
		// 	  id: "2",
		// 	  title: "Cita 2",
		// 	  start: "2024-12-05T22:30:00",
		// 	  color: "#00c853",
		// 	},
		//   ],
	}
	public function searchCustomers(){
		$query = $_POST['query'];
		$data = $this->model->SearchCustomers($query);
		while($row = mysqli_fetch_assoc($data)){
			$json[] = array(
				"id" => $row['idcliente'],
				"nombre" => $row['nombre'],
				"apellido" => $row['apellido']
			);
		}
		echo json_encode($json);
	}
	public function guardarCita(){
		$idcliente = $_POST['idcliente'];
		$titulo = $_POST['titulo'];
		$fechaInicio = $_POST['fecha-inicio'];
		$horaInicio = $_POST['hora-inicio'];
		$fechaFin = $_POST['fecha-fin'];
		$horaFin = $_POST['hora-fin'];
		$etiqueta = $_POST['etiqueta'];
		$mensaje = $_POST['mensaje'];

		// echo json_encode(array("idcliente"=>$idcliente,"titulo"=>$titulo,"fechaInicio"=>$fechaInicio,"horaInicio"=>$horaInicio,"fechaFin"=>$fechaFin,"horaFin"=>$horaFin,"etiqueta"=>$etiqueta,"mensaje"=>$mensaje));

		if($this->model->GuardarCita($idcliente,$titulo,$fechaInicio,$horaInicio,$fechaFin,$horaFin,$etiqueta,$mensaje)){
			echo "ok";
		}else{
			throw new Exception("Error al crear la cita");
		}
	}
}