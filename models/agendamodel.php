<?php 
class AgendaModel extends Model{
    function __construct(){
        parent::__construct();
    }
    public function get(){
        $sql = "SELECT c.idcliente,e.idetiqueta,e.color,c.nombre,ci.idcita, ci.idcliente, ci.titulo, ci.idetiqueta, ci.fecha_ini, ci.hora_ini, ci.fecha_fin,ci.hora_fin FROM citas ci JOIN clientes c ON c.idcliente = ci.idcliente JOIN etiquetas e ON ci.idetiqueta=e.idetiqueta;";
        $data = $this->conn->ConsultaCon($sql);
        return $data;
    }
    public function SearchCustomers($search){
        $sql = "SELECT idcliente, nombre, apellido FROM clientes WHERE nombre LIKE '%$search%' OR apellido LIKE '%$search%' OR dni LIKE '$search%';";
        $data = $this->conn->ConsultaCon($sql);
        return $data;
    }
    public function GuardarCita($idcliente,$idetiqueta,$titulo,$fechaInicio,$horaInicio,$fechaFin,$horaFin,$mensaje){
        $sql = "INSERT INTO citas (idcliente,idetiqueta,titulo,mensaje,fecha_ini,hora_ini,fecha_fin,hora_fin) VALUES('$idcliente','$idetiqueta','$titulo','$mensaje','$fechaInicio','$horaInicio','$fechaFin','$horaFin');";
        $result = $this->conn->ConsultaSin($sql);
        return $result;
    }
    public function InfoCita($id){
        $sql = "SELECT e.color,c.idcliente, c.nombre, c.apellido,c.telefono, ci.idcita, ci.titulo,ci.titulo,ci.idetiqueta,ci.mensaje,ci.fecha_ini,ci.hora_ini,ci.fecha_fin,ci.hora_fin from citas ci JOIN clientes c ON ci.idcliente=c.idcliente JOIN etiquetas e ON ci.idetiqueta=e.idetiqueta WHERE idcita='$id';";
        $data = $this->conn->ConsultaArray($sql);
        return $data;
    }
    public function Delete($id){
        $sql = "DELETE FROM citas WHERE idcita = '$id';";
        $result = $this->conn->ConsultaSin($sql);
        return $result;
    }
    public function GetPersonal(){
        $sql = "SELECT e.nombre,e.idetiqueta,p.nombre,p.apellido FROM personal p JOIN login l ON p.idpersonal=l.idpersonal JOIN etiquetas e ON e.idpersonal = p.idpersonal WHERE l.estado=1;";
        $data = $this->conn->ConsultaCon($sql);
        return $data;
    }
    public function GetProcedimientos(){
        $sql = "SELECT procedimiento,iniciales FROM procedimientos;";
        $data = $this->conn->ConsultaCon($sql);
        return $data;
    }
    public function GetClientes(){
        $sql = "SELECT idcliente, nombre, apellido FROM clientes;";
        $data = $this->conn->ConsultaCon($sql);
        return $data;
    }
    // HORAS DISPONIBLES
    public function GetHoras($day){
        $sql = "SELECT hora_ini,hora_fin FROM citas WHERE fecha_ini = '$day';";
		$data = $this->conn->ConsultaCon($sql);
		return $data;
    }
    public function EditarCita($idcita,$titulo,$horaInicio,$horaFin){
        $sql = "UPDATE citas SET titulo = '$titulo', hora_ini = '$horaInicio', hora_fin = '$horaFin' WHERE idcita = '$idcita';";
        $result = $this->conn->ConsultaSin($sql);
        return $result;
    }
}