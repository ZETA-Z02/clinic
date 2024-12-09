<?php 
class AgendaModel extends Model{
    function __construct(){
        parent::__construct();
    }
    public function get(){
        $sql = "SELECT c.nombre, ci.idcliente, ci.titulo, ci.etiqueta, ci.fecha_ini, ci.hora_ini, ci.fecha_fin,ci.hora_fin FROM citas ci JOIN clientes c ON c.idcliente = ci.idcliente;";
        $data = $this->conn->ConsultaCon($sql);
        return $data;
    }
    public function SearchCustomers($search){
        $sql = "SELECT idcliente, nombre, apellido FROM clientes WHERE nombre LIKE '%$search%' OR apellido LIKE '%$search%' OR dni LIKE '$search%';";
        $data = $this->conn->ConsultaCon($sql);
        return $data;
    }
    public function GuardarCita($idcliente,$titulo,$fechaInicio,$horaInicio,$fechaFin,$horaFin,$etiqueta,$mensaje){
        $sql = "INSERT INTO citas (idcliente,titulo,etiqueta,mensaje,fecha_ini,hora_ini,fecha_fin,hora_fin) VALUES('$idcliente','$titulo','$etiqueta','$mensaje','$fechaInicio','$horaInicio','$fechaFin','$horaFin');";
        $result = $this->conn->ConsultaSin($sql);
        return $result;
    }
}