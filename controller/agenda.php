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
				'id'=> $row['idcita'],
				'title' => $row['titulo'],
                'start' => $row['fecha_ini'].'T'.$row['hora_ini'],
                'end'   => $row['fecha_fin'].'T'.$row['hora_fin'],
                'borderColor' => $row['color'],
                'backgroundColor' => $row['color'],
                'textColor' => '#ffffff',
				'idcliente' => $row['idcliente'],
				'idetiqueta' => $row['idetiqueta'],
				'fecha_ini'	=> $row['fecha_ini'],
				'hora_ini'	=> $row['hora_ini'],
				'fecha_fin'	=> $row['fecha_fin'],
				'hora_fin'	=> $row['hora_fin'],
            );
        }
        echo json_encode($json);
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
		$clientePost = $_POST['cliente'];
		$personalProcedimiento = $_POST['personal-procedimiento'];
		$procedimiento = $_POST['procedimientos'];
		$duracion = $_POST['duracion'];
		$personalCreador = $_POST['personal-creador'];
		$fechaInicio = $_POST['fecha-inicio'];
		$horaInicio = $_POST['hora-inicio'];
		$fechaFin = $_POST['fecha-fin'];
		$horaFin = $_POST['hora-fin'];
		$idetiqueta = $_POST['idetiqueta'];
		$mensaje = $_POST['mensaje'];
		$cliente = explode(' ', $clientePost)[0];
		$titulo = $personalProcedimiento.'-'.$cliente.'-'.$procedimiento.'-'.$duracion.'-'.$personalCreador;
		//echo json_encode($titulo);
		// echo json_encode(array("idcliente"=>$idcliente,"titulo"=>$titulo,"fechaInicio"=>$fechaInicio,"horaInicio"=>$horaInicio,"fechaFin"=>$fechaFin,"horaFin"=>$horaFin,"etiqueta"=>$etiqueta,"mensaje"=>$mensaje));

		if($this->model->GuardarCita($idcliente,$idetiqueta,$titulo,$fechaInicio,$horaInicio,$fechaFin,$horaFin,$mensaje)){
			echo "ok";
		}else{
			throw new Exception("Error al crear la cita");
		}
	}
	public function duplicarCita(){
		$idcliente = $_POST["idcliente"];
		$idetiqueta = $_POST["idetiqueta"];
		$titulo = $_POST['titulo'];
		$fechaInicio = $_POST['fecha_inicio'];
		$horaInicio = $_POST['hora_inicio'];
		$fechaFin = $_POST['fecha_fin'];
		$horaFin = $_POST['hora_fin'];
		$mensaje = '';

		if($this->model->GuardarCita($idcliente,$idetiqueta,$titulo,$fechaInicio,$horaInicio,$fechaFin,$horaFin,$mensaje)){
			echo "ok";
		}else{
			throw new Exception("Error al crear la cita");
		}
	}
	public function infoCita(){
		$idcita = $_POST['id'];
		$data = $this->model->InfoCita($idcita);
		echo json_encode($data);
	}
	public function delete(){
		$idcita = $_POST['id'];
		if($this->model->Delete($idcita)){
			echo "ok";
		}else{
			//throw new Exception("Error al eliminar la cita");
			echo "Orror";
		}
	}
	public function getPersonal(){
		$data = $this->model->GetPersonal();
		while($row=mysqli_fetch_array($data)){
			//$nombre = explode(' ',$row["nombre"]);
			$iniciales = $row["nombre"][0].$row["apellido"][0];
			$json[] = array(
				"nombre"=>$row['nombre'],
				"id"=>$row['idetiqueta'],
				"iniciales"=>$iniciales,
			);
		}
		echo json_encode($json);
	}
	// TRAE LOS PROCEDIMIENTOS-> CAMBIAR ESTO SI SE NECESITA INCIALES PERSONALIZADAS
	// PREGUNTA SI QUIEREN QUE SEA LAS PRIMERAS LETRAS DEL PROCEDIMIENTO O QUE ELLOS CREEN LAS INICIALES
	public function getProcedimientos(){
		$data = $this->model->GetProcedimientos();
		while($row=mysqli_fetch_array($data)){
			$iniciales = substr($row['procedimiento'],0,4);
			$json[] = array(
				"procedimiento"=>$row['procedimiento'],
				"iniciales"=>$row['iniciales'],
				// "iniciales"=>$iniciales,
			);
		}
		echo json_encode($json);
	}
	public function getClientes(){
		$data = $this->model->GetClientes();
		while($row=mysqli_fetch_array($data)){
			$json[] = array(
				"idcliente"=>$row['idcliente'],
				"nombres"=>$row['nombre']." ".$row['apellido'],
			);
		}
		echo json_encode($json);
	}
}