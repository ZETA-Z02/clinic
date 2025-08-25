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
		$this->disabledCache();
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
		$post = json_decode(file_get_contents('php://input'), true);
		$query = $post['query'];
		$data = $this->model->SearchCustomers($query);
		while($row = mysqli_fetch_assoc($data)){
			$ini = explode(" ", $row['apellido']);
			$json[] = array(
				"id" => $row['idcliente'],
				"nombre" => $row['nombre'],
				"apellido" => $row['apellido'],
				"iniApellido" => $ini[0][0]. $ini[1][0],

			);
		}
		echo json_encode($json);
	}
	public function guardarCita(){
		try {
			$post = json_decode(file_get_contents('php://input'), true);
			$idcliente = $post['idcliente'];
			$clientePost = $post['cliente'];
			$personalProcedimiento = $post['personal_procedimiento'];
			$procedimiento = $post['procedimientos'];
			$duracion = $post['duracion'];
			$personalCreador = $post['personal_creador'];
			$fechaInicio = $post['fecha_inicio'];
			$horaInicio = $post['hora_inicio'];
			$fechaFin = $post['fecha_fin'];
			$horaFin = $post['hora_fin'];
			$idetiqueta = $post['idetiqueta'];
			$mensaje = $post['mensaje'];
			$cliente = explode(' ', $clientePost)[0];
			$titulo = $personalProcedimiento.'-'.$cliente.'-'.$procedimiento.'-'.$duracion.'-'.$personalCreador;

			if($result = $this->model->GuardarCita($idcliente,$idetiqueta,$titulo,$fechaInicio,$horaInicio,$fechaFin,$horaFin,$mensaje)){
				echo json_encode([
					"success" => true,
					"message" => "Cita creado correctamente",
					"data" => $result,
					"error" => false
				]);
			}else{
				throw new Exception("Error al crear la cita");
			}
		} catch (Exception $e) {
			http_response_code($e->getCode() ?: 500);
			echo json_encode([
				"success" => false,
				"error" => $e->getMessage()
			]);
		}
	}
	public function duplicarCita(){
		try {
			$post = json_decode(file_get_contents('php://input'), true);
			$idcliente = $post["idcliente"];
			$idetiqueta = $post["idetiqueta"];
			$titulo = $post['titulo'];
			$fechaInicio = $post['fecha_inicio'];
			$horaInicio = $post['hora_inicio'];
			$fechaFin = $post['fecha_fin'];
			$horaFin = $post['hora_fin'];
			$mensaje = '';
			if($result = $this->model->GuardarCita($idcliente,$idetiqueta,$titulo,$fechaInicio,$horaInicio,$fechaFin,$horaFin,$mensaje)){
				echo json_encode([
					"success" => true,
					"message" => "Cita duplicado correctamente",
					"data" => $result,
					"error" => false
				]);
			}else{
				throw new Exception("Error al duplicar la cita");
			}
		} catch (Exception $e) {
			http_response_code($e->getCode() ?: 500);
			echo json_encode([
				"success" => false,
				"error" => $e->getMessage()
			]);
		}
	}
	public function infoCita(){
		$post = json_decode(file_get_contents('php://input'), true);
		$idcita = $post['id'];
		$data = $this->model->InfoCita($idcita);
		echo json_encode($data);
	}
	public function delete(){
		try {
			$post = json_decode(file_get_contents("php://input"), true);
			$idcita = $post['id'];
			if($result = $this->model->Delete($idcita)){
				echo json_encode([
					"success" => true,
					"message" => "Cita creado correctamente",
					"data" => $result,
					"error" => false
				]);
			}else{
				throw new Exception("Error al eliminar la cita");
			}
		} catch (Exception $e) {
			http_response_code($e->getCode() ?: 500);
			echo json_encode([
				"success" => false,
				"error" => $e->getMessage()
			]);
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
		$this->disabledCache();
		$data = $this->model->GetClientes();
		while($row=mysqli_fetch_array($data)){
			$json[] = array(
				"idcliente"=>$row['idcliente'],
				"nombres"=>$row['nombre']." ".$row['apellido'],
			);
		}
		echo json_encode($json);
	}
	public function getHoras(){
		$this->disabledCache();
		$post = json_decode(file_get_contents('php://input'), true);
        $day = $post['fecha'];
        $data = $this->model->GetHoras($day);
		$horasOcupadas = [];
		while($row = mysqli_fetch_array($data)){
			$horaInicio = strtotime($row['hora_ini']);
			$horaFin = strtotime($row['hora_fin']);
			// Guarda el rango ocupado en un array
            for ($hora = $horaInicio; $hora < $horaFin; $hora += 1800) { // Cada 30 min (1800s)
                $horasOcupadas[] = date('H:i', $hora);
            }
		}
		 // Generar todas las horas posibles (de 07:00 a 18:00)
		 $horasDisponibles = [];
		 $horaInicioDia = strtotime("07:00");
		 $horaFinDia = strtotime("21:00");
 
		 for ($hora = $horaInicioDia; $hora < $horaFinDia; $hora += 1800) { // Intervalos de 30 min
			 $horaStr = date('H:i', $hora);
			 if (!in_array($horaStr, $horasOcupadas)) {
				 $horasDisponibles[] = $horaStr;
			 }
		 }
		 echo json_encode($horasDisponibles);
	}
	public function editarCita(){
		try {
			$post = json_decode(file_get_contents('php://input'), true);
			$idcita = $post['idcita'];
			$titulo = $post['titulo'];
			$horaInicio = $post['horaini'];
			$horaFin = $post['horafin'];
			if($result = $this->model->EditarCita($idcita,$titulo,$horaInicio,$horaFin)){
				echo json_encode([
					"success" => true,
					"message" => "Cita editada correctamente",
					"data" => $result,
					"error" => false
				]);	
			}else{
				throw new Exception("Error al editar la cita");
			}
		} catch (Exception $e) {
			http_response_code($e->getCode() ?: 500);
			echo json_encode([
				"success" => false,
				"error" => $e->getMessage()
			]);
		}
	}
}